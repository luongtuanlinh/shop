<?php


namespace Modules\Core\Models\Shop;


use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;

class Product extends Model
{
    public function sales()
    {
        return $this->belongsToMany(Sale::class,'product_sale','product_id','sale_id')->withPivot(['discount']);
    }
    public function admin()
    {
        return $this->belongsTo(User::class,'id','admin_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'id','category_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class,'product_size','product_id','size_id')->withPivot(['count','updated_at']);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_product','product_id','order_id');
    }
}