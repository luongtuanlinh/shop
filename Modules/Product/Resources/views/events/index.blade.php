@extends('layouts.admin_default')
@section('title', trans('product::category.title'))
@section ('before-styles-end')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}"> 
@stop
@section ('scripts')
    <script src="{{ asset('product.js') }}"></script>
    <script>
    </script>
@stop

@section('content')
<section class="content-header">
    <h1>{{trans('product::category.title')}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">{{trans('product::category.list_category')}}</li>
    </ol>
</section>
<section class="content">
    <div id='flash-container' class='flash-container'>
        Saved.
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary" style="padding: 20px 30px;">
                <div class="box-action">
                    <button class="btn btn-primary btn-sm add-cate" data-toggle="modal" data-target="#modal-add-category" data-id="0">Thêm sự kiện mới</button>
                </div>
                <div class="profile-private main main_lecture">
                      
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
</section>

@endsection