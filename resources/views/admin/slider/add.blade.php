@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid" style="min-width:500px">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm Slider
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/slider/action') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Viết Tiêu Đề">
                        @error('name')
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
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
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
                    <button type="submit" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
