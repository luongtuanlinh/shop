@extends('layouts.admin_default')
@section('title', "Đơn hàng")
@section ('before-styles-end')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}"> 
@stop
@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #d2d6de !important;
            border-radius: 0 !important;
            height: 100% !important;
        }
        .daterangepicker select.hourselect, .daterangepicker select.minuteselect, .daterangepicker select.secondselect, .daterangepicker select.ampmselect {
            width: 60px;
            margin-bottom: 0;
        }
    </style>
    <section class="content-header">
        <h1>
            Danh sách đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Đơn hàng</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-info">

                    <div class="box-header">
                        <h3 class="box-title">Lọc đơn hàng</h3>
                        {{-- @include('agency::includes.message') --}}
                        @if(session()->has('messages'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check"></i> Thông báo</h4>
                                {{session('messages')}}
                            </div>
                        @else
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @include('orders::includes.order.filter')
                    </div><!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-header">
                        {{-- @include('agency::includes.message') --}}
                        <h3 class="box-title">Danh sách đơn hàng</h3>
                        <div class="pull-right">
                        @if(Session::get('create'))
                                <a class="btn btn-success btn-sm" href="{{ route('order.create') }}">Tạo đơn hàng</a>
                                 <a class="btn btn-info btn-sm" href="{{ route('order.excel') }}"><i class="fa fa-download"></i> Excel</a>
                        @endif
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover" id="post_table">
                                <thead>
                                <tr>
                                    <th>Mã hoá đơn</th>
                                    {{-- <th>Tên đại lý</th> --}}
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Địa điểm giao hàng</th>
                                    <th style="width: 13%">Thời gian giao hàng</th>
                                    {{-- <th style="width: 13%">Đổi trạng thái</th> --}}
                                    <th>Ngày tạo</th>
                                    <th class="action">Hành động</th>
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
                    url: '{{ route("order.get") }}',
                    type: 'get',
                    data: function(d) {
                        d.status = $('#status').val();
                        d.deliver_time = $('#datetimepicker1').val();
                        d.customer_name = $('#customer_name').val();
                        d.csrf = '{{csrf_field()}}';
                    }
                },
                columns: [
                    {data: 'id', name:'orders.id'},
                    // {data: 'creater', name:'orders.user_id'},
                    {data: 'customer_name', name:'orders.customer_id'},
                    {data: 'customer_phone', name:'orders.customer_phone'},
                    {data: 'total_price', name:'orders.total_price'},
                    {data: 'status', name:'orders.order_status'},
                    {data: 'deliver_address', name:'orders.deliver_address'},
                    {data: 'deliver_time', sortable: true,name:'orders.deliver_time'},
                    // {data: 'check', sortable: true},
                    {data: 'created_at', sortable: true,name:'orders.created_at'},
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
                    { "width": "7%", "targets": 0},
                    { "width": "13%", "targets": 7},
                    { "width": "10%", "targets": 6},
                    { "width": "11%", "targets": 4}
                ]
            });

        });

        function filter(){
            table.draw();
        }

        $(function () {
            $('#datetimepicker1').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                },

                timePicker: true,
            });

        });

        $(document).ready(function(){
            $('.input-group-addon').click(function(){
                $('#datetimepicker1 ').focus();
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
        
        function changeStatus() {
            var list = [];
            $('input:checked').each(function () {
                list.push($(this).val());
            });
            btn_loading.loading("post_table");
            $.ajax({
                data:{
                    id : list
                },
                url: "{{ route('order.change.status') }}",
                type: "GET",
                success: function (data) {
                    btn_loading.hide();
                    alert(data.message);
                    location.reload();
                }
            })
        }

    </script>
@endsection

