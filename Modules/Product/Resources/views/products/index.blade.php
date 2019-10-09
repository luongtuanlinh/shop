@extends('layouts.admin_default')
@section('title', trans('product::product.title'))
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
            <div class="body table-responsive">
                <table class="table table-hover table-bordered txt-center">
                    <thead>
                        <tr class="bg-cyan">
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Loại sản phẩm</th>
                            <th>Ảnh</th>
                            <th>End</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>In</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
</section>
@endsection