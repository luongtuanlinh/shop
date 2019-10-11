<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['categories'];

    public function getCategory(){
        return Category::all();
    }

    public function insertCate($data){
        return $this->insert($data);
    }

    public function updateCate($id, $data){
        return $this->where('id', $id)
                    ->update($data);
    }
}
