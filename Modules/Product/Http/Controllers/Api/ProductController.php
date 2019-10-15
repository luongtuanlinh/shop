<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category){
        $this->product = $product;
        $this->category = $category;
    }

    public function getProductForTopic(Request $request) {

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getDetaiProduct(Request $request) {
        $id = $request->id;
        $product = $this->product->getProductById($id);

        if ($product) {
            return response()->json(['success' => true, 'data' => $product]);
        } else {
            return response()->json(['success' => false, 'message' => "Err"]);
        }
    }

    public function getProductByCategory(Request $request) {
        if ($product) {
            return response()->json(['success' => true, 'data' => $data]);
        } else {
            return response()->json(['success' => false, 'message' => "Err"]);
        }
    }
}
