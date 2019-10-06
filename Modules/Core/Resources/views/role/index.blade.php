@extends('layouts.admin_default')
@section('title', trans('core::role.title'))
@section('content')
<section class="content-header">
    <h1>{{trans('core::role.title')}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">{{trans('core::role.list_role')}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            @if ($errors->any())
            <h4 style="color:red">{{$errors->first()}}</h4>
            @endif
            <div class="box">
                <div class="box-header">
                    @if(session()->has('messages'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Thông báo</h4>
                        {{session('messages')}}
                    </div>
                    @else
                    @endif
                    <h3 class="box-title">{{trans('core::role.list_role')}}</h3>
                    @if($current_user->hasPermission($controller,'create'))
                    <div class="pull-right">
                        <a class="btn btn-primary" href="/admin/role/create">{{trans('core::role.add_new_role')}}</a>
                    </div>
                    @endif
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{trans('core::role.name')}}</th>
                                <th class="text-center">{{trans('core::role.edit')}}</th>
                                <th class="text-center">{{trans('core::role.delete')}}</th>
                                <th class="text-center">{{trans('core::role.restore')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                @if($current_user->hasPermission($controller,'edit') == true)
                                <td class="text-center">
                                    <a href="{{ route('core.role.edit', $role->id) }}" class="btn btn-warning btn-xs"><i
                                            class="fa fa-pencil"></i></a>
                                </td>
                                @else
                                <td class="text-center">
                                </td>
                                @endif
                                {{--@php--}}
                                {{--dd($current_user->hasPermission($controller,'edit'));--}}
                                {{--@endphp--}}
                                @if($current_user->hasPermission($controller,'destroy'))
                                <td class="text-center">
                                    @if (!$role->deleted_at)
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['core.role.destroy', $role->id]])
                                    !!}
                                    <a href="#" class="btn btn-danger btn-xs"
                                        onclick="if(confirm('{{trans('core::role.confirm')}}')) $(this).closest('form').submit();"><i
                                            class="fa fa-trash"></i></a>
                                    {!! Form::close() !!}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($role->deleted_at)
                                    {!! Form::open(['method' => 'POST', 'route' => ['core.role.restore', $role->id]])
                                    !!}
                                    <a href="#" class="btn btn-danger btn-xs"
                                        onclick="$(this).closest('form').submit();"><i class="fa fa-reply"></i></a>
                                    {!! Form::close() !!}
                                    @endif
                                </td>
                                @else
                                <td class="text-center">
                                </td>
                                <td class="text-center">
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    {{ $roles->appends($params)->links() }}
                </div>
                <!-- /.box-body -->
                <div class="overlay hide">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
@endsection