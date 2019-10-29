<div class="row row-8">
    @foreach($products->chunk(4)  as $chunk)
        @foreach($chunk as $product)
            <div class="col-md col-sm-6 product">
                <div class="product__img-holder">
                    <a href="#" class="product__link">
                        <img src="{{json_decode($product->cover_path)[0]}}" alt="" class="product__img">
                        <img src="{{json_decode($product->cover_path)[1]}}" alt="" class="product__img-back">
                    </a>
                    <div class="product__actions">
                        <a href="#quickview" class="product__quickview" title="Xem ngay">
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
                        <a href="#single-product">{{$product->name}}</a>
                    </h3>
                </div>

                <span class="product__price">
                  <ins>
                    <span class="amount">{{number_format($product->price)}}đ</span>
                  </ins>
                </span>
            </div> <!-- end product -->
        @endforeach
        <div class="w-100"></div>
    @endforeach
</div>