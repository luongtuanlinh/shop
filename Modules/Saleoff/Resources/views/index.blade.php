@extends('layouts.admin_default')
@section('title', "Khuyến mại")
@section('content')
<style>
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #d2d6de !important;
        border-radius: 0 !important;
        height: 100% !important;
    }

    .daterangepicker select.hourselect,
    .daterangepicker select.minuteselect,
    .daterangepicker select.secondselect,
    .daterangepicker select.ampmselect {
        width: 60px;
        margin-bottom: 0;
    }
</style>
<section class="content-header">
    <h1>
        Danh sách khuyến mại
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Khuyến mại</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">

                <div class="box-header">
                    {{-- @include('agency::includes.message') --}}
                    @if(session()->has('messages'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> Thông báo</h4>
                            {{session('messages')}}
                        </div>
                    @else
                    @endif
                    <h3 class="box-title">Danh sách đợt khuyến mãi</h3>
                    <div class="pull-right">
                        <a class="btn btn-success btn-sm" href="{{ route('admin.saleoff.create') }}">Tạo sale</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-hover" id="post_table">
                            <thead>
                            <tr>
                                <th>TT</th>
                                <th>Tên sự kiện</th>
                                <th>Mô tả</th>
                                <th>Bắt đầu</th>
                                <th>Kết thúc</th>
                                <th>Ngày tạo</th>
                                <th class="action">Hành động</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--table-responsive-->
                </div><!-- /.box-body -->
            </div>
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
                    url: '{{ route("admin.saleoff.get") }}',
                    type: 'get',
                    data: function(d) {
                        d.csrf = '{{csrf_field()}}';
                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'event_name'},
                    {data: 'introduction'},
                    // {data: 'cover_img'},
                    {data: 'start_time', sortable: true},
                    {data: 'end_time', sortable: true},
                    {data: 'created_at', sortable: true},
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
                    { "width": "10%", "targets": 6},
                    { "width": "11%", "targets": 3},
                    { "width": "11%", "targets": 4},
                    { "width": "11%", "targets": 5},
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