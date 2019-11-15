@extends('layouts.admin_default')
@section('title', 'Sửa đơn hàng')
@section ('before-styles-end')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@stop
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

    .select2-container--default .select2-selection--multiple {
        width: 350px;
    }

    .select2-dropdown select2-dropdown--below {
        width: 350px;
    }

    #amount>input {
        border: solid 1px #d0d0d0;
        height: 32px;
        padding-left: 10px;
        font-style: bold;
    }

    td select2-dropdown select2-dropdown--below {
        width: 140px;
    }

    .form-group>.select2 {
        height: 34px;
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
                                <input type="hidden" name="order_status" value="{{  $order->order_status }}"
                                    id="order_status">
                                <input type="hidden" name="payment_status" value="{{ $order->payment_status  }}"
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
                                <table class="table table-striped" style="width: 100%">
                                    <thead>
                                        <th>TT</th>
                                        <th>Loại sản phẩm</th>
                                        <th>Sản phẩm</th>
                                        <th>Kích cỡ</th>
                                        <th>Màu sắc</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                        {{-- <th>Hành động</th> --}}
                                        @if($order->order_status <= Modules\Orders\Entities\Orders::PROCESSING_STATUS)
                                            <th>Hành động</th>
                                            @endif
                                    </thead>
                                    <tbody id="tbody">
                                        @foreach ($order_items as $key => $item)
                                        <tr>
                                            <td>#{{ $key + 1 }}</td>
                                            <td>{{ $item->cate_name }}</td>
                                            <td>{{ $item->name }}<input type="hidden" name="product_id[]"
                                                    value="{{ $item->product_id }}"></td>
                                            <td>{{ $item->size }}<input type="hidden" name="size[]"
                                                    value="{{ $item->size_id }}"></td>
                                            <td>{{ $item->color }}<input type="hidden" name="color[]"
                                                    value="{{ $item->color }}"></td>
                                            <td>{{ $item->amount }}<input type="hidden" name="amount[]"
                                                    value="{{ $item->amount }}"></td>
                                            <td>{{ number_format($item->price) }}</td>
                                            <td>{{ number_format($item->price * $item->amount) }}</td>
                                            @if($order->order_status <=
                                                Modules\Orders\Entities\Orders::PROCESSING_STATUS) <td><button
                                                    type="button" class="btn btn-danger btn-xs"
                                                    onclick="deleteRow($(this))"><i class="fa fa-minus">Xoá</i></button>
                                                </td>
                                                @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @if($order->order_status <= Modules\Orders\Entities\Orders::PROCESSING_STATUS)
                                            <tr>
                                            <td colspan="9" class="text-center"><button type="button" id="add_button_1"
                                                    class="btn btn-info btn-xs" onclick="addRow()"><i
                                                        class="fa fa-plus">Thêm</i></button></td>
                                            </tr>
                                            @endif
                                    </tfoot>
                                </table>

                                <div class="box-info col-md-12">
                                    <h3 id="total-title">Đơn hàng</h3>
                                    <div id="note" class="col-md-6">
                                        <h3>Đổi trạng thái đơn hàng</h3>
                                        <div><span>Trạng thái đơn hàng</span><br>
                                            <select id="select_status" class="form-control">
                                                @foreach(\Modules\Orders\Entities\Orders::listStatus() as $key =>
                                                $value)
                                                <option value="{{ $key }}" @if ($key==$order->order_status)
                                                    {{ "selected" }}
                                                    @endif
                                                    >{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div style="margin-top:20px;">
                                            <span>Trạng thái thanh toán</span><br>
                                            <select id="select_payment_status" class="form-control">
                                                <option value="{{ \Modules\Orders\Entities\Orders::NOT_PAY_STATUS }}" 
                                                @if ($order->payment_status ==
                                                    \Modules\Orders\Entities\Orders::NOT_PAY_STATUS)
                                                    selected
                                                    @endif >Chưa thanh toán</option>
                                                <option value="{{ \Modules\Orders\Entities\Orders::PAID_STATUS }}"
                                                @if ($order->payment_status ==
                                                    \Modules\Orders\Entities\Orders::PAID_STATUS)
                                                    selected
                                                    @endif >Đã thanh toán</option>
                                            </select>
                                        </div>
                                        {{-- <span> Miêu tả</span><br>
                                        <textarea name="subcrible" id="" cols="30" rows="4"></textarea> --}}
                                    </div>
                                    <div id="order-total" class="box-info col-md-6">
                                        <h3>Thông tin đơn hàng</h3>
                                        <table class="table table-striped">
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
                                                <td>Hình thức thanh toán: </td>
                                                <td>{{ $order->payment }}</td>    
                                            </tr>
                                            {{-- <tr>
                                                <td>Thành tiền: </td>

                                            </tr> --}}
                                            <tr>
                                                <td>Trạng thái: </td>
                                                @if ($order->payment_status ==
                                                \Modules\Orders\Entities\Orders::NOT_PAY_STATUS)
                                                <td>Chưa thanh toán</td>
                                                @endif
                                                @if ($order->payment_status ==
                                                \Modules\Orders\Entities\Orders::PAID_STATUS)
                                                <td>Đã thanh toán</td>
                                                @endif

                                            </tr>
                                        </table>
                                        <button type="submit" name="update" value="Update"
                                            class="btn btn-info pull-left" style="font-weight: bold">Update</button>

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
{{-- <script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.js') }}"></script> --}}

<script>
    // $(function() {
    //     table = $('#items_table').DataTable({
    //         processing : true,
    //         serverSide : true,
    //         bAutoWidth : false,
    //         searching : false,
    //         ajax: {
    //             url: '{{ route("order.getOrderItems", $order->id) }}',
    //             type: 'get',
    //             data: function(d) {
    //                 d.csrf = '{{csrf_field()}}';
    //             },
    //         },
    //         columns: [
    //             {data: 'id', name: 'order_product.product_id'},
    //             {data: 'category'},
    //             {data: 'product_name', name: 'product.name'},
    //             {data: 'size', name: 'product.size'},
    //             {data: 'color', name: 'product.color'},
    //             {data: 'amount', name: 'order_product.amount'},
    //             {data: 'sell_price', name: 'order_product.sell_price'},
    //             {data: 'total_price', name: 'total_price'},
    //             {data: 'action', orderable: false}
    //         ],
    //         "order": [[ 0, "desc" ]],
    //         "language": {
    //             "lengthMenu": "Hiển thị _MENU_ bản ghi trên một trang",
    //             "zeroRecords": "Không tìm bản ghi phù hợp",
    //             "info": "Đang hiển thị trang _PAGE_ of _PAGES_",
    //             "infoEmpty": "Không có dữ liệu",
    //             "infoFiltered": "(lọc từ tổng số _MAX_ bản ghi)",
    //             "info": "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ kết quả",
    //             "paginate": {
    //                 "previous":   "«",
    //                 "next":       "»"
    //             },
    //             "sProcessing": '<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading'
    //         },
    //         "columnDefs": [
    //             { "width": "7%", "targets": 0},
    //             { "width": "13%", "targets": 7},
    //             {"width": "20%", "targets": 6}
    //         ],
    //     });
    // });
    var count = {{ count($order_items) }};

    function addRow() {
            btn_loading.loading("tbody");
            $.ajax({
                data: {
                    index: count,
                },
                url: "{{ route('order.product.addRow') }}",
                type: "GET",
                success: function(data) {
                    if (data.result == 0) {
                        console.log(data.message);
                    } else {
                        btn_loading.hide("tbody");
                        // $("#color_" + index).html("");
                        $("#tbody").append(data.message);
                        count++;
                        $(".select2").select2();
                        filterProduct(count);
                    }
                }
            });
        }
        function filterProduct(category, index) {
            $.ajax({
                data: {
                    category_id: category,
                },
                url: "{{ route('order.product.filter') }}",
                type: "GET",
                success: function (data) {
                    if(data.result == 0){
                        alert(data.message);
                    }else{
                        $("#product_id_" + index).select2({
                            data: data.message,
                        });
                    }
                }

            })
        }

        function filterSize(index) {
            var product = $("#product_id_" + index).select2('data');
            $("#sell_price_" + index + " span").html("");
            $("#sell_price_" + index + " span").append(addCommas(product[0].price));
            $("#price_hidden_" + index).val(product[0].price);
            tt(index);
            total();
            $.ajax({
                data: {
                    product_id: product[0].id,
                },
                url: "{{ route('order.product.filterSize') }}",
                type: "GET",
                success: function(data) {
                    if (data.result == 0) {
                        console.log(data.message);
                    } else {
                        $("#size_" + index).html("");
                        $("#size_" + index).append(data.message);
                    }
                }
            });
        }
        function filterColor(index) {
            var product = $("#product_id_" + index).select2('data');
            var size = $("#size_" + index).select2('data');
            console.log(size);
            $.ajax({
                data: {
                    product_id: product[0].id,
                    size_id: size[0].id,
                },
                url: "{{ route('order.product.filterColor') }}",
                type: "GET",
                success: function(data) {
                    if (data.result == 0) {
                        console.log(data.message);
                    } else {
                        $("#color_" + index).html("");
                        $("#color_" + index).append(data.message);
                    }
                }
            })

        }

        function addCommas(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        function deleteRow(_this) {
            if($(_this).parent().children().length == 2){
                $(_this).parent().parent().remove();
                var sum_total = getSumTotal();
                _sum_total(sum_total);

                var str ="<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deleteRow($(this))\"><i class=\"fa fa-minus\">Xoá</i></button>";
                $("#td-" + count).html("");
                $("#td-" + count).html(str);
            }else{parent
                $(_this).parent().parent().remove();
            }

            count = count - 1;
            console.log(count);
            var i = 1;
            $("#tbody tr").each(function() {
                $(this).find("td").first().html("#" + i);
                i++;
            });

        }

        function changeAmount(id){
            tt(id);
        }

        /**
         *
         * @param id
         */
        function tt(id) {
            var price = $("#price_hidden_"+id).val();
            var amount = $("#amount_"+id).val();
            $("#tt_hidden_"+id).val(price * amount);
            $("#tt_"+id+" span").html(addCommas(price * amount));
            total();
        }

        function total() {
            var total = 0;
            $("#tbody tr").each(function() {
                let value = $(this).find("td").slice(7,8).find("input").val();
                if (value == '') {
                    value = 0;
                }
                total += parseInt(value);
            });
            $("#sum_price #total").val(total);
            $("#sum_price span").html("");
            $("#sum_price span").html(addCommas(total));
        }

        function _sum_total(sum_total) {
            $("#sum_total span").html("");
            $("#sum_total_hidden").val("");
            $("#sum_total_hidden").val(sum_total);
            $("#sum_total span").html(addCommas(sum_total));
            sum_discount(sum_total);
        }
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