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

    public function sizes() {
        return $this->belongsToMany(Size::class, 'product_size');
    }

    public function getAllProduct(){
        return Product::paginate(20);
    }

    public function insertProduct($data){
        return $this->insert($data);
    }

    public function updateProduct($id, $data){
        return $this->where('id', $id)
                    ->update($data);
    }
}
