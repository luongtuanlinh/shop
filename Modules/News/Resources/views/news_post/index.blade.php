@extends('layouts.admin_default')
@section('title', trans('news::post_index.title'))
@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #d2d6de !important;
            border-radius: 0 !important;
            height: 100% !important;
        }
    </style>
    <section class="content-header">
        <h1>
            {{trans('news::post_index.title')}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">{{trans('news::post_index.list_post')}}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-info">

                    <div class="box-header">
                        <h3 class="box-title">{{trans('news::post_index.filter')}}</h3>
                        @include('news::includes.message')
                        @if(session()->has('messages'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check"></i> {{trans('news::region_index.alert')}}</h4>
                                {{session('messages')}}
                            </div>
                        @else
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @include('news::includes.post.filter')
                    </div><!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-header">
                        @include('news::includes.message')
                        <h3 class="box-title">{{trans('news::post_index.list_post')}}</h3>
                        <div class="pull-right">
                            <a class="btn btn-success btn-sm" href="{{ route('news.news_post.create') }}">{{trans('news::post_index.add_post')}}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover" id="post_table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('news::post_index.name')}}</th> dd
                                    <th>{{trans('news::post_index.status')}}</th>
                                    <th>{{trans('news::post_index.post_famous')}}</th>
                                    <th>{{trans('news::post_index.published_at')}}</th>
                                    <th>{{trans('news::post_index.created_at')}}</th>
                                    <th>{{trans('news::post_index.show_title')}}</th>
                                    <th class="actions">{{trans('news::post_index.action')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div><!--table-responsive-->
                    </div><!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.js') }}"></script>
    <script>

        $(function() {
            table=$('#post_table').DataTable({
                processing: true,
                serverSide: true,
                bAutoWidth: false,
                searching: false,
                ajax: {
                    url: '{{ route("news.news_post.get") }}',
                    type: 'get',
                    data: function(d) {
                        d.title = $('#title').val();
                        d.published_at = $('#datetimepicker1').val();
                        d.post_status = $('#post_status option:selected').val();
                        d.post_famous = $('#post_famous option:selected').val();
                        d.csrf = '{{csrf_field()}}';
                    }
                },
                columns: [
                    {data: 'id', name:'news_posts.id'},
                    {data: 'title', name:'news_posts.title'},
                    {data: 'post_status', sortable: true, name:'news_posts.post_status'},
                    {data: 'post_famous', sortable: false},
                    {data: 'published_at', sortable: true,name:'news_posts.published_at'},
                    {data: 'created_at', sortable: true,name:'news_posts.created_at'},
                    {data: 'show_title', sortable: true,name:'news_posts.show_title'},
                    {data: 'actions', orderable: false}
                ],
                "order": [[ 0, "desc" ]],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ bản ghi trên một trang",
                    "zeroRecords": "Không tìm bản ghi phù hợp",
                    "info": "Đang hiển thị trang _PAGE_ of _PAGES_",
                    "infoEmpty": "Không có dữ liệu",
                    "infoFiltered": "(lọc từ tổng số _MAX_ bản ghi)",
                    "info": "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ kết quả",
                    "paginate": {
                        "previous":   "«",
                        "next":       "»"
                    },
                    "sProcessing": '<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading'
                },
                "columnDefs": [
                    { "width": "18%", "targets": 7},
                    {"width": "13%", "targets": 6}
                ]
            });
        });

        function filter(){
            table.draw();
        }

        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: "DD-MM-YYYY",
            });

        });

        $(document).ready(function(){
            $('.input-group-addon').click(function(){
                $('#datetimepicker1 ').datetimepicker("show","format:\"DD-MM-YYYY\"");
            });
        });

        $('input').on( "keypress", function(event) {
            if (event.which == 13 && !event.shiftKey) {
                event.preventDefault();
                filter();
            }
        });

        $('input#datetimepicker1').change(function(){
            return filter();
        });

        function updateShowTitle (id) {
            btn_loading.loading("post_table");
            $.ajax({
                data:{
                    id : id
                },
                url: "{{route('news.new_post.updateShowTitle')}}",
                type: "GET",
                success: function (data) {
                    alert(data.message);
                    btn_loading.hide("post_table");
                }
            })
        }
    </script>
@endsection
