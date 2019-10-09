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
                    Chính sách thanh toán
                </li>
            </ol>

            <div class="row">
                <div class="col-lg-10">
                    <h1 class="mb-20">Quý khách có thể chọn 1 trong 2 hình thức thanh toán sau:</h1>

                    <!-- Accordion -->
                    <div class="accordion mb-50" id="accordion">
                        <div class="accordion__panel">
                            <div class="accordion__heading" id="headingOne">
                                <a data-toggle="collapse" href="#collapseOne" class="accordion__link accordion--is-open"
                                   aria-expanded="true" aria-controls="collapseOne">Thanh toán COD thu hộ Viettel
                                    Post<span class="accordion__toggle">&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse show" data-parent="#accordion" role="tabpanel"
                                 aria-labelledby="headingOne">
                                <div class="accordion__body">Shop Hàng Xuất Dư Xịn chỉ nhận COD với đơn hàng dưới
                                    1.500.000 VNĐ
                                </div>
                                <div class="accordion__body">Khách hàng trả tiền trực tiếp cho shipper của Viettel
                                    Post
                                </div>
                            </div>
                        </div>

                        <div class="accordion__panel">
                            <div class="accordion__heading" id="headingTwo">
                                <a data-toggle="collapse" href="#collapseTwo"
                                   class="accordion__link accordion--is-closed" aria-expanded="false"
                                   aria-controls="collapseTwo">Thanh toán qua ngân hàng<span class="accordion__toggle">&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordion" role="tabpanel"
                                 aria-labelledby="headingTwo">
                                <div class="accordion__body">Khách hàng thanh toán qua tài khoản:</div>
                                <div class="accordion__body">Nguyễn Quốc Việt</div>
                                <div class="accordion__body">Vietcombank chi nhánh Hoàn Kiếm</div>
                                <div class="accordion__body">STK: 0011000825841</div>
                            </div>
                        </div>

                        <div class="accordion__panel">
                            <div class="accordion__body">Lưu ý: với khách buôn sẽ có chính sách khác, cụ thể trao đổi
                                trực tiếp khi làm việc
                            </div>
                        </div>
                    </div> <!-- end accordion -->
                </div>
            </div>

        </div>
    </div> <!-- end faq -->
@endsection