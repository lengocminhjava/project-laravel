@extends('layouts.unimart')
@section('header')
    @foreach ($headers as $item)
        <li>
            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}" title="">{{ $item->name }}</a>
        </li>
    @endforeach
@endsection
@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="#" title="">{{ $name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">{{ $name }}</h3>
                        <div class="filter-wp fl-right">
                            <p class="desc" style="font-size:18px;color:red">Hiển thị {{ $products->count() }} trên
                                {{ $total }} sản phẩm</p>
                            <div class="form-filter">
                                <!--<form method="" action="{{ url('san-pham.html?arrange.html') }}">-->
                                <!--    <select name="select_arrange">-->
                                <!--        @error('select_arrange')
        -->
                                    <!--            <small class="text-danger">{{ $message }}</small>-->
                                    <!--
    @enderror-->
                                <!--<option value="0">Sắp xếp</option>-->
                                <!--<option value="3">Giá cao xuống thấp</option>-->
                                <!--<option value="4">Giá thấp lên cao</option>-->
                                <!--    </select>-->
                                <!--    <button value="lọc" type="submit">Lọc</button>-->
                                <!--</form>-->
                            </div>
                        </div>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix"id="item_products">
                            @if ($products->count() > 0)
                                @foreach ($products as $product)
                                    <li>
                                        <a href=" {{ route('sanpham.detail', ['slug' => create_slug($product->name), 'id' => $product->id]) }}"
                                            title="" class="thumb">
                                            <img src="{{ url($product->thumbnail) }}">
                                        </a>
                                        <a href=" {{ route('sanpham.detail', ['slug' => create_slug($product->name), 'id' => $product->id]) }}"
                                            title="" class="product-name">{{ $product->name }}</a>
                                        <div class="price">
                                            <span class="new">{{ $product->price }}</span>
                                            <span class="old">{{ $product->price_old }}</span>
                                        </div>
                                        <div class="action clearfix">
                                            <button title="Thêm giỏ hàng" data-id="{{ $product->id }}"
                                                class="add-cart add_cart fl-left">Thêm giỏ
                                                hàng</button>
                                            <a href="" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <p>Sản phẩm đã bán hết</p>
                            @endif
                        </ul>
                    </div>
                </div>
                {{ $products->links() }}
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
                                    @foreach ($categorys_pr as $item)
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
                        <a href="?page=detail_product" title="" class="thumb">
                            <img src="public/thumbnail/banner.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
