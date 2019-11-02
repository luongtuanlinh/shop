@extends('layouts.admin_default')
@section('title', trans('news::post_edit.title'))
@section('content')
    <section class="content-header">
        <h1>
            {{trans('news::post_edit.post_manage')}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="{{ route('news.news_post.index') }}"> {{trans('news::post_edit.list_post')}}</a></li>
            <li class="active">{{trans('news::post_edit.update')}}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            {!! Form::open(['method' => 'POST','id'=>'form-edit-post', 'route' => ['news.news_post.update', $post->id],'enctype'=>'multipart/form-data']) !!}
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('news::post_edit.title')}}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('news::includes.message')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{trans('news::post_edit.name')}} (*)</label>
                                    <input name="title" type="text" value="{{ $post->title }}" class="form-control" placeholder="Nhập tiêu đề danh mục" onchange="changeInput(this.value)">
                                </div>
                                <div class="form-group hidden">
                                    <label for="exampleInputEmail1">{{trans('news::post_edit.slug')}} (*)</label>
                                    <input id="slug" name="slug" type="text" value="{{ $post->slug }}" class="form-control" placeholder="Nhập đường dẫn URL">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{trans('news::post_edit.summary')}}</label>
                                    <textarea name="summary" class="form-control" placeholder="Nhập vào mô tả bài viết">{{ $post->summary }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{trans('news::post_edit.content')}} (*)</label>
                                    <div id="typeContentNews" class="col-md-12"> 
                                        <textarea id="post-data" name="data" class="form-control">{{ $post->data }}</textarea>
                                    </div>
                                    <!-- <div id="typeContentOther" class="col-md-12" style="display: {{$post->post_type != 'news' ? 'block' : 'none'}};">
                                        <table class="table table-responsive table-bordered">
                                            <thead>
                                            <th>Caption</th>
                                            <th>File</th>
                                            <th colspan="2">Action</th>
                                            </thead>
                                            <tbody id="body_files">
                                                @if($post->post_type != 'news')
                                                    <?php
                                                        $media = json_decode($post->media, true);
                                                        if(empty($media)){
                                                            $media = array();
                                                        }
                                                        $idx  = 1;
                                                    ?>
                                                @foreach($media as $item)
                                                    <tr class="tr_clone">
                                                        <td>
                                                            <textarea class="form-control" name="caption[]" placeholder="Input caption name here...">{{$item['caption']}}</textarea>
                                                        </td>
                                                        <td style="width: 40%;">
                                                            <input type="file" class="form-control" name="file[]">
                                                            <input type="hidden" name="link[]" value="{{$item['link']}}">
                                                            <a target="_blank" href="{{\Modules\News\Models\NewsPost::getDataUrl($item['link'])}}">File upload {{$idx}}</a>
                                                        </td>
                                                        <td style="width: 10%;" class="text-center">
                                                            <button type="button" onclick="return post.addRowFile(this,'edit');" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                                        </td>
                                                        <td style="width: 10%;" class="text-center">
                                                            <button type="button" onclick="return post.delRow(this);" class="btn btn-danger"><i class="fa fa-close"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php $idx ++;?>
                                                @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <button type="button" class="btn btn-primary" onclick="return post.addRowFile(undefined,'edit')"><i class="fa fa-plus"></i> Add row</button>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{trans('news::post_edit.type')}}</label>
                                    <select name="post_type" class="form-control" onchange="return post.changeType(this);">
                                        {{--<option value="pdf" {{ $post->post_type == 'pdf' ?'selected' : '' }}>PDF</option>--}}
                                        <option value="news" {{ $post->post_type == 'news' ?'selected' : '' }}>{{trans('news::post_edit.type_news')}}</option>
                                        <option value="sale" {{ $post->post_type == 'sale' ?'selected' : '' }}>Khuyến mại</option>
                                        {{--<option value="image" {{ $post->post_type == 'image' ?'selected' : '' }}>{{trans('news::post_edit.type_image')}}</option>--}}
                                        {{--<option value="video" {{ $post->post_type == 'video' ?'selected' : '' }}>{{trans('news::post_edit.type_video')}}</option>--}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Loại tin bài (*)</label>
                                    <select name="post_famous" class="form-control">
                                        <option value="0" {{ $post->post_famous == 0 ?'selected' : '' }}>Bài viết thường</option>
                                        <option value="1" {{ $post->post_famous == 1 ?'selected' : '' }}>Bài viết nổi bật</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{trans('news::post_edit.status')}}</label>
                                    <select name="post_status" class="form-control">
                                        <option value="0" {{$post->post_status == 0 ?'selected':''}}>{{trans('news::post_edit.temp')}}</option>
                                        <option value="1" {{$post->post_status == 1 ?'selected':''}}>{{trans('news::post_edit.release')}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{trans('news::post_edit.avatar')}}</label>
                                    <input type="file" name="thumbnail" class="form-control preview-upload-image"/>
                                    <img @if($post->thumbnail!="") src="{{ \Modules\News\Models\NewsPost::getDataUrl($post->thumbnail)}}" @else src="{{asset('/img/placeholder.jpg')}}" @endif  class="preview-feature-image preview-image"/>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{trans('news::post_edit.published_at')}}</label>
                                    <div class='input-group date'>
                                        <input type='text' class="form-control" name="published_at" id="datetimepicker1" value="{{ \Carbon\Carbon::parse($post->published_at)->format('d-m-Y H:i')}}" />
                                        <label class="input-group-addon btn" for="date">
                                            <span class="fa fa-calendar open-datetimepicker"></span>
                                        </label>
                                    </span>
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
                        <div class="col-md-6 text-right"><button type="submit" class="btn btn-primary">{{trans('news::post_edit.save')}}</button></div>
                        <div class="col-md-6 text-left"><a href="{{ route('news.news_post.index') }}" class="btn btn-default">{{trans('news::post_edit.cancel')}}</a></div>
                    </div>
                </div>

            <input class="id" name="id" value="{{$post->id}}" style="display:none" >

            {!! Form::close() !!}
        </div>
        <!-- Modal add Category -->
        @include('news::includes.post.modal_add_category')
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('admin-lte/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/iCheck/icheck.min.js') }}"></script>
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
                $.ajax({
                    url : '{{route('news.news_category.store')}}',
                    type: 'POST',
                    data: data,
                    success : function (data) {
                        $('.list-categories').append('<div class="checkbox">'+
                            '<label> <input type="checkbox" name="category[]" value="'+data.id+'"/>'+data.name +'</label></div>');
                        $('#addCat').modal('hide');
                    },
                    error: function (data) {
                        if(data.responseText.name != ''){
                            $('#alert-cat-add').append('<div class="alert alert-danger" >Vui lòng nhập vào tên</div>')
                        }else {
                            $('#alert-cat-add').append('<div class="alert alert-danger" >Có lỗi xảy ra vui lòng thử lại</div>')
                        }
                    }
                })
                return false;
            });
            $('#form-edit-post').bind("keypress", function(e) {
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
