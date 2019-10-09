<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shop hàng xuất dư xịn | Trang chủ</title>

    <meta charset="utf-8">
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese"
          rel="stylesheet">
    <!-- Css -->
    <!-- script css for tin-tuc -->
    <link rel="stylesheet" href="/shop/css/tin-tuc.css">
    <!-- end script css for tin-tuc -->
    <link rel="stylesheet" href="/shop/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/shop/css/font-icons.css"/>
    <link rel="stylesheet" href="/shop/css/style.css"/>
    <link rel="stylesheet" href="/shop/css/color.css"/>

    <!-- Favicons -->
    <link rel="shortcut icon" href="/shop/img/favicon.ico">
    <link rel="apple-touch-icon" href="/shop/img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/shop/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/shop/img/apple-touch-icon-114x114.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"/>
    @stack('css')
    <!-- jQuery -->
    <script src="/shop/js/jquery.min.js"></script>
</head>

<body>
<!-- Preloader -->
<div class="loader-mask">
    <div class="loader">
        <div></div>
    </div>
</div>

<!-- Mobile Sidenav -->
@include('guest::partials.mobile-nav')
<main class="main oh" id="main">

    <!-- Navigation -->
@include('guest::partials.nav')
@yield('content')
<!-- Hero Slider -->


    <!-- Footer -->
@include('guest::partials.footer')

<!-- Shopping bag -->
    <div class="shopping-bag">
        <img src="/shop/img/bag.svg">
    </div>

    <div id="back-to-top">
        <a href="/shop/#top" aria-label="Go to top"><i class="ui-arrow-up"></i></a>
    </div>

</main> <!-- end main-wrapper -->


<!-- jQuery Scripts -->
<script type="text/javascript" src="/shop/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/shop/js/easing.min.js"></script>
<script type="text/javascript" src="/shop/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="/shop/js/owl-carousel.min.js"></script>
<script type="text/javascript" src="/shop/js/flickity.pkgd.min.js"></script>
<script type="text/javascript" src="/shop/js/modernizr.min.js"></script>
<script type="text/javascript" src="/shop/js/scripts.js"></script>
<!-- script hover tintuc -->
<script src="/shop/js/tintuc.js"></script>
<!-- script hover tintuc -->
<script type="text/javascript">
    $(document).ready(function () {
        var owl = $("#owl-demo");
        owl.owlCarousel({
            items: 2, //10 items above 1000px browser width
            itemsDesktop: [1000, 2], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 2], //2 items between 600 and 0
            itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
        });
        var owl1 = $("#owl-demo1");
        owl1.owlCarousel({
            items: 2, //10 items above 1000px browser width
            itemsDesktop: [1000, 2], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 2], //2 items between 600 and 0
            itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
            autoplayTimeout: 1000,
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
        });
        var owl2 = $("#owl-demo2");
        owl2.owlCarousel({
            items: 2, //10 items above 1000px browser width
            itemsDesktop: [1000, 2], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 2], //2 items between 600 and 0
            itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
            autoplayTimeout: 1000,
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
        });
        var owl3 = $("#owl-demo3");
        owl3.owlCarousel({
            items: 2, //10 items above 1000px browser width
            itemsDesktop: [1000, 2], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 2], //2 items between 600 and 0
            itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
            autoplayTimeout: 1000,
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
        });
        var owl4 = $("#owl-demo4");
        owl4.owlCarousel({
            items: 2, //10 items above 1000px browser width
            itemsDesktop: [1000, 2], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 2], //2 items between 600 and 0
            itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
            autoplayTimeout: 1000,
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
        });
    });
</script>
@stack('js')

</body>
</html>