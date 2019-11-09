@extends('layouts.admin_default')
@section('title', "Tạo đơn hàng")
@section('content')
<section class="content-header">
    <h1>Tạo mới đơn hàng</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="{{ route('order.index') }}"> Đơn hàng</a></li>
        <li class="active">Tạo đơn hàng</li>
    </ol>
</section>
<style>
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

    /* td select2-dropdown select2-dropdown--below {
        width: 140px;
    } */

    .form-group>.select2 {
        height: 34px;
    }
</style>
<section class="content">
    <div class="row">
        {!! Form::open(['method' => 'POST', 'route' => ['order.store'], 'class' =>
        'validate','enctype'=>'multipart/form-data']) !!}
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
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin đại lý</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-6">
                        <input type="hidden" value="" id="customer_id" name="customer_id">
                        <div class="form-group">
                            <label>Tên khách hàng (*)</label>
                            <input type="text" name="name" id="customer_name" class="form-control"
                                value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại (*)</label>
                            <input type="text" name="mobile" class="form-control typeahead-mobile" autocomplete="off"
                                value="{{ old('mobile') }}" required>
                        </div>
                        <div class="form-group remove-date">
                            <label>Lưu ý</label>
                            <textarea style="width: 100%;" name="more_info"></textarea>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group remove-date">
                            <label>Tỉnh</label>
                            <select class="form-control select2" id="province" name="province_id"
                                onchange="return filterArea($(this).val(),'district', 'province', '{{ old('district_id') }}')">
                                <option value="">--Tất cả--</option>
                                @foreach($provinces as $province)
                                <option value="{{ $province->id }}"
                                    <?php echo ($province->id == old('province_id'))? "selected" : "";?>>
                                    {{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group remove-date">
                            <label>Huyện</label>
                            <select class="form-control select2" id="district" name="district_id"
                                onchange="return filterArea($(this).val(),'commune', 'district', '{{ old('commune_id') }}')">
                                <option value="">--Tất cả--</option>
                            </select>
                        </div>
                        <div class="form-group remove-date">
                            <label>Xã</label>
                            <select class="form-control select2" id="commune" name="commune_id"
                                onchange="return filterAddress($(this))">
                                <option value="">--Tất cả--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ cụ thể(*)</label>
                            <input name="address" id="address" type="textbox" value="{{ old('address') }}"
                                class="form-control" placeholder="Nhap dia chi cu the vao day" required>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin đơn hàng</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-info table-bordered">
                        <thead>
                            <th>TT</th>
                            <th>Loại sản phẩm</th>
                            <th>Sản phẩm</th>
                            <th>Kích cỡ</th>
                            <th>Màu sắc</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                            <th>Hành động</th>
                        </thead>
                        <tbody id="tbody">
                            <tr>
                                <td>#1</td>
                                <td>
                                    <select class="form-control select2" required name="category[]" id="type_1"
                                        onchange="return filterProduct($(this).val(), '1')">
                                        <option value="">--Chọn loại sp--</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->cate_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" required name="product_id[]" id="product_id_1"
                                        onchange="return filterProductProperties('1')">
                                        <option value="">--Chọn sản phẩm--</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" required name="size[]" id="size_1">
                                        <option value="">--Kích cỡ--</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" required name="color[]" id="color_1">
                                        <option value="">--Màu sắc--</option>
                                    </select>
                                </td>
                                <td id="amount">
                                    <input type="number" id="amount_1" value="1" min="1" name="amount[]" max="4"
                                        required onchange="return changeAmount('1')">
                                </td>
                                <td id="sell_price_1">
                                    <input type="hidden" id="price_hidden_1">
                                    <span>0</span>
                                </td>
                                <td id="tt_1">
                                    <input type="hidden" id="tt_hidden_1">
                                    <span>0</span>
                                </td>

                                {{-- <td id="sum_price_1">0</td> --}}
                                <td id="td-1">
                                    <button type="button" class="btn btn-danger btn-xs" onclick="deleteRow($(this))"><i
                                            class="fa fa-minus">Xoá</i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9" class="text-center"><button type="button" id="add_button_1" class="btn btn-info btn-xs"
                                    onclick="addRow()"><i class="fa fa-plus">Thêm</i></button></td>
                            </tr>
                            <tr>
                                <td colspan="2">Tổng tiền</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="2" id="sum_price">
                                    <input type="hidden" name="total" id="total" value='0'?/>
                                    <span>0</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="box-footer" style="text-align: center">
                    {!! Form::button(trans('core::user.save'), ['class' => 'btn btn-primary', 'type' => "submit"]) !!}
                    <a href="{{ route('order.index') }}" class="btn btn-default">{{trans('core::user.cancel')}}</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript">
    $(function () {
            $('#datetimepicker1').datetimepicker({
                format: "DD-MM-YYYY",
                locale: 'vi'
            });

        });
        var count = 1;
        var listColor = [];
        $(document).ready(function(){
            $('.input-group-addon').click(function(){
                $('#datetimepicker1 ').focus();
            });
        });

        $(".colorcode").select2({
            templateResult: function (data, container) {
                if (data.element) {
                    if(data.data("id")){
                        $(container).css("border-left", "10px "+ data.data("id") +" solid");
                    }
                }
                return data.text;
            },
        });

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

        function filterProductProperties(index) {
            var product = $("#product_id_" + index).select2('data');
            // console.log($("sell_price_" + index + " span").text());
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
            $.ajax({
                data: {
                    product_id: product[0].id,
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

        function sum_discount(sum_total) {
            var discount = $("#discount").val();
            if(discount == ""){
                discount = 0;
            }
            var total_type_4 = getTotalType4();
            $("#sum_discount").html("");
            $("#sum_discount").html(addCommas(parseInt(discount) * (parseInt(sum_total) - parseInt(total_type_4)) /100));
            sum_tax(discount, sum_total);
        }

        function sum_tax(discount, sum_total) {
            var tax = $("#tax").val();
            if(tax == ""){
                tax = 0;
            }

            var total_type_4 = getTotalType4();
            $("#sum_tax").html("");
            $("#sum_tax").html(addCommas(parseInt(tax) * (100 - parseInt(discount)) * (sum_total - parseInt(total_type_4)) / 10000));
            sum_price(discount, tax, sum_total);
        }

        function getTotalType4() {
            var total_type_4 = 0;
            for(var i = 1 ; i <= count ; i++){
                var type = $("#type_" + i + " option:selected").val();
                if(type == 2){
                    total_type_4 += $("#price_hidden_" + i).val() * $("#amount_" + i).val();
                }
            }
            return total_type_4;
        }

        function sum_price(discount, tax, sum_total) {
            var total_type_4 = getTotalType4();
            $("#sum_price").html("");
            $("#sum_price").html(addCommas((100 - parseInt(tax)) * (100 - parseInt(discount)) * (sum_total - parseInt(total_type_4)) / 10000 + parseInt(total_type_4)));
        }

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
                        $("tbody").append(data.message);
                        count++;
                        $(".select2").select2();
                        filterProduct(count);
                    }
                }
            });
        }

        $('input.typeahead-mobile').typeahead({
            source:  function (query, process) {
                return $.get('{{ route('customer.search') }}', { query: query }, function (data) {
                    data = $.parseJSON(data);
                    return process(data);
                });
            },
            displayText: function(item){
                // OMG ugly !!! :p
                if (item.mobile == undefined) return item;
                return item.mobile;
            },
            updater: function(item) {
                $("#customer_id").val(item.id);
                $("#customer_name").val(item.name);
                $('#type').val(item.type);
                $('#province').val(item.province_id).trigger('change');

                filterArea(item.province_id, "district", "province", item.district_id);
                filterArea(item.district_id, "commune", "district", item.commune_id);
                $("#address").val(item.address);

                return item.mobile;
            },
            afterSelect: function (obj) {
                // var unit = $("#unit_" + count).val();
                // filterPrice(count, unit, obj);
            }
        })

        var province_text = "";
        var district_text = "";
        var commune_text = "";

        <?php if(!empty(old('province_id'))){ ?>
        filterArea('{{ old('province_id') }}', "district", "province", {{ old('district_id') }});
        filterArea('{{ old('district_id') }}', "commune", "district", {{ old('commune_id') }});
        $("#address").val("{{ old('address') }}");
        <?php } ?>
        <?php if(!empty(old('level'))){ ?>
        filterParent("{{ old('level') }}")
        <?php } ?>
        /**
         *
         * @param _this
         */
        function filterAddress(_this) {
            var text = $(_this).find(":selected").text();
            commune_text = text
            $("#address").val(commune_text + ", " + district_text + ", " + province_text);
        }

        function deleteRow(_this) {
            if($(_this).parent().children().length == 2){
                $(_this).parent().parent().remove();
                var sum_total = getSumTotal();
                _sum_total(sum_total);

                var str ="<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deleteRow($(this))\"><i class=\"fa fa-minus\">Xoá</i></button>";
                $("#td-" + count).html("");
                $("#td-" + count).html(str);
            }else{
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

        $.fn.datetimepicker.dates['es'] = {
            days: ["CN",
                "T2",
                "T3",
                "T4",
                "T5",
                "T6",
                "T7"],
            months: ["Tháng 1",
                "Tháng 2",
                "Tháng 3",
                "Tháng 4",
                "Tháng 5",
                "Tháng 6",
                "Tháng 7",
                "Tháng 8",
                "Tháng 9",
                "Tháng 10",
                "Tháng 11",
                "Tháng 12"],
            today: "Hôm nay"
        };

        function getSumTotal() {
            var sum_total = 0;
            //update sum of list item
            for(var i = 0 ; i < count ; i++){
                var j = i + 1;
                var price_item = $("#price_hidden_"+j).val();
                var amount_item = $("#amount_" + j).val();
                if(amount_item == ""){
                    amount_item = "0";
                }
                var tt_item = $("#tt_hidden_"+j).val();
                if(tt_item == ""){
                    tt_item = "0";
                }
                if(price_item == ""){
                    price_item = "0";
                }


                sum_total += (parseInt(price_item) + parseInt(tt_item)) * parseInt(amount_item);
            }
            return sum_total;
        }

        var province_text = "";
        var district_text = "";
        var commune_text = "";
        function filterArea(id, type, parent_type, old_value) {
            var text = $("#" + parent_type).find(":selected").text();
            console.log(text);
            text = text.trim();
            if(type != "district"){
                district_text = text;
                $("#address").val(district_text + ", " + province_text);
            } else {
                province_text = text;
                $("#address").val(province_text);
            }
            $.ajax({
                data:{
                    id : id,
                    type: type,
                    value: old_value
                },
                url: "{{route('order.filter')}}",
                type: "GET",
                success: function (data) {
                    if(data.result == 0){
                        alert(data.message);
                    }else{
                        $("#" + type).html("");
                        $("#" + type).append(data.message);
                    }
                }
            })
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
</script>
@endsection