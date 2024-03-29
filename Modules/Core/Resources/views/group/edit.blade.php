@extends('layouts.admin_default')
@section('title', trans('core::group.title'))
@section('content')
    <section class="content-header">
        <h1>{{trans('core::group.title')}}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="{{ route('core.group.index') }}"> {{trans('core::group.title')}}</a></li>
            <li class="active">{{trans('core::group.update')}}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('core::group.edit_group')}}</h3>
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
            {!! Form::open(['method' => 'PUT', 'route' => ['core.group.update', $group->id], 'class' => 'validate']) !!}
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>{{trans('core::group.name')}} (*)</label>
                            <input name="name" type="text" value="{{$group->name}}" class="form-control" placeholder="{{trans('core::group.enter_name_group')}}" required>
                        </div>
                        <div class="form-group">
                            <label>{{trans('core::group.type')}} (*)</label>
                            {!! Form::select('type', [
                                    0 => trans('core::group.admin_account'),
                                    1 => trans('core::group.staff_account')
                                ],
                                $group->type,
                                ['id' => 'selectType', 'class'=>'form-control select2', 'required'=>true]
                            ) !!}
                        {{--</div>--}}
                        {{--@if ($group->type == 0)--}}
                            {{--<div class="form-group" id="typeCompany">--}}
                                {{--<label>Chọn công ty BH</label>--}}
                                {{--{!! Form::select('companies[]', $companies, $objectIds, ['class'=>'form-control select2', 'multiple'=>'true', 'style'=>'width: 100%']) !!}--}}
                            {{--</div>--}}
                            {{--<div class="form-group" id="typeAgency" style="display: none">--}}
                                {{--<label>Chọn đại lý BH</label>--}}
                                {{--{!! Form::select('agencies[]', $agencies, null, ['class'=>'form-control select2', 'multiple'=>'true', 'style'=>'width: 100%']) !!}--}}
                            {{--</div>--}}
                        {{--@else--}}
                            {{--<div class="form-group" id="typeCompany" style="display: none">--}}
                                {{--<label>Chọn công ty BH</label>--}}
                                {{--{!! Form::select('companies[]', $companies, null, ['class'=>'form-control select2', 'multiple'=>'true', 'style'=>'width: 100%']) !!}--}}
                            {{--</div>--}}
                            {{--<div class="form-group" id="typeAgency">--}}
                                {{--<label>Chọn đại lý BH</label>--}}
                                {{--{!! Form::select('agencies[]', $agencies, $objectIds, ['class'=>'form-control select2', 'multiple'=>'true', 'style'=>'width: 100%']) !!}--}}
                            {{--</div>--}}
                        {{--@endif--}}
                        {{--<!-- /.form-group -->--}}
                    </div>
                        <div class="col-md-3"></div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer" style="text-align: center">
                {!! Form::button(trans('core::group.update'), ['class' => 'btn btn-primary ', 'type' => "submit"]) !!}
                <a href="/admin/group" class="btn btn-default">{{trans('core::group.cancel')}}</a>

            </div>
            {!! Form::close() !!}
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('scripts')
<script src="{{asset('js/groupUser.js')}}"></script>

@endsection
