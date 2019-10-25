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
    protected $fillable = [];

    const PENDING_STATUS = 1;
    const PROCESSING_STATUS = 2;
    const SHIPPED_STATUS = 3;
    const DELIVERED = 4;
    const SUCCESS_STATUS = 5;
    const CANCEL_STATUS = 6;

    const UPDATED_STATUS = 1;
    const NOT_UPDATED_STATUS = 0;
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
            $item = [];
            $product_price = ProductPrice::with("product")->where(['unit' => $params["unit"][$key], 'product_id' => $value])->first();
            $item["order_id"] = $params['order_id'];
            $item["product_id"] = $value;
            $item["product_name"] = $product_price->product->name;
            $item["amount"] = $params["amount"][$key];
            $item["sell_price"] = $product_price->price;
            $item["unit"] = $params["unit"][$key];
            if($params["type"][$key] == 1){
                $color_item = ColorCode::where("hex_code", $params["color_id"][$index_color])->whereNull('deleted_at')->first();
                $item["colorcode_id"] = $params["color_id"][$index_color];
                $item["color_percent"] = (double) (!empty($color_item)) ? $color_item->color_percent : 0;
                $index_color = $index_color + 1;
            }else{
                $item["colorcode_id"] = null;
                $item["color_percent"] = 0;
            }
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
        foreach ($params["items"] as $param){
            $item = [];
            $item["order_id"] = $params['order_id'];
            $item["product_id"] = $param["product_id"];
            $item["product_name"] = Product::where('id', $param["product_id"])->first()->name;
            $item["amount"] = $param["amount"];
            $item["sell_price"] = $param["sell_price"];
            $item["unit"] = $param["unit"];
            if(!empty($param["colorcode_id"])){
                $item["colorcode_id"] = $param["colorcode_id"];
                $item["color_percent"] = (double) (!empty($param["color_percent"])) ? $param["color_percent"] : 0;
            }else{
                $item["colorcode_id"] = null;
                $item["color_percent"] = 0;
            }
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
