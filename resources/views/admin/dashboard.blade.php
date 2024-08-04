@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width:18rem;height:176px">
                    <div class="card-header">ĐƠN THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[0] }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem; min-hight:100%">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[2] }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem; height:176px">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ jam_read_num_forvietnamese($total) }}</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem; min-hight:100%">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[1] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall table-responsive"
                    style="width: 100%; table-layout: fixed;">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col"width="10%">Mã đơn</th>
                            <th scope="col"width="8%" class="text-center">Số lượng</th>
                            <th scope="col" width="13%" class="text-center">Tên khách hàng</th>
                            <th scope="col"width="13%">Tổng tiền</th>
                            <th scope="col" width="13%">Ghi chú</th>
                            <th scope="col" width="13%" class="text-center">Thời gian</th>
                            <th scope="col" width="12%">Trạng thái</th>
                            <th scope="col" class="text-center">Chi tiết</th>
                            <th scope="col" class="text-center">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->total() > 0)
                            @php
                                $currentPage = $orders->currentPage();
                                $perPage = $orders->perPage();
                                $startingNumber = ($currentPage - 1) * $perPage;
                            @endphp
                            @foreach ($orders as $item)
                                @php
                                    $startingNumber++;
                                @endphp
                                <tr id="tr-data-{{ $item->id }}">
                                    <td>{{ $startingNumber }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td class="text-center">
                                        {{ number_format($item->num) }}
                                    </td>
                                    <td><a href="#" class="text-center">{{ $item->client->name }}</a></td>
                                    <td>{{ number_format($item->total) }}</td>

                                    <td>
                                        @if (!empty($item->note))
                                            {{ $item->note }}
                                        @else
                                            Không có
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        {{ $item->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</td>
                                    <td><span class="status">{{ change_name($item->status->name) }}</span>
                                    </td>
                                    <td><a href="{{ route('admin.order.detail', $item->id) }}" class="btn btn-primary ">Chi
                                            tiết</a></td>
                                    <td>
                                        <button data-id="{{ $item->id }}"
                                            class="btn btn-danger btn-sm py-3 px-3 d-block rounded-0 text-white delete_order"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="bg-white pb-0">Không tồn tại giá trị nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if ($orders->total() > 10)
                    <div class="card-body p-0" style="text-align:center">
                        <div style="display:inline-block; text-align:center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/order.js') }}"></script>
@endsection
