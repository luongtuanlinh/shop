<?php

namespace Modules\Orders\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\Product\Entities\ColorCode;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductPrice;


class Orders extends Model
{


    protected $table = "orders";
    //protected $fillable = [];

    const PENDING_STATUS = 1;
    const PROCESSING_STATUS = 2;
    const SHIPPED_STATUS = 3;
    const DELIVERED = 4;
    const SUCCESS_STATUS = 5;
    const CANCEL_STATUS = 6;

    const UPDATED_STATUS = 1;
    const NOT_UPDATED_STATUS = 0;

    const PAID_STATUS = 1;
    const NOT_PAY_STATUS = 0;
    public $timestamps = false;

    /**
     * Gen html for status
     * @param $status
     * @return string
     */
    public static function genStatusHtml($status){
        if($status == self::PENDING_STATUS)
            $html = '<span class="label label-warning"><i class="fa fa-refresh fa-spin"></i>&nbsp;   Đang chờ xử lý</span>';

        elseif($status == self::PROCESSING_STATUS)
            $html = '<span class="label label-info"><i class="fa fa-refresh fa-spin"></i>&nbsp;   Đang xử lý</span>';
        elseif($status == self::SHIPPED_STATUS)
            $html = '<span class="label label-success"><i class="fa fa-refresh fa-spin"></i>&nbsp;   Vận chuyển</span>';
        elseif($status == self::DELIVERED)
            $html = '<span class="label label-danger"><i class="fa fa-refresh fa-spin"></i>&nbsp;   Đã giao hàng</span>';
        elseif($status == self::SUCCESS_STATUS)
            $html = '<span class="label label-primary"><i class="fa fa-check"></i>&nbsp;   Hoàn thành</span>';
        else
            $html = '<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;   Huỷ đơn</span>';
        return $html;
    }

    /**
     * Gen html for action
     * @param $oder_id
     * @return string
     */
    public static function genActionCollumn($oder_id){
        $html = "";
        if(Session::get('edit')){
            $html = '<a href="'. route('order.view', $oder_id).'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>&nbsp;  View </a>';
        }

        return $html;
    }

    /**
     * Get order member
     *
     * @return mixed
     */
    public function getOrderMember()
    {
        $member = DB::table('users')->where('id',$this->customer_id)->first();
        return $member;
    }

    /**
     * List status
     * @return array
     */
    public static function listStatus(){
        return array(
            1 => "Chờ xử lý",
            2 => "Đang xử lý",
            3 => "Vận chuyển",
            4 => "Giao hàng",
            5 => "Hoàn thành",
            6 => "Huỷ đơn"
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_item(){
        return $this->hasMany('Modules\Orders\Entities\OrderItems', 'order_id')->whereNull('deleted_at');
    }

    /**
     * @param $params
     */
    public function updateOrderitem($params){
        OrderItems::where('order_id', $params['order_id'])->delete();
        self::insertOrderitem($params);
    }

    /**
     * @param $params
     */
    public static function insertOrderitem($params){
        OrderItems::where('order_id', $params['order_id'])->delete();
        $order_items = [];
        $index_color = 0;
        foreach ($params["product_id"] as $key => $value){
            // OrderItems::where('order_id', $params['order_id'])
            // ->where('product_id',  $params["product_id"][$key])
            // ->where('color_id',  $params["color"][$key])
            // ->where('size_id',  $params["size"][$key])
            // ->delete();
            $product = Product::whereId($value)->first();
            $item = [];
            $item["order_id"] = $params["order_id"];
            $item["product_id"] = $value;
            $item["size_id"] = $params["size"][$key];
            $item["color_id"] = $params["color"][$key];
            $item["amount"] = $params["amount"][$key];
            $item["sell_price"] = $product->price;
            $item["list_price"] = $product->price; // gia goc
            $item["created_at"] = Carbon::now();
            array_push($order_items, $item);
        }
        OrderItems::insert($order_items);
    }

    /**
     * @param $params
     */
    public static function insertOrderitemApi($params){
        OrderItems::where('order_id', $params['order_id'])->delete();
        $order_items = [];
        foreach ($params["products"] as $product){
            $product_item = Product::where('id', $product->product_id)->first();
            $item = [];
            $item["order_id"] = $params["order_id"];
            $item["product_id"] = $product->product_id;
            $item["size_id"] = $product->size;
            $item["color_id"] = $product->color;
            $item["amount"] = $product->amount;
            $item["sell_price"] = (empty($product_item)) ? 0 : $product_item->price;
            $item["list_price"] = (empty($product_item)) ? 0 : $product_item->price; // gia goc
            $item["created_at"] = Carbon::now();
            array_push($order_items, $item);
        }

        OrderItems::insert($order_items);
    }

    /**
     * @param $item
     * @return string
     */
    public static function renderMessage($item){
        $msg = "Kho đang không đủ hàng cho sản phẩm: " . $item->product_name . " đơn vị: ". Product::listProductUnit()[$item->unit];
        if(!empty($item->colorcode_id)){
            $msg .= " màu: ".$item->colorcode_id;
        }
        return$msg;
    }
}
