<?php


namespace App\Models\Shop;


use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_sale','sale_id','product_id')->withPivot(['discount']);
    }
}