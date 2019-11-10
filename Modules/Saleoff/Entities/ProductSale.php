<?php

namespace Modules\Saleoff\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    protected $fillable = ["sale_id", "product_id", "discount"];
    protected $table = "product_sale";

    public static function insertList($productIds = [], $discounts = [], $sale_id, $is_update = false){
        if($is_update){
            ProductSale::where('sale_id', $sale_id)->delete();
        }
        if(count($productIds)){
            $product_sales = [];
            foreach ($productIds as $key => $value) {
                $item = [];
                $item["sale_id"] = $sale_id;
                $item["product_id"] = $value;
                $item["discount"] = $discounts[$key];
                $item["created_at"] = Carbon::now();
                $item["updated_at"] = Carbon::now();
                array_push($product_sales, $item);
            }
            self::insert($product_sales);
        }
    }
}
