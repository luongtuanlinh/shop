<?php


namespace Modules\Core\Models\Shop;


use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }



}