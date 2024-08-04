@extends('layouts.unimart')
@section('header')
    @foreach ($headers as $item)
        <li>
            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}" title="">{{ $item->name }}</a>
        </li>
    @endforeach
@endsection
@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="http://localhost/Laravel/unimart_laravelpro/" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="#" title="">Điện thoại</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="main-content fl-right">
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                        <div class="thumb-wp fl-left">
                            <a href="" title="" id="main-thumb">
                                <img id="zoom" style="max-width:350px;min-height:350px"
                                    src="{{ url($product->thumbnail) }}"
                                    data-zoom-image="{{ asset('/admin/uploads/product/resized/' . $name_file) }}" />
                            </a>
                            <div id="list-thumb">

                                @foreach ($images as $item)
                                    <a href="" data-image="{{ url($item->name) }}"
                                        data-zoom-image="{{ asset('/admin/uploads/product/resized/' . str_replace('public/admin/uploads/product/', '', $item->name)) }}">
                                        <img id="zoom" style="width:50px;height:50px" src="{{ url($item->name) }}" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="thumb-respon-wp fl-left">
                            <img style=" display:block;margin-left:auto; margin-right:auto"
                                src="{{ url($product->thumbnail) }}" alt="">
                        </div>
                        <div class="info fl-right">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="desc">
                                {{ $product->description }}
                            </div>
                            <div class="num-product">
                                <span class="title">{{ $category_name }} - {{ $product->category->name }} : </span>
                                @if ($product->num_qty != 0)
                                    <span class="status">Còn hàng</span>
                                @else
                                    <span class="status">Hết hàng</span>
                                @endif

                            </div>
                            <p class="price pb-1">{{ number_format($product->price) }}đ</p>
                            @if ($product->num_qty != 0)
                                <div id="num-order-wp">
                                    <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                    <input type="text" data-quantity="{{ $product->num_qty }}"
                                        data-id="{{ $product->id }}" name="num-order" value="1" id="num-order">
                                    <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                </div>
                                <button title="Thêm giỏ hàng" class="add-cart cart_detail" style="border:none">Thêm giỏ
                                    hàng</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Mô tả sản phẩm</h3>
                    </div>
                    <style>
                        .product-description .description {
                            height: 300px;
                            overflow: hidden;
                        }

                        .product-description .read-more {
                            font-size: 16px;
                            color: #069;
                            border: none;
                            background: none;
                            cursor: pointer;
                            margin-top: 20px;
                        }
                    </style>
                    <div class="section-detail product-description">
                        <div class="description">
                            {!! $product->detail_product !!}
                        </div>
                        <button class="read-more">Xem thêm</button>
                    </div>
                </div>
                <div class="section" id="same-category-wp">
                    <div class="section-head">
                        <h3 class="section-title" style>Cùng chuyên mục</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item" id="item_product">
                            @foreach ($products as $item)
                                <li>
                                    <a href="{{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }}"
                                        title="" class="thumb">
                                        <img src="{{ url($item->thumbnail) }}">
                                    </a>
                                    <a href="{{ route('sanpham.detail', ['slug' => create_slug($item->name), 'id' => $item->id]) }}"
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
            </div>
            <div class="sidebar fl-left">
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
                                        <a href="{{ route('unimart.cart') }}"
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
