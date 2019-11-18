<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = [];
    protected $table = "product_color";

    public function size() {
        return $this->belongsTo(Size::class,'size_id','id');
    }

    public function product() {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function color() {
        return $this->belongsTo(Color::class,'color_id','id');
    }

    public static function genColumnHtml($data){
        $message = "'Bạn có chắc chắn muốn xóa?'";
        $collum = "";
        if(!empty($data)){
            $collum .= '<a type="button" href="' .route('product.color.edit_amount', ['product' => $data->product_id, 'id' => $data->id]) .'" class="btn btn-primary btn-sm">Sửa</a>';
            $collum .= '<a href="'. route('product.color.delete_amount', ['product' => $data->product_id, 'id' => $data->id]) .'" onclick="return confirm('.$message.')" class="btn btn-sm btn-danger">Xóa</a>';
        }
        return $collum;
    }
}
