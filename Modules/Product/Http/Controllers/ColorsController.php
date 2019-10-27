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

    public function createAmount($id, Request $request) {
        if($request->isMethod('post')){
            $size_id = $request->size_id;
            $color_id = $request->color_id;
            // $count = $request->count;
            if (!$color_id) {
                return redirect()->back()->withFlashWarning('Bạn phải chọn màu cho sản phẩm');
            }
            // if (!$count) {
            //     return redirect()->back()->withFlashWarning('Số lượng sản phẩm phải lớn hơn 0');
            // }

            //check exist color_id && size_id
            $checkExist = ProductColor::where('product_id', $id)
                            ->where('size_id', $size_id)
                            ->where('color_id', $color_id)
                            ->count();
            if ($checkExist > 0) {
                return redirect()->back()->withFlashWarning('Đã tồn tại size và màu, vui lòng chọn dữ liệu đầu vào khác!');
            }

            $created_at = date('Y-m-d H:i:s');

            $array = [
                'product_id' => $id,
                'size_id' => $size_id,
                'color_id' => $color_id,
                // 'count' => $count,
                'created_at' => $created_at
            ];
    
            $created = ProductColor::insert($array);
            if ($created) {
                // $this->updateCountProduct($id);
                return redirect()->back()->withFlashSuccess('Thêm thành công');
            } else {
                return redirect()->back()->withFlashDanger('Đã có lỗi xảy ra, vui lòng thử lại!');
            }
        }
        $sizes = Size::all();
        $colors = Color::all();
        $listSize = array();
        $listColor = array();

        foreach($sizes as $item) {
            $listSize[$item->id] = $item->size_name;
        }

        foreach($colors as $item) {
            $listColor[$item->id] = $item->color_name;
        }

        $productId = $id;
        return view('product::colors/createAmount', compact('listSize', 'productId', 'listColor'));
    }

    public function editAmount(Request $request) {
        $product_id = $request->product;
        $id = $request->id;
        $data = ProductColor::where('id', $id)->get();

        if ($data) {
            $data = $data[0];
        } else {
            return redirect()->back()->withFlashDanger('Đã có lỗi xảy ra, vui lòng thử lại!');
        }

        if($request->isMethod('post')){
            $size_id = $request->size_id;
            $color_id = $request->color_id;
            // $count = $request->count;
            if ( ($size_id == $data->size_id) && ($color_id == $data->color_id) ) {
                return redirect()->back();
            } else {
                $checkExist = ProductColor::where('product_id', $product_id)
                                    ->where('size_id', $size_id)
                                    ->where('color_id', $color_id)
                                    ->get();

                if( $checkExist[0]->id != $id ) {
                    return redirect()->back()->withFlashWarning('Đã tồn tại size và màu, vui lòng chọn dữ liệu đầu vào khác!');
                }

                $array = [
                    'size_id' => $size_id,
                    'color_id' => $color_id,
                    // 'count' => $count,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
        
                $updateData = ProductColor::where('id', $id)->update($array);
                if ($updateData) {
                    // $this->updateCountProduct($product_id);
                    return redirect()->back()->withFlashSuccess('Chỉnh sửa thành công');
                } else {
                    return redirect()->back()->withFlashDanger('Đã có lỗi xảy ra, vui lòng thử lại!');
                }
            }
        }

        $sizes = Size::all();
        $colors = Color::all();
        $listSize = array();
        $listColor = array();

        foreach($sizes as $item) {
            $listSize[$item->id] = $item->size_name;
        }

        foreach($colors as $item) {
            $listColor[$item->id] = $item->color_name;
        }

        $productId = $product_id;
        return view('product::colors/edit_amount', compact('listSize', 'productId', 'listColor', 'data'));
    }

    public function deleteAmount(Request $request) {
        $product_id = $request->product;
        $id = $request->id;
        if (!$id || !$product_id) {
            return redirect()->back()->withFlashDanger('Đã có lỗi xảy ra!');
        } else {
            $deleteData = ProductColor::where('id', $id)->delete();
            if ($deleteData) {
                // $this->updateCountProduct($product_id);
                return redirect()->back()->withFlashSuccess('Xóa dữ liệu thành công');
            } else {
                return redirect()->back()->withFlashDanger('Đã có lỗi xảy ra, vui lòng thử lại!');
            }
        }
    }

    public function updateCountProduct($id) {
        $countProduct = ProductColor::where('product_id', $id)->sum('count');
        $arr = [
            'count' => $countProduct,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Product::where('id', $id)->update($arr);
    }

    public function get(Request $request) {
        $query = ProductColor::with('size')
                    ->with('product')
                    ->with('color')
                    ->whereNull('deleted_at');

        return Datatables::of($query)
                ->filter(function ($query) use ($request) {
                    foreach ($request->all() as $key => $value) {
                        if (($value == "") || ($value == -1) || ($value == null)) {

                        } else {
                            if ($key == 'size_id') {
                                $query->where('size_id', $value);
                            }
                            if ($key == 'product_id') {
                                $query->where('product_id', $value);
                            }
                        }
                    }
                })
                ->escapeColumns([])
                ->addColumn('actions', function ($color) {
                    $html = ProductColor::genColumnHtml($color);
                    return $html;
                })
                ->addColumn('size_name', function ($color) {
                    if (isset($color->size)){
                        return $color->size->size_name;
                    } else {
                        return null;
                    }
                })
                ->addColumn('product_name', function ($color) {
                    if (isset($color->product)){
                        return $color->product->name;
                    } else {
                        return null;
                    }
                })
                ->addColumn('color_name', function ($color) {
                    if (isset($color->color)){
                        return $color->color->color_name;
                    } else {
                        return null;
                    }
                })
                ->make(true);
    }
}
