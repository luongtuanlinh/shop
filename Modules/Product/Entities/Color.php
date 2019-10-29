<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color', 'code'];
    protected $table = "colors";

    public function products() {
        return $this->belongsToMany(Product::class, 'product_size');
    }
}
