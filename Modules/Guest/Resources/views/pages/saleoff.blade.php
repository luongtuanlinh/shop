@extends('guest::app')
@section('content')
    <section class="section-wrap pt-60 pb-30 catalog">
        <div class="container">

            <!-- Breadcrumbs -->
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">Trang chủ</a>
                </li>
                <li>
                    <a href="index.html">Trang chính</a>
                </li>
                <li class="active">
                    Danh sách sản phẩm
                </li>
            </ol>

            <div class="row">
                <div class="col-lg-9 order-lg-2 mb-40">

                    <!-- Filter -->
                    <div class="shop-filter">
                        <p class="woocommerce-result-count">
                            Hiển thị: 1-12 trên 80 sản phẩm
                        </p>
                        <span class="woocommerce-ordering-label">Sắp xếp</span>
                        <form class="woocommerce-ordering">
                            <select>
                                <option value="default-sorting">Mặc định</option>
                                <option value="price-low-to-high">Giá: từ cao tới thấp</option>
                                <option value="price-high-to-low">Giá: từ thấp tới cao</option>
                                <option value="date">Mới hơn</option>
                            </select>
                        </form>
                    </div>

                    <div class="row row-8">

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_1.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_1.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Joeby Tailored Trouser</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">170.000đ</span>
                  </ins>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_2.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_2.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Denim Hooded</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_3.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_3.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Mint Maxi Dress</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">170.000đ</span>
                  </ins>
                  <del>
                    <span>300.000đ</span>
                  </del>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_4.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_4.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">White Flounce Dress</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                  <del>
                    <span>300.000đ</span>
                  </del>
                </span>
                        </div> <!-- end product -->

                        <div class="w-100"></div>

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_5.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_5.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Maxi dress</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_6.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_6.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Casual Jacket</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">170.000đ</span>
                  </ins>
                  <del>
                    <span>300.000đ</span>
                  </del>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_7.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_7.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Bounce Elegant Dress</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                  <del>
                    <span>300.000đ</span>
                  </del>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_8.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_8.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Classic White Tailored Shirt</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                  <del>
                    <span>300.000đ</span>
                  </del>
                </span>
                        </div> <!-- end product -->

                        <div class="w-100"></div>

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_9.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_9.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Men’s Belt</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_10.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_10.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Sport Hi Adidas</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_11.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_11.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Floral Mini Strappy</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                  <del>
                    <span>300.000đ</span>
                  </del>
                </span>
                        </div> <!-- end product -->

                        <div class="col-md col-sm-6 product">
                            <div class="product__img-holder">
                                <a href="single-product.html" class="product__link">
                                    <img src="/shop/img/shop/product_12.jpg" alt="" class="product__img">
                                    <img src="/shop/img/shop/product_back_12.jpg" alt="" class="product__img-back">
                                </a>
                                <div class="product__actions">
                                    <a href="quickview.html" class="product__quickview" title="Xem ngay">
                                        <i class="ui-eye"></i>
                                        <span>Xem ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-cart" title="Mua ngay">
                                        <i class="ui-bag"></i>
                                        <span>Mua ngay</span>
                                    </a>
                                    <a href="#" class="product__add-to-wishlist" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                        <span>Thêm</span>
                                    </a>
                                </div>
                            </div>

                            <div class="product__details">
                                <h3 class="product__title">
                                    <a href="single-product.html">Hooded Jacket</a>
                                </h3>
                            </div>

                            <span class="product__price">
                  <ins>
                    <span class="amount">300.000đ</span>
                  </ins>
                </span>
                        </div> <!-- end product -->

                    </div> <!-- end row -->

                    <!-- Pagination -->
                    <div class="pagination clearfix">
                        <nav class="pagination__nav right clearfix">
                            <a href="#" class="pagination__page"><i class="ui-arrow-left"></i></a>
                            <span class="pagination__page pagination__page--current">1</span>
                            <a href="#" class="pagination__page">2</a>
                            <a href="#" class="pagination__page">3</a>
                            <a href="#" class="pagination__page">4</a>
                            <a href="#" class="pagination__page"><i class="ui-arrow-right"></i></a>
                        </nav>
                    </div>

                </div> <!-- end col -->


                <!-- Sidebar -->
                <aside class="col-lg-3 sidebar left-sidebar">

                    <!-- Categories -->
                    <div class="widget widget_categories widget--bottom-line">
                        <h4 class="widget-title">Sản phẩm</h4>
                        <ul>
                            <li>
                                <a href="#">Áo nữ</a>
                            </li>
                            <li class="active">
                                <a href="#">Quần nữ</a>
                            </li>
                            <li>
                                <a href="#">Váy và đầm</a>
                            </li>
                            <li>
                                <a href="#">Đồ ngủ và nội y</a>
                            </li>
                            <li>
                                <a href="#">Khác</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Size -->
                    <div class="widget widget__filter-by-size widget--bottom-line">
                        <h4 class="widget-title">Kích thước</h4>
                        <ul class="size-select">
                            <li>
                                <input type="checkbox" class="checkbox" id="small-size" name="small-size">
                                <label for="small-size" class="checkbox-label">X</label>
                            </li>
                            <li>
                                <input type="checkbox" class="checkbox" id="medium-size" name="medium-size">
                                <label for="medium-size" class="checkbox-label">S</label>
                            </li>
                            <li>
                                <input type="checkbox" class="checkbox" id="large-size" name="large-size">
                                <label for="large-size" class="checkbox-label">M</label>
                            </li>
                            <li>
                                <input type="checkbox" class="checkbox" id="xlarge-size" name="xlarge-size">
                                <label for="xlarge-size" class="checkbox-label">L</label>
                            </li>
                            <li>
                                <input type="checkbox" class="checkbox" id="xxlarge-size" name="xxlarge-size">
                                <label for="xxlarge-size" class="checkbox-label">XL</label>
                            </li>
                        </ul>
                    </div>

                    <!-- Color -->
                    <div class="widget widget__filter-by-color widget--bottom-line">
                        <h4 class="widget-title">Màu sắc</h4>
                        <ul class="color-select">
                            <li>
                                <input type="checkbox" class="checkbox" id="green-color" name="green-color">
                                <label for="green-color" class="checkbox-label">Xanh lá</label>
                            </li>
                            <li>
                                <input type="checkbox" class="checkbox" id="red-color" name="red-color">
                                <label for="red-color" class="checkbox-label">Đỏ</label>
                            </li>
                            <li>
                                <input type="checkbox" class="checkbox" id="blue-color" name="blue-color">
                                <label for="blue-color" class="checkbox-label">Xanh dương</label>
                            </li>
                            <li>
                                <input type="checkbox" class="checkbox" id="white-color" name="white-color">
                                <label for="white-color" class="checkbox-label">Trắng</label>
                            </li>
                            <li>
                                <input type="checkbox" class="checkbox" id="black-color" name="black-color">
                                <label for="black-color" class="checkbox-label">Đen</label>
                            </li>
                        </ul>
                    </div>

                    <!-- Filter by Price -->
                    <div class="widget widget__filter-by-price widget--bottom-line">
                        <h4 class="widget-title">Lọc theo giá</h4>

                        <div id="slider-range"></div>
                        <p>
                            <label for="amount">Mức giá:</label>
                            <input type="text" id="amount">
                            <a href="#" class="btn btn-sm btn-dark"><span>Lọc</span></a>
                        </p>
                    </div>

                </aside> <!-- end sidebar -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </section> <!-- end catalog -->
@endsection