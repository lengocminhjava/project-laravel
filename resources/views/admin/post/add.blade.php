@extends('layouts.admin-add')
@section('content')
    <div id="content" class="container-fluid" style="min-width:500px">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/post/create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input class="form-control" placeholder="Thêm bài viết" type="text" name="name"
                            value="{{ old('name') }}" id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea class="form-control" name="content" placeholder="Nội dung bài viết ..." id="content-textarea" cols="30"
                            rows="5">{!! old('content') !!} </textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="intro">Đoạn mô tả ngắn</label>
                        <textarea class="form-control" name="intro" id="intro" placeholder=" ... Mô tả ngắn" cols="40"
                            rows="3">{{ old('intro') }}</textarea>
                        @error('intro')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group d-flex">
                        <div class="form-group col-sm-6 pl-0">
                            <label for="">Danh mục</label>
                            <select class="form-control" name="select_form">
                                <option value="chọn">Chọn danh mục</option>
                                @foreach ($list_category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('select_form')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                            <div class="form-group mt-3">
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
                        </div>
                        <div class="form-group col-6 pr-0">
                            <label for="">Hình ảnh</label>
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" name="file" id="customFile">
                                <label class="custom-file-label" for="customFile" id="name_file">Chọn file</label>
                                @error('file')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div id="image-container"><img id="previewImage" class="name-img" src=""> </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
