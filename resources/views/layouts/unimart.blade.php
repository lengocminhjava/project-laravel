<!DOCTYPE html>
<html>

<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Thêm thẻ meta tiêu đề -->
    <meta property="og:title" content="Unimart">
    <!-- Thêm thẻ meta hình ảnh -->
    <meta property="og:image" content="http://localhost/Laravel/unimart_laravelpro/public/admin/uploads/slider/unimart.jpg">
    <link rel="icon" href="/path/to/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/path/to/favicon.ico" type="image/x-icon">
    <link href="{{ asset('unimart/css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('unimart/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @yield('css')
    <link href="{{ asset('unimart/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('unimart/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">
    <link href="{{ asset('unimart/css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('unimart/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('unimart/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('unimart/responsive.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('unimart/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('unimart/js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('unimart/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('unimart/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('unimart/js/main.js') }}" type="text/javascript"></script>
</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="{{ url('/') }}" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="{{ url('san-pham.html') }}" title="">Sản phẩm</a>
                                </li>
                                <li>
                                    <a href="{{ url('bai-viet.html') }}" title="">Blog</a>
                                </li>
                                @yield('header')
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="http://localhost/Laravel/unimart_laravelpro/" title="" id="logo" class="fl-left"><img
                                src="{{ asset('unimart/thumbnail/logo.png') }}" /></a>
                        <div id="search-wp" class="fl-left">
                            <form action="#">
                                <input type="text" name="s" id="s"
                                    placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                <button value="Tìm kiếm" type="submit" id="sm-s">Tìm kiếm</button>
                            </form>
                            <div id="search-ajax" style="margin-top:5px;">
                            </div>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0987.654.321</span>
                            </div>
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="{{ url('gio-hang.san-pham.html') }}" title="giỏ hàng" id="cart-respon-wp"
                                class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">
                                    @if (Cart::count() > 0)
                                        {{ Cart::count() }}
                                    @endif
                                </span>
                            </a>
                            <div id="cart-wp" class="fl-right">
                                <div id="btn-cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num">
                                        @if (Cart::count() > 0)
                                            {{ Cart::count() }}
                                        @endif
                                    </span>
                                </div>
                                @if (Cart::content()->count() > 0)
                                    <div id="dropdown">
                                        <p class="desc" id="dest_update">Có <span> {{ Cart::count() }}</span> sản
                                            phẩm trong giỏ
                                            hàng</p>
                                        <ul class="list-cart">
                                            @foreach (Cart::content() as $item)
                                                <li class="clearfix">
                                                    <a href="{{ url('gio-hang.san-pham.html') }}" title=""
                                                        class="thumb fl-left">
                                                        <img src="{{ url($item->options->thumbnail) }}"
                                                            alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="{{ url('gio-hang.san-pham.html') }}" title=""
                                                            class="product-name">{{ $item->name }}</a>
                                                        <p class="price"style="color:rgb(187, 41, 15)">
                                                            {{ number_format($item->price) }}đ</p>
                                                        <p class="qty" style="color:black">Số lượng:
                                                            <span
                                                                id="qty_num-{{ $item->rowId }}">{{ $item->qty }}</span>
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right" id="total_pr" style="color:rgb(187, 41, 15)">
                                                {{ Cart::total() }}đ
                                            </p>
                                        </div>
                                        <div class="action-cart clearfix">
                                            <a href="{{ url('gio-hang.san-pham.html') }}" title="Giỏ hàng"
                                                class="view-cart fl-left">Giỏ hàng</a>
                                            <a href="{{ url('thanh-toan.san-pham.html') }}" title="Thanh toán"
                                                class="checkout fl-right">Thanh
                                                toán</a>
                                        </div>
                                    </div>
                                @else
                                    <div id="dropdown">
                                        <img src="{{ asset('unimart/uploads/cart.png') }}" alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- header --}}
            @yield('content')
            {{-- footer  --}}
            {{-- <div style="text-align:center;align-items: center">
                <audio id="myAudio">
                    <source src="{{ asset('unimart/uploads/maimaikhongphaianh.mp3') }}" type="audio/mp3">
                </audio>
            </div> --}}
            <div id="footer-wp">
                <div id="foot-body">
                    <div class="wp-inner clearfix">
                        <div class="block" id="info-company">
                            <h3 class="title">ISMART</h3>
                            <p class="desc">ISMART luôn cung cấp luôn là sản phẩm chính
                                hãng có thông tin rõ ràng,
                                chính sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.
                            </p>
                            <div id="payment">
                                <div class="thumb">
                                    <img src="public/images/img-foot.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="block menu-ft" id="info-shop">
                            <h3 class="title">Thông tin cửa hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <p>106 - Trần Bình - Cầu Giấy - Hà Nội</p>
                                </li>
                                <li>
                                    <p>0987.654.321 - 0989.989.989</p>
                                </li>
                                <li>
                                    <p>vshop@gmail.com</p>
                                </li>
                            </ul>
                        </div>
                        <div class="block menu-ft policy" id="info-shop">
                            <h3 class="title">Chính sách mua hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <a href="" title="">Quy định - chính
                                        sách</a>
                                </li>
                                <li>
                                    <a href="" title="">Chính sách bảo hành -
                                        đổi trả</a>
                                </li>
                                <li>
                                    <a href="" title="">Chính sách hội
                                        viện</a>
                                </li>
                                <li>
                                    <a href="" title="">Giao hàng - lắp
                                        đặt</a>
                                </li>
                            </ul>
                        </div>
                        <div class="block" id="newfeed">
                            <h3 class="title">Bảng tin</h3>
                            <p class="desc">Đăng ký với chung tôi để nhận được thông tin
                                ưu đãi sớm nhất</p>
                            <div id="form-reg">
                                <form method="POST" action="">
                                    <input type="email" name="email" id="email"
                                        placeholder="Nhập email tại đây">
                                    <button type="submit" id="sm-reg">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="foot-bot">
                    <div class="wp-inner">
                        <p id="copyright">© Bản quyền thuộc về unitop.vn | Php Master</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="menu-respon">
            <a href="http://localhost/Laravel/unimart_laravelpro/" title="" class="logo">VSHOP</a>
            <div id="menu-respon-wp">
                <ul class="" id="main-menu-respon">
                    <li>
                        <a href="http://localhost/Laravel/unimart_laravelpro/" title>Trang chủ</a>
                    </li>
                    <li>

                        <a href="http://localhost/Laravel/unimart_laravelpro/san-pham.html" title>Sản phẩm</a>
                        <?php
                        echo render_menu(categoryProduct(), $menu_class = 'sub-menu', 0, 0); ?>
                    </li>
                    <li>

                        <a href="http://localhost/Laravel/unimart_laravelpro/bai-viet.html" title>Blog</a>
                        <?php
                        echo render_menu_post(categoryPost(), $menu_class = 'sub-menu', 0, 0); ?>
                    </li>
                    @foreach (header_unimart() as $item)
                        <li>
                            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}"
                                title="">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div id="btn-top"><img src="public/thumbnail/icon-to-top.png" alt="" />
        </div>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            window.addEventListener("load", function() {
                var audio = document.getElementById("myAudio");
                audio.play();
            });
        </script>
        @yield('js')
    </div>
</body>

</html>
<script>
    function getRandomShakeClass() {
        const shakeClasses = ['phone-shake-1', 'phone-shake-2', 'phone-shake-3'];
        return shakeClasses[Math.floor(Math.random() * shakeClasses.length)];
    }
</script>
@yield('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
