<!-- Navigation -->
<header class="nav">
    <a href="#top" hidden>Top</a>
    <div class="nav__holder nav--sticky">
        <div class="container relative">

            <!-- Top Bar -->
            <div class="top-bar d-none d-lg-flex">

                <!-- About / Contact -->
                <ul class="top-bar__currency-language">
                    <li class="top-bar__language">
                        <a href="{{route('guest.introduction')}}">Giới thiệu</a>
                    </li>
                    <li class="top-bar__currency">
                        <a href="{{route('guest.contact')}}">Liên hệ</a>
                    </li>
                </ul>

                <!-- Promo -->
                <p class="top-bar__promo text-center"></p>

                <!-- Sign in / Wishlist -->
                <div class="top-bar__right">

                    <!-- Sign In -->
                    <a href="{{route('guest.login')}}" class="top-bar__item top-bar__sign-in" id="top-bar__sign-in"><i class="ui-user"></i>Đăng nhập</a>
                    <div class="top-bar__border-bar"></div>

                    <!-- Search -->
                    <div class="top-bar__item nav__search">
                        <form method="get" class="nav__search-form">
                            <input type="search" class="nav__search-input" placeholder="Tìm kiếm" name="keyword">
                            <button type="submit" class="nav__search-submit">
                                <i class="ui-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div> <!-- end top bar -->

            <div class="flex-parent">

                <!-- Mobile Menu Button -->
                <button class="nav-icon-toggle" id="nav-icon-toggle" aria-label="Open mobile menu">
              <span class="nav-icon-toggle__box">
                <span class="nav-icon-toggle__inner"></span>
              </span>
                </button> <!-- end mobile menu button -->

                <!-- Logo -->
                <a href="index.html" class="logo-mobile">
                    <img class="logo-mobile__img" src="/shop/img/logo_light.png" alt="logo">
                </a>

                <!-- Nav-wrap -->
                <nav class="flex-child nav__wrap d-none d-lg-block">
                    <ul class="nav__menu">

                        <li class="nav__dropdown active">
                            <a href="{{route('guest.index')}}">Trang chủ</a>
                        </li>

                        <li class="nav__dropdown">
                            <a href="{{route('guest.product')}}">Sản phẩm</a>
                            <ul class="nav__dropdown-menu nav__megamenu">
                                <li>
                                    <div class="nav__megamenu-wrap">
                                        <div class="row">

                                            <div class="col nav__megamenu-item">
                                                <a href="#" class="nav__megamenu-title">Áo nữ</a>
                                                <ul class="nav__megamenu-list">
                                                    <li><a href="#">Áo phông &amp; áo thun</a></li>
                                                    <li><a href="#">Áo Sơ mi</a></li>
                                                    <li><a href="#">Áo lên &amp; Cardigan</a></li>
                                                    <li><a href="#">Áo khoác</a></li>
                                                    <li><a href="#">Khác</a></li>
                                                </ul>
                                            </div>

                                            <div class="col nav__megamenu-item">
                                                <a href="#" class="nav__megamenu-title">Quần nữ</a>
                                                <ul class="nav__megamenu-list">
                                                    <li><a href="#">Quần sooc</a></li>
                                                    <li><a href="#">Quần dài</a></li>
                                                </ul>
                                            </div>

                                            <div class="col nav__megamenu-item">
                                                <a href="#" class="nav__megamenu-title">Váy và đầm</a>
                                                <ul class="nav__megamenu-list">
                                                    <li><a href="#">Chân váy</a></li>
                                                    <li><a href="#">Đầm</a></li>
                                                </ul>
                                            </div>

                                            <div class="col nav__megamenu-item">
                                                <a href="#" class="nav__megamenu-title">Đồ ngủ và nội y</a>
                                                <ul class="nav__megamenu-list">
                                                    <li><a href="#">Bộ đồ ngủ</a></li>
                                                    <li><a href="#">Bộ đồ lót</a></li>
                                                    <li><a href="#">Bộ đồ bơi</a></li>
                                                    <li><a href="#">Áo ngực</a></li>
                                                    <li><a href="#">Quần lót</a></li>
                                                </ul>
                                            </div>

                                            <div class="col nav__megamenu-item">
                                                <a href="#" class="nav__megamenu-title">Khác</a>
                                            </div>

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav__dropdown">
                            <!-- Logo -->
                            <a href="{{route('guest.index')}}" class="logo">
                                <img class="logo__img" src="shop/img/logo_light.png" alt="logo">
                            </a>
                        </li>

                        <li class="nav__dropdown">
                            <a href="{{route('guest.saleoff')}}">Sale Off</a>
                        </li>

                        <li class="nav__dropdown">
                            <a href="{{route('guest.news')}}">Tin tức</a>
                            <ul class="nav__dropdown-menu">
                                <li><a href="{{route('guest.news')}}">Tin tức</a></li>
                                <li><a href="catalog.html">Khuyến mãi</a></li>
                            </ul>
                        </li>

                        <!-- <li class="nav__dropdown">
                          <a href="contact.html">Pages</a>
                          <ul class="nav__dropdown-menu">
                            <li><a href="catalog.html">Catalog</a></li>
                            <li><a href="single-product.html">Single Product</a></li>
                            <li><a href="cart.html">Cart</a></li>
                            <li><a href="checkout.html">Checkout</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="contact.html">Contact</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="404.html">404</a></li>
                          </ul>
                        </li> -->

                    </ul> <!-- end menu -->

                </nav> <!-- end nav-wrap -->

                <!-- Mobile Cart -->
                <a href="cart.html" class="nav__mobile-cart d-lg-none">
                    <i class="ui-bag"></i>
                    <span class="nav__mobile-cart-amount">(2)</span>
                </a>

            </div> <!-- end flex-parent -->
        </div> <!-- end container -->

    </div>
</header> <!-- end navigation -->