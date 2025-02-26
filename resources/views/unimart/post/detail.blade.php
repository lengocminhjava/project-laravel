@extends('layouts.unimart')
@section('header')
    @foreach ($headers as $item)
        <li>
            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}" title="">{{ $item->name }}</a>
        </li>
    @endforeach
@endsection
@section('content')
    <div id="main-content-wp" class="clearfix detail-blog-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="http://localhost/Laravel/unimart_laravelpro/" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="#" title="">Blog</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title">{{ $post->name }}
                        </h3>
                    </div>
                    <div class="section-detail">
                        <span class="create-date">{{ $post->created_at }}</span>
                        <div class="detail">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
                <div class="section" id="social-wp">
                    <div class="section-detail">
                        <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small"
                            data-show-faces="true" data-share="true"></div>
                        <div class="g-plusone-wp">
                            <div class="g-plusone" data-size="medium"></div>
                        </div>
                        <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                    </div>
                </div>
            </div>
           <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục bài viết</h3>
                    </div>
                    <div class="secion-detail">
                        <?php
                        echo render_menu_post($categorys, $menu_class = 'list-item', 'sidebar-menu', 0, 0); ?>

                    </div>
                </div>
                <div class="section" id="selling-wp">
                    <div class="section-head" style="margin-top:20px">
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
