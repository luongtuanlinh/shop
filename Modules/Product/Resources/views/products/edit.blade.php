@extends('layouts.admin_default')
@section('title', trans('product::product.title'))
@section ('before-styles-end')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}"> 
@stop
@section('content')
<section class="content-header">
    <h1>{{trans('product::product.title_edit')}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="{{ route('product.product.index') }}">{{ trans('product::product.title') }}</a></li>
        <li class="active">{{ trans('product::product.edit') }}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">           
            <div class="box box-primary" style="padding: 10px 5px;">
                {!! Form::open(['method' => 'PATCH', 'route' => ['product.product.update', $product->id], 'class' => 'validate','enctype'=>'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ trans('product::product.name') }}(*)</label>
                            <input name="name" type="text" class="form-control" value="{{ $product->name }}" placeholder="{{ trans('product::product.enter_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.price') }}(*)</label>
                            <input name="price" type="number" class="form-control" value="{{ $product->price }}" placeholder="{{ trans('product::product.enter_price') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.material') }}(*)</label>
                            <input name="material" type="text" class="form-control" value="{{ $product->material }}" placeholder="{{ trans('product::product.enter_material') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.description') }}</label>
                            <textarea name="description" type="text" class="form-control" placeholder="{{trans('product::product.enter_description')}}" required> {{ $product->description }} </textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.category') }}</label>
                            {!! Form::select('category_id', $selectedCategories, $product->category_id, ['class'=>'form-control select2']) !!}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.origin') }}</label>
                            <input name="location" type="text" class="form-control" value="{{ $product->location }}" placeholder="{{ trans('product::product.enter_origin') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Trang thái</label>
                            <select class="form-control" name="has_quantity">
                                <option value="0" {{ ($product->has_quantity == 0) ? "selected" : "" }}>Hết hàng</option>
                                <option value="1" {{ ($product->has_quantity == 1) ? "selected" : "" }}>Còn hàng</option>
                            </select>
                        </div>
                        <hr>
                        <h3>Phân loại sản phẩm</h3>
                        <div class="form-group row no-margin-lr">
                            <label class="col-sm-2 col-form-label no-padding">S :</label>
                            <div class="col-sm-10 no-padding">
                                <input type="text" data-role="tagsinput" class="form-control" name="size[]" value="{{ isset($listSize[1]) > 0 ? $listSize[1] : '' }}">
                                <input type="text" class="form-control product-amount" name="amount[]" value="{{ isset($listAmount[1]) > 0 ? $listAmount[1] : '' }}">
                            </div>
                        </div>
                        <div class="form-group row no-margin-lr">
                            <label class="col-sm-2 col-form-label no-padding">M :</label>
                            <div class="col-sm-10 no-padding">
                                <input type="text" data-role="tagsinput" class="form-control" name="size[]" value="{{ isset($listSize[2]) > 0 ? $listSize[2] : '' }}">
                                <input type="text" class="form-control product-amount" name="amount[]" value="{{ isset($listAmount[2]) > 0 ? $listAmount[2] : '' }}">
                            </div>
                        </div>
                        <div class="form-group row no-margin-lr">
                            <label class="col-sm-2 col-form-label no-padding">L :</label>
                            <div class="col-sm-10 no-padding">
                                <input type="text" data-role="tagsinput" class="form-control" name="size[]" value="{{ isset($listSize[3]) > 0 ? $listSize[3] : '' }}">
                                <input type="text" class="form-control product-amount" name="amount[]" value="{{ isset($listAmount[3]) > 0 ? $listAmount[3] : '' }}">
                            </div>
                        </div>
                        <div class="form-group row no-margin-lr">
                            <label class="col-sm-2 col-form-label no-padding">XL :</label>
                            <div class="col-sm-10 no-padding">
                                <input type="text" data-role="tagsinput" class="form-control" name="size[]" value="{{ isset($listSize[4]) > 0 ? $listSize[4] : '' }}">
                                <input type="text" class="form-control product-amount" name="amount[]" value="{{ isset($listAmount[4]) > 0 ? $listAmount[4] : '' }}">
                            </div>
                        </div>
                        <div class="form-group row no-margin-lr">
                            <label class="col-sm-2 col-form-label no-padding">XXL :</label>
                            <div class="col-sm-10 no-padding">
                                <input type="text" data-role="tagsinput" class="form-control" name="size[]" value="{{ isset($listSize[5]) > 0 ? $listSize[5] : '' }}">
                                <input type="text" class="form-control product-amount" name="amount[]" value="{{ isset($listAmount[5]) > 0 ? $listAmount[5] : '' }}">
                            </div>
                        </div>
                        <div class="form-group row no-margin-lr">
                            <label class="col-sm-2 col-form-label no-padding">XXXL :</label>
                            <div class="col-sm-10 no-padding">
                                <input type="text" data-role="tagsinput" class="form-control" name="size[]" value="{{ isset($listSize[6]) > 0 ? $listSize[6] : '' }}">
                                <input type="text" class="form-control product-amount" name="amount[]" value="{{ isset($listAmount[6]) > 0 ? $listAmount[6] : '' }}">
                            </div>
                        </div>
                        <hr>
                        <h3>Thông tin seo sản phẩm</h3>
                        <div class="form-group">
                            <label>{{ trans('product::product.seo_title') }}</label>
                            <input name="seo_title" type="text" class="form-control" value="{{ $product->seo_title }}{{ old('seo_title') }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.seo_des') }}</label>
                            <textarea name="seo_description" type="text" class="form-control"> {{ $product->seo_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.seo_key') }}</label>
                            <textarea name="seo_key" type="text" class="form-control">{{ $product->seo_key }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ trans('product::product.cover1') }}</label>
                            <input type="file" name="cover_path[]" class="form-control preview-upload-image"/>
                            <img src="{{ ($product->cover_path[0] != null) ? url($product->cover_path[0]) : '' }}" alt="" class="preview-feature-image preview-image" required/>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.cover2') }}</label>
                            <input type="file" name="cover_path[]" class="form-control preview-upload-image"/>
                            <img src="{{ ($product->cover_path[1] != null) ? url($product->cover_path[1]) : '' }}" alt="" class="preview-feature-image preview-image" required/>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.cover3') }}</label>
                            <input type="file" name="cover_path[]" class="form-control preview-upload-image"/>
                            <img src="{{ ($product->cover_path[2] != null) ? url($product->cover_path[2]) : '' }}" alt="" class="preview-feature-image preview-image"/>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.cover4') }}</label>
                            <input type="file" name="cover_path[]" class="form-control preview-upload-image"/>
                            <img src="{{ ($product->cover_path[3] != null) ? url($product->cover_path[3]) : '' }}" alt="" class="preview-feature-image preview-image"/>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('product::product.cover5') }}</label>
                            <input type="file" name="cover_path[]" class="form-control preview-upload-image"/>
                            <img src="{{ ($product->cover_path[4] != null) ? url($product->cover_path[4]) : '' }}" alt="" class="preview-feature-image preview-image"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a href="{{ route('product.product.index') }}" class="btn btn-default pull-right">{{trans('product::product.cancel')}}</a>
                {!! Form::button( trans('product::product.save'), ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection