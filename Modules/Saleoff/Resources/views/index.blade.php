@extends('admin.app')
@push('css')

@endpush
@section('content')
    <div class="content-wrapper" style="min-height: 1231.06px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách các sự kiện</h1>
                        <a role="button" href="{{route('admin.saleoff.create')}}" class="btn btn-success">
                            <i class="fas fa-plus"></i>Thêm sự kiện sale mới
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang quản lý</a></li>
                            <li class="breadcrumb-item active">Sale off</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sự kiện</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body p-0" style="display: block;">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">
                                #
                            </th>
                            <th style="width: 20%">
                                Tên
                            </th>
                            <th style="width: 20%">
                                Thời gian
                            </th>
                            <th style="width: 20%">
                                Lời giới thiệu
                            </th>
                            <th style="width: 10%">Sản phẩm</th>
                            <th style="width: 29%" class="text-center">
                                Thao tác
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sales as $index => $sale)
                            <tr>
                                <td>
                                    {{$index+1}}
                                </td>
                                <td>
                                    <a>
                                        {{$sale->event_name}}
                                    </a>
                                    <br>
                                    <small>
                                        Tạo lúc: {{$sale->created_at}}
                                    </small>
                                </td>
                                <td>
                                    <div>
                                        Từ {{substr($sale->start_time,0,10)}} <br>tới {{ substr($sale->end_time,0,10) }}
                                    </div>
                                </td>
                                <td>
                                    {{$sale->introduction}}
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#{{'sale-' . $sale->id}}">Xem</a>
                                </td>
                                <td class="project-state">

                                    {{--                                    <a class="btn btn-info btn-sm" href="{{route('admin.children1s.edit',['children1' => $post->slug])}}">--}}
                                    <a class="btn btn-info btn-sm"
                                       href="#">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Sửa
                                    </a>
                                    <a class="btn btn-info btn-sm" href="#" onclick="event.preventDefault(); document.getElementById('{{"delete-".$sale->id}}').submit();">
                                        <i class="fas fa-trash-alt">
                                        </i>
                                        Xóa
                                    </a>
                                    <form id={{'delete-'.$sale->id}} action="{{route('admin.saleoff.destroy')}}"
                                            method="POST" style="display: none;">
                                        <input value="{{$sale->id}}" name="id">
                                        {{ csrf_field() }}
                                        {{method_field('delete')}}
                                    </form>
                                    <!-- Modal -->
                                    <div class="modal fade" id="{{'sale-' . $sale->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLongTitle">{{$sale->event_name}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{$sale->introduction}}</p>
                                                    <p style="float: left">Danh sách các sản phẩm được giảm giá</p>
                                                    <table class="table table-head-fixed">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tên sản phẩm</th>
                                                            <th>Mã sản phẩm</th>
                                                            <th>Giá gốc</th>
                                                            <th>Giảm</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($sale->products as $index => $product)
                                                            <tr>
                                                                <td>{{$index+1}}</td>
                                                                <td>{{$product->name}}</td>
                                                                <td>{{$product->code}}</td>
                                                                <td>{{$product->price}}</td>
                                                                <td>{{$product->pivot->discount}} %</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
@push('js')

@endpush