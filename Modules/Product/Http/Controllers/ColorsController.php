<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Color;
use Modules\Product\Entities\ProductColor;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Size;
use Yajra\Datatables\Datatables;
use DB;
use Validator;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id) {
        $listSize = Size::all();
        $productId = $id;
        return view('product::colors/index', compact('listSize', 'productId'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function getListColor()
    {
        $listColor = Color::whereNull('deleted_at')->paginate(20);
        return view('product::colors/create', compact('listColor'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $color_name = $request->color_name;

        $validatorArray = [
            'color_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        }
       
        $time = date('Y-m-d H:i:s');
        $data = [
            'color_name'    => $color_name,
            'created_at'    => $time
        ];
        $createColor = Color::insert($data);

        if ($createColor) {
            return redirect()->back()->withFlashSuccess('Thêm màu thành công!');
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
    public function update(Request $request) {
        $color_id = $request->color_id;
        $color_name = $request->color_name;
        
        if ( !$color_name || $color_name == null ) {
            return redirect()->back()->withFlashWarning('Tên màu không được phép để trống');
        }
        $time = date('Y-m-d H:i:s');
        $data = [
            'color_name'   => $color_name,
            'updated_at'  => $time
        ];

        $update_color = Color::where('id', $color_id)
                            ->update($data);

        if ($update_color) {
            return redirect()->back()->withFlashSuccess('Chỉnh sửa thành công!');
        } else {
            return redirect()->back()->withFlashDanger( @trans('product::notify.has_err') );
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($color_id)
    {
        if ( !$color_id || $color_id == null ) {
            return redirect()->back()->withFlashWarning( @trans('product::notify.has_err') );
        }

        $time = date('Y-m-d H:i:s');

        $countProduct = ProductColor::whereNull('deleted_at')
                                    ->where('color_id', $color_id)
                                    ->count();
        if ($countProduct > 0) {
            return redirect()->back()->withFlashWarning('Bạn không được phép xóa mã màu đã được dùng cho sản phẩm');  
        }
        
        $delete_color = Color::where('id', $color_id)->delete();
        if ($delete_color) {
            return redirect()->back()->withFlashSuccess('Xóa mã màu thành công!');
        } else {
            return redirect()->back()->withFlashDanger (@trans('product::notify.has_err') );
        }
    }
}
