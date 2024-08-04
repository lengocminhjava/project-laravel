@extends('layouts.unimart')
@section('header')
    @foreach ($headers as $item)
        <li>
            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}" title="">{{ $item->name }}</a>
        </li>
    @endforeach
@endsection
@section('content')
    <div id="main-content-wp" class="home-page clearfix">
        <div class="wp-inner">
            <div class="main-content fl-right">
                <div class="section" id="slider-wp">
                    <div class="section-detail">
                        @foreach ($sliders as $item)
                            <div class="item">
                                <img style="width:100%;max-height:350px" src="{{ url($item->thumbnail) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="section" id="support-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix icon_possible">
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('unimart/thumbnail/icon-1.png') }}">
                                </div>
                                <h3 class="title">Miễn phí vận chuyển</h3>
                                <p class="desc">Tới tận tay khách hàng</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('unimart/thumbnail/icon-2.png') }}">
                                </div>
                                <h3 class="title">Tư vấn 24/7</h3>
                                <p class="desc">1900.9999</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('unimart/thumbnail/icon-3.png') }}">
                                </div>
                                <h3 class="title">Tiết kiệm hơn</h3>
                                <p class="desc">Với nhiều ưu đãi cực lớn</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('unimart/thumbnail/icon-4.png') }}">
                                </div>
                                <h3 class="title">Thanh toán nhanh</h3>
                                <p class="desc">Hỗ trợ nhiều hình thức</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('unimart/thumbnail/icon-5.png') }}">
                                </div>
                                <h3 class="title">Đặt hàng online</h3>
                                <p class="desc">Thao tác đơn giản</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm nổi bật</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item" id="item_product">
                            @foreach ($product_hightlights as $item)
                                <li>
                                    <button class="discount-btn">
                                        <span
                                            class="btn-text">{{ number_format((($item->price_old - $item->price) / $item->price) * 100, 1, ',', '.') }}%</span>
                                    </button>
                                    <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                        title="" class="thumb">
                                        <img src="{{ url($item->thumbnail) }}">
                                    </a>
                                    <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                        title="" class="product-name">{{ $item->name }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($item->price) }}đ</span>
                                        <span class="old">{{ number_format($item->price_old) }}đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <button data-id={{ $item->id }} title="Thêm giỏ hàng"
                                            class="add-cart add_cart fl-left">Thêm giỏ
                                            hàng</button>
                                        <a href="{{ route('unimart.add_now', $item->id) }}" title=""
                                            class="buy-now fl-right">Mua
                                            ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Laptop</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix"id="item_product">
                            @foreach ($product_laptops as $item)
                                <li>
                                    <button class="discount-btn">
                                        <span
                                            class="btn-text">{{ number_format((($item->price_old - $item->price) / $item->price) * 100, 1, ',', '.') }}%</span>
                                    </button>
                                    <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                        title="" class="thumb">
                                        <img src="{{ url($item->thumbnail) }}">
                                    </a>
                                    <a href="" title="" class="product-name">{{ $item->name }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($item->price) }}đ</span>
                                        <span class="old">{{ number_format($item->price_old) }}đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <button data-id={{ $item->id }} title="Thêm giỏ hàng"
                                            class="add-cart add_cart fl-left">Thêm giỏ
                                            hàng</button>
                                        <a href="{{ route('unimart.add_now', $item->id) }}" title=""
                                            class="buy-now fl-right">Mua
                                            ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- Điện thoại  --}}
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Điện thoại</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix"id="item_product">
                            @foreach ($product_mobiles as $item)
                                <li>
                                    <button class="discount-btn">
                                        <span
                                            class="btn-text">{{ number_format((($item->price_old - $item->price) / $item->price) * 100, 1, ',', '.') }}%</span>
                                    </button>
                                    <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                        title="" class="thumb">
                                        <img src="{{ url($item->thumbnail) }}">
                                    </a>
                                    <a href="" title="" class="product-name">{{ $item->name }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($item->price) }}đ</span>
                                        <span class="old">{{ number_format($item->price_old) }}đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <button data-id={{ $item->id }} title="Thêm giỏ hàng"
                                            class="add-cart add_cart fl-left">Thêm giỏ
                                            hàng</button>
                                        <a href="{{ route('unimart.add_now', $item->id) }}" title=""
                                            class="buy-now fl-right">Mua
                                            ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- Table --}}
                <style>
                    ul#item_product li {
                        position: relative;
                    }

                    .discount-btn {
                        border-radius: 25px;
                        background: linear-gradient(to right, #ff416c, #ff4b2b);
                        padding: 10px 20px;
                        color: white;
                        font-weight: 600;
                        border: none;
                        cursor: pointer;
                        position: relative;
                        transition: transform 0.2s ease-in;
                        position: absolute;
                        left: 3%;
                        top: 5px;
                    }

                    .discount-btn:hover {
                        transform: translateY(-5px);
                        box-shadow: 0px 5px 20px rgba(255, 75, 43, 0.4);
                    }

                    .btn-text {
                        display: inline-block;
                        margin-right: 5px;
                    }
                </style>

                {{-- Thực thế --}}
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Máy tính bảng</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix"id="item_product">
                            @foreach ($product_tablets as $item)
                                <li>
                                    <button class="discount-btn">
                                        <span
                                            class="btn-text">{{ number_format((($item->price_old - $item->price) / $item->price) * 100, 1, ',', '.') }}%</span>
                                    </button>
                                    <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                        title="" class="thumb">
                                        <img src="{{ url($item->thumbnail) }}">
                                    </a>
                                    <a href="" title="" class="product-name">{{ $item->name }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($item->price) }}đ</span>
                                        <span class="old">{{ number_format($item->price_old) }}đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <button data-id={{ $item->id }} title="Thêm giỏ hàng"
                                            class="add-cart add_cart fl-left">Thêm giỏ
                                            hàng</button>
                                        <a href="{{ route('unimart.add_now', $item->id) }}" title=""
                                            class="buy-now fl-right">Mua
                                            ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- Phụ kiện --}}
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Phụ kiện</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix"id="item_product">
                            @foreach ($product_accessorys as $item)
                                <li>
                                    <button class="discount-btn">
                                        <span
                                            class="btn-text">{{ number_format((($item->price_old - $item->price) / $item->price) * 100, 1, ',', '.') }}%</span>
                                    </button>
                                    <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                        title="" class="thumb">
                                        <img src="{{ url($item->thumbnail) }}">
                                    </a>
                                    <a href="" title="" class="product-name">{{ $item->name }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($item->price) }}đ</span>
                                        <span class="old">{{ number_format($item->price_old) }}đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <button data-id={{ $item->id }} title="Thêm giỏ hàng"
                                            class="add-cart add_cart fl-left">Thêm giỏ
                                            hàng</button>
                                        <a href="{{ route('unimart.add_now', $item->id) }}" title=""
                                            class="buy-now fl-right">Mua
                                            ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        <?php
                        echo render_menu($categorys, $menu_class = 'list-item', 'sidebar-menu', 0, 0); ?>

                    </div>
                </div>
                <div class="section" id="selling-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm bán chạy</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($product_sellings as $item)
                                <li class="clearfix">
                                    <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                        title="" class="thumb fl-left">
                                        <img style="border:1px solid #F6F7C1" src="{{ url($item->thumbnail) }}"
                                            alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                            title="" class="product-name">{{ $item->name }}</a>
                                        <div class="price">
                                            <span style="display:block"
                                                class="new">{{ number_format($item->price) }}đ</span>
                                            <span
                                                class="old"style="color:black">{{ number_format($item->price_old) }}đ</span>
                                        </div>
                                        <a href="{{ route('unimart.add_now', $item->id) }}"
                                            style="padding:5px 50px 5px 5px;background-color:tomato;color:aliceblue; display:inline-block"
                                            title="" class="buy-now">Mua
                                            ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- Sản phẩm đang tạm ngưng --}}
                <div class="section" id="selling-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm tạm ngưng</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($product_pauses as $item)
                                <li class="clearfix">
                                    <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                        title="" class="thumb fl-left">
                                        <img style="border:1px solid #F6F7C1" src="{{ url($item->thumbnail) }}"
                                            alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                            title="" class="product-name">{{ $item->name }}</a>
                                        <div class="price">
                                            <span style="display:block"
                                                class="new">{{ number_format($item->price) }}đ</span>
                                            <span
                                                class="old"style="color:black">{{ number_format($item->price_old) }}đ</span>
                                        </div>
                                        <a href="@if ($item) {{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }} @endif"
                                            style="padding:5px 50px 5px 5px;background-color:#698269;color:aliceblue; display:inline-block"
                                            title="" class="buy-now">Chi tiết</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="" title="" class="thumb">
                            <img style="height:100%" src="{{ asset('unimart/uploads/iphone123.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="https://unitop.vn/" title="" class="thumb">
                            <img src="{{ asset('unimart/thumbnail/banner.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="" title="" class="thumb">
                            <img src="{{ asset('unimart/uploads/thietke.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
