@extends('layouts.admin-add')
@section('content')
    <div id="content" class="container-fluid col-md-8" style="min-width:500px">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm trang
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/page/action') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề</label>
                        <input class="form-control" value="{{ old('name') }}" type="text" name="name" id="name"
                            placeholder="Viết Tiêu Đề">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung trang</label>
                        <textarea class="form-control" name="content" placeholder="Nội dung bài viết ..." id="content-textarea" cols="30"
                            rows="5">{!! old('content') !!} </textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-0">Trạng thái</label>
                        @error('select_form')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                        <select class="form-control" name="select_form">
                            <option>Chọn trạng thái</option>
                            @foreach ($status as $item)
                                <option value="{{ $item->id }}" {{ $item->id == old('select_form') ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
