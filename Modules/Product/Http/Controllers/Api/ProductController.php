<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Validator;
use Response;
use stdClass;

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
                                        ->whereNull('deleted_at')
                                        ->get();
            $listData = array();
            if (count($listCateParent) > 0) {
                foreach($listCateParent as $key => $value) {
                    $listData[$key] = new stdClass();
                    $listData[$key]->category = $value;
                    if ($key < 3) {
                        $listProduct = Product::with('category')
                                                ->with('sales')
                                                ->whereNull('deleted_at')
                                                ->where('status', 1)
                                                ->whereHas('category', function($q) use ($value){
                                                    $q->where('id', $value->id)
                                                        ->orWhere('parent_id', $value->id);
                                                })
                                                ->get();
                        $listProduct = $this->convertImageHome($listProduct);
                        $listData[$key]->product = $listProduct;
                    }
                }
                $listDataFirst = $this->product->getProductFirst();
                $listDataFirst = $this->convertImageHome($listDataFirst);

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

    public function convertImageHome($listProduct) {
        foreach($listProduct as $key => $item) {
            if ($item->cover_path != null) {
                $listPath = json_decode($item->cover_path);
                $listProduct[$key]->cover_path1 = null ;
                $listProduct[$key]->cover_path2 = url($listPath[0]);
            }
        }
        return $listProduct;
    }

    public function convertImage($listProduct) {
        foreach($listProduct as $key => $item) {
            if ($item->cover_path != null) {
                $listPath = json_decode($item->cover_path);
                $newArr = array();
                foreach ($listPath as $key2 => $path) {
                    if ($path) {
                        $newArr[$key2] = url($path);
                    } else {
                        $newArr[$key2] = null;
                    }
                }
                $listProduct[$key]->cover_path = $newArr;
            }
        }
        return $listProduct;
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

                $category = $this->category->getCategoryById($product->category_id);
                
                return Response::json([
                    'status' => 200,
                    'result' => $product,
                    'category' => $category
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
            $listCate = Category::where('parent_id', $cate_id)
                                ->whereNull('deleted_at')
                                ->get();
            if ($product) {
                foreach($product as $key => $item) {
                    if ($item->cover_path != null) {
                        $listPath = json_decode($item->cover_path);
                        $newArr = array();
                        foreach ($listPath as $key2 => $path) {
                            if ($path) {
                                $newArr[$key2] = url($path);
                            } else {
                                $newArr[$key2] = null;
                            }
                        }
                        $product[$key]->cover_path = $newArr;
                    }
                }
                return Response::json([
                    'status' => 200, 
                    'result' => $product,
                    'listCate' => $listCate
                    ]);
            } else {
                return Response::json(['status' => 404, 'message' => 'Không tìm thấy dữ liệu']);
            }
        // } catch (\Exception $ex){
        //     return Response::json(['status' => 500, 'message' => 'Đã có lỗi xảy ra']);
        // }
    }

    public function getCategory() {
        $categories = $this->category->getCategoryList();
        if ($categories) {
            return Response::json(['status' => 200, 'result' => $categories]);
        } else {
            return Response::json(['status' => 404, 'message' => 'Không tìm thấy dữ liệu']);
        }
    }

    public function getProduct(Request $request) {
        // try{
            $listData = Product::with('category')
                                ->with('sales')
                                ->whereNull('deleted_at')
                                ->get();
            $listCate = Category::where('parent_id', 0)
                                ->whereNull('deleted_at')
                                ->get();
            if ($listData) {
                return Response::json([
                    'status' => 200,
                    'result' => $listData,
                    'listCate' => $listCate
                ]);
            } else {
                return Response::json([
                    'status' => 404,
                    'message' => 'Không tìm thấy dữ liệu'
                ]);
            }

        // }catch (\Exception $ex){
        //     return response()->json(['status' => 403, $ex->getMessage()]);
        // }
    }
}
