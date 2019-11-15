<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class Category extends Model
{
    protected $fillable = [];
    protected $table = "categories";

    public function getCategory(){
        $data = Category::where('status', 0)
                        ->where('parent_id', 0)
                        ->whereNull('deleted_at')
                        ->get();
        $listCate = array();
        foreach ($data as $key => $value) {
            $listCate[$key] = array();
            array_push($listCate[$key], $value);
           
            $itemData = Category::where('status', 0)
                                ->where('parent_id', $value->id)
                                ->whereNull('deleted_at')
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

    public function getCategoryById($id) {
        $data = $this->where('id', $id)->first();
        $parent_id = $data->parent_id;
        if ($parent_id != 0) {
            $data->parent_cate = $this->where('id', $parent_id)->first();
        } else {
            $data->parent_cate = null;
        }
        return $data;
    }

    public function getCategoryList(){
        $data = Category::where('status', 0)
                        ->where('parent_id', 0)
                        ->whereNull('deleted_at')
                        ->get();
        $listCate = array();
        foreach ($data as $key => $value) {
            $listCate[$key] = new stdClass();
            $listCate[$key]->parent = $value;
            $itemData = Category::where('status', 0)
                                ->where('parent_id', $value->id)
                                ->whereNull('deleted_at')
                                ->get();
            $listCate[$key]->child_cate = $itemData;
        }
        return $listCate;
    }

    public function getCateParent(){
        return $this->where('parent_id', 0)
                    ->whereNull('deleted_at')
                    ->get();
    }
    
}
