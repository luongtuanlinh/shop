@extends('layouts.admin_default')
@section('title', "Hoá đơn")
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
            Danh sách hoá đơn
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Hoá đơn</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-info">

                    <div class="box-header">
                        <h3 class="box-title">Lọc hoá đơn</h3>
                        @include('agency::includes.message')
                        @if(session()->has('messages'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check"></i> {{trans('products::region_index.alert')}}</h4>
                                {{session('messages')}}
                            </div>
                        @else
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @include('orders::includes.index')
                    </div><!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-header">
                        @include('agency::includes.message')
                        <h3 class="box-title">List Order</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover" id="post_table">
                                <thead>
                                <tr>
                                    <th>Mã hoá đơn</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Địa điểm giao hàng</th>
                                    <th>Thời gian giao hàng</th>
                                    <th>Ngày tạo</th>
                                    <th class="action">Action</th>
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
    <script src="{{ asset('js/slide.js') }}"></script>
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
                        d.created_at = $('#datetimepicker1').val();
                        d.csrf = '{{csrf_field()}}';
                    }
                },
                columns: [
                    {data: 'id', name:'orders.id'},
                    {data: 'customer_id', name:'orders.user_id'},
                    {data: 'total_price', name:'orders.total_price'},
                    {data: 'status', sortable: true,name:'orders.status'},
                    {data: 'payment_status', sortable: true,name:'orders.payment_status'},
                    {data: 'payment_type', sortable: true,name:'orders.payment_type'},
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
                    { "width": "18%", "targets": 7},
                    {"width": "13%", "targets": 6}
                ]
            });
        });

        function filter(){
            table.draw();
        }

        $(function () {
            $(function () {
                $('#datetimepicker1').daterangepicker({
                    locale: {
                        format: 'DD-MM-YYYY hh:mm A'
                    },

                    timePicker: true,
                });

            });

        });

        $(document).ready(function(){
            $('.input-group-addon').click(function(){
                $('#datetimepicker1 ').daterangepicker.show();
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
    </script>
@endsection

