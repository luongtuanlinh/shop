<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Validator;
use Response;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category){
        $this->product = $product;
        $this->category = $category;
    }

    public function getProductForTopic(Request $request) {
        try{
            $listCateParent = Category::where('parent_id', 0)
                                       ->get();
            $listData = array();
            if (count($listCateParent) > 0) {
                foreach($listCateParent as $key => $value) {
                    $listData[$key] = Product::with('category')
                                              ->whereNull('deleted_at')
                                              ->where('status', 1)
                                              ->whereHas('category', function($q) use ($value){
                                                    $q->where('parent_id', $value->id);
                                                })
                                              ->get();
                }
                $listDataFirst = Product::with('category')
                                    ->whereNull('deleted_at')
                                    ->where('status', 2)
                                    ->get();

                if ($listData) {
                    return Response::json([
                        'status' => 200,
                        'result' => $listData,
                        'firstList' => $listDataFirst
                    ]);
                } else {
                    return Response::json([
                        'status' => 404,
                        'message' => 'Không tìm thấy dữ liệu'
                    ]);
                }
            }

        }catch (\Exception $ex){
            return response()->json(['status' => 403, $ex->getMessage()]);
        }
    }

    public function getDetaiProduct(Request $request) {
        try{
            $id = $request->id;
            
            if (!$id) {
                return response()->json(['success' => 500, 'Invalid id']);
            }
            $product = $this->product->getProductById($id);

            if ($product) {
                if ($product->cover_path != null) {
                    $product->cover_path = json_decode($product->cover_path);
                    $arr = array();
                    foreach ($product->cover_path as $key => $path) {
                        if ($path) {
                            $arr[$key] = url($path);
                        } else {
                            $arr[$key] = null;
                        }
                    }
                    $product->cover_path = $arr;
                }
               
                return Response::json([
                    'status' => 200,
                    'result' => $product
                ]);
            } else {
                return Response::json([
                    'status' => 404,
                    'message' => 'Không tìm thấy dữ liệu'
                ]);
            }
        } catch (\Exception $ex){
            return response()->json(['status' => 403, $ex->getMessage()]);
        }
    }

    public function getProductByCategory(Request $request) {
        // try{
            $cate_id = $request->id;
            if (!$cate_id) {
                return response()->json(['success' => 500, 'Invalid category id']);
            }
            $product = $this->product->getProductByCategory($cate_id);
            return $product;

            if ($product) {
                if ($product->cover_path != null) {
                    $product->cover_path = json_decode($product->cover_path);
                    $arr = array();
                    foreach ($product->cover_path as $key => $path) {
                        if ($path) {
                            $arr[$key] = url($path);
                        } else {
                            $arr[$key] = null;
                        }
                    }
                    $product->cover_path = $arr;
                }
                return Response::json(['status' => 200, 'result' => $product]);
            } else {
                return Response::json(['status' => 404, 'message' => 'Không tìm thấy dữ liệu']);
            }
        // } catch (\Exception $ex){
        //     return Response::json(['status' => 500, 'message' => 'Đã có lỗi xảy ra']);
        // }
    }
}
