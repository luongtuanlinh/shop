<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [];
    protected $table = "categories";

    public function getCategory(){
        $data = Category::where('status', 0)
                        ->where('parent_id', 0)
                        ->get();
        $listCate = array();
        foreach ($data as $key => $value) {
            $listCate[$key] = array();
            array_push($listCate[$key], $value);
           
            $itemData = Category::where('status', 0)
                                ->where('parent_id', $value->id)
                                ->get();
            foreach ($itemData as $item) {
                array_push($listCate[$key], $item);
            }
        }
        return $listCate;
    }

    public function insertCate($data){
        return $this->insert($data);
    }

    public function updateCate($id, $data){
        return $this->where('id', $id)
                    ->update($data);
    }
    
}
