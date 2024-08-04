@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid col-md-8 border_slider" style="min-width:500px">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa trang
            </div>
            <div class="card-body">
                <form method="POST"action="{{ route('edit_slider', $slider->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name"></label>
                        <input class="form-control" value="{{ $slider->name }}" type="text" name="name"
                            id="name">
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
                                <option value="{{ $item->id }}" {{ $item->id == $slider->status_id ? 'selected' : '' }}>
                                    {{-- @if ($item->id == $slider->status_id) {{ $selected }} @else {{ $array }} @endif> --}}
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="customFile">Hình ảnh sản phẩm</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" name="file" id="customFile">
                            <label class="custom-file-label" name="label_img" for="customFile"
                                id="name_file">@php echo str_replace("public/admin/uploads/slider\\", '',$slider->thumbnail ); @endphp</label>
                            @error('file')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div id="image-container"><img id="previewImage" class="name-img"
                                src="{{ url($slider->thumbnail) }}"> </div>
                    </div>
                    <button type="submit" value="Update" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
