<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'size_name',
        'introduction',
    ];
    protected $table = "product_size";

    public function products() {
        return $this->belongsToMany(Product::class, 'product_size');
    }

}
