<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\ProductSize;
use Modules\Product\Entities\Product;
use DB;

class OrderItems extends Model
{
    use Compoships;
    protected $fillable = ["id", "product_id", "order_id", "amount", "sell_price", "list_price", "updated_at"];
    protected $table = "order_product";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo("Modules\Product\Entities\Product", "product_id");
    }

    public static function returnProduct($order_id) {
        $product_item = OrderItems::where('order_id', $order_id)->get();

        if ($product_item) {
            foreach ($product_item as $key => $product) {
                $sizeColor = ProductSize::where("product_id", $product->product_id)
                                        ->where("size_id", $product->size_id)
                                        ->first();
                $newAmount = '';
                
                if($sizeColor) {
                    $color = explode(",", $sizeColor->color);
                    $amount = explode(",", $sizeColor->amount);

                    foreach($color as $key => $item) {
                        if (trim($item) == trim($product->color)) {
                            $amount[$key] = (string)((int)$amount[$key] + (int)$product->amount);
                        }
                    }

                    foreach($amount as $key2 => $value ) {
                        if($key2 == 0) {
                            $newAmount .= (string)$value;
                        } else {
                            $newAmount .= ",".(string)$value;
                        }
                    }

                }
                //update amount of size
                ProductSize::where("id", $sizeColor->id)
                            ->update(["amount" => $newAmount]);

                //update amount of product
                Product::where("id", $product->product_id)
                        ->update([ "count" => DB::raw("count + $product->amount") ]);
            }
        }
    }

}
