@extends('layouts.admin_default')
@section('title', trans('product::product.title'))
@section ('before-styles-end')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}"> 
@stop
@section('content')
<section class="content-header">
    <h1>{{trans('product::product.title_add')}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="{{ route('product.product.index') }}">{{ trans('product::product.title') }}</a></li>
        <li class="active">Thay đổi sản phẩm trang chủ</li>
    </ol>
</section>
<section class="content">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">           
        <div class="box box-primary" style="padding: 10px 25px;">
            <p class="trending">
                <span><i class="fa fa-circle" aria-hidden="true"></i></span> Sản phẩm nổi bật
                <a class="add-top" href=" {{ route('product.product.choose_poduct', 0) }}">Chọn</a>
            </p>
            @if ( count($listDataFirst) > 0)
            <div class="row">
                @foreach($listDataFirst as $item)
                <div class="col-md-3">
                    <div class="box-product">
                        <img class="img-product" src="{{ ($item->cover_path != null ) ? $item->cover_path : url('img/fashion.png') }}">
                        <p class="product-name">{{ $item->name }}</p>
                        <p>{{ $item->price }} vnd</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else 
            <p>Chưa có sản phẩm nổi bật</p>
            @endif
            @foreach($listData as $key => $value)
                <p class="trending">
                    <span><i class="fa fa-circle" aria-hidden="true"></i></span> Top sản phẩm {{ $value->category->cate_name }}
                    <a class="add-top" href=" {{ route('product.product.choose_poduct', $value->category->id) }}">Chọn</a>
                </p>
                @if ( count($value->product) > 0)
                <div class="row">
                    @foreach($value->product as $item)
                    <div class="col-md-3">
                        <div class="box-product">
                            <img class="img-product" src="{{ ($item->cover_path1 != null ) ? $item->cover_path1 : url('img/fashion.png') }}">
                            <p class="product-name">{{ $item->name }}</p>
                            <p>{{ $item->price }} vnd</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p>Chưa có sản phẩm nổi bật</p>
                @endif
            @endforeach
        </div>
    </div>
</div>
</section>
@endsection
