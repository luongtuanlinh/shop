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
                    Chính sách bảo mật
                </li>
            </ol>

            <div class="row">
                <div class="col-lg-10">
                    <h1 class="uppercase mb-20">Chính sách bảo mật</h1>

                    <!-- Accordion -->
                    <div class="accordion mb-50" id="accordion">
                        <div class="accordion__panel">
                            <div class="accordion__body">Chính sách bảo mật này nhằm giúp Quý khách hiểu về cách website thu thập và sử dụng thông tin cá nhân của mình thông qua việc sử dụng trang web, bao gồm mọi thông tin có thể cung cấp thông qua trang web khi Quý khách đăng ký tài khoản, đăng ký nhận thông tin liên lạc từ chúng tôi, hoặc khi Quý khách mua sản phẩm, dịch vụ, yêu cầu thêm thông tin dịch vụ từ chúng tôi.</div>
                            <div class="accordion__body">Chúng tôi sử dụng thông tin cá nhân của Quý khách để liên lạc khi cần thiết liên quan đến việc Quý khách sử dụng website của chúng tôi, để trả lời các câu hỏi hoặc gửi tài liệu và thông tin Quý khách yêu cầu.</div>
                            <div class="accordion__body">Trang web của chúng tôi coi trọng việc bảo mật thông tin và sử dụng các biện pháp tốt nhất để bảo vệ thông tin cũng như việc thanh toán của khách hàng.</div>
                            <div class="accordion__body">Mọi thông tin giao dịch sẽ được bảo mật ngoại trừ trong trường hợp cơ quan pháp luật yêu cầu.</div>
                        </div>
                    </div> <!-- end accordion -->
                </div>
            </div>

        </div>
    </div> <!-- end faq -->
@endsection