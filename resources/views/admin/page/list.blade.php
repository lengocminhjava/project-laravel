@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách trang</h5>
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
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[0] }})</span></a>
                </div>
                <form action="{{ url('admin/page/request') }}" method="POST">
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
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary mt-1">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col">#</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col" class="text-center">Người tạo</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Ngày cập nhật gần nhất</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pages->total() > 0)
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($pages as $page)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr id="tr-data-{{ $page->id }}">
                                            <td>
                                                <input type="checkbox"name="list_id[]" value="{{ $page->id }}">
                                            </td>
                                            <th scope="row">{{ $i }}</th>
                                            <td>{{ $page->name }}</td>
                                            <td><span class="status">{{ $page->statu->name }}</span></td>
                                            <td class="text-center">
                                                @if ($page->user && is_object($page->user))
                                                    {{ $page->user->name }}
                                                    <span class="permission d-block mt-1"> admin</span>
                                                @else
                                                    <small class="text-danger d-block ">User đã bị vô hiệu hóa</small>
                                                @endif
                                            </td>

                                            <td>{{ $page->created_at }}</td>
                                            <td>{{ $page->updated_at }}</td>
                                            <td>
                                                @if ($act != 'Trash')
                                                    <a href="{{ route('update_page', $page->id) }}"
                                                        class="btn btn-success btn-sm rounded-0 text-white mb-1"
                                                        type="button" data-toggle="tooltip" data-placement="top"
                                                        title="Edit"><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if ($act == 'Trash')
                                                    <button
                                                        class="btn btn-danger btn-sm rounded-0 text-white delete_page_trash"
                                                        data-id="{{ $page->id }}" type="button" data-toggle="tooltip"
                                                        data-placement="top" title="Delete"><i
                                                            class="fa fa-trash"></i></button>
                                                @else
                                                    <button
                                                        class="btn btn-danger btn-sm rounded-0 text-white delete_page mb-1"
                                                        data-id="{{ $page->id }}" type="button" data-toggle="tooltip"
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
                    </div>
                </form>
                {{ $pages->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/page.js') }}"></script>
@endsection
