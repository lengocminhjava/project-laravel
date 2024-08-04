@extends('layouts.unimart')
@section('header')
    @foreach ($headers as $item)
        <li>
            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}" title="">{{ $item->name }}</a>
        </li>
    @endforeach
@endsection
@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="http://localhost/Laravel/unimart_laravelpro/" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="#" title="">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="info-cart-wp">
                <div class="section-detail table-responsive"
                    style="min-height: 400px; text-align:center; position:relative;">
                    @if (Cart::content()->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Ảnh sản phẩm</td>
                                    <td>Tên sản phẩm</td>
                                    <td>Giá sản phẩm</td>
                                    <td>Số lượng</td>
                                    <td>Thành tiền</td>
                                    <td>Xóa</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp

                                @foreach (Cart::content() as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr id="tr-cart-{{ $item->id }}">
                                        <td>{{ $i }}</td>
                                        <td>
                                            <a href="" title="" class="thumb">
                                                <img src="{{ url($item->options->thumbnail) }}" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" title="" class="name-product">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ number_format($item->price) }}đ</td>
                                        <td>
                                            <input type="number" style="width:50px" min="1"
                                                name-id="{{ $item->id }}" data-id="{{ $item->rowId }}"
                                                value="{{ $item->qty }}" class="num-order">
                                        </td>
                                        <td id="total-item-{{ $item->rowId }}">
                                            {{ number_format($item->total) }}đ
                                        </td>
                                        <td>
                                            <button class="del-product delete_cart" id="{{ $item->id }}"
                                                data-id="{{ $item->rowId }}"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <p id="total-price" class="fl-right">Tổng giá:
                                                <span>{{ Cart::total() }} đ</span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <div class="fl-right">
                                                <a href="{{ url('card/destroy') }}" title="" id="update-cart">Xóa giỏ
                                                    hàng</a>
                                                <a href="{{ url('thanh-toan.san-pham.html') }}" title=""
                                                    id="checkout-cart">Thanh toán</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="section" id="action-cart-wp">
                            <div class="section-detail">
                                <p class="title">Nhấn vào thanh toán để hoàn tất mua hàng.
                                </p>
                                <a href="{{ url('san-pham.html') }}" title="" id="buy-more">Mua tiếp</a><br />
                            </div>
                        </div>
                </div>

            </div>
        @else
            <div> Hiện tại không có sản phẩm nào vui lòng trờ về <a href="{{ url('san-pham.html') }}" title=""
                    id="buy-more">Mua tiếp</a><br />
            </div>
            <div id="cart-empty" style="position: absolute;left: 50%;transform: translateX(-50%);top:15px"> <img
                    style="width:100%%;height:100%;" src="{{ asset('unimart/uploads/cart.png') }}" alt=""></div>
            @endif
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
@endsection
