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
                <h5 class="m-0 ">Danh sách thành viên</h5>
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
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary mt-1">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích hoạt<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'admin']) }}" class="text-primary">Admin quản lí
                        user<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'post']) }}" class="text-primary">Quản lí bài
                        viết<span class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'product']) }}" class="text-primary">Quản lí sản
                        phẩm<span class="text-muted">({{ $count[4] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'order']) }}" class="text-primary">Quản lí đơn
                        hàng
                        <span class="text-muted">({{ $count[5] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                        hóa<span class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ url('admin/user/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $value)
                                <option value="{{ $k }}">{{ $value }}</option>
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
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Quyền</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->total() > 0)
                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach ($users as $user)
                                        @php
                                            $t++;
                                        @endphp
                                        <tr id="tr-data-{{ $user->id }}">
                                            <td>
                                                <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                                            </td>
                                            <th scope="row">{{ $t }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach ($user->roles as $name)
                                                    <span class="permission">
                                                        {{ $name->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                @if ($status != 'trash')
                                                    <a href="{{ route('update_user', $user->id) }}"
                                                        class="btn btn-success btn-sm rounded-0 text-white mb-1"
                                                        type="button" data-toggle="tooltip" data-placement="top"
                                                        title="Edit"><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if (Auth::id() != $user->id)
                                                    @if ($status == 'trash')
                                                        <button
                                                            class="btn btn-success btn-sm rounded-0 text-white user_restore"
                                                            data-id="{{ $user->id }}" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Restore"><i
                                                                class="fa fa-window-restore"></i></button>
                                                        <button
                                                            class="btn btn-danger btn-sm rounded-0 text-white delete_user_trash"
                                                            data-id="{{ $user->id }}" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="fa fa-trash"></i></button>
                                                    @else
                                                        <button
                                                            class="btn btn-danger btn-sm rounded-0 text-white delete_user mb-1"
                                                            data-id="{{ $user->id }}" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="fa fa-trash"></i></button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="bg-white pb-0">Không tìm thấy bản ghi nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>
                {{ $users->links() }}
            </div>
        </div>
    @endsection
    @section('js')
        <script src="{{ asset('admin/js/user.js') }}"></script>
    @endsection
