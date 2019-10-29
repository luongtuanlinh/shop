@extends('layouts.admin_default')
@section('title', trans('news::media.media_manage'))
@section('content')
    <section class="content-header">
        <h1>
            {{trans('news::media.media_manage')}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
             <li class="active">{{trans('news::media.media_manage')}}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <iframe src="{{asset('admin-lte/plugins/filemanager/dialog.php?type=1&field_id=url_abs')}}" width="100%" height="500px"></iframe>
            </div>

        </div>
        <!-- /.row -->
    </section>
@endsection
@section('scripts')

@endsection
