@extends('layouts.admin_default')
@section('title', trans('product::sale.title'))
@section('content')
<section class="content-header">
    <h1>{{trans('product::sale.title')}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">{{trans('product::sale.list_sale')}}</li>
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