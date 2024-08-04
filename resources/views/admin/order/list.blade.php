@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('warning'))
                <div class="alert alert-warning section">
                    {{ session('warning') }}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success section">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline search_input_pr_abc">
                    <form action="#" class="d-flex">
                        <input type="" class="form-control form-search mr-1 mt-1" name="keyword"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary mt-1">
                    </form>
                </div>
                <div class="form-search form-inline search_input">
                    <form action="#">
                        <input type="" class="form-control form-search mb-1" name="keyword" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>

            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ url('admin/order/list') }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'cancel']) }}" class="text-primary">Đơn hàng
                        hủy<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'successs']) }}" class="text-primary">Đơn hàng
                        thành công<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}" class="text-primary"> Đang vận
                        chuyển<span class="text-muted">({{ $count[3] }})</span></a>
                </div>
                <form action="{{ url('admin/order/request') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="select_status" id="">
                            @error('select_status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <option>Chọn</option>
                            @foreach ($status as $k => $value)
                                <option value="{{ $k }}">
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn_search" value="Áp dụng" class="btn btn-primary mt-1">
                    </div>
                    <table class="table table-striped table-checkall table-responsive"
                        style="width: 100%; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th width="3%">
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col" width="5%">#</th>
                                <th scope="col"width="10%">Mã đơn</th>
                                <th scope="col"width="8%" class="text-center">Số lượng</th>
                                <th scope="col" width="13%" class="text-center">Tên khách hàng</th>
                                <th scope="col"width="13%">Tổng tiền</th>

                                <th scope="col" width="11%">Ghi chú</th>
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
                                        <td>
                                            <input type="checkbox" name="list_id[]" value="{{ $item->id }}">
                                        </td>
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
                                            {{ $item->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                                        </td>
                                        <td><span class="status">{{ change_name($item->status->name) }}</span>
                                        </td>
                                        <td><a href="{{ route('admin.order.detail', $item->id) }}"
                                                class="btn btn-primary ">Chi tiết</a></td>
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
                </form>
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
