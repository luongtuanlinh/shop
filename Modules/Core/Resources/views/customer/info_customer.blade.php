<div class="col-md-3">
    <div style="border: #e6e6e6 1px solid; height: 100%">
        <p class="text-center" style="background: #0775c9; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
            <strong>Khách hàng mới</strong>
        </p>
        <p style="background: #7fabdc; height: 20px; padding: 1px 5px; color: #fff"><b class="pull-right">{{$total_customer}}</b></p>
        <div class="clearfix"></div>
        <div class="progress-group" style="padding: 1px 8px">
            <p>Khách hàng cá nhân : {{$customer_type_cn}}</p>
            <p>Khách hàng doanh nghiệp : {{$customer_type_dn}}</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="text-center">
                <a href="{{route('insurance.customer.index')}}?type=moi&start={{$start}}&end={{$end}}" class="small-box-footer">
                    Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>
<!-- /.col -->
<div class="col-md-3">
    <div style="border: #e6e6e6 1px solid; height: 100%">
        <p class="text-center" style="background: #0775c9; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
            <strong>Khách hàng tiềm năng</strong>
        </p>
        <p style="background: #7fabdc; height: 20px; padding: 1px 5px; color: #fff"><b class="pull-right">{{$kh_tiem_nang}}</b></p>
        <div class="clearfix"></div>
        <div class="progress-group" style="padding: 1px 8px">
            <p>Gửi mail : 0</p>
            <p>SMS : 0</p>
            <p>Cuộc gọi : 0</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="text-center">
                <a href="{{route('insurance.customer.index')}}?type=tiem_nang&start={{$start}}&end={{$end}}" class="small-box-footer">
                    Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>
<!-- /.col -->
<div class="col-md-3">
    <div style="border: #e6e6e6 1px solid; height: 100%">
        <p class="text-center" style="background: #0775c9; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
            <strong>Mua hàng</strong>
        </p>
        <p style="background: #7fabdc; height: 20px; padding: 1px 5px; color: #fff"><b class="pull-right">{{$kh_mua_hang}}</b></p>
        <div class="clearfix"></div>
        <div class="progress-group" style="padding: 1px 8px">
            <p>Doanh thu sales : {{number_format($contract_sale)}} VNĐ</p>
            <p>Doanh thu đại lý : {{number_format($contract_agence)}} VNĐ</p>
            <p>Tổng doanh thu : {{number_format($tong_doanh_thu)}} VNĐ</p>
            <p>Công nợ : {{number_format($tong_doanh_thu - $da_tra)}} VNĐ</p>
            <p>&nbsp;</p>
            <p class="text-center">
                <a href="{{route('insurance.contract.index')}}?start={{$start}}&end={{$end}}" class="small-box-footer">
                    Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>
<!-- /.col -->
<div class="col-md-3">
    <div style="border: #e6e6e6 1px solid; height: 100%">
        <p class="text-center" style="background: #0775c9; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
            <strong>Tái tục</strong>
        </p>
        <p style="background: #7fabdc; height: 20px; padding: 1px 5px; color: #fff"><b class="pull-right">{{$kh_tai_tuc}}</b></p>
        <div class="clearfix"></div>
        <div class="progress-group" style="padding: 1px 8px">
            <p>Doanh thu tái tục : {{number_format($doanh_thu_tai_tuc)}} VNĐ</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="text-center">
                <a href="#" class="small-box-footer">
                    Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>
<!-- /.col -->