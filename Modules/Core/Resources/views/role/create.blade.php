@extends('layouts.admin_default')
@section('title', trans('core::role.title'))
@section('content')
    <section class="content-header">
        <h1>{{trans('core::role.title')}}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="{{ route('core.role.index') }}"> {{trans('core::role.title')}}</a></li>
            <li class="active">{{trans('core::role.add')}}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('core::role.add_new_role')}}</h3>
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
            {!! Form::open(['method' => 'POST', 'route' => ['core.role.store'], 'class' => 'validate']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>{{trans('core::role.name') }}(*)</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="form-control" placeholder="{{trans('core::role.enter_role')}}" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-md-12">
                        <h4>{{trans('core::role.role')}}</h4>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <?php
                                $arr = [];
                                ?>
                            <div class="col-md-3">
                                <section>
                                    <label>{{ $permission['name'] }}</label>
                                    <div class="form-group">
                                        @foreach ($permission['actions'] as $action)
                                            @if (!in_array($action["id"], $arr))
                                                <?php
                                                array_push($arr, $action["id"]);
                                                ?>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="permissions[]" class="minimal" value="{{$action['id']}}" {{ old('permissions') !== null && in_array($pId, old('permissions')) ? 'checked' : '' }}>
                                                        {{ $action["name"] }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </section>
                            </div>

                            @endforeach
                        </div>
                        <!-- /.form-group -->

                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="/admin/role" class="btn btn-default pull-right">{{trans('core::role.cancel')}}</a>
                {!! Form::button(trans('core::role.save'), ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>
@endsection
