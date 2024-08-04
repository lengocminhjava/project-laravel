@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid" style="min-width:700px">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm danh mục
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/post/cat/add') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" placeholder="Thêm danh mục" type="text" name="name"
                                    id="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select class="form-control" name="data_select" id="">
                                    @foreach ($data_select as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                @foreach ($status as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                            id="exampleRadios1" value="{{ $item->id }}"
                                            {{ $item->id == 6 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="exampleRadios1">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
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
                    <div class="card-header font-weight-bold">
                        Danh mục
                    </div>
                    <div class="card-body">
                        <div class="analytic">
                            <a href="" class="text-primary">Tất
                                cả<span class="text-muted">({{ $count[0] }})</span></a>
                            <a href="{{ url('admin/post/cat/request') }}" class="text-primary">Thùng rác
                                <span class="text-muted">({{ $count[1] }})</span></a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($count[0] > 0)
                                    @php
                                        $i = 0;
                                        
                                    @endphp
                                    @foreach ($list_new as $item)
                                        @php
                                            $i++;
                                        @endphp

                                        <tr id="tr-data-{{ $item->id }}">
                                            <th scope="row">{{ $i }}</th>
                                            <td>@php echo str_repeat('--*', $item->level) . $item->name; @endphp</td>
                                            <td>{{ $item->slug_url }}</td>
                                            <td><span class="status">{{ $item->status->name }}</span></td>
                                            <td>
                                                <a href="{{ route('update_cat_post', $item->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white mt-1" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <button
                                                    class="btn btn-danger btn-sm rounded-0 text-white delete_cat_posts mt-1"
                                                    data-id="{{ $item->id }}" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                            </td>
                                            <input type="hidden" id="array" value="{{ json_encode($data) }}">
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/post.js') }}"></script>
@endsection
