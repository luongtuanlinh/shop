@extends('layouts.admin_default')
@section('title', "Tạo sale")
@section('content')
    <section class="content-header">
        <h1>Sửa sale off</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="{{ route('admin.saleoff.index') }}"> Sale off</a></li>
            <li class="active">Sửa sale off</li>
        </ol>
    </section>
    <style>
        .select2-container--default .select2-selection--multiple {
            width: 350px;
        }

        .select2-dropdown select2-dropdown--below {
            width: 350px;
        }

        #amount > input {
            border: solid 1px #d0d0d0;
            height: 32px;
            padding-left: 10px;
            font-style: bold;
        }

        /* td select2-dropdown select2-dropdown--below {
            width: 140px;
        } */

        .form-group > .select2 {
            height: 34px;
        }
    </style>
    <section class="content">
        <div class="row">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="col-md-12">
                <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- /.card-header -->
                        <div class="card-body pad">
                            <div class="mb-3">
                                <form method="post" enctype="multipart/form-data" novalidate
                                      action="{{route('admin.saleoff.update',['id' => $sale->id])}}" id="sale-form">
                                    {{csrf_field()}}
                                    {{method_field('PUT')}}
                                    <div class="form-group">
                                        <label for="event_name">Tên sự kiện</label>
                                        <input type="text" name="event_name" id="event_name" class="form-control"
                                               required
                                               placeholder="Nhập tên sự kiện" value="{{$sale->event_name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="introduction">Lời giới thiệu ngắn</label>
                                        <input type="text" name="introduction" id="introduction" class="form-control"
                                               placeholder="Lời giới thiệu ngắn về sự kiện" required
                                               value="{{$sale->introduction}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Khoảng thời gian diễn ra sự kiện:</label>

                                        <div class="form-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="datetimepicker1"
                                                   name="datetimepicker1" required>
                                            <div class="form-group">
                                                <label>
                                                    Các sản phẩm giảm giá trong sự kiện
                                                    <a href="#" data-toggle="modal" data-target="#product-list">Chỉnh
                                                        sửa các
                                                        sản phẩm</a>
                                                </label>
                                                <div class="modal fade" id="product-list">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Danh sách các sản phẩm hiện có
                                                                    trong hệ
                                                                    thống </h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="row" id="product_list">
                                                                    <div class="col-md-12">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h3 class="card-title">Chọn sản phẩm sẽ
                                                                                    giảm giá
                                                                                    trong sự kiện này
                                                                                    <input type="checkbox"
                                                                                           v-model="checkAll">
                                                                                </h3>

                                                                                <div class="card-tools">
                                                                                    <div class="input-group input-group-sm"
                                                                                         style="width: 150px;">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.card-header -->
                                                                            <div class="card-body table-responsive p-0"
                                                                                 style="height: 300px;">
                                                                                <table class="table table-head-fixed"
                                                                                       id="product-table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>Thứ tự</th>
                                                                                        <th>Tên sản phẩm</th>
                                                                                        <th>Mã sản phẩm</th>
                                                                                        <th>Giá sản phẩm</th>
                                                                                        <th>Khuyến mại</th>
                                                                                        <th>Phần trăm</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <tr v-for="(product,key) in products">
                                                                                        <td>@{{ key+1 }}</td>
                                                                                        <td>@{{ product.name }}</td>
                                                                                        <td>@{{ product.code }}</td>
                                                                                        <td>@{{ product.price }}</td>
                                                                                        <td>
                                                                                            <input type="checkbox"
                                                                                                   name="productId[]"
                                                                                                   :value="product.id"
                                                                                                   v-model="product.sale">
                                                                                        </td>
                                                                                        <td>
                                                                                            <input name="discount"
                                                                                                   class="form-control"
                                                                                                   :id="product.id"
                                                                                                   :disabled="!product.sale"
                                                                                                   type="number"
                                                                                                   max="99"
                                                                                                   v-model="product.percentage"
                                                                                            >
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <!-- /.card-body -->
                                                                            <div class="card-tools">
                                                                                <div class="input-group input-group-sm"
                                                                                     style="width: 150px;">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.card-header -->
                                                                        <!-- /.card-body -->
                                                                    </div>
                                                                    <!-- /.card -->
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-primary"
                                                                    data-dismiss="modal">Xong
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer" style="text-align: center">
                                        <button class="btn btn-primary" id="submit-button">Lưu</button>
                                        <a href="{{ route('admin.saleoff.index') }}"
                                           class="btn btn-default">{{trans('core::user.cancel')}}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var app = new Vue({
            el: "#product_list",
            data: {
                products: {!! json_encode($products) !!},
                checkAll: false,
            },
            methods: {},
            mounted: function () {
                setTimeout(() => {
                    $('#product-table').DataTable();
                }, 0);
            },
            watch: {
                checkAll: function () {
                    for (let i = 0; i < this.products.length; i++) {
                        this.products[i].sale = this.checkAll;
                    }
                },
                haveSaleProducts: function () {
                    if (this.haveSaleProducts === false) this.checkAll = false;
                }
            },
            computed: {
                haveSaleProducts: function () {
                    let arr = this.products.map(function (el) {
                        return el.sale;
                    });
                    for (let i = 0; i < arr.length; i++) {
                        if (arr[i] === true) return true;
                    }
                    return false;
                }
            },
        });
        $('#submit-button').click(function (event) {
            event.preventDefault();
            let saleProductIds = [];
            let percentageDiscounts = [];
            for (let i = 0; i < app.products.length; i++) {
                if (app.products[i].sale === true) {
                    saleProductIds.push(app.products[i].id);
                    percentageDiscounts.push(parseInt(app.products[i].percentage));
                }
            }
            let params = {
                event_name: $('#event_name').val(),
                introduction: $('#introduction').val(),
                period: $('#datetimepicker1').val(),
                saleProductIds: saleProductIds,
                percentageDiscounts: percentageDiscounts,
            };
            axios.put("{{route('admin.saleoff.update',['id' => $sale->id])}}",
                params
            ).then(function (res) {
                alert(res.data.messenger);

                window.location.replace("{{route('admin.saleoff.index')}}");
            }).catch(function (err) {
                console.log(err.data);
            });
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.input-group-addon').click(function () {
                $('#datetimepicker1 ').focus();
            });
        });

        $(function () {
            $('#datetimepicker1').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                // date('d-m-Y H:i:s', strtotime($item->date_begin))
                startDate: "{{ date('Y-m-d',strtotime($sale->start_time)) }}",
                endDate: "{{date('Y-m-d',strtotime($sale->end_time)) }}",
            });
        });

    </script>

@endsection
