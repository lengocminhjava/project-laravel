@extends('layouts.unimart')
@section('header')
    @foreach ($headers as $item)
        <li>
            <a href="{{ route('unimart.contact', $slug = create_slug($item->name)) }}" title="">{{ $item->name }}</a>
        </li>
    @endforeach
@endsection
@section('content')
    <div id="main-content-wp" class="checkout-page" style="min-height:380px">
        @if (Cart::content()->count() > 0)
            <div class="section" id="breadcrumb-wp">
                <div class="wp-inner">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <a href="http://localhost/Laravel/unimart_laravelpro/" title="">Trang chủ</a>
                            </li>
                            <li>
                                <a href="#" title="">Đặt hàng thành công</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <style>
                .abc img {
                    width: 200px;
                }

                table#order-success {
                    font-family: "Segoe UI", "Arial", sans-serif;
                    border-collapse: separate;
                    border-spacing: 0;
                    width: 100%;
                    margin: 0 auto;
                    /* border: 1px solid #ccc; */
                    /* background-color: #fff; */
                    margin-top: 20px;
                }

                table#order-success thead {
                    border: 1px solid #ccc;
                    background-color: #4267B2;
                    color: white;
                    text-align: center;
                    font-weight: bold;
                }

                table#order-success tbody {

                    background-color: #fff;
                    border: 1px solid #ccc;

                }

                table#order-success .head-item {
                    padding: 12px;
                    border-right: 1px solid #ccc;
                }

                table#order-success .head-item:last-child {
                    border-right: none;
                }

                table#order-success tbody tr:nth-child(even) {
                    background-color: #f2f2f2;
                }

                table#order-success tbody tr:hover {
                    background-color: #e9e9e9;
                }

                table#order-success .body-item {
                    padding: 12px;
                    border-right: 1px solid #ccc;
                    text-align: center;
                }

                table#order-success .body-item:last-child {
                    border-right: none;
                }

                table#order-success td:first-child {
                    border-radius: 6px 0 0 6px;
                }

                table#order-success td:last-child {
                    border-radius: 0 6px 6px 0;
                }

                table#order-success th:first-child {
                    border-radius: 6px 0 0 0;
                }

                table#order-success th:last-child {
                    border-radius: 0 6px 0 0;
                }
            </style>
            <div id="wrapper" class="wp-inner clearfix" style="min-height:500px">
                <div class="section" id="detail-blog-wp">
                    <div class="section-head clearfix" style="text-align:center; align-items: center;">
                        <div class="abc" style="display:inline-block;"><img
                                src="{{ asset('unimart/uploads/icon-dathang.png') }}" />
                            <p style="font-size:18px;color:#28b123;"> Bạn đã đặt hàng thành công </p>
                        </div>
                    </div>
                    <div class="section-detail">
                        <div class="detail table-responsive">
                            <table id="order-success" class="table">
                                <thead>
                                    <tr>
                                        <th class="head-item">Mã đơn</th>
                                        <th class="head-item" width="10%">Họ và tên</th>
                                        <th class="head-item" width="15%">Địa chỉ</th>
                                        <th class="head-item">Số điện thoại</th>
                                        <th class="head-item">Email</th>
                                        <th class="head-item">Tên sản phẩm</th>
                                        <th class="head-item">Ảnh sản phẩm</th>
                                        <th class="head-item" width="8%">Thương hiệu</th>
                                        <th class="head-item">Số lượng</th>
                                        <th class="head-item">Giá</th>
                                        <th class="head-item"
                                            style="text-align:cente;border-right:1px dotted #333;padding-right:3px">Thời
                                            gian</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="body-item" rowspan="{{ $order_detail }}">
                                            {{ $orders->code }}</td>
                                        <td class="body-item" rowspan="{{ $order_detail }}">
                                            {{ $client->name }}</td>
                                        <td class="body-item" rowspan="{{ $order_detail }}">
                                            {{ $client->address }}
                                            <span style="display:block">
                                                Ghi chú: @if (!empty($client->note))
                                                    {{ $client->note }}
                                                @else
                                                    Không có
                                                @endif </span>
                                        </td>
                                        <td class="body-item" rowspan="{{ $order_detail }}">
                                            {{ $client->phone_number }}
                                        </td>
                                        <td class="body-item" rowspan="{{ $order_detail }}">
                                            {{ $client->email }}</td>
                                        @foreach (Cart::content() as $item)
                                            <td class="body-item"style="vertical-align:none!important">
                                                {{ $item->name }}</td>
                                            <td class="body-item"><img style="width:100px;"
                                                    src="{{ url($item->options->thumbnail) }}"></td>
                                            <td class="body-item">{{ $item->options->category }}</td>
                                            <td class="body-item">{{ $item->qty }}</td>
                                            <td class="body-item">{{ number_format($item->total) }}đ</td>
                                            <td style="text-align:center;border-right:1px dotted #333;padding-right:3px">
                                                {{ $orders->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                                            </td>
                                    </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <div>
                        <p style="margin-top:20px; font-size:18px">Tổng giá:
                            <span style="color:#da1818">{{ Cart::total() }} đ</span>
                        </p>
                    </div>
                </td>
            </tr>
        </tfoot>
        </table>
        <div style="display:inline-block;font-size:18px;margin-top:15px">Check email để xem chi tiết
        </div>
    </div>
    </div>
    </div>
@else
    <div style="text-align:center"> Vui lòng quay trở lại <a href="{{ url('trang-chu') }}">Trang chủ</a>
    </div>
    @endif
    </div>

    </div>
@endsection
@section('css')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
@endsection
{{-- @section('js')
    @endsection --}}
