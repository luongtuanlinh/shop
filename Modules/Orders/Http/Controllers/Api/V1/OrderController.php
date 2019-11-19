<?php
/**
 * Created by PhpStorm.
 * User: paditech
 * Date: 6/16/19
 * Time: 1:16 AM
 */

namespace Modules\Orders\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Agency\Entities\Agency;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Models\User;
use Modules\Orders\Entities\Customer;
use Modules\Orders\Entities\OrderItems;
use Modules\Orders\Entities\Orders;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductPrice;

class OrderController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * return list categories depend on request params
     */
    public function listOrders(Request $request)
    {
        try {
            //Params
            if(empty($request->user('api')->id)){
                return $this->errorResponse([], "Không tồn tại người dùng này");
            }
            $params = $request->all();
            $page = isset($params['page']) ? (int)$params['page'] : 1;
            $pageSize = isset($params['page_size']) ? (int)$params['page_size'] : 10;

            //Sortby
            $sortBy = isset($params['sort_by']) ? $params['sort_by'] : "id";
            $sortType = isset($params['sort_type']) ? $params['sort_type'] : "desc";


            $result = array();
            $query = Orders::select(DB::raw('id, created_user_id, status, total, discount, tax, deliver_time, created_at, customer_name, customer_phone, deliver_address, customer_address'))->where('created_user_id', $request->user('api')->id);

            if (!empty($params['customer_name'])) {
                $query = $query->whereRaw('LOWER(customer_name) LIKE ? ', ['%'.trim(mb_strtolower($params["customer_name"])).'%']);
            }
            if (!empty($params['customer_mobile'])) {
                $query = $query->whereRaw('LOWER(customer_mobile) LIKE ? ', ['%'.trim(mb_strtolower($params["customer_mobile"])).'%']);
            }
            if (!empty($params['order_id'])) {
                $query = $query->where('id', $params['order_id']);
            }
            if (!empty($params['status'])) {
                $query = $query->where('status', $params["status"]);
            }
            if (!empty($params['start_date']) && !empty($params['end_date'])) {
                $start_date = Carbon::createFromTimestamp($params['start_date'] / 1000);
                $end_date = Carbon::createFromTimestamp($params['end_date'] / 1000);
                if($params['start_date'] != $params['end_date'])
                    $query = $query->whereBetween('created_at', array($start_date, $end_date));
            }
            $count = $query->count();
            $pages = ceil($count / $pageSize);
            if ($count > (($page - 1) * $pageSize)) {
                $posts = $query->orderBy($sortBy, $sortType)->skip(($page - 1) * $pageSize)->take($pageSize)->get();
                foreach ($posts as $item) {
                    $item->created_at = date("Y/m/d H:i:s", strtotime($item->created_at));
                    $item->deliver_time = date("Y/m/d H:i:s", strtotime($item->deliver_time));
                    $result[] = $item;
                }
                return $this->successResponse(['orders' => $result, 'pages' => $pages, 'current_page' => $page], 'Response Successfully');
            } else {
                return $this->successResponse([], 'Not enough record in page ' . $page . ' with ' . $pageSize . ' records per page');
            }
        } catch (\Exception $ex) {
            return $this->errorResponse([], $ex->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Request $request){
        DB::beginTransaction();
        try {
            //Params

            $params = $request->all();
            $validatorArray = [
                'user_name' => 'required',
                'phone_number' => 'required',
                'user_address'  => 'required',
                'payments-methods' => 'required',
//                'deliver_time' => 'required',
                'calc_shipping_country'   => 'required',
                'products'    => 'required',
            ];
            $messages = [
                'user_name.required' => 'Bạn chưa nhập tên',
                'phone_number.required' => 'Bạn chưa nhập số điện thoại',
                'user_address.required'  => 'Bạn chưa nhập địa chỉ',
                'payments-methods.required' => 'Bạn chưa chọn loại hình thanh toán',
//                'deliver_time' => 'required',
                'calc_shipping_country.required'   => 'Bạn chưa chọn thành phố',
                'products.required'    => 'Bạn chưa chọn sản phẩm',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => $validator->messages()],'Response Successfully');
            }


            $customer = [];
            $customer['customer_name'] = trim($params['user_name']);
            $customer['customer_phone'] = trim($params['phone_number']);
            $customer['customer_address'] = trim($params['user_address']);
            $customer['province'] = trim($params['calc_shipping_country']);
            $customer['created_at'] = Carbon::now();
            $customer_id = Customer::insertGetId($customer);

            $order = [];
            $order["deliver_address"] = $params['user_address'];
            $order["order_status"] = Orders::PENDING_STATUS;
            $order["total_price"] = $params['total'];
            $order['ship_price'] = (trim($params['calc_shipping_country']) == "HN") ? 20000 : 30000;
            $order['customer_phone'] = trim($params['phone_number']);
            $order["customer_id"] = $customer_id;
            $order["payment"] = $params['payments-methods'];
            $order["payment_status"] = 0;
            $order["created_at"] = Carbon::now();
            $params["products"] = json_decode($params["products"]);
            $params['order_id'] = Orders::insertGetId($order);
            
            //update order item
            Orders::insertOrderitemApi($params);
            DB::commit();
            return $this->successResponse(["success" => 1], 'Response Successfully');

        } catch (\Exception $ex) {
            DB::rollback();
            Log::error('[Order] ' . $ex->getMessage());
            return $this->errorResponse([], $ex->getMessage());
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id, Request $request){
        try{
            if(empty($request->user('api')->id)){
                return $this->errorResponse([], "Không tồn tại người dùng này");
            }
            $object = Orders::select(DB::raw('id, created_user_id, status, total, discount, tax, deliver_time, created_at, customer_name, customer_phone, deliver_address, customer_address'))->where('id', $id)->where('created_user_id', $request->user('api')->id)->first();
            if(empty($object)){
                return $this->errorResponse([], "Không tồn tại order này");
            }else{
                $allItems = OrderItems::with('color', 'product')->where('order_id',$id)->get();
                //dd($allItems);
                foreach ($allItems as $key => $value){
                    $allItems[$key]->unit_name = Product::listProductUnit()[$value->unit];
                }
                $object->item = $allItems;
                $object->status_name = Orders::listStatus()[$object->status];
                return $this->successResponse(['order' => $object], 'Response Successfully');
            }
        }catch (\Exception $exception){
            return $this->errorResponse([], $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editOrder(Request $request){
        $params = $request->json()->all();

        DB::beginTransaction();
        try {
            $order = Orders::with("order_item")->where('id',$params['order_id'])->first();
            if(empty($order)){
                return $this->errorResponse([], "Không tồn tại đơn hàng này");
            }else {
                $total = 0;
                foreach ($params["items"] as $key => $param){
                    $object = ProductPrice::where([
                        "product_id" => $param["product_id"],
                        "unit" =>  $param["unit"]
                    ])->first();

                    if(empty($object)){
                        $params["items"][$key]["sell_price"] = 0;
                        $total += 0;
                    }else{
                        $params["items"][$key]["sell_price"] = $object->price;
                        $total += $object->price * $params["items"][$key]["amount"];
                    }
                }
                $order->total = $total;
                Orders::insertOrderitemApi($params);
                $order->save();
            }
            DB::commit();
            return $this->successResponse([], 'Response Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[Product] ' . $e->getMessage());
            return $this->errorResponse([], $e->getMessage());
        }
    }

}
