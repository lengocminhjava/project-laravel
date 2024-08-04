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
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline search_input_pr_abc">
                    <form action="#" class="d-flex">
                        <input type="" class="form-control form-search mr-1 mt-1" name="keyword"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary mt-1">
                    </form>
                </div>
                <div class="form-search form-inline search_input">
                    <form action="#">
                        <input type="" class="form-control form-search mr-1" name="keyword" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary mt-1">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'page_all']) }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'posted']) }}" class="text-primary">Đã đăng<span
                            class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Pending']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[2] }})</span></a>
                    <a href="http://localhost/Laravel/unimart_laravelpro/admin/product/list?status=Trash" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[0] }})</span></a>
                </div>
                <form action="{{ url('admin/product/request') }}" method="POST">
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
                                <th scope="col" width="3%">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col"width="5%">#</th>
                                <th scope="col" class="text-center" width="6%">Mã code</th>
                                <th scope="col"width="10%">Ảnh</th>
                                <th scope="col"width="15%" class="text-center">Tên sản phẩm</th>
                                <th scope="col"width="10%"class="text-center">Kho hàng</th>
                                <th scope="col"width="9%"class="text-center">Số lượng</th>
                                <th scope="col"class="text-center"width="10%">Trạng thái</th>
                                <th scope="col"width="11%"class="text-center">Giá</th>
                                <th scope="col"class="text-center"width="10%">Người tạo</th>
                                <th scope="col"width="10%">Ngày tạo</th>
                                <th scope="col"class="text-center" width="8.9%">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->total() > 0)
                                @php
                                    $currentPage = $products->currentPage();
                                    $perPage = $products->perPage();
                                    $startingNumber = ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach ($products as $product)
                                    @php
                                        $startingNumber++;
                                    @endphp
                                    <tr id="tr-data-{{ $product->id }}">
                                        <td>
                                            <input type="checkbox" name="list_id[]" value="{{ $product->id }}">
                                        </td>

                                        <td scope="row">{{ $startingNumber }}</td>
                                        <td class="text-center">{{ $product->code }}</td>
                                        <td><img src="{{ url($product->thumbnail) }}" alt=""></td>
                                        <td class="text-center">{{ $product->name }}
                                        </td>
                                        <td>
                                            @if (!empty($product->selling))
                                                <span
                                                    class="selling d-block mb-1">{{ $stock_name[$product->selling] }}</span>
                                            @endif
                                            @if (!empty($product->hightlight))
                                                <span
                                                    class="highlight d-block mb-1">{{ $stock_name[$product->hightlight] }}</span>
                                            @endif
                                            <span id="stock-{{ $product->id }}">
                                                <span
                                                    class="d-block stock text-center">{{ $stock_name[$product->stock] }}</span>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($act != 'Trash')
                                                <input type="number"style="width:130%" min="0"
                                                    data-id={{ $product->id }} value="{{ $product->num_qty }}"
                                                    placeholder="số lượng sản phẩm" name="num_qty" class="num_qty">
                                            @else
                                                {{ number_format($product->num_qty), 0, '', '.' }}
                                            @endif
                                        </td>
                                        <td><span class="status">{{ $product->status->name }}</span></td>
                                        <td class="text-center">
                                            <small class="text-danger d-block">
                                                <span class="text-dark"><strong>
                                                        {{ number_format($product->price, 0, '', '.') }}đ</strong></span>
                                                <del><strong>{{ number_format($product->price_old, 0, '', '.') }}đ</strong></del>
                                        </td>
                                        <td class="text-center">
                                            @if ($product->user && is_object($product->user))
                                                <small class="text-success d-block"><strong>
                                                        {{ $product->user->name }}</strong></small>
                                            @else
                                                <small class="text-danger d-block ">User đã bị vô hiệu hóa</small>
                                            @endif
                                            <span class="d-block permission mt-1">admin</span>
                                        </td>
                                        <td> <small
                                                class="text-secondary d-block ">{{ $product->updated_at }}</small></span>
                                        </td>
                                        <td>
                                            @if ($act != 'Trash')
                                                <a href="{{ route('update_product', $product->id) }}"
                                                    class="btn btn-success small-button btn-sm rounded-0 text-white mb-1"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"><i class="fa fa-edit"></i></a>
                                                <button
                                                    class="btn btn-danger btn-sm small-button rounded-0 text-white delete_product"
                                                    data-id="{{ $product->id }}" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></button>
                                            @else
                                                <button
                                                    class="btn btn-success small-button btn-sm rounded-0 text-white product_restore mb-1"
                                                    data-id="{{ $product->id }}" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Restore"><i
                                                        class="fa fa-window-restore"></i></button>
                                                <button
                                                    class="btn btn-danger btn-sm small-button rounded-0 text-white delete_product_trash"
                                                    data-id="{{ $product->id }}" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></button>
                                            @endif
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
                @if ($products->total() > 10)
                    <div class="card-body p-0" style="text-align:center">
                        <div style="display:inline-block; text-align:center">
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/product.js') }}"></script>
@endsection
