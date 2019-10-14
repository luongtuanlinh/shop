@extends('layouts.admin_default')
@section('title', trans('product::product.title'))
@section ('before-styles-end')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}"> 
@stop
@section ('scripts')
    <script>
        $(function(){
            $('.delete-product').click(function(){
                var product_id = $(this).data("id");
                $('#product_id').val(product_id);
            });
        });
    </script>
@stop
@section('content')
<section class="content-header">
    <h1>{{trans('product::product.title')}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">{{trans('product::product.list_product')}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">           
            <div class="box box-primary" style="padding: 10px 5px;">
                <div class="box-action">
                    <a class="btn btn-primary btn-sm add-cate" href="{{ route('product.product.create') }}">Thêm sản phẩm mới</a>
                </div>
                <div class="body table-responsive">
                    <table class="table table-hover table-bordered txt-center">
                        <thead>
                            <tr class="bg-cyan">
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Loại sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Ảnh</th>
                                <th>Chất liệu</th>
                                <th>Mô tả</th>
                                <th>Xuất xứ</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->category->cate_name }}</td>
                                <td>{{ $item->count }}</td>
                                <td>
                                    @if($item->cover_path != null)
                                    @foreach ($item->cover_path as $path)
                                        <img class="image-product" src="{{ ($path != null) ? url($path) : '' }}">
                                    @endforeach
                                    @endif
                                </td>
                                <td>{{ $item->material }}</td>
                                <td>{{ $item->description }}</td>
                                <td>Trung Quốc</td>
                                <td>
                                    <a type="button" href="{{ route('product.product.edit', $item->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                                    <a type="button" class="btn btn-danger btn-sm delete-product" data-toggle="modal" data-target="#modal-delete-product" data-id="{{ $item->id }}">Xóa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
</section>

<div id="modal-delete-product" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body box-add-cate">
                <form action="{{ route('product.product.deleteProduct') }}" method="POST" name="form-delete-product">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input type="hidden" name="id" id="product_id" />
                    <div class="title-modal">Xóa sản phẩm</div>
                    <div class="modal-box">
                        <p class="delete-confirm">Bạn có chắc chắn muốn xóa sản phẩm này?</p> 
                        <div class="box-btn">
                            <button class="btn btn-primary btn-sm" type="submit">Đồng ý</button>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal">Hủy</button>
                        </div>      
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection