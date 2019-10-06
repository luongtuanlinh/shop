@extends('layouts.admin_default')
@section('title', trans('core::user.title'))
@section('content')
    <section class="content-header">
        <h1>{{trans('core::user.title')}}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('core.user.index') }}"> {{trans('core::user.list_user')}}</a></li>
            <li class="active">{{trans('core::user.update')}}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('core::user.edit_user')}}</h3>
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
                    @if(session()->has('messages'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> {{trans('news::category_index.alert')}}</h4>
                            {{session('messages')}}
                        </div>
                    @else
                    @endif
                {!! Form::open(['method' => 'POST', 'route' => ['core.user.update_information', $user->id], 'class' => 'validate','enctype'=>'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Email(*)</label>
                            <input name="email" type="email" value="{{$user->email}}" class="form-control" placeholder="{{trans('core::user.enter_email')}}" required>
                        </div>
                        <div class="form-group">
                            <label>Tên đăng nhập(*)</label>
                            <input name="username" type="textbox" value="{{$user->username}}" class="form-control" placeholder="{{trans('core::user.enter_name')}}" required>
                        </div>

                        <label><input type="checkbox" id="check_change_password" name="check_change_password" value="0">     {{trans('core::user.change_password')}}</label>


                        <div class="form-group">
                            <label>{{trans('core::user.password')}}(*)</label>
                            <input name="password" type="password" class="form-control password" placeholder="{{trans('core::user.enter_password')}}" readonly>
                        </div>

                        <div class="form-group">
                            <label>{{trans('core::user.password_again')}}(*)</label>
                            <input name="password_confirmation" type="password" class="form-control password_confirmation" placeholder="{{trans('core::user.enter_password_again')}}" readonly>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group" style="display: none;">
                            <label>{{trans('core::user.user_role')}}</label>
                            {!! Form::select('roles[]', $roles, $user_roles, ['class'=>'form-control select2', 'multiple'=>'true']) !!}
                        </div>
                        <div class="form-group" style="display: none;">
                            <label>{{trans('core::user.user_group')}}</label>
                            {!! Form::select('groups[]', $groups, $user_groups, ['class'=>'form-control select2', 'multiple'=>'true']) !!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ảnh đại diện</label>
                            <input type="file" name="avatar" class="form-control preview-upload-image"/>
                            <img @if($user->avatar!="") src="{{ asset('img/user/').'/'.$user->avatar}}" @else src="{{asset('/img/placeholder.jpg')}}" @endif  class="preview-feature-image preview-image"/>
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="/admin" class="btn btn-default pull-right">{{trans('core::user.cancel')}}</a>
                {!! Form::button(trans('core::user.update'), ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        $('input').on('ifChecked',function(event){
            $('.password').prop('required',true);
            $('.password_confirmation').prop('required',true);
            $('.password').prop('readonly',false);
            $('.password_confirmation').prop('readonly',false);


        })
        $('input').on('ifUnchecked',function(event){
            $('.password').prop('required',false);
            $('.password_confirmation').prop('required',false);
            $('.password').prop('readonly',true);
            $('.password_confirmation').prop('readonly',true);
            $('.password').val("");
            $('.password_confirmation').val("");
        })
    </script>
@endsection
