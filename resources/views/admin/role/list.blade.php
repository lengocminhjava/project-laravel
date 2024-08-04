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
                <h5 class="m-0 ">Danh sách vai trò</h5>
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
                            class="text-muted">({{ $count }})</span></a>
                </div>
                <form action="#">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="select_form1">
                            <option value="chọn">Chọn</option>
                            <option value="delete">Xóa</option>
                        </select>
                        <input type="submit" name="btn-choose" value="Áp dụng" class="btn btn-primary mt-1">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên vai trò</th>
                                    <th scope="col">Quyền hạn</th>
                                    <th scope="col">Thời gian</th>
                                    <th scope="col">Thời gian cập nhật</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($roles as $item)
                                    <tr id="tr-data-{{ $item->id }}">
                                        <td>
                                            <input type="checkbox" name="list_check[]"value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $i++ }}</td>
                                        <td><a href="{{ route('role.update', $item->id) }}">{{ $item->name }}</a></td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('role.update', $item->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white mb-1" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <button class="btn btn-danger btn-sm rounded-0 text-white delete_role mb-1"
                                                data-id="{{ $item->id }}" type="button" data-toggle="tooltip"
                                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="bg-white pb-0">Không tồn tại giá trị nào ! </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </form>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/role.js') }}"></script>
@endsection
