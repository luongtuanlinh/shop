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
        <li><a href="{{ route('product.product.index') }}">{{trans('product::product.title')}}</a></li>
        <li class="active">{{trans('product::product.add')}}</li>
    </ol>
</section>
<section class="content">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">           
        <div class="box box-primary" style="padding: 10px 5px;">
        </div>
    </div>
</div>
</section>
@endsection