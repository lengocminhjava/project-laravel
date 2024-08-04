@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card mb-2">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Khách hàng</h5>
                <div class="form-search form-inline">
                </div>
            </div>
            <div class="card-body table-responsive" style="border-bottom:2px solid #dee2e6">
                <div class="font-weight-bold px-2 py-3">
                    Thông tin khách hàng
                </div>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Mã đơn hàng:</td>
                            <td>{{ $orders->code }}</td>
                        </tr>
                        <tr>
                            <td>Tên khách hàng:</td>
                            <td>{{ $orders->client->name }}</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ email:</td>
                            <td>{{ $orders->client->email }}</td>
                        </tr>
                        <tr>
                            <td>Số điện thoại:</td>
                            <td>{{ $orders->client->phone_number }}</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ:</td>
                            <td>{{ $orders->client->address }}</td>
                        </tr>
                        <tr>
                            <td>Thời gian đặt hàng:</td>
                            <td>{{ $orders->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Phương thức thanh toán:</td>
                            <td>{{ change_name($orders->pay) }}</td>
                        </tr>
                        <tr>
                            <td>Ghi chú:</td>

                            <td>
                                @if (!empty($orders->note))
                                    {{ $orders->note }}
                                @else
                                    Không có
                                @endif
                            </td>

                        </tr>

                    </tbody>
                </table>
                <form action="{{ route('admin.status.detail', $orders->id) }}">
                    <input type="hidden" name="_token" value="n5bblggflYNRS5OwQk5h4RVuNTkgPdGMqpu1eDxB">
                    <div class="form-inline pb-3">
                        <label class="pl-2" for="">Tình trạng đơn hàng:</label>
                        <div class="px-3">
                            <select name="select-status" class="form-control" id="">
                                @foreach ($status as $item)
                                    <option {{ $item->id == $orders->id_status ? 'selected' : '' }}
                                        value="{{ $item->id }}">
                                        {{ change_name($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" name="btn-status" value="Cập nhật" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Đơn hàng</h5>
                <div class="form-search form-inline">
                </div>
            </div>
            <div class="card-body">
                <div class="font-weight-bold px-2 py-3">
                    Thông tin đơn hàng
                </div>
                <table class="table table-striped table-checkall table-responsive">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Mã sản phẩm</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Thành tiền</th>
                            <th scope="col"class="text-center">Thời gian đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->count() > 0)
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($order as $products)
                                @foreach ($products->product as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td><img src="{{ url($item->thumbnail) }}">
                                        </td>

                                        <td class="text-center">
                                            {{ $products->num }}
                                        </td>
                                        <td><a href="#" class="text-center">{{ $item->name }}</a></td>
                                        <td>{{ number_format($item->price) }}</td>

                                        <td>{{ number_format($products->num * $item->price) }}đ</td>

                                        <td class="text-center">{{ $orders->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="bg-white pb-0">Không tồn tại giá trị nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div style="font-size:18px">Thành tiền: <span
                        style="color:rgb(247, 60, 27);">{{ number_format($orders->total) }}đ</span></div>
            </div>
        </div>
        {{-- Khách hàng  --}}

    </div>
@endsection
