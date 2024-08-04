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
                <h5 class="m-0 ">Danh sách slider</h5>
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
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'slider_all']) }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'posted']) }}" class="text-primary">Đã đăng<span
                            class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Pending']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[0] }})</span></a>
                </div>
                <form action="{{ url('admin/slider/request') }}" method="POST">
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
                                <th width="3%">
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col" width="3%">#</th>
                                <th scope="col"width="15%">Tiêu đề</th>
                                <th scope="col"width="18%">Ảnh</th>
                                <th scope="col">slug</th>
                                <th scope="col"width="10%">Trạng thái</th>
                                <th scope="col"width="12%">Người tạo</th>
                                <th scope="col"width="12%">Ngày tạo</th>
                                <th scope="col"width="15%">Ngày cập nhật gần nhất</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($sliders->total() > 0)
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($sliders as $slider)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr id="tr-data-{{ $slider->id }}">
                                        <td>
                                            <input type="checkbox"name="list_id[]" value="{{ $slider->id }}">
                                        </td>
                                        <td>{{ $i }}</td>
                                        <td>{{ $slider->name }}</td>

                                        <td><img style="width:100%" src="{{ url($slider->thumbnail) }}"
                                                alt="@php echo str_replace("public/admin/uploads/sliders\\", '',$slider->thumbnail ); @endphp">
                                        </td>
                                        <td class="text-center">#</td>
                                        <td><span class="status">{{ $slider->status->name }}</span></td>
                                        <td>
                                            @if ($slider->user && is_object($slider->user))
                                                {{ $slider->user->name }}
                                                <span class="permission d-block mt-1"> admin</span>
                                            @else
                                                <small class="text-danger d-block ">User đã bị vô hiệu hóa</small>
                                            @endif
                                        </td>
                                        <td>{{ $slider->created_at }}</td>
                                        <td>{{ $slider->updated_at }}</td>
                                        <td>
                                            @if ($act != 'Trash')
                                                <a href="{{ route('update_slider', $slider->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white mb-1"
                                                    style="padding:5px 10px" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            @endif
                                            @if ($act == 'Trash')
                                                <button
                                                    class="btn btn-danger btn-sm rounded-0 text-white delete_slider_trash"
                                                    data-id="{{ $slider->id }}" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                            @else
                                                <button class="btn btn-danger btn-sm rounded-0 text-white delete_slider mb-1"
                                                    style="padding:5px 11px" data-id="{{ $slider->id }}" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
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
                {{ $sliders->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/slider.js') }}"></script>
@endsection
