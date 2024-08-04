@extends('layouts.unimart')
@section('header')
    @foreach ($headers as $item)
        <li>
            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}" title="">{{ $item->name }}</a>
        </li>
    @endforeach
@endsection
@section('content')
    <div id="main-content-wp" class="clearfix category-product-page pb-0">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="#" title="">Sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">Sản phẩm đang bán</h3>
                        <div class="filter-wp fl-right">
                            <p class="desc">Hiển thị {{ $products->count() }} trên {{ $total }} sản phẩm</p>
                            <div class="form-filter">
                                <form method="" action="" id="arrange_form">
                                    @error('select_arrange')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                    <select name="select_arrange">
                                        <option {{ $arrange == 0 ? 'selected' : '' }} value="0">Sắp xếp</option>
                                        <option {{ $arrange == 3 ? 'selected' : '' }} value="3">Giá cao xuống thấp
                                        </option>
                                        <option {{ $arrange == 4 ? 'selected' : '' }} value="4">Giá thấp lên cao
                                        </option>
                                    </select>
                                    <button value="lọc" type="submit">Lọc</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="section-detail">
                        @if ($products->total() > 0)
                            <ul class="list-item clearfix"id="item_product">
                                @foreach ($products as $item)
                                    <li>
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
                        @else
                            <div class="thumnail_gif">
                                <p>Xin lỗi Không tìm thấy sản phẩm nào thỏa mãn</p> <img
                                    src="{{ asset('unimart/uploads/giphy-unscreen.gif') }}">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="center-div">
                    {{ $products->links() }}
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
                <div class="section" id="filter-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Bộ lọc</h3>
                    </div>
                    <div class="section-detail">
                        <form method="" action="" class="comom_selector">
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Giá</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="radio" name="r-price" {{ $price == 1 ? 'checked' : '' }}
                                                value="1" class="r_price"></td>
                                        <td>Dưới 500.000đ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price" {{ $price == 2 ? 'checked' : '' }}
                                                value="2" class="r_price"></td>
                                        <td>500.000đ - 1.000.000đ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price" {{ $price == 3 ? 'checked' : '' }}
                                                value="3" class="r_price"></td>
                                        <td>1.000.000đ - 5.000.000đ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price" {{ $price == 4 ? 'checked' : '' }}
                                                value="4" class="r_price"></td>
                                        <td>5.000.000đ - 10.000.000đ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price" {{ $price == 5 ? 'checked' : '' }}
                                                value="5" class="r_price"></td>
                                        <td>Trên 10.000.000đ</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Hãng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category_prs as $item)
                                        <tr>
                                            <td><input type="radio" {{ $brand == $item->id ? 'checked' : '' }}
                                                    value="{{ $item->id }}" name="r-brand"class="r_brand">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Loại</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="radio" name="r-price"></td>
                                        <td>Điện thoại</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price"></td>
                                        <td>Laptop</td>
                                    </tr>
                                </tbody>
                            </table> --}}
                        </form>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="unitop.com.vn" title="" class="thumb">
                            <img src="{{ asset('unimart/thumbnail/banner.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
@endsection
