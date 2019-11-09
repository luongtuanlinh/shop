<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
