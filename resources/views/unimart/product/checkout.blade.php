@extends('layouts.unimart')
@section('header')
    @foreach ($headers as $item)
        <li>
            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}" title="">{{ $item->name }}</a>
        </li>
    @endforeach
@endsection
@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="http://localhost/Laravel/unimart_laravelpro/" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="#" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix"style="min-height:300px">
            @if (Cart::content()->count() > 0)
                <form method="POST" action="{{ url('unimart/checkout') }}" name="form-checkout">
                    @csrf
                    <div class="section" id="customer-info-wp">
                        <div class="section-head">
                            <h1 class="section-title">Thông tin khách hàng</h1>
                        </div>
                        <div class="section-detail">
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="fullname">Họ tên</label>
                                    <input type="text" name="fullname" value="{{ old('fullname') }}" id="fullname">
                                    @error('fullname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="email">Email</label>
                                    <input type="email" value="{{ old('email') }}" name="email" id="email">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="tel" value="{{ old('phone') }}" name="phone" id="phone">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="number">Đường, Số nhà</label>
                                    <input type="text" value="{{ old('number') }}" name="number" id="number">
                                    @error('number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="address">Tỉnh/thành</label>
                                    <input type="text" value="{{ old('address') }}" name="address" id="address">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="district_">Quận/huyện</label>
                                    <input type="text" value="{{ old('district_') }}" name="district_" id="district_">
                                    @error('district_')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="notes">Ghi chú</label>
                                <textarea style="width:100%!important;height:100px" name="note" row="50" col="30">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="section" id="order-review-wp">
                        <div class="section-head">
                            <h1 class="section-title">Thông tin đơn hàng</h1>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success section" style="color:#362FD9 ; font-size:18px">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="section-detail">
                            <table class="shop-table">
                                <thead>
                                    <tr>
                                        <td>Sản phẩm</td>
                                        <td>Hình ảnh</td>
                                        <td>Tổng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $item)
                                        <tr class="cart-item">
                                            <td class="product-name">{{ $item->name }}<strong class="product-quantity">x
                                                    {{ $item->qty }}</strong>
                                            </td>
                                            <td class="product-name"><a href="" title="" class="thumb">
                                                    <img style="width:100px;"src="{{ url($item->options->thumbnail) }}"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td class="product-total">{{ number_format($item->total) }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="order-total">
                                        <td>Tổng đơn hàng:</td>
                                        <td></td>
                                        <td><strong class="total-price" style="color:tomato">{{ Cart::total() }}đ</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div id="payment-checkout-wp">
                                <ul id="payment_methods">
                                    <li>
                                        <input type="radio" id="payment-home" name="payment-method" value="house"
                                            checked>
                                        <label for="payment-home">Thanh toán tại nhà</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="direct-payment" name="payment-method" value="store">
                                        <label for="direct-payment">Thanh toán tại cửa hàng</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="place-order-wp clearfix">
                                <input type="submit" name="order" id="order-now" value="Đặt hàng">
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    @else
        <div class="text-center"> Vui lòng quay trở lại <a href="{{ url('trang-chu') }}">Trang chủ</a></div>
        @endif
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
@endsection
