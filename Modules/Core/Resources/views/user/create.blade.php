@extends('layouts.admin_default')
@section('title', trans('core::user.title'))
@section('content')
    <section class="content-header">
        <h1>{{trans('core::user.title')}}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="{{ route('core.user.index') }}"> {{trans('core::user.title')}}</a></li>
            <li class="active">{{trans('core::user.add')}}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('core::user.add_new_user')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            {!! Form::open(['method' => 'POST', 'route' => ['core.user.store'], 'class' => 'validate','enctype'=>'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Email(*)</label>
                            <input name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="{{trans('core::user.enter_email')}}" required>
                        </div>
                        <div class="form-group">
                            <label>Tên đăng nhập(*)</label>
                            <input name="username" type="textbox" value="{{ old('username') }}" class="form-control" placeholder="{{trans('core::user.enter_name')}}" required>
                        </div>
                        <div class="form-group">
                            <label>{{trans('core::user.password')}}(*)</label>
                            <input name="password" type="password" class="form-control" placeholder="{{trans('core::user.enter_password')}}" required>
                        </div>
                        <div class="form-group">
                            <label>{{trans('core::user.password_again')}}(*)</label>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="{{trans('core::user.enter_password_again')}}" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>{{trans('core::user.user_role')}}</label>
                            {!! Form::select('roles[]', $roles, old('roles[]'), ['class'=>'form-control select2', 'multiple'=>'true']) !!}
                        </div>
                        <div class="form-group">
                            <label>{{trans('core::user.user_group')}}</label>
                            {!! Form::select('groups[]', $groups, old('groups[]'), ['class'=>'form-control select2', 'multiple'=>'true']) !!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Avatar</label>
                            <input type="file" name="avatar" class="form-control preview-upload-image"/>
                            <img src="{{asset('/img/placeholder.jpg')}}" alt="" class="preview-feature-image preview-image"/>
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="/admin/user" class="btn btn-default pull-right">{{trans('core::user.cancel')}}</a>
                {!! Form::button(trans('core::user.save'), ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>
@endsection
