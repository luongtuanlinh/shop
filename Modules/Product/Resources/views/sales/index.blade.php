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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">           
            <div class="box box-primary" style="padding: 10px 5px;">
                
            </div>
        </div>
    </div>
</section>
@endsection