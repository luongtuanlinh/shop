<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Yajra\Datatables\Datatables;
use Intervention\Image\Facades\Image as Image;
use Auth;
use Validator;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category){
        $this->product = $product;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('product::products/index');
        // $products = $this->product->getAllProduct();
        
        // foreach ($products as $key => $value) {
        //     if ($value->cover_path != null) {
        //         $products[$key]->cover_path = json_decode($value->cover_path);
        //     }
        // }
        // return view('product::products/index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $selectedCategories = array();
        $categories = Category::all();

        foreach($categories as $category) {
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
        $created_at = date('Y-m-d H:i:s');
        $admin_id = Auth::user()->id;

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

        if( $request->cover_path == null || count($request->cover_path) < 2 ) {
            return redirect()->back()->withFlashWarning( @trans('product::notify.min_upload') );
        }

        if( count($request->cover_path) > 5 ) {
            return redirect()->back()->withFlashWarning( @trans('product::notify.max_upload') );
        }

        $list_img = array();
        foreach ($request->cover_path as $key => $value) {
            $filename = '/img/product/_'.substr( md5('_' . time() ), 0, 15) .$key. '.png'; 
            $path = public_path( $filename );
            Image::make($value)->orientate()->save($path);
            array_push($list_img, $filename);
        }

        for( $i = 0; $i < 5; $i++) {
            if ( isset($request->cover_path[$i]) && $request->cover_path[$i] !== null) {
                $filename = '/img/product/_'.substr( md5('_' . time() ), 0, 15) .$i. '.png'; 
                $path = public_path( $filename );
                Image::make($request->cover_path[$i])->orientate()->save($path);
                $list_img[$i] = $filename;
            } else {
                $list_img[$i] = null;
            }
        }

        $array = [
            'name' => $name,
            'price' => $price,
            'material' => $material,
            'description' => $description,
            'admin_id' => $admin_id,
            'category_id' => $category_id,
            'cover_path' => json_encode($list_img),
            'created_at' => $created_at
        ];

        $created = $this->product->insertProduct($array);

        if ($created) {
            return redirect()->back()->withFlashSuccess( @trans('product::notify.add_product_success') );
        } else {
            return redirect()->back()->withFlashDanger( @trans('product::notify.has_err') );
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
        $categories = Category::all();
        $product = $this->product->getProductById($id);
        if ($product->cover_path != null) {
            $product->cover_path = json_decode($product->cover_path);
        }

        foreach($categories as $category) {
            $selectedCategories[$category->id] = $category->cate_name;
        }
        return view('product::products/edit', compact('selectedCategories', 'product'));
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
        $updated_at = date('Y-m-d H:i:s');
        $admin_id = Auth::user()->id;

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

        if( count($request->cover_path) > 5 ) {
            return redirect()->back()->withFlashWarning( @trans('product::notify.max_upload') );
        }

        $old_list_image = Product::select('cover_path')->where('id', $id)->get();
        $old_list_image = $old_list_image[0];
        $old_list_image = json_decode($old_list_image->cover_path);
        $list_img = array();

        for( $i = 0; $i < 5; $i++) {
            if ( isset($request->cover_path[$i]) && $request->cover_path[$i] !== null) {
                $filename = '/img/product/_'.substr( md5('_' . time() ), 0, 15) .$i. '.png'; 
                $path = public_path( $filename );
                Image::make($request->cover_path[$i])->orientate()->save($path);
                $list_img[$i] = $filename;
            } else {
                $link = $old_list_image[$i];
                $list_img[$i] = $link;
            }
        }

        $array = [
            'name' => $name,
            'price' => $price,
            'material' => $material,
            'description' => $description,
            'admin_id' => $admin_id,
            'category_id' => $category_id,
            'cover_path' => json_encode($list_img),
            'updated_at' => $updated_at
        ];

        $updated = $this->product->updateProduct($id, $array);

        if ($updated) {
            return redirect()->back()->withFlashSuccess( @trans('product::notify.edit_product_success') );
        } else {
            return redirect()->back()->withFlashDanger( @trans('product::notify.has_err') );
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteProduct(Request $request) {
        $id = $request->id;
        
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
            return redirect()->back()->withFlashSuccess( @trans('product::notify.delete_product_success') );
        } else {
            return redirect()->back()->withFlashDanger( @trans('product::notify.has_err') );
        }
    }

    public function get(Request $request)
    {
        $query = Product::with('category')->whereNull('deleted_at');

        return Datatables::of($query)
                ->escapeColumns([])
                ->addColumn('actions', function ($product) {
                    $html = Product::genColumnHtml($product);
                    return $html;
                })
                ->addColumn('cate_name', function ($product) {

                    return $product->category->cate_name;
                })
                ->addColumn('source', function ($product) {

                    return 'Trung quốc';
                })
                ->addColumn('cover_path', function ($product) {
                    if ($product->cover_path != null) {
                        $data = json_decode($product->cover_path);
                        $html = '';
                        foreach ($data as $key => $path) {
                            $html .= '<img class="image-product" src="'.( ($path != null) ? url($path) : "") .'">';
                        }
                        return $html;
                    }else{
                        return '';
                    }
                })
                ->make(true);
    }
}
