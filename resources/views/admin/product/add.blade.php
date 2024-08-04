@extends('layouts.admin-add')
@section('content')
    <div id="content" class="container-fluid" style="min-width:700px">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/product/create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input class="form-control" type="text" value="{{ old('name') }}" name="name"
                                        placeholder="Tên sản phẩm" id="name">
                                    @error('name')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="price">Giá sản phẩm</label>
                                    <input class="form-control" type="number" value="{{ old('price') }}"
                                        placeholder="Giá sản phẩm" name="price" id="price">
                                    @error('price')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price_old">Giá cũ (Nếu có)</label>
                                    <input class="form-control" type="number" value="{{ old('price_old') }}"
                                        placeholder="Giá sản phẩm" name="price_old" id="price_old">
                                </div>
                                <div class="form-group">
                                    <label for="intro">Mô tả sản phẩm</label>
                                    <textarea name="intro" class="form-control" id="intro" placeholder=" ... Mô tả sản phẩm" cols="40"
                                        rows="10">{!! old('intro') !!}</textarea>
                                    @error('intro')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="code">Mã sản phẩm</label>
                                    <input class="form-control" type="text" value="{{ old('code') }}"
                                        placeholder="Mã sản phẩm" name="code" id="code">
                                    @error('code')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="number">Số lượng sản phẩm</label>
                                    <input class="form-control" type="number" value="{{ old('number') }}"
                                        placeholder="SL sản phẩm" name="number" id="number">
                                </div>
                                <div class="form-group">
                                    <label for="customFile">Ảnh đại diện</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" name="file" id="customFile">
                                        <label class="custom-file-label" name="label_img" for="customFile"
                                            id="name_file">Ảnh sản
                                            phẩm</label>
                                        @error('file')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div id="image-container"><img id="previewImage" class="name-img" src=""> </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="detail">Chi tiết sản phẩm</label>
                            <textarea name="detail" class="form-control" id="content-textarea" placeholder="... Chi tiết sản phẩm" cols="30"
                                rows="5">{!! old('detail') !!}</textarea>
                            @error('detail')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="images">Thêm nhiều hình ảnh (Không giới hạn hình ảnh)</label>
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" name="images[]" id="my-file-input" multiple>
                                <label class="custom-file-label" for="customFile" id="file_name">Ảnh mô tả</label>
                                @error('images.*')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                                @error('images')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div id="image-preview-container"></div>
                        </div>


                        <div class="form-group col-12 col-sm-6 pl-0">
                            <label for="">Danh mục</label>
                            @error('select_form')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                            <select class="form-control" name="select_form" id="">
                                <option>Chọn danh mục</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-flex justify-content-between pl-0 pt-3">
                            <div class="form-group col-5 pl-0">
                                <label for="selling">Bán chạy</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="selling" value="selling"
                                        id="selling">
                                    Sản phẩm bán chạy
                                </div>
                            </div>
                            <div class="form-group col-md-4 pl-0">
                                <label for="">Trạng thái</label>
                                @foreach ($status as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                            id="exampleRadios1" value="{{ $item->id }}"
                                            {{ $item->name == 'Công khai' ? 'checked' : '' }}>
                                        {{ $item->name }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group" style="min-width:150px">
                                <label for="hightlight">Nổi bật</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hightlight" value="hightlight"
                                        id="hightlight">
                                    Sản phẩm nổi bật
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center pt-3">
                            <button type="submit" value="Thêm mới" id="new_add"
                                class="btn btn-primary mx-auto w-50 p-3">Thêm
                                mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
