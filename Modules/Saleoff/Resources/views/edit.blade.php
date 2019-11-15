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
                        <h1>Sửa thông tin sự kiện sale</h1>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                Điền vào thông tin của sự kiện
                            </h3>
                            <!-- tools box -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove"
                                        data-toggle="tooltip" title="Remove" style="display: none;">
                                    <i class="fas fa-times"></i></button>
                            </div>
                            <!-- /. tools -->
                        </div>
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
                                               placeholder="Nhập tên sự kiện" value="{{$sale->event_name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="introduction">Lời giới thiệu ngắn</label>
                                        <input type="text" name="introduction" id="introduction" class="form-control"
                                               placeholder="Lời giới thiệu ngắn về sự kiện"
                                               value="{{$sale->introduction}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Khoảng thời gian diễn ra sự kiện:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="period"
                                                   name="period">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Các sản phẩm giảm giá trong sự kiện
                                            <a href="#" data-toggle="modal" data-target="#product-list">Chỉnh sửa các
                                                sản phẩm</a>
                                        </label>
                                        <div class="modal fade" id="product-list">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Danh sách các sản phẩm hiện có trong hệ
                                                            thống </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row" id="product_list">
                                                            <div class="col-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h3 class="card-title">Chọn sản phẩm sẽ giảm giá
                                                                            trong sự kiện này</h3>

                                                                        <div class="card-tools">
                                                                            <div class="input-group input-group-sm"
                                                                                 style="width: 150px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.card-header -->
                                                                    <div class="card-body table-responsive p-0"
                                                                         style="height: 300px;">
                                                                        <table class="table table-head-fixed" id="product-table">
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
                                                                                           type="number" max="99"
                                                                                           v-model="product.percentage"
                                                                                    >
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
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
                                    <button type="submit" class="btn btn-success">Lưu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>

@endsection
@push('js')
    <script>
        $('#period').daterangepicker({
            timePicker: true,
            startDate: "{{$sale->start_time}}",
            endDate: "{{$sale->end_time}}",
            locale: {
                format: 'YYYY-MM-DD',
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: "#product_list",
            data: {
                products: {!! json_encode($products) !!},
            },
            methods: {},
            mounted: function () {
                setTimeout(() => {
                    $('#product-table').DataTable();
                }, 0);
            },
        });
        $('#sale-form').submit(function (event) {
            console.log('gg');
            event.preventDefault();
            let saleProductIds = [];
            let percentageDiscounts = [];
            for (let i = 0; i < app.products.length; i++) {
                if (app.products[i].sale === true){
                    saleProductIds.push(app.products[i].id);
                    percentageDiscounts.push(parseInt(app.products[i].percentage));
                }
            }
            let params = {
                event_name: $('#event_name').val(),
                introduction: $('#introduction').val(),
                period: $('#period').val(),
                saleProductIds: saleProductIds,
                percentageDiscounts: percentageDiscounts,
            };
            axios.put("{{route('admin.saleoff.update',['id' => $sale->id])}}",
                params
            ).then(function (res) {
                alert('thanh cong');
            }).catch(function (err) {
                alert('loi');
            });
        })
    </script>
@endpush