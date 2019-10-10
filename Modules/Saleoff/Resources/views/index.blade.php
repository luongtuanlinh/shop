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
                        <a role="button" href="#" class="btn btn-success"><i
                                    class="fas fa-plus"></i>Thêm sự kiện sale mới</a>
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
                            <th style="width: 10%">
                                Thời gian
                            </th>
                            <th style="width: 20%">
                                Lời giới thiệu
                            </th>
                            <th style="width: 10%">Sản phẩm</th>
                            <th style="width: 39%" class="text-center">
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
                                        Cập nhật vào: {{$sale->updated_at}}
                                    </small>
                                </td>
                                <td >
                                    <div class="content-hidden">

                                        {{$sale->introduction}}
                                    </div>
                                </td>
                                <td class="4">
                                    <img src="{{$sale->cover_img}}" width="120px">
                                </td>
                                <td>
                                    Thêm cái modal hoặc href để thêm sửa sản phẩm
                                </td>
                                <td class="project-state">
                                    <a class="btn btn-primary btn-sm" data-toggle="modal"
                                       data-target="#{{'sale-' . $sale->id}}" href="#">
                                        <i class="fas fa-folder">
                                        </i>
                                        Xem
                                    </a>
                                    {{--                                    <a class="btn btn-info btn-sm" href="{{route('admin.children1s.edit',['children1' => $post->slug])}}">--}}
                                    <a class="btn btn-info btn-sm"
                                       href="#">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Sửa
                                    </a>
                                    <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-trash-alt">
                                        </i>
                                        Xóa
                                    </a>
                                    {{--                                    <form id={{'delete-'.$post->slug}} action="{{ route('admin.children1s.destroy',['children1' => $post->slug]) }}" method="POST" style="display: none;">--}}
                                    <!-- Modal -->
                                    <div class="modal fade" id="{{'sale-' . $sale->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLongTitle">{{$sale->introduction}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="#" width="200px">
                                                    <p>{!!$sale->introduction!!}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-info btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>Sửa
                                                    </a>
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