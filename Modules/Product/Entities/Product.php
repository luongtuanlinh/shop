<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'price',
        'cover_path',
        'count',
        'status',
        'admin_id',
        'material',
        'description',
        'category_id',
    ];

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
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class,'product_size','product_id','size_id')->withPivot(['count','updated_at']);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_product','product_id','order_id');
    }

    public function getAllProduct(){
        $data = Product::with('category')
                        ->where('status', '<>' , -1)
                        ->paginate(20);
        return $data;
    }

    public function insertProduct($data){
        return $this->insert($data);
    }

    public function updateProduct($id, $data){
        return $this->where('id', $id)
                    ->update($data);
    }

    public function getProductById($id){
        return $this->where("id", $id)->first();
    }
  
}
