<?php

namespace Modules\Orders\Http\Controllers;

use App\Models\KMsg;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use Modules\Agency\Entities\Agency;
use Modules\Orders\Entities\Province;
use Modules\Orders\Entities\District;
use Modules\Orders\Entities\Commune;
use Modules\Core\Models\User;
use Modules\Orders\Entities\Customer;
use Modules\Orders\Entities\History;
use Modules\Orders\Entities\OrderItems;
use Modules\Orders\Entities\Orders;
// use Modules\Product\Entities\ColorCode;
use Modules\Product\Entities\ElectedWarehouse;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Color;
use Modules\Product\Entities\Size;
use Modules\Product\Entities\ProductPrice;
use Modules\Product\Entities\WareHouse;
use Yajra\Datatables\Datatables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Excel;
use App\Exports\OrderExport;
use Modules\Product\Entities\Category;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $actions = request()->route()->getAction();
        $controller = explode("@",$actions['controller']);
        $controller = $controller[0];
        Session::put('edit', Auth::user()->hasPermission($controller, "edit"));
        Session::put('create', Auth::user()->hasPermission($controller, "create"));

        return view('orders::order.index');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function get(Request $request)
    {
        $query = Orders::select("orders.*", "customers.customer_name as customer_name", "customers.customer_phone as customer_phone")->join("customers", "customers.id", "=", "orders.customer_id");
        return Datatables::of($query)
            ->filter(function ($query) use ($request) {
                foreach ($request->all() as $key => $value) {
                    if (($value == "") || ($value == -1) || ($value == null)) {

                    } else {
                        if ($key == 'status') {
                            $query->where('order_status', $value);
                        }
                        if ($key == 'deliver_time') {
                            $date = explode(' - ', $value);
                            // dd($date);/
                            if($date[0] != $date[1]){
                                $start_date = Carbon::parse($date[0])->format('Y-m-d H:i:s');
                                $end_date = Carbon::parse($date[1])->format('Y-m-d H:i:s');
                                $query->whereBetween('created_at', array($start_date, $end_date));
                            }
                        }
                        if ($key == 'phone') {
                            $query->where('customer_phone', 'LIKE', '%'.$value.'%');
                        }
                        if ($key == 'customer_name' ) {
                            $query->where('customer_name', 'LIKE', '%'.$value.'%');
                        }
                    }
                }
            })
            ->escapeColumns([])
            ->editColumn('id', function ($order) {
                return "#".$order->id;
            })
            ->editColumn('customer_name', function ($order) {
                $customer =  Customer::whereId($order->customer_id)->first();
                return $customer->customer_name;
            })
            ->editColumn('created_at', function ($order) {
                return Carbon::parse($order->created_at)->format('d-m-Y');
            })
            ->editColumn('status', function ($order) {
                $html = Orders::genStatusHtml($order->order_status);
                return $html;
            })
            ->editColumn('total', function ($order) {
                return number_format($order->count_price);
            })
            ->editColumn('deliver_time', function ($order) {
                return "<button type='button' class='btn btn-success btn-xs'><i class='fa fa-clock-o'>$order->deliver_time</i></button>";
            })
            ->addColumn('actions', function ($order) {
                $html = Orders::genActionCollumn($order->id);
                return $html;
            })
            ->addColumn('check', function ($order) {
                if($order->status == Orders::DELIVERED){
                    $html = "<input type='checkbox' value='". $order->id ."'>";
                }else{
                    $html = "";
                }
                return $html;
            })
            ->make(true);
    }

    /**
     * View order
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id, Request $request){
        $order = Orders::where('id', $id)->first();
        $customer = Customer::whereId($order->customer_id)->first();
        $order->customer_name = $customer->customer_name;
        return view('orders::order.edit',['order' => $order]);
    }

    public function getOrderItems($id, Request $request) {
        $query = OrderItems::where('order_id', $id)->join('products', 'products.id', '=', 'order_product.product_id');
        $order_price = 0;
        return Datatables::of($query)
        ->filter(function($query) use ($request) {

        })
        ->escapeColumns([])
        ->addColumn('id', function($item) {
            return $item->product_id;
        })
        ->addColumn('product_name', function($item) {
            return Product::whereId($item->product_id)->first()->name;
        })
        ->addColumn('image', function($item) {
            if ($item->cover_path != null) {
                $data = json_decode($item->cover_path);
                $html = '';
                $html .= '<img class="image-product" src="' . (($data[0] != null) ? url($data[0]) : "") . '">';
                return $html;
            } else {
                return '';
            }
    })
        ->addColumn('color', function($item) {
            return Color::join('color_product', 'colors.id', '=', 'color_product.color_id')->where('color_product..product_id', $item->product_id)->first()->color;
        })
        ->addColumn('size', function($item) {
            return Size::whereId($item->size_id)->first()->size_name;
        })
        ->editColumn('amount', function($item) {
            // $html = "<input type='number' min='0' id='item".$item->id."' value='".$item->amount."/>";
            $html = "<input style='width: 50px; border: 0px solid;' type='number' min='0' id='item".$item->id."' value='".$item->amount."'/>";
            return $html;
        })
        ->addColumn('total_price', function($item) {
            // $order_price += $item->amount * $item->sell_price;
            return $item->amount * $item->sell_price;
        })
        ->make(true);
    }
    /**
     * Update item in order
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        $params = $request->all();

        $validatorArray = [
            'type' => 'required',
            'product_id' => 'required',
            'unit' => 'required',
            'amount' => 'required',
            'sell_price'  => 'required',
        ];

        $validator = Validator::make($params, $validatorArray);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }
        DB::beginTransaction();
        $order = Orders::with("order_item")->where('id',$params['order_id'])->first();
        try {
            
            DB::commit();
            return redirect()->back()->with('messages','Đổi trạng thái đơn hàng thành công');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[Product] ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(["Không thể lưu được bản ghi nào"]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        // $maxLevel = Agency::max('level');
        // $colors = ColorCode::whereNull('deleted_at')->get();
        $provinces = Province::all();
        $categories = Category::whereNull('deleted_at')->get();

        return view('orders::order.create', compact('provinces', 'categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $params = $request->all();
        $validatorArray = [
            'name' => 'required',
            'mobile' => 'required', 
            'more_info' => '',
            'address'  => 'required',
            'province_id'   => 'required',
            'commune_id'    => 'required',
            'district_id'   => 'required',
            'total' => 'required|min:0'
        ];

        $validator = Validator::make($params, $validatorArray);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }

        DB::beginTransaction();
        try{
            //create customer
            if(empty($params["customer_id"])){
                $customer = [];
                $customer['customer_name'] = trim($params['name']);
                $customer['customer_phone'] = trim($params['mobile']);
                $customer['customer_address'] = trim($params['address']);
                $customer['province_id'] = trim($params['province_id']);
                $customer['district_id'] = trim($params['district_id']);
                $customer['commune_id'] = trim($params['commune_id']);
                $customer['created_at'] = Carbon::now();
                $customer_id = Customer::insertGetId($customer);
            }else{
                $customer_id = $params["customer_id"];
            }

            $order = [];
            $order["deliver_address"] = $customer['customer_address'];
            $order["order_status"] = Orders::PENDING_STATUS;
            $order["total_price"] = $params['total'];
            $order["customer_id"] = $customer_id;
            $order["created_at"] = Carbon::now();
            $params['order_id'] = Orders::insertGetId($order);
            //update order item
            Orders::insertOrderitem($params);

            DB::commit();
            return redirect(route('order.index'))->with('messages','Tạo đơn hàng thành công');
        }catch (\Exception $exception){
            DB::rollback();
            Log::error('[Order] ' . $exception->getMessage());
            return redirect()->back()->withInput()->withErrors([trans('core::user.error_save')]);
        }
    }

    /**
     * @return mixed
     */
    public function excel(){
        return Excel::download(new OrderExport, 'order.xlsx');
    }

    public function changeStatus(Request $request){
        $result = new KMsg();
        if(count($request->id) == 0){
            $result->result = KMsg::RESULT_ERROR;
            $result->message = "Xảy ra lỗi";
            return \response()->json($result);
        }else{
            DB::beginTransaction();
            try{
                Orders::whereIn('id', $request->id)->update([
                    'status' => Orders::SUCCESS_STATUS
                ]);
                $object = [];
                foreach ($request->id as $key => $value){
                    $item = [
                        'order_id' => $value,
                        'actor_id' => Orders::SUCCESS_STATUS,
                        'description' => "Đổi trạng thái từ " .Orders::listStatus()[Orders::DELIVERED]." sang ".Orders::listStatus()[Orders::SUCCESS_STATUS] ,
                        'user_id'   =>  Auth::user()->id,
                        'user_name' =>  Auth::user()->username
                    ];
                    array_push($object, $item);
                }
                History::insert($object);
                $result->result = KMsg::RESULT_SUCCESS;
                $result->message = "Đổi trạng thái thành công";

                DB::commit();
                return \response()->json($result);
            }catch(\Exception $exception){
                $result->result = KMsg::RESULT_ERROR;
                $result->message = "Xảy ra lỗi";
                return \response()->json($result);
            }


        }
    }

    /**
     * Filter area
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request){
        $result = new KMsg();
        if(empty($request->id) || empty($request->type)){
            $result->message = "Something was wrong";
            $result->result = KMsg::RESULT_ERROR;
            return \response()->json($result);
        }else{
            if($request->type == "district"){
                $html = "";
                $districts = District::select('id', 'name')->where('province_id', $request->id)->get();
                $html .= "<option value='' selected>-- Tất cả --</option>";
                foreach ($districts as $district){
                    if(!empty($request->value) && $request->value == $district->id){
                        $html .= "<option value=". $district->id ." selected>". $district->name ."</option>";
                    }else{
                        $html .= "<option value=". $district->id .">". $district->name ."</option>";
                    }
                }
                $result->message = $html;
                $result->result = KMsg::RESULT_SUCCESS;
            }
            else if($request->type == "commune"){
                $html = "";
                $communes = Commune::select('id', 'name')->where('district_id', $request->id)->get();
                $html .= "<option value='' selected>-- Tất cả --</option>";
                foreach ($communes as $commune){
                    if(!empty($request->value) && $request->value == $commune->id){
                        $html .= "<option value=". $commune->id ." selected>". $commune->name ."</option>";
                    }else{
                        $html .= "<option value=". $commune->id .">". $commune->name ."</option>";
                    }
                }
                $result->message = $html;
                $result->result = KMsg::RESULT_SUCCESS;
            }
            return \response()->json($result);
        }
    }
}
