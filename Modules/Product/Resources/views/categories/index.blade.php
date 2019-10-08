@extends('layouts.admin_default')
@section('title', trans('product::category.title'))
@section('content')
<section class="content-header">
    <h1>{{trans('product::category.title')}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">{{trans('product::category.list_category')}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
         
        </div>
        <!-- /.col -->
    </div>
</section>
@endsection