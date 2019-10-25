@extends('layouts.admin_default')
@section('title', 'Sửa đơn hàng')
@section('content')
<section class="content-header">
    <h1>
        Cập nhật trang thái đơn hàng
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
        <li><a href="{{ route('order.index') }}">Đơn hàng</a></li>
        <li class="active">Chi tiết hoá đơn</li>
    </ol>
</section>
<style>
    .avatar-comment img {
        margin-top: 9%;
    }

    .box.box-info {
        border-top-color: white;
    }

    td .select2-container--default .select2-selection--single {
        width: 140px;
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">

                <div class="tab-content">
                    <div class="box box-info tab-pane active" id="infomation">
                        <div class="box-header">
                            @if(session()->has('messages'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check"></i> {{trans('products::region_index.alert')}}</h4>
                                {{session('messages')}}
                            </div>
                            @else
                            @endif
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                            <div class="box-info col-md-1">
                            </div>
                            <div class="col-md-8 col-md-offset-1">
                                <h3>Thông tin khách hàng</h3>
                                <table class="table table-striped">
                                    <tr class="row">
                                        <td class="col-xs-4">Mã Khách hàng: </td>
                                        <td class="col-xs-8">
                                            #{{ $order->customer_id }}
                                        </td>
                                    </tr>
                                    <tr class="row">
                                        <td class="col-xs-4">Tên khách hàng: </td>
                                        <td class="col-xs-8">
                                            {{ $order->customer_name }}
                                        </td>
                                    </tr>
                                    <tr class="row">
                                        <td class="col-xs-4">Số điện thoại: </td>
                                        <td class="col-xs-8">
                                            {{ $order->customer_phone }}
                                        </td>
                                    </tr>
                                    <tr class="row">
                                        <td class="col-xs-4">Địa chỉ giao hàng: </td>
                                        <td class="col-xs-8" style="overflow:hidden">
                                            {{ $order->deliver_address }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="box-info col-md-1">
                            </div>
                            <div style="clear: both;"></div>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form class="form-horizontal" action="{{ route('order.update') }}" method="POST">
                                {{ csrf_field() }}
                                <!-- id cua don hang minh dinh update -->
                                <input type="hidden" name="order_id" value="{{$order->id}}">
                                <input type="hidden" name="order_status" value="{{$order->status}}" id="order_status">
                                <input type="hidden" name="payment_status" value="{{$order->payment_status}}"
                                    id="payment_status">


                                <!-- done, spin , wait -->
                                <div class="row" id="process-bar">
                                    <div class="col-md-3 col-md-offset-1 status">
                                        <div class="circle"><i class="fa fa-check"></i><i class="fa fa-close"></i><i
                                                class="fa fa-refresh fa-spin"></i></div>
                                        <div class="line"></div>
                                        <div class="progress">Chờ xử lý </div>
                                        <!--                             <div id="justSolve">
                                                <input type="button" class="btn" value="Done">
                                            </div> -->
                                    </div>
                                    <div class="col-md-3 status">
                                        <div class="circle"><i class="fa fa-check"></i><i class="fa fa-close"></i><i
                                                class="fa fa-refresh fa-spin"></i></div>
                                        <div class="line"></div>
                                        <div class="progress">Đang xử lý</div>
                                    </div>
                                    <div class="col-md-3 status">
                                        <div class="circle"><i class="fa fa-check"></i><i class="fa fa-close"></i><i
                                                class="fa fa-refresh fa-spin"></i></div>
                                        <div class="line"></div>
                                        <div class="progress">Vận chuyển</div>
                                    </div>
                                    <div class="col-md-1 status">
                                        <div class="circle"><i class="fa fa-check"></i><i class="fa fa-close"></i><i
                                                class="fa fa-refresh fa-spin"></i></div>
                                        <div class="progress">Giao hàng</div>
                                    </div>
                                </div>
                                <h3 class="box-title">Danh sách sản phẩm của đơn hàng</h3>

                                <!-- /.box-header -->
                                <table id="items_table">
                                    <thead>
                                        <thead>
                                            <th width="4%">TT</th>
                                            <th width="23%">Sản phẩm</th>
                                            <th width="23%">Hình ảnh</th>
                                            <th width="10%">Màu</th>
                                            <th width="10%">Kích cỡ</th>
                                            <th width="10%">Số lượng</th>
                                            <th width="10%">Đơn giá</th>
                                            <th width="10%">Thành tiền</th>
                                            @if($order->status == Modules\Orders\Entities\Orders::PENDING_STATUS)
                                            <th>Hành động</th>
                                            @endif
                                        </thead>
                                    <tbody id="order_item">

                                    </tbody>
                                </table>

                                <div class="box-info col-md-12">
                                    <h3 id="total-title">Đơn hàng</h3>
                                    <div id="note" class="col-md-6">
                                        <h3>Đổi trạng thái đơn hàng</h3>
                                        <span> Status</span><br>
                                        <select id="select_status" class="form-control">
                                            @foreach(\Modules\Orders\Entities\Orders::listStatus() as $key => $value)
                                            <option value="{{ $key }}" @if ($key==$order->order_status)
                                                {{ "selected" }}
                                                @endif
                                                >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <span> Miêu tả</span><br>
                                        <textarea name="subcrible" id="" cols="30" rows="4"></textarea>
                                        <button type="submit" name="update" value="Update"
                                            class="btn btn-info pull-right" style="font-weight: bold">Update</button>
                                    </div>
                                    <div id="order-total" class="box-info col-md-6">
                                        <h3>Thông tin đơn hàng</h3>
                                        <table class="table table-striped" >
                                            <tr>
                                                <td>Mã đơn hàng: </td>
                                                <td>#{{$order->id}}</td>
                                            </tr>
                                            <tr>
                                                <td>Ngày nhận hàng: </td>
                                                <td>{{ $order->deliver_time }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tổng tiền: </td>
                                                <td>{{ number_format($order->total_price) }}</td>
                                            </tr>
                                            <tr>
                                            </tr>
                                            {{-- <tr>
                                                <td>Thành tiền: </td>

                                            </tr> --}}
                                            <tr>
                                                <td>Trạng thái: </td>
                                                <td>Chưa thanh toán</td>

                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.table-responsive -->
                            </form>
                        </div>
                        @if($order->status >= Modules\Orders\Entities\Orders::SHIPPED_STATUS &&
                        Auth::user()->hasPermission("Modules\Product\Http\Controllers\WareHouseController", "show"))
                        <div class="box-footer" style="text-align: center">
                            <a href="{{ route('warehouse.export', $order->id) }}" style="color: white"><button
                                    class="btn btn-primary"><i class="fa fa-download">Xuất kho</i></button></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <!-- /.box-body -->
</section>
@endsection
@section('scripts')
<script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.js') }}"></script>

<script>
    $(function() {
        table = $('#items_table').DataTable({
            processing : true,
            serverSide : true,
            bAutoWidth : false,
            searching : false,
            ajax: {
                url: '{{ route("order.getOrderItems", $order->id) }}',
                type: 'get',
                data: function(d) {
                    d.csrf = '{{csrf_field()}}';
                },
            },
            columns: [
                {data: 'id', name: 'order_product.product_id'},
                {data: 'product_name', name: 'product.name'},
                {data: 'image', name: 'product.image'},
                {data: 'color', name: 'product.color'},
                {data: 'size', name: 'product.size'},
                {data: 'amount', name: 'order_product.amount'},
                {data: 'sell_price', name: 'order_product.sell_price'},
                {data: 'total_price', name: 'total_price'},
                // {data: 'actions', orderable: false}
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
                {"width": "20%", "targets": 6}
            ],
        });
    });

    var arr_status = ["pending", "processing", "shipped", "delivery", "success"];
        var arr_status_class = ["btn-warning", "btn-info", "btn-success", "btn-danger", "btn-primary"];

        /*phan delete item trong don hang*/
        function form_submit() {
            document.getElementById("delete_form").submit();
        }

        $(".delete").click(function () {
            // name trong input gui request de sua
            $('#deleteModal').find('#delProduct').val($(this).data("itemid"));
            // name tren box modal
            $('#deleteModal').find('#pickProduct').html($(this).data("orderid"));
        });
        /*===================================*/
        var order_status = parseInt($('#order_status').val());
        // $('#select_status').val(order_status);
        changeProgressSubcrible();
        var payment_status = parseInt($('#payment_status').val());
        $('#select_payment_status').val(payment_status);

        $(document).ready(function () {
            //status int to text
            $('#final-total').html({{$order->total_price*1.1 + 20000}});
            $('#select_status').change(function () {
                changeProgressSubcrible();
            });
            $('#select_payment_status').change(function () {
                payment_status = parseInt($('#select_payment_status').val());
                $('#payment_status').val(payment_status);
            });
            // trong comment history
            $('.status-history').each(function () {
                status = $(this).data("status");
                $(this).html(arr_status[status - 1]);
                $(this).addClass(arr_status_class[status - 1]);
            });
        });

        function changeProgressSubcrible() {
            order_status = parseInt($('#select_status').val());
            $('#order_status').val(order_status);
            var i = 1;
            if(order_status < 6){
                $('#process-bar > div').each(function () {
                    if ($(this).hasClass('cancel')) $(this).removeClass('cancel');
                    if ($(this).hasClass('done')) $(this).removeClass('done');
                    if ($(this).hasClass('spin')) $(this).removeClass('spin');
                    if ($(this).hasClass('wait')) $(this).removeClass('wait');

                    if (i < order_status) {
                        $(this).addClass('done');
                    }
                    else if (i > order_status) {
                        $(this).addClass('wait');
                    }
                    else $(this).addClass('spin');
                    i++;
                });
            }else{
                $('#process-bar > div').each(function () {

                    if ($(this).hasClass('done')) $(this).removeClass('done');
                    if ($(this).hasClass('spin')) $(this).removeClass('spin');
                    if ($(this).hasClass('wait')) $(this).removeClass('wait');
                    $(this).addClass('cancel');
                });
            }

        }

        //row count
        //string to render color option
        $('#datetimepicker1').datetimepicker({
            format: "DD-MM-YYYY",
            locale: 'vi'
        });
        $(document).ready(function(){
            $('.input-group-addon').click(function(){
                $('#datetimepicker1 ').focus();
            });
        });
</script>

@endsection