@extends('layouts.admin_default')
@section('title', trans('news::post_create.title'))
@section('content')
    <section class="content-header">
        <h1>
            {{trans('news::post_create.title')}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="{{ route('news.news_post.index') }}"> {{trans('news::post_create.list_post')}}</a></li>
            <li class="active">{{trans('news::post_create.add')}}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <form id="form-add-post" class="form-add-insurance-company" method="post" action="{{ route('news.news_post.index') }}" enctype="multipart/form-data">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('news::post_create.title')}}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('news::includes.message')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{trans('news::post_create.name')}} (*)</label>
                                <input name="title" type="text" value="{{ old('title') }}" class="form-control" placeholder="{{trans('news::post_create.placeholder_title')}}" onchange="changeInput(this.value)">
                            </div>
                            <div class="form-group hidden">
                                <label for="exampleInputEmail1">{{trans('news::post_create.slug')}} (*)</label>
                                <input id="slug" name="slug" type="text" value="{{ old('slug') }}" class="form-control" placeholder="{{trans('news::post_create.placeholder_slug')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{trans('news::post_create.summary')}}</label>
                                <textarea name="summary" class="form-control" placeholder="{{trans('news::post_create.placeholder_summary')}}"
                                maxlength="130"
                                >{{ old('summary') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{trans('news::post_create.content')}} (*)</label>
                                <div id="typeContentNews" class="col-md-12">
                                    <textarea id="post-data" name="data" class="form-control">{{ old('data') }}</textarea>
                                </div>
                                {{--<div id="typeContentOther" class="col-md-12">--}}
                                    {{--<table class="table table-responsive table-bordered">--}}
                                        {{--<thead>--}}
                                            {{--<th>Caption</th>--}}
                                            {{--<th>File</th>--}}
                                            {{--<th colspan="2">Action</th>--}}
                                        {{--</thead>--}}
                                        {{--<tbody id="body_files">--}}
                                            {{--<tr class="tr_clone">--}}
                                                {{--<td>--}}
                                                    {{--<textarea class="form-control" name="caption[]" placeholder="Input caption name here..."></textarea>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="file" class="form-control" name="file[]">--}}
                                                {{--</td>--}}
                                                {{--<td style="width: 10%;" class="text-center">--}}
                                                    {{--<button type="button" onclick="return post.addRowFile(this,'create');" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>--}}
                                                {{--</td>--}}
                                                {{--<td style="width: 10%;" class="text-center">--}}
                                                    {{--<button type="button" onclick="return post.delRow(this);" class="btn btn-danger"><i class="fa fa-close"></i></button>--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                        {{--</tbody>--}}
                                        {{--<tfoot>--}}
                                            {{--<tr>--}}
                                                {{--<td colspan="4" class="text-center">--}}
                                                    {{--<button type="button" class="btn btn-primary" onclick="return post.addRowFile()"><i class="fa fa-plus"></i> Add row</button>--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                        {{--</tfoot>--}}
                                    {{--</table>--}}
                                {{--</div>--}}

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{trans('news::post_create.type')}} (*)</label>
                                <select name="post_type" class="form-control" onchange="return post.changeType(this);">
{{--                                    <option value="pdf">PDF</option>--}}
                                    <option value="news">{{trans('news::post_create.type_news')}}</option>
                                    {{--<option value="image">{{trans('news::post_create.type_image')}}</option>--}}
                                    {{--<option value="video">{{trans('news::post_create.type_video')}}</option>--}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loại tin bài (*)</label>
                                <select name="post_famous" class="form-control">
                                    <option value="0">Bài viết thường</option>
                                    <option value="1">Bài viết nổi bật</option>
                                </select>
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">{{trans('news::post_create.cate')}} (*)   <i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="You just only choose level 3 category!"></i></label>--}}
                                {{--<div class="list-categories" style="height: 250px; overflow-y: scroll">--}}
                                    {{--{{menuAddInPost($categories,$listCatePermission)}}--}}

                                {{--</div>--}}
                                {{--<br>--}}
                                {{--<button id="load-cat-parent" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addCat">Thêm danh mục</button>--}}
                            {{--</div>--}}
                            <div class="form-group hidden">
                                <label for="exampleInputEmail1">{{trans('news::post_create.tag')}}</label><br>
                                <input type="text" value="" name="tags" data-role="tagsinput" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{trans('news::post_create.avatar')}}</label>
                                <input type="file" name="thumbnail" class="form-control preview-upload-image"/>
                                <img src="{{asset('/img/placeholder.jpg')}}" alt="" class="preview-feature-image preview-image"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{trans('news::post_create.published_at')}}</label>
                                <div class='input-group date'>
                                    <input type='text' class="form-control" id='datetimepicker1' name="published_at" value="{{ !empty(old('published_at')) ? old('published_at') : Carbon\Carbon::now()->format('d-m-Y H:i')}}" />
                                    <label class="input-group-addon btn" for="date">
                                        <span class="fa fa-calendar open-datetimepicker"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{trans('news::post_create.status')}}</label>
                                <select name="post_status" class="form-control">
                                    <option value="1">{{trans('news::post_create.release')}}</option>
                                    <option value="0">{{trans('news::post_create.temp')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class="box-footer">
                    <div class="row">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-6 text-right"><button type="submit" class="btn btn-primary">{{trans('news::post_create.save')}}</button></div>
                        <div class="col-md-6 text-left"><a href="{{ route('news.news_post.index') }}" class="btn btn-default">{{trans('news::post_create.cancel')}}</a></div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Modal add Category -->
        @include('news::includes.post.modal_add_category')
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('admin-lte/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{asset('js/tinymceConfig.js')}}"></script>
    <script src="{{asset('js/news_posts.js?v=1')}}"></script>

    <script>
        $(document).ready(function () {
            $('#load-cat-parent').click(function () {
                $.ajax({
                    url : '{{route('news.news_category.create')}}?action=get',
                    type: 'GET',
                    success: function (data) {
                        $.each(data, function( index, val ) {
                            $('#parent_cat').append('<option value="'+val.id+'">'+val.prefix+val.name+'</option>');
                        });
                    }
                });
            })
            $('#form-add-cat').submit(function () {
                var data = $(this).serialize();
                $('#form-add-cat').validate();
                $.ajax({
                    url : '{{route('news.news_category.store')}}',
                    type: 'POST',
                    data: data,
                    success : function (data) {
                        $('.list-categories').append('<div class="checkbox">'+
                            '<label> <input type="checkbox" name="category[]" value="'+data.id+'"/>'+data.name +'</label></div>');
                        $('#form-add-cat').trigger("reset");
                        $('#addCat').modal('hide');
                    },
                    error: function (data) {
                        if(data.responseText.name != ''){
                            $('#alert-cat-add').empty();
                            $('#alert-cat-add').append('<div class="alert alert-danger" >Vui lòng nhập vào tên</div>')
                        }else {
                            $('#alert-cat-add').append('<div class="alert alert-danger" >Có lỗi xảy ra vui lòng thử lại</div>')
                        }
                    }
                })
                return false;
            });
            $('#form-add-post').bind("keypress", function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    return false;
                }
            });
            $('[data-toggle="tooltip"]').tooltip();

            $('.input-group-addon').click(function () {
                $('#datetimepicker1').datetimepicker({
                    format :"DD-MM-YYYY"
                });
            })

        })

    </script>

@endsection
