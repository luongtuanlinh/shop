<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    protected $fillable = [];
    protected $table = "product_sale";

    public function sale() {
        return $this->belongsTo(Sale::class,'sale_id','id');
    }
}
