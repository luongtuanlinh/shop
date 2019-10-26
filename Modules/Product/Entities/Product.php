<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use DB;

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
        return $this->with('sales')
                    ->where("id", $id)->first();
    }

    public function getProductByCategory($cate_id) {
        return Product::with('category')
                    ->with('sales')
                    ->whereNull('deleted_at')
                    ->where('status', '!=' , -1)
                    ->whereHas('category', function($q) use ($cate_id){
                        $q->where('id', $cate_id)
                        ->orWhere('parent_id', $cate_id);
                    })
                    ->get();
    }

    public static function genColumnHtml($data){
        $message = "'Bạn có chắc chắn muốn xóa sản phẩm này?'";
        $collum = "";
        if(!empty($data)){
            $collum .= '<a type="button" href="' .route('product.product.edit', $data->id) .'" class="btn btn-primary btn-sm">Sửa</a>';
            $collum .= '<a href="'. route('product.product.delete', $data->id) .'" onclick="return confirm('.$message.')" class="btn btn-xs btn-danger"><i class="fa fa-trash">Xoá</i></a>';

            // if(Session::get('edit')) {
            //     $collum .= '<a type="button" href="' .route('product.product.edit', $data->id) .'" class="btn btn-primary btn-sm">Sửa</a>';
            // }
            // if(Session::get('destroy')){
            //     $collum .= '<a href="'. route('product.product.delete', $data->id) .'" onclick="return confirm('.$message.')" class="btn btn-xs btn-danger"><i class="fa fa-trash">Xoá</i></a>';
            // }
        }
        return $collum;
    }

    public static function genColumnChoose($data){
        $collum = "";
        if(!empty($data)){
            $collum .= '<input type="checkbox" value=" '. $data->id. '" name="dataChoose[]">';
        }
        return $collum;
    }
  
}
