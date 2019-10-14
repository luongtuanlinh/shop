<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Category;
use DB;
use Validator;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category){
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $categories = $this->category->getCategory();
        return view('product::categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('product::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $cate_name = $request->cate_name;
        $parent_id = $request->parent_id ? $request->parent_id : 0;

        // $validatorArray = [
        //     'cate_name' => 'required',
        // ];

        // $validator = Validator::make($request->all(), $validatorArray);
        // if ($validator->fails()) {
        //     $message = $validator->errors();
        //     return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        // }
       
        $time = date('Y-m-d H:i:s');
        $data = [
            'cate_name'     => $cate_name,
            'parent_id'     => $parent_id,
            'created_at'    => $time
        ];
        $create_category = $this->category->insertCate($data);

        if ($create_category) {
            return redirect()->back()->withFlashSuccess( @trans('product::notify.add_cate_success') );
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
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('product::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
    }

    public function editCategory(Request $request) {
        $cate_id = $request->cate_id;
        $cate_name = $request->cate_name;
        
        if ( !$cate_name || $cate_name == null ) {
            return redirect()->back()->withFlashWarning('Tên danh mục không được phép để trống');
        }
        $time = date('Y-m-d H:i:s');
        $data = [
            'cate_name'   => $cate_name,
            'updated_at'  => $time
        ];

        $update_category = $this->category->updateCate($cate_id, $data);

        if ($update_category) {
            return redirect()->back()->withFlashSuccess( @trans('product::notify.edit_cate_success') );
        } else {
            return redirect()->back()->withFlashDanger( @trans('product::notify.has_err') );
        }
    }

    public function deleteCategory(Request $request) {
        $cate_id = $request->cate_id;
        
        if ( !$cate_id || $cate_id == null ) {
            return redirect()->back()->withFlashWarning( @trans('product::notify.has_err') );
        }

        $time = date('Y-m-d H:i:s');

        //check count of product in this category, if count >1 -> errr

        $delete_category = DB::transaction(function () use($cate_id, $time) {
            $data = [
                'status'   => -1,
                'deleted_at'  => $time
            ];

            Category::where('id', $cate_id)
                    ->update($data);

            Category::where('parent_id', $cate_id)
                    ->update($data);
            });

        if (empty($delete)) {
            return redirect()->back()->withFlashSuccess( @trans('product::notify.delete_cate_success') );
        } else {
            return redirect()->back()->withFlashDanger (@trans('product::notify.has_err') );
        }
    }
}
