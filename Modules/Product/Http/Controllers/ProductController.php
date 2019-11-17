<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Size;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\ProductSize;
use Yajra\Datatables\Datatables;
use Intervention\Image\Facades\Image as Image;
use App\Models\KMsg;

use Auth;
use Modules\Product\Entities\Color;
use Validator;
use stdClass;
use DB;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $categories = Category::whereNull('deleted_at')->get();
        $actions = request()->route()->getAction();
        $controller = (explode("@",$actions['controller']));
        $controller = $controller[0];
        return view('product::products/index', compact('categories', 'controller'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $selectedCategories = array();
        $categories = Category::whereNull('deleted_at')->get();

        foreach ($categories as $category) {
            $selectedCategories[$category->id] = $category->cate_name;
        }

        return view('product::products/create', compact('selectedCategories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $price = $request->price;
        $material = $request->material;
        $description = $request->description;
        $category_id = $request->category_id;
        $seo_title = $request->seo_title;
        $seo_description = $request->seo_description;
        $seo_key = $request->seo_key;
        $origin = $request->origin;
        $created_at = date('Y-m-d H:i:s');
        $admin_id = Auth::user()->id;
        $listSize = $request->size;

        $validatorArray = [
            'name' => 'required',
            'price' => 'required',
            'material' => 'required',
            'category_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        }

        if ($request->cover_path == null || count($request->cover_path) < 2) {
            return redirect()->back()->withFlashWarning(@trans('product::notify.min_upload'));
        }

        if (count($request->cover_path) > 5) {
            return redirect()->back()->withFlashWarning(@trans('product::notify.max_upload'));
        }

        $list_img = array();
        foreach ($request->cover_path as $key => $value) {
            $filename = '/img/product/_' . substr(md5('_' . time()), 0, 15) . $key . '.png';
            $path = public_path($filename);
            Image::make($value)->orientate()->save($path);
            array_push($list_img, $filename);
        }

        for ($i = 0; $i < 5; $i++) {
            if (isset($request->cover_path[$i]) && $request->cover_path[$i] !== null) {
                $filename = '/img/product/_' . substr(md5('_' . time()), 0, 15) . $i . '.png';
                $path = public_path($filename);
                Image::make($request->cover_path[$i])->orientate()->save($path);
                $list_img[$i] = $filename;
            } else {
                $list_img[$i] = null;
            }
        }
        $product = new Product();
        $product->name = $name;
        $product->price = $price;
        $product->material = $material;
        $product->description = $description;
        $product->admin_id = $admin_id;
        $product->category_id = $category_id;
        $product->cover_path = json_encode($list_img);
        $product->created_at = $created_at;
        $product->seo_title = $seo_title;
        $product->seo_description = $seo_description;
        $product->seo_key = $seo_key;
        $product->location = $origin;
        $product->save();

        $product_id = $product->id;

        if ($product_id) {
            foreach ($listSize as $key => $value) {
                if ($value !== null ) {
                    $size_id = $key + 1;
                    $arr = [
                        'product_id' => $product_id,
                        'size_id' => $size_id,
                        'color' => $value,
                        'created_at' => $created_at
                    ];
                    $insertSize = ProductSize::insert($arr);
                }
            }
            return redirect()->route('product.product.index')->with('messages', @trans('product::notify.add_product_success'));
        } else {
            return redirect()->back()->withErrors(@trans('product::notify.has_err'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('product::products/index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $selectedCategories = array();
        $categories = Category::whereNull('deleted_at')->get();
        $product = $this->product->getProductById($id);

        $listSize = [];
        if (count($product->product_size) ) {
            foreach ($product->product_size as $key => $value) {
                $listSize[$value->size_id] = $value->color;
            }
        }
       
        if ($product->cover_path != null) {
            $product->cover_path = json_decode($product->cover_path);
        }

        foreach ($categories as $category) {
            $selectedCategories[$category->id] = $category->cate_name;
        }
        return view('product::products/edit', compact('selectedCategories', 'product', 'listSize'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->name;
        $price = $request->price;
        $material = $request->material;
        $description = $request->description;
        $category_id = $request->category_id;
        $seo_title = $request->seo_title;
        $seo_description = $request->seo_description;
        $seo_key = $request->seo_key;
        $location = $request->location;
        $has_quantity = $request->has_quantity;
        $updated_at = date('Y-m-d H:i:s');
        $admin_id = Auth::user()->id;
        $listSize = $request->size;

        $validatorArray = [
            'name' => 'required',
            'price' => 'required',
            'material' => 'required',
            'category_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        }

        $old_list_image = Product::select('cover_path')->where('id', $id)->get();
        $old_list_image = $old_list_image[0];
        $old_list_image = json_decode($old_list_image->cover_path);
        $list_img = array();

        if ($request->cover_path) {
            if (count($request->cover_path) > 5) {
                return redirect()->back()->withFlashWarning(@trans('product::notify.max_upload'));
            }

            for ($i = 0; $i < 5; $i++) {
                if (isset($request->cover_path[$i]) && $request->cover_path[$i] !== null) {
                    $filename = '/img/product/_' . substr(md5('_' . time()), 0, 15) . $i . '.png';
                    $path = public_path($filename);
                    Image::make($request->cover_path[$i])->orientate()->save($path);
                    $list_img[$i] = $filename;
                } else {
                    $link = $old_list_image[$i];
                    $list_img[$i] = $link;
                }
            }
        } else {
            $list_img = $old_list_image;
        }

        $array = [
            'name' => $name,
            'price' => $price,
            'material' => $material,
            'description' => $description,
            'admin_id' => $admin_id,
            'category_id' => $category_id,
            'cover_path' => json_encode($list_img),
            'updated_at' => $updated_at,
            'seo_title' => $seo_title,
            'seo_description' => $seo_description,
            'seo_key' => $seo_key,
            'location' => $location,
            'has_quantity' => $has_quantity
        ];

        $updated = $this->product->updateProduct($id, $array);
        foreach ($listSize as $key => $value) {
            $size_id = $key + 1;
            $arr = [
                'color' => $value,
                'updated_at' => $updated_at
            ];
            if (ProductSize::where('product_id', '=', $id)->where('size_id', $size_id)->exists()) {
                $updateSize = ProductSize::where('product_id', $id)->where('size_id', $size_id)->update($arr);
            } else {
                if($value != null) {
                    $arr_new = [
                        'product_id' => $id,
                        'size_id' => $size_id,
                        'color' => $value,
                        'created_at' => $updated_at
                    ];
                    $insertSize = ProductSize::insert($arr_new);
                }
            }
        }

        if ($updated) {
            return redirect()->route('product.product.index')->with('messages', @trans('product::notify.edit_product_success'));
        } else {
            return redirect()->back()->withErrors(@trans('product::notify.has_err'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ( !$id || $id == null ) {
            return redirect()->back()->withFlashWarning( @trans('product::notify.has_err') );
        }

        $time = date('Y-m-d H:i:s');

        $data = [
            'status'   => -1,
            'deleted_at'  => $time
        ];

        $delete_product =  $this->product->updateProduct($id, $data);

        if ($delete_product) {
            return redirect()->back()->with('messages', @trans('product::notify.delete_product_success'));
        } else {
            return redirect()->back()->withErrors(@trans('product::notify.has_err'));
        }
    }

    public function chooseData(Request $request) {
        $cate_id = $request->cate_id;
        if ($cate_id == 'undefined') {
            return back();
        }

        return view('product::products/first_choose', compact('cate_id'));
    }

    public function getChooseProduct(Request $request) {
        $listCateParent = $this->category->getCateParent();
        $listDataFirst = $this->product->getProductFirst();
        $listData = array();
        if (count($listCateParent) > 0) {
            foreach ($listCateParent as $key => $value) {
                $listData[$key] = new stdClass();
                $listProduct = $this->product->getProductHome($value->id);
                foreach ($listProduct as $key2 => $item) {
                    if ($item->cover_path != null) {
                        $listPath = json_decode($item->cover_path);
                        if ($listPath[0] != null) {
                            $listProduct[$key2]->cover_path1 = url($listPath[0]);
                        }
                    }
                }
                $listData[$key]->product = $listProduct;
                $listData[$key]->category = $value;
            }
            foreach ($listDataFirst as $key => $item) {
                if ($item->cover_path != null) {
                    $listPath = json_decode($item->cover_path);
                    if ($listPath[0] != null) {
                        $listDataFirst[$key]->cover_path = url($listPath[0]);
                    }
                }
            }
        }
        return view('product::products/first', compact('listData', 'listDataFirst'));
    }

    public function get(Request $request)
    {
        $query = Product::with('category')->whereNull('deleted_at');

        return Datatables::of($query)
            ->filter(function ($query) use ($request) {
                foreach ($request->all() as $key => $value) {
                    if (($value == "") || ($value == -1) || ($value == null)) { } else {
                        if ($key == 'category_id') {
                            $query->where('category_id', $value)
                                ->orWhereHas('category', function ($q) use ($value) {
                                    $q->where('parent_id', $value);
                                });
                        }
                    }
                }
            })
                ->escapeColumns([])
                ->addColumn('actions', function ($product) {
                    $html = Product::genColumnHtml($product);
                    return $html;
                })
                ->addColumn('cate_name', function ($product) {
                    if ($product->category && isset($product->category)){
                        return $product->category->cate_name;
                    } else {
                        return null;
                    }
                })
                ->addColumn('cover_path', function ($product) {
                    if ($product->cover_path != null) {
                        $data = json_decode($product->cover_path);
                        $data = (array)$data;
                        $html = '';
                        if ($data != null) {
                            $html .= '<img class="image-product" src="'.( ($data[0] != null) ? url($data[0]) : "") .'">';
                        }
                        return $html;
                    }else{
                        return '';
                    
                }
            })
            ->make(true);
    }

    public function getDataChoose(Request $request) {
        $query = Product::with('category')->whereNull('deleted_at');

        return Datatables::of($query)
            ->filter(function ($query) use ($request) {
                foreach ($request->all() as $key => $value) {
                    if (($value == "") || ($value == -1) || ($value == null)) { } else {
                        if ($key == 'category_id') {
                            if ($value != 0) {
                                $query->where('category_id', $value)
                                    ->where('status', '<>', 2)
                                    ->orWhereHas('category', function ($q) use ($value) {
                                        $q->where('parent_id', $value);
                                    });
                            } else {
                                $query->where('status', '<>', 1);
                            }
                        }
                    }
                }
            })
            ->escapeColumns([])
            ->addColumn('actions', function ($product) {
                $data = new stdClass();
                $data->status = $product->status;
                $data->id = $product->id;
                $data->cate_id = $product->category_id;
                $data = json_encode($data);
                return $data;
            })
            ->addColumn('cate_name', function ($product) {

                return $product->category->cate_name;
            })
            ->addColumn('cover_path', function ($product) {
                if ($product->cover_path != null) {
                    $data = json_decode($product->cover_path);
                    $data = (array)$data;
                    $html = '';
                    if ($data != null) {
                        $html .= '<img class="image-product" src="'.( ($data[0] != null) ? url($data[0]) : "") .'">';
                    }
                    return $html;
                } else {
                    return '';
                }
            })
            ->make(true);
    }

    public function updateChoosen(Request $request) {
        if ($request->ajax()) {
            $product_id = $request->product_id;
            $category_id = $request->cate_id;
            $status = $request->status;
            if(!$product_id) {
                return \response()->json([
                    'status' => 403,
                    'mess' => 'Dữ liệu đầu vào không đúng, hãy thử lại sau!',
                ]);
            }
            if ($category_id == 0) {
                if ($status == 1) {
                    $count =  Product::where('status', 2)
                                    ->whereNull('deleted_at')
                                    ->count();
                    if ($count >= 4) {
                        return \response()->json([
                            'status' => 403,
                            'mess' => 'Bạn chỉ được chọn tối đa 4 sản phẩm',
                        ]);
                    }

                    $update_new_data = Product::where('id', $product_id)
                                                ->update(['status' => '2']);
                } else {
                    $update_new_data = Product::where('id', $product_id)
                                                ->update(['status' => '0']);
                }

                if ($update_new_data) {
                    return \response()->json([
                        'status' => 200,
                        'mess' => 'Update success',
                    ]);
                } else {
                    return \response()->json([
                        'status' => 401,
                        'mess' => 'Đã có lỗi xảy ra, vui lòng thử lại sau!',
                    ]);
                }
                
            } else {
                
                if ($status == 1) {
                    $count_data = Product::where('status', 1)
                                    ->whereNull('deleted_at')
                                    ->whereHas('category', function($q) use ($category_id){
                                        $q->where('id', $category_id)
                                        ->orWhere('parent_id', $category_id);
                                    })
                                    ->count();
                    if ($count_data >= 4) {
                        return \response()->json([
                            'status' => 403,
                            'mess' => 'Bạn chỉ được chọn tối đa 4 sản phẩm',
                        ]); 
                    }
                    $update_new_data = Product::where('id', $product_id)
                                            ->whereHas('category', function($q) use ($category_id){
                                                $q->where('id', $category_id)
                                                ->orWhere('parent_id', $category_id);
                                            })
                                            ->update(['status' => '1']);
                } else {
                    $update_new_data = Product::where('id', $product_id)
                                            ->whereHas('category', function($q) use ($category_id){
                                                $q->where('id', $category_id)
                                                ->orWhere('parent_id', $category_id);
                                            })
                                            ->update(['status' => '0']);
                }

                if ($update_new_data) {
                    return \response()->json([
                        'status' => 200,
                        'mess' => 'Update success',
                    ]);
                } else {
                    return \response()->json([
                        'status' => 401,
                        'mess' => 'Đã có lỗi xảy ra, vui lòng thử lại sau!',
                    ]);
                }              
            }
        }
    }

    public function orderProductFilter(Request $request) {
        $result = new KMsg();
        if (empty($request->category_id)) {
            $result->message = "Something was wrong";
            $result->result = KMsg::RESULT_ERROR;
            return \response()->json($result);
        } else {
            $products = Product::select('id', 'name as text', 'price')->where('category_id', $request->category_id)->get();
            $result->message = $products;
            $result->result = KMsg::RESULT_SUCCESS;
            return \response()->json($result);
        }
    }

    public function orderSizeFilter(Request $request) {
        $result = new KMsg();
        if (empty($request->product_id)) {
            $result->message = "Some thing wrong";
            $result->result = KMsg::RESULT_ERROR;
            return \response()->json($result);
        } else {
            $html = "<option value=''>--Kích cỡ--</option>";
            $sizes = Size::join('product_size', 'sizes.id', '=', 'product_size.size_id')->where('product_size.product_id', $request->product_id)->get();
            foreach ($sizes as $size) {
                $html .= "<option value='".$size->size_id."'>".$size->size_name."</option>";
            }
            
            $result->message = $html;
            $result->result = KMsg::RESULT_SUCCESS;

            return \response()->json($result);
        }
    }

    public function orderColorFilter(Request $request) {
        $result = new KMsg();
        if (empty($request->product_id)) {
            $result->message = "Some thing wrong";
            $result->result = KMsg::RESULT_ERROR;
            return \response()->json($result);
        } else {
            $html = "<option value=''>--Màu sắc--</option>";
            // $colors = Color::join('color_product', 'colors.id', '=', 'color_product.color_id')->where('color_product.product_id', $request->product_id)->get();

            $colors = DB::table('product_size')->where('product_id', $request->product_id)->where('size_id', $request->size_id)->first()->color;
            $colors = explode(',', $colors);
            foreach ($colors as $color) {
                $html .= "<option value='".trim($color)."'>".trim($color)."</option>";
            }
            
            $result->message = $html;
            $result->result = KMsg::RESULT_SUCCESS;

            return \response()->json($result);
        }
    }

    public function addRow(Request $request) {
        $result = new KMsg();
        $index = $request->index + 1;
        $categories = Category::get();
        $html = view('orders::includes.order.orderProductAddRow', compact('index', 'categories'))->render();
        $result->message = $html;
        $result->result = KMsg::RESULT_SUCCESS;

        return \response()->json($result);
    }
}
