@extends('layouts.admin_default')
@section('title', trans('product::product.title'))
@section ('before-styles-end')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}"> 
@stop
@section('content')
<section class="content-header">
    <h1>Chọn sản phẩm</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="{{ route('product.product.index') }}">{{ trans('product::product.title') }}</a></li>
        <li><a href="{{ route('product.choose') }}">Thay đổi sản phẩm trang chủ</a></li>
        <li class="active">Chọn sản phẩm</li>
    </ol>
</section>
<section class="content">
<div class="row">
  
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
        <div id='flash-container' class='flash-container'>
            Saved.
        </div>    
        <div style="margin-bottom: 10px; font-size: 1.1em;">
            <a href="{{ route('product.choose') }}"> < Quay lại</a>
        </div>     

        <div class="box box-primary" style="padding: 10px 5px;">
            <table id="table-product" class="table table-hover table-bordered txt-center">
                <thead>
                    <tr class="bg-cyan">
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Loại sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Chọn </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="overlay hide">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
        <input type="hidden" id="data-search">
    </div>
</div>
</section>
@endsection

@section('scripts')
    <script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/theory_group.js') }}"></script>
    <script src="{{ asset('js/product.js') }}"></script>
    <script>

        $(function() {
            table = $('#table-product').DataTable({
                processing: true,
                serverSide: true,
                bAutoWidth: false,
                searching: false,
                ajax: {
                    url: '{{ route("product.product.get_choose") }}',
                    type: 'get',
                    data: function(d) {
                        d.category_id = '{{ $cate_id }}'
                        d.csrf = '{{csrf_field()}}';
                    }
                },
                columns: [
                    {data: 'id', sortable: true},
                    {data: 'name', orderable: false},
                    {data: 'price', sortable: true},
                    {data: 'cate_name', orderable: false},
                    {data: 'cover_path', orderable: false},
                    {data: 'actions', 
                        orderable: false,
                        render: function ( data, type, row ) {
                            data = JSON.parse(data);
                            if ( type === 'display' ) {
                                if (data.status == 1 || data.status == 2) {
                                    return '<input type="checkbox" class="product-'+data.id+'" onclick="changeProduct('+data.id+')" checked>';
                                } else {
                                    return '<input type="checkbox" class="product-'+data.id+'" onclick="changeProduct('+data.id+')">';
                                }
                            }
                            return data;
                        }
                    }
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
                ]
            });
        });
        var clickCheck = false;

        function changeProduct(product_id) {
            var cate_id = $('#data-search').val();
            var check = $('.product-' + product_id ).attr('checked');
            var status;
            if (check == undefined) {
                status = 1;
            } else {
                status = 0;
            }

            if(clickCheck) {
                return;
                if (status) {
                    $('.product-' + product_id ).prop('checked', false);
                } else {
                    $('.product-' + product_id ).prop('checked', true);
                }
            } else {
                clickCheck = true;
            }
           
            $.ajax({
                url: "{{ route('product.product.updateChoosen')}}",
                type: 'POST',
                data: {
                    product_id,
                    cate_id: '{{ $cate_id }}',
                    status
                },
                headers: {'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')},
                success: function(res){
                    clickCheck = false;
                    if(res.status == 200){
                        if (status) {
                            $('.product-' + product_id ).attr("checked", "checked");
                        } else {
                            $('.product-' + product_id ).removeAttr('checked');
                        }
                        Flash.success('Cập nhật dữ liệu thành công!');
                    } else {
                        if (status) {
                            $('.product-' + product_id ).prop('checked', false);
                        } else {
                            $('.product-' + product_id ).prop('checked', true);
                        }
                        Flash.fail(res.mess);
                    }
                },
                error: function(e) {
                }
            });
        }
    </script>
@endsection