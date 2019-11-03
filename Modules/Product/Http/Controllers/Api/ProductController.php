<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Size;
use Modules\Product\Entities\Color;
use Validator;
use Response;
use stdClass;
use Datetime;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category){
        $this->product = $product;
        $this->category = $category;
    }

    public function getProductForTopic(Request $request) {
        // try{
            $listCateParent = Category::where('parent_id', 0)
                                        ->whereNull('deleted_at')
                                        ->get();
            $listData = array();
            if (count($listCateParent) > 0) {
                foreach($listCateParent as $key => $value) {
                    $listData[$key] = new stdClass();
                    $listData[$key]->category = $value;

                    $listProduct = $this->product->getProductHome($value->id);
                    $listProduct = $this->convertImageHome($listProduct);

                    $listData[$key]->product = $listProduct;
                }
                $getDataFirst = $this->product->getProductFirst();
                $listDataFirst = $this->convertImageHome($getDataFirst);

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

        // }catch (\Exception $ex){
        //     return response()->json(['status' => 403, $ex->getMessage()]);
        // }
    }

    public function convertImageHome($listProduct) {
        foreach($listProduct as $key => $item) {
            if ($item->cover_path != null) {
                $listPath = json_decode($item->cover_path);
                $listProduct[$key]->cover_path1 = $listPath[0] ? url($listPath[0]) : null;
                $listProduct[$key]->cover_path2 = $listPath[1] ? url($listPath[1]) : null;
            } else {
                $listProduct[$key]->cover_path1 = null;
                $listProduct[$key]->cover_path2 = null;
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
                    $arr_path = (array)$product->cover_path;
                    $arr = array();
                    foreach ($arr_path as $key => $path) {
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
                $product = $this->convertImageHome($product);
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

    public function getSizeColor() {
        $listSize = Size::all();
        $listColor = Color::all();
        if ($listSize) {
            return Response::json(['status' => 200, 'listSize' => $listSize, 'listColor' => $listColor]);
        } else {
            return Response::json(['status' => 404, 'message' => 'Không tìm thấy dữ liệu']);
        }
    }

    public function getCategoryById(Request $request) {
        try {
            $id = $request->id;
            $category = Category::where('id', $id)->first();
            if ($category) {
                return Response::json(['status' => 200, 'result' => $category]);
            } else {
                return Response::json(['status' => 404, 'message' => 'Không tìm thấy dữ liệu']);
            }
        } catch (\Exception $ex) {
            return Response::json(['status' => 500, 'message' => 'Đã có lỗi xảy ra']);
        }
    }

    public function getProduct(Request $request) {
        // try {
            //Params
            $params = $request->all();
            $page = isset($params['page']) ? (int)$params['page'] : 1;
            $pageSize = isset($params['page_size']) ? (int)$params['page_size'] : 12;

            //Sortby
            $sortBy = isset($params['sort_by']) ? $params['sort_by'] : 'created_at';
            $sortType = isset($params['sort_type']) ? $params['sort_type'] : "ASC";
            
            //sort size and color
            $size_id = isset($params['size_id']) ? $params['size_id'] : 'all';
            $color_id = isset($params['color_id']) ? $params['color_id'] : "all";

            //sort by price

            $result = array();
            $query = Product::with(['sales' => function ($sale) {
                                    $dayNow = new DateTime();
                                    $sale->where('end_time', '>=', $dayNow);
                                }])
                                ->with('category')
                                ->whereNull('deleted_at');
            $cate_id = isset($params['cate_id']) ? $params['cate_id'] : null;
            if ($cate_id != null) {
                $query = $query->whereHas('category', function($q) use ($cate_id){
                            $q->where('id', $cate_id)
                            ->orWhere('parent_id', $cate_id);
                        });
            }

            if ($size_id != 'all' && $color_id == 'all') {
                $query = $query->whereHas('colors', function($q) use ($size_id){
                    $q->where('size_id', $size_id);
                });
            }

            if ($color_id != 'all' && $size_id == 'all') {
                $query = $query->whereHas('colors', function($q) use ($color_id){
                    $q->where('color_id', $color_id);
                });
            }

            if ($color_id != 'all' && $size_id != 'all') {
                $query = $query->whereHas('colors', function($q) use ($color_id, $size_id){
                    $q->where('color_id', $color_id)
                      ->where('size_id', $size_id);
                });
            }

            $query = $query->orderby($sortBy, $sortType);

            $listData = $query->paginate($pageSize, ['*'], 'page', $page);
            $listData = $this->convertImageHome($listData);
            if ($listData) {

                if ($cate_id == null) {
                    $listCate = $this->category->getCateParent();
                } else {
                    $listCate = Category::where('parent_id', $cate_id)
                                        ->whereNull('deleted_at')
                                        ->get();
                }
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
        // } catch (\Exception $ex) {
        //     return $this->errorResponse([], $ex->getMessage());
        // }
    }
}
