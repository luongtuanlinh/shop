<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $fillable = [];
    protected $table = "product_size";

    public function size() {
        return $this->belongsTo(Size::class,'size_id','id');
    }

    public function product() {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
