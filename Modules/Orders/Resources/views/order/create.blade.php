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
        .select2-container--default .select2-selection--multiple{
            width: 350px;
        }
        .select2-dropdown select2-dropdown--below{
            width: 350px;
        }
        td .select2-container--default .select2-selection--single{
            width: 140px;
        }
        td select2-dropdown select2-dropdown--below{
            width: 140px;
        }
    </style>
    <section class="content">
        <div class="row">
            {!! Form::open(['method' => 'POST', 'route' => ['order.store'], 'class' => 'validate','enctype'=>'multipart/form-data']) !!}
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
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-6">
                            <input type="hidden" value="" id="customer_id" name="customer_id">
                            <div class="form-group">
                                <label>Số điện thoại (*)</label>
                                <input type="text" name="mobile" class="form-control typeahead-mobile" autocomplete="off" value="{{ old('mobile') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Họ và tên (*)</label>
                                <input type="text" name="name" id="customer_name" class="form-control" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Loại khách hàng (*)</label>
                                <select name="type_customer" id="type" class="form-control" required>
                                    <option value="">--Chọn loại khách hàng--</option>
                                    <option value="1">Công ty</option>
                                    <option value="2">Cá nhân</option>
                                </select>
                            </div>
                            <div class="form-group remove-date">
                                <label>Tỉnh</label>
                                <select class="form-control select2" id="province" name="province_id" onchange="return filterArea($(this).val(),'district', 'province', '{{ old('district_id') }}')">
                                    <option value="">--Tất cả--</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" <?php echo ($province->id == old('province_id'))? "selected" : "";?>>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group remove-date">
                                <label>Huyện</label>
                                <select class="form-control select2" id="district" name="district_id" onchange="return filterArea($(this).val(),'commune', 'district', '{{ old('commune_id') }}')">
                                    <option value="">--Tất cả--</option>
                                </select>
                            </div>
                            <div class="form-group remove-date">
                                <label>Xã</label>
                                <select class="form-control select2" id="commune" name="commune_id" onchange="return filterAddress($(this))">
                                    <option value="">--Tất cả--</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Địa chỉ cụ thể(*)</label>
                                <input name="address" id="address" type="textbox" value="{{ old('address') }}" class="form-control" placeholder="Nhap dia chi cu the vao day" required>
                            </div>
                            <h3 class="h3">Thông tin đại lý</h3>
                            <div class="form-group">
                                <label>Cấp đại lý (*)</label>
                                <select name="user_level" id="level" class="form-control select2" required  onchange="filterLevel($(this).val())">
                                    <option value="">--Chọn cấp đại lý--</option>
                                    <option value="0">Cấp công ty</option>
                                    @for($i = 1 ; $i <= $maxLevel ; $i++)
                                        <option value="{{ $i }}" <?php echo ($i == old('level')? "selected" : "")?>>Cấp {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Đại lý (*)</label>
                                <select name="created_user_id" id="created_user_id" required class="form-control select2">
                                    <option value="">--Chọn đại lý--</option>
                                </select>
                            </div>
                            <div class="form-group no-margin remove-date">
                                <label>Ngày giao hàng</label>
                                <div class='input-group date'>
                                    <input type='text' class="form-control" id="datetimepicker1" name="deliver_time"  value="{{ Request::get('published_at') }}" onchange="return filter()" />
                                    <label class="input-group-addon btn" for="date">
                                        <span class="fa fa-calendar open-datetimepicker"></span>
                                    </label>
                                </div>
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
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-info table-bordered">
                            <thead>
                                <th>TT</th>
                                <th width="14%">Loại sản phẩm</th>
                                <th width="14%">Sản phẩm</th>
                                <th width="14%">Đơn vị</th>
                                <th width="10%">Mã màu</th>
                                <th>Màu</th>
                                <th>Tồn kho</th>
                                <th style="width: 7%">Số lượng</th>
                                <th width="7%">% màu</th>
                                <th style="width: 9%">TT</th>
                                <th width="10%">Đơn giá</th>
                                <th width="10%">Thành tiền sơn</th>
                                <th style="width: 115px">Hành động</th>
                            </thead>
                            <tbody>
                                @php
                                    $listTypes = \Modules\Product\Entities\Product::listTypeProduct();
                                    $listUnits = \Modules\Product\Entities\Product::listProductUnit();
                                @endphp
                                <tr>
                                    <td>#1</td>
                                    <td>
                                        <select class="form-control select2" required name="type[]" id="type_1" onchange="filterProduct($(this).val(), '1')">
                                            <option value="">--Chọn loại sp--</option>
                                            @foreach($listTypes as $key => $value)
                                                <option value="{{ $key }}" >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select2" required name="product_id[]" id="product_id_1" onchange="filter('1')">
                                            <option value="">--Chọn sản phẩm--</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select2" required name="unit[]" id="unit_1" onchange="filterUnit('1')">
                                            <option value="">--Chọn đơn vị--</option>
                                            @foreach($listUnits as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="typeahead form-control"  data-index="1" oninput="filterColor($(this))" autocomplete="off" id="colorcode_id_1" style="margin:0px auto;" name="color_id[]" type="text" disabled>
                                    </td>
                                    <td>
                                        <button type="button" id="color_1" style="width: 20px; height: 20px; background-color: white"></button>
                                    </td>
                                    <td id="inventory_1">0</td>
                                    <td><input type="number" min="1" value="1" name="amount[]" id="amount_1" oninput='changeAmount("1")' class="form-control"></td>
                                    <td id="percent_1"><input type="hidden"  id="color_percent_1" name="color_percent[]" value=""><span>0%</span></td>
                                    <td id="tt_1"><input type="hidden" id="tt_hidden_1" value=""><span>0</span></td>
                                    <td id="price_1"><input type="hidden" id="price_hidden_1" name="sell_price[]"><span>0</span></td>
                                    <td id="sum_price_1">0</td>
                                    <td id="td-1">
                                        <button type="button" class="btn btn-info btn-xs" onclick="addRow($(this))"><i class="fa fa-plus">Thêm</i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="deleteRow($(this))"><i class="fa fa-minus">Xoá</i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">Cộng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="4" id="sum_total"><input type="hidden" value="" id="sum_total_hidden" name="total"><span>0</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Chiết khấu</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class='input-group discount'>
                                            <input type="number" name="discount" id="discount" oninput="sum_discount($('#sum_total_hidden').val())" class="form-control">
                                        </div>

                                    </td>
                                    <td colspan="4" id="sum_discount">0</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Chiết khấu thánh toán</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class='input-group tax'>
                                            <input type="number" oninput="sum_tax($('#discount').val(), $('#sum_total_hidden').val())" name="tax" id="tax" class="form-control">
                                        </div>

                                    </td>
                                    <td colspan="4" id="sum_tax">0</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Thành tiền</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="4" id="sum_price">0</td>
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

        function filterLevel(level) {
            if(level > 0){
                $("#created_user_id").prop('required', true);
                $.ajax({
                    data:{
                        level : level
                    },
                    url: "{{route('agency.filter.level')}}",
                    type: "GET",
                    success: function (data) {
                        $("#created_user_id").html("");
                        $("#created_user_id").append(data.message);

                    }
                })
            }else{
                $("#created_user_id").prop('required', false);
            }

        }

        function filterProduct(type, id) {
            $.ajax({
                data:{
                    type : type
                },
                url: "{{route('product.filter.type')}}",
                type: "GET",
                success: function (data) {
                    if(data.result == 1){
                        $("#product_id_"+id).html("");
                        $("#product_id_"+id).append(data.message);
                        if(parseInt(type) == 1){
                            $("#colorcode_id_"+id).prop("disabled", false);
                        }
                        else{
                            $("#colorcode_id_"+id).val("");
                            $("#colorcode_id_"+id).prop("disabled", true);
                            $("#percent_"+ id +" span").html("");
                            $("#percent_"+ id +" span").append("0%");
                            $("#tt_"+ id +" span").append("0");
                            $("#tt_hidden_"+id).val();
                            tt(id);
                            total(id);
                        }
                    }
                }
            })
        }

        function filterUnit(id) {
            var data = $('#unit_'+ id).select2('data');
            if($("#type_" + id).val() != "1"){
                filterPrice(id, data[0].id);
            }else{
                var color_id = $("#colorcode_id").val();
                filterPrice(id, data[0].id, color_id);
            }
        }

        function filterPrice(id, unit, color_id = "") {
            $.ajax({
                data:{
                    unit : unit,
                    product_id: $("#product_id_"+id + " option:selected").val(),
                    color_id: color_id
                },
                url: "{{route('product.filter.price')}}",
                type: "GET",
                success: function (data) {
                    if(data.result == 1){
                        $("#price_hidden_"+id).val(data.message);
                        $("#price_"+ id + " span").html("");
                        $("#price_"+ id + " span").append(addCommas(data.message));
                        $("#inventory_" + id).html(data.message1);
                        tt(id);
                        total(id);
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

        function filter(id) {
            var data_1 = $('#unit_'+ id).select2('data');
            filterPrice(id, data_1[0].id);
        }


        function changeAmount(id){
            total(id);
        }

        /**
         *
         * @param id
         */
        function tt(id) {
            var price = $("#price_hidden_"+id).val();
            var percent = $("#percent_"+ id +" span").html().replace("%", "");
            $("#tt_hidden_"+id).val(price * percent/100);
            $("#tt_"+id+" span").html(addCommas(price * percent/100));

        }

        function total(id) {
            var price = $("#price_hidden_"+id).val();
            var amount = $("#amount_" + id).val();
            if(amount == ""){
                amount = 0
            }
            if(price == ""){
                price = 0;
            }
            var tt = $("#tt_hidden_"+id).val();
            if(tt == ""){
                tt = 0;
            }
            //update sum of item
            $("#sum_price_"+id).html("");
            $("#sum_price_"+id).html(addCommas((parseInt(price) + parseInt(tt)) * parseInt(amount)));

            var sum_total = getSumTotal();
            //update sum of list item
            _sum_total(sum_total);
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

        function addRow(_this) {
            $(_this).remove();
            var str_row = "";
            count = count + 1;
            str_row += "<tr>\n" +
                "                                    <td>#"+ count +"</td>\n" +
                "                                    <td>\n" +
                "                                        <select class=\"form-control select2\" name=\"type[]\" id=\"type_"+count+"\" onchange=\"filterProduct($(this).val(), '"+count+"')\">\n" +
                "                                            <option value=\"\">--Chọn loại sp--</option>\n" +
                "                                            @foreach($listTypes as $key => $value)\n" +
                "                                                <option value=\"{{ $key }}\">{{ $value }}</option>\n" +
                "                                            @endforeach\n" +
                "                                        </select>\n" +
                "                                    </td>\n" +
                "                                    <td>\n" +
                "                                        <select class=\"form-control select2\" name=\"product_id[]\" id=\"product_id_"+count+"\" onchange=\"filter('"+count+"')\">\n" +
                "                                            <option value=\"\">--Chọn sản phẩm--</option>\n" +
                "                                        </select>\n" +
                "                                    </td>\n" +
                "                                    <td>\n" +
                "                                        <select class=\"form-control select2\" name=\"unit[]\" id=\"unit_"+count+"\" onchange=\"filterUnit('"+count+"')\">\n" +
                "                                            <option value=\"\">--Chọn đơn vị--</option>\n" +
                "                                            @foreach($listUnits as $key => $value)\n" +
                "                                                <option value=\"{{ $key }}\">{{ $value }}</option>\n" +
                "                                            @endforeach\n" +
                "                                        </select>\n" +
                "                                    </td>\n" +
                "                                     <td>\n" +
                "                                        <input class=\"typeahead form-control\" oninput=\"filterColor($(this))\" autocomplete=\"off\" data-index="+ count +" id=\"colorcode_id_"+ count +"\" style=\"margin:0px auto;\" name=\"color_id[]\" type=\"text\" disabled>\n" +
                "                                    </td>"+
                "                                       <td>\n" +
                "                                        <button type=\"button\" id=\"color_"+ count +"\" style=\"width: 20px; height: 20px; background-color: white\"></button>\n" +
                "                                    </td>"+
                    "<td id=\"inventory_"+ count +"\">0</td>"+
                "                                    <td><input type=\"number\" min=\"1\" value=\"1\" name=\"amount[]\" id=\"amount_"+count+"\" oninput='changeAmount(\""+count+"\")' class=\"form-control\"></td>\n" +
                "                                    <td id=\"percent_"+count+"\"><input type=\"hidden\" id=\"color_percent_"+ count +"\" name=\"color_percent[]\" value=\"\"><span>0%</span></td>\n" +
                "                                    <td id=\"tt_"+count+"\"><input type=\"hidden\" id=\"tt_hidden_"+count+"\" value=\"\"><span>0</span></td>\n" +
                "                                    <td id=\"price_"+count+"\"><input type=\"hidden\" id=\"price_hidden_"+count+"\" name=\"sell_price[]\"><span>0</span></td>\n" +
                "                                    <td id=\"sum_price_"+count+"\">0</td>\n" +
                "                                    <td id='td-"+ count +"'><button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"addRow($(this))\"><i class=\"fa fa-plus\">Thêm</i></button>" +
                "                                           <button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deleteRow($(this))\"><i class=\"fa fa-minus\">Xoá</i></button></td>\n" +
                "                                </tr>";
            $("tbody").append(str_row);
            $(".select2").select2();
            filterColor(_this);
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
        function filterArea(id, type, parent_type, old_value) {
            var text = $("#" + parent_type).find(":selected").text();
            if (type != "district") {
                district_text = text;
                $("#address").val(district_text + "," + province_text);
            } else {
                province_text = text;
                $("#address").val(province_text);
            }
            $.ajax({
                data: {
                    id: id,
                    type: type,
                    value: old_value
                },
                url: "{{route('agency.filter')}}",
                type: "GET",
                success: function (data) {
                    if (data.result == 0) {

                    } else {
                        $("#" + type).html("");
                        $("#" + type).append(data.message);
                    }

                }
            })
        }

        <?php if(!empty(old('province_id'))){ ?>
        filterArea('{{ old('province_id') }}', "district", "province", {{ old('district_id') }});
        filterArea('{{ old('district_id') }}', "commune", "district", {{ old('commune_id') }});
        $("#address").val("{{ old('address') }}");
        <?php } ?>
        <?php if(!empty(old('level'))){ ?>
        filterParent("{{ old('level') }}")
        <?php } ?>
        function filterParent(level) {
            level = parseInt(level);
            if(level > 1){
                level = level - 1;
                $.ajax({
                    data:{
                        level : level
                    },
                    url: "{{route('agency.filter.parent')}}",
                    type: "GET",
                    success: function (data) {
                        $("#parent").html("");
                        $("#parent").append(data.message);

                    }
                })
            }else{
                $("#parent").find('option').remove();
            }

        }

        /**
         *
         * @param _this
         */
        function filterAddress(_this) {
            var text = $(_this).find(":selected").text();
            commune_text = text
            $("#address").val(commune_text + "," + district_text + "," + province_text);
        }

        function deleteRow(_this) {
            if($(_this).parent().children().length == 2){
                $(_this).parent().parent().remove();
                count = count - 1;
                var sum_total = getSumTotal();
                _sum_total(sum_total);

                var str =
                    "<button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"addRow($(this))\"><i class=\"fa fa-plus\">Thêm</i></button>\n" +
                    "                                <button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deleteRow($(this))\"><i class=\"fa fa-minus\">Xoá</i></button>";
                $("#td-" + count).html("");
                $("#td-" + count).html(str);
            }else{
                $(_this).parent().parent().remove();
            }
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

        function filterColor(_this) {
            var index = $(_this).data("index");
            $(_this).typeahead({
                source:  function (query, process) {
                    return $.get('{{ route('product.color.filter') }}', { query: query }, function (data) {
                        data = $.parseJSON(data);
                        return process(data);
                    });
                },
                displayText: function(item){
                    // OMG ugly !!! :p
                    if (item.hex_code == undefined) return item;
                    return item.hex_code;
                },
                updater: function(item) {
                    $("#percent_"+ index +" span").html("");
                    $("#percent_"+ index +" span").append(item.percent + "%");
                    $("#color_percent_" + index).val(item.percent);
                    $("#color_"+index).css("background-color", item.real_color_code);
                    return item.hex_code;
                },
                afterSelect: function (obj) {
                    var unit = $("#unit_" + index).val();
                    filterPrice(index, unit, obj);
                }
            });
        }
    </script>
@endsection
