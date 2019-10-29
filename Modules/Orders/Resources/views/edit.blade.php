@extends('layouts.admin_default')
@section('title', 'Create post')
@section('content')
    <section class="content-header">
        <h1>
            Create prodcut
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i>Admin home</a></li>
            <li><a href="{{ route('product.index') }}">List product</a></li>
            <li class="active">Create product</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title">Order View</h4>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-tabs tabs-left">
                            <li class="active"><a href="#infomation" data-toggle="tab">Information</a></li><br>
                            <li><a href="#comment-hisoty" style="margin-top: -21px;" data-toggle="tab">Comments History</a></li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-9 tab-content">
                <div class="box box-info tab-pane active" id="infomation">
                    <div class="box-header with-border">
                        <div class="box-info col-md-6">
                            <h3>Order information</h3>
                            <table class="table-striped">
                                <tr>
                                    <td>Order ID: </td>
                                    <td>#{{$order->id}}</td>
                                </tr>
                                <tr>
                                    <td>Order Date: </td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Order Status: </td>
                                    <td>{{ \Modules\Orders\Entities\Orders::listStatus()[$order->status] }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="box-info col-md-6">
                            <h3>Acount information</h3>
                            <table class="table-striped">
                                <tr>
                                    <td>Customer name: </td>
                                    <td>
                                        @if(empty($order->name))
                                            {{ $order->firstname." ". $order->lastname }}
                                        @else
                                            {{ $order->name }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Customer email: </td>
                                    <td>
                                        @if(empty($order->email))
                                            {{ $order->email_order }}
                                        @else
                                            {{ $order->email }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="clear: both;"></div>
                        <div class="box-info col-md-6">
                            <h3>Address information</h3>
                            <table class="table-striped">
                                <tr>
                                    <td>Address: </td>
                                    <td>Số 4 ngõ 6 Giáp Nhị, Hoàng Mai, Hà Nội</td>
                                </tr>
                            </table>
                        </div>
                        <div class="box-info col-md-6">
                            <h3>Payment information</h3>
                            <table class="table-striped">
                                <tr>
                                    <td>Payment_type: </td>
                                    <td>{{$order->payment_type}}</td>
                                </tr>
                                <tr>
                                    <td>Payment: </td>
                                    <td>
                                        @if($order->payment_status == 0)
                                            No
                                        @else Yes
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="clear: both;"></div>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" action="{{ route('order.update') }}" method="POST">
                        {{ csrf_field() }}
                        <!-- id cua don hang minh dinh update -->
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <input type="hidden" name="order_status" value="{{$order->status}}" id="order_status">
                            <input type="hidden" name="payment_status" value="{{$order->payment_status}}" id="payment_status">


                            <!-- done, spin , wait -->
                            <div class="row" id="process-bar">
                                <div class="col-md-3 col-md-offset-1 status">
                                    <div class="circle"><i class="fa fa-check"></i><i class="fa fa-refresh fa-spin"></i></div>
                                    <div class="line"></div>
                                    <div class="progress">Pending</div>
                                    <!--                             <div id="justSolve">
                                        <input type="button" class="btn" value="Done">
                                    </div> -->
                                </div>
                                <div class="col-md-3 status">
                                    <div class="circle"><i class="fa fa-check"></i><i class="fa fa-refresh fa-spin"></i></div>
                                    <div class="line"></div>
                                    <div class="progress">Processing</div>
                                </div>
                                <div class="col-md-3 status">
                                    <div class="circle"><i class="fa fa-check"></i><i class="fa fa-refresh fa-spin"></i></div>
                                    <div class="line"></div>
                                    <div class="progress">Shipped</div>
                                </div>
                                <div class="col-md-1 status">
                                    <div class="circle"><i class="fa fa-check"></i><i class="fa fa-refresh fa-spin"></i></div>
                                    <div class="progress">Delivery</div>
                                </div>
                            </div>
                            <h3 class="box-title">Items ordered</h3>

                            <!-- /.box-header -->
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Type</th>
                                        <th>Color percent</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allItems as $item)
                                        <tr>
                                            <td>{{$item->getProduct()->id}}</td>
                                            <td>Sơn vàng</td>
                                            <!-- id cua tung san pham san pham trong don hang -->
                                            <td>
                                                <input type="hidden" name="itemId[]" value="{{$item->getProduct()->id}}">
                                                <input type="number" class="quanity" step="1" min="1" max="" name="{{$item->getProduct()->id}}" value="{{$item->quantity}}"  size="4" inputmode="numeric" id="qtt{{$item->id}}">
                                            </td>
                                            <td>{{$item->price}}</td>
                                            <td>Bao</td>
                                            <td>20%</td>
                                            <td class="action">
                                                <button type="button" class="btn btn-danger delete" data-toggle="modal" data-itemid="{{$item->getProduct()->id}}" data-target="#deleteModal"><i class="fa fa-trash-o"></i>&nbsp;  Delete </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="box-info col-md-12">
                                <h3 id="total-title">Order total</h3>
                                <div id="note" class="col-md-6">
                                    <h4>Note for this order</h4>
                                    <table>
                                        <tr>
                                            <td><span> Status</span></td>
                                            <td><span> Payment</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="select_status">
                                                    @foreach(\Modules\Orders\Entities\Orders::listStatus() as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select id="select_payment_status">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <span> Comment</span><br>
                                    <textarea name="subcrible" required id="" cols="30" rows="4"></textarea>
                                    <button type="submit" name="update" value="Update" class="btn btn-info pull-right" style="font-weight: bold">Update</button>
                                </div>
                                <div id="order-total" class="box-info col-md-6">
                                    <h4>Amount Due {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</h4>
                                    <table class="table-striped">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>{{ number_format($order->total_price) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax(10%)</td>
                                            <td>{{ number_format($order->total_price/10) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td>20000</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td id="final-total"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                                    <!-- /.table-responsive -->
                        </form>
                    </div>
                </div>
                <div class="box tab-pane"  style="" id="comment-hisoty" >
                    @if(!empty($events))
                        @foreach($events as $eventsInDay)
                            <?php echo \Carbon\Carbon::parse($eventsInDay[0]->created_at)->format('d-m-Y'); ?>
                            @foreach($eventsInDay as $event)
                                <div class="comment row" style="width: 100%; margin-left: 0px;">
                                    <div class="col-md-1 avatar-comment">
                                        <img src="https://t4.ftcdn.net/jpg/01/05/72/55/240_F_105725545_wjyNkHco8leWLvlw3kWJbDas8MwBz9Wl.jpg" alt="">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="name-date">
                                            <span class="admin">Admin {{$event->admin_id}}</span>
                                            <span class="pull-right">
                                    <?php echo \Carbon\Carbon::parse($eventsInDay[0]->created_at)->format('h:i:s A'); ?>
                                </span>
                                        </div>
                                        <div class="comment-content">{{$event->subcrible}}</div>
                                    </div>

                                    {{--<div class="col-md-1 status-history btn" data-status="{{$event->status}}"></div>--}}
                                </div>
                            @endforeach
                        @endforeach
                    @else
                        <div class="comment row">
                            <div class="col-md-1 avatar-comment">
                                <img src="https://t4.ftcdn.net/jpg/01/05/72/55/240_F_105725545_wjyNkHco8leWLvlw3kWJbDas8MwBz9Wl.jpg" alt="">
                            </div>
                            <div class="col-md-9">
                                <div class="comment-content">No comment here</div>
                            </div>

                            {{--<div class="col-md-1 status-history btn" data-status="{{$event->status}}"></div>--}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- ============================================= -->
        <div class="modal fade" id="deleteModal" role="dialog">
            <div class="modal-dialog">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-tags"></i>Remove product</h3>
                        <strong><h3 id="pickProduct"></h3></strong>
                    </div>
                    <div class="box-body">
                        <form class="form-group" action="{{ route('order.delete') }}" method="post" id="delete_form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden"  name="itemId" id="delProduct">
                            <input type="hidden" name="orderId" value="{{$order->id}}">
                            <input onclick="form_submit()" class="btn btn-info" name="delete" data-dismiss="modal" value="Ok" style="text-align: left; width: 45px;">
                            <input type="button" class="btn btn-default" name="cancel" data-dismiss="modal" value="Cancel">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('admin-lte/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{asset('js/tinymceConfig.js')}}"></script>
    <script src="{{asset('js/news_posts.js?v=1')}}"></script>

    <script>
        var arr_status = ["pending", "processing", "shipped", "delivery", "success"];
        var arr_status_class = ["btn-warning", "btn-info", "btn-success", "btn-danger", "btn-primary"];

        /*phan delete item trong don hang*/
        function form_submit() {
            document.getElementById("delete_form").submit();
        }

        $(".delete").click(function () {
            // name trong input gui request de sua
            console.log($(this).data("name"));
            $('#deleteModal').find('#delProduct').val($(this).data("itemid"));
            // name tren box modal
            $('#deleteModal').find('#pickProduct').html($(this).data("orderid"));
        });
        /*===================================*/
        var order_status = parseInt($('#order_status').val());
        $('#select_status').val(order_status);
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
            console.log(order_status);
            var i = 1;
            $('#process-bar > div').each(function () {
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
        }
    </script>

@endsection

