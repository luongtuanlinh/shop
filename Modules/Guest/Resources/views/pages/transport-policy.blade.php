@extends('guest::app')
@section('content')
<div class="section-wrap">
    <div class="container">

        <!-- Breadcrumbs -->
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">Trang chủ</a>
            </li>
            <li>
                <a href="index.html">Chính sách</a>
            </li>
            <li class="active">
                Chính sách vận chuyển
            </li>
        </ol>

        <div class="row">
            <div class="col-lg-10">
                <h1 class="uppercase mb-20">Chính sách vận chuyển</h1>

                <!-- Accordion -->
                <div class="accordion mb-50" id="accordion">
                    <div class="accordion__panel">
                        <div class="accordion__heading" id="headingOne">
                            <a data-toggle="collapse" href="#collapseOne" class="accordion__link accordion--is-open" aria-expanded="true" aria-controls="collapseOne">Phương thức giao hàng<span class="accordion__toggle">&nbsp;</span>
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="#accordion" role="tabpanel" aria-labelledby="headingOne">
                            <div class="accordion__body">Để thuận tiện cho quý khách trong quá trình mua sắm, Shop Hàng Xuất Dư Xịn thực hiện chính sách giao hàng như sau</div>
                            <div class="accordion__body">Khu vực nội thành Hà Nội: Ship của Shop ưu tiên đi trong ngày cho đơn hàng trước 16:00 p.m</div>
                            <div class="accordion__body">Khu vực khác: vận chuyển qua dịch vụ Viettel Post</div>
                            <div class="accordion__body">Có nhận gửi xe khách đường dài cho khách có nhu cầu</div>
                        </div>
                    </div>

                    <div class="accordion__panel">
                        <div class="accordion__heading" id="headingTwo">
                            <a data-toggle="collapse" href="#collapseTwo" class="accordion__link accordion--is-closed" aria-expanded="false" aria-controls="collapseTwo">Phí vận chuyển<span class="accordion__toggle">&nbsp;</span>
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#accordion" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="accordion__body">Địa chỉ Hà Nội: đồng giá 20.000 VNĐ/ đơn hàng</div>
                            <div class="accordion__body">Địa chỉ ngoài Hà Nội: đồng giá 30.000 VNĐ/ đơn hàng</div>
                            <div class="accordion__body">(Ngoài ra có một số chương trình đặc biệt khuyến mại FREESHIP theo loại sản phẩm/ sự kiện/.... sẽ được thông báo tới Quý khách hàng trong mục TIN TỨC)</div>
                        </div>
                    </div>

                    <div class="accordion__panel">
                        <div class="accordion__heading" id="headingThree">
                            <a data-toggle="collapse" href="#collapseThree" class="accordion__link accordion--is-closed" aria-expanded="false" aria-controls="collapseThree">Thời gian giao hàng<span class="accordion__toggle">&nbsp;</span>
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordion" role="tabpanel" aria-labelledby="headingThree">
                            <div class="accordion__body">Khu vực nội thành Hà Nội: Từ 1 – 2 ngày</div>
                            <div class="accordion__body">Khu vực khác: 2 – 7 ngày tùy sản phẩm, tùy địa chỉ</div>
                        </div>
                    </div>

                    <div class="accordion__panel">
                        <div class="accordion__body">Lưu ý: với khách buôn sẽ có chính sách khác, cụ thể trao đổi trực tiếp khi làm việc</div>
                    </div>
                </div> <!-- end accordion -->
            </div>
        </div>

    </div>
</div> <!-- end faq -->
@endsection