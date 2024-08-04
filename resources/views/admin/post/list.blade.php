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
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline search_input_pr_abc">
                    <form action="#" class="d-flex">
                        <input type="" class="form-control form-search mr-1 mt-1" name="keyword" placeholder="Tìm kiếm">
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
                <form action="{{ url('admin/post/request') }}" method="POST">
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
                    <table class="table table-striped table-checkall table-responsive" style="width: 100%; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col"width="5%">#</th>
                                <th scope="col"width="10%">Ảnh</th>
                                <th scope="col" class="text-center">Tiêu đề</th>
                                <th scope="col"width="13%">Danh mục</th>
                                <th scope="col"width="13%">Người tạo</th>
                                <th scope="col"width="10%">Trạng thái</th>
                                <th scope="col"width="13%">Ngày tạo</th>
                                <th scope="col"width="10%">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($posts->total() > 0)
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($posts as $post)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr id="tr-data-{{ $post->id }}">
                                        <td>
                                            <input type="checkbox"name="list_id[]" value="{{ $post->id }}">
                                        </td>
                                        <td scope="row">{{ $i }}</td>
                                        <td><img src="{{ url($post->thumbnail) }}" alt=""></td>
                                        <td class="text-center">{{ $post->name }}
                                        </td>
                                        <td>
                                            @if ($post->category !== null && is_object($post->category))
                                                {{ $post->category->name }}
                                            @else
                                                <span class="">Đã bị vô hiệu hóa</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($post->user !== null && is_object($post->user))
                                                <span class="d-block ">{{ $post->user->name }}<span>
                                                        <span class="badge badge-primary">admin </span>
                                                    @else
                                                        <span class="">User đã bị vô hiệu hóa</span>
                                            @endif
                                        </td>
                                        <td><span class="status">{{ $post->status->name }}</span></td>
                                        <td>{{ $post->updated_at }}</td>
                                        <td>
                                            @if ($act != 'Trash')
                                                <a href="{{ route('update_post', $post->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white mb-1" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                            @endif
                                            @if ($act == 'Trash')
                                                <button class="btn btn-danger btn-sm rounded-0 text-white delete_post_trash"
                                                    data-id="{{ $post->id }}" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                            @else
                                                <button class="btn btn-danger btn-sm rounded-0 text-white delete_post mb-1"
                                                    data-id="{{ $post->id }}" type="button" data-toggle="tooltip"
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
                @if ($posts->total() > 10)
                    <div class="card-body p-0" style="text-align:center">
                        <div style="display:inline-block; text-align:center">
                            {{ $posts->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/post.js') }}"></script>
@endsection
