@extends('layouts.admin-add')
@section('content')
    <div id="content" class="container-fluid" style="min-width:500px">
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
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('product_edit', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input class="form-control" type="text" value="{{ $product->name }}" name="name"
                                    placeholder="Tên sản phẩm" id="name">
                                @error('name')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price">Giá sản phẩm</label>
                                <input class="form-control" type="number" value="{{ $product->price }}"
                                    placeholder="Giá sản phẩm" name="price" id="price">
                                @error('number')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price_old">Giá cũ (Nếu có)</label>
                                <input class="form-control" type="number" value="{{ $product->price_old }}"
                                    placeholder="Giá sản phẩm" name="price_old" id="price_old">
                            </div>
                            <div class="form-group">
                                <label for="intro">Mô tả sản phẩm</label>
                                <textarea name="intro" class="form-control" id="intro" placeholder=" ... Mô tả sản phẩm" cols="40"
                                    rows="10">{!! $product->description !!}</textarea>
                                @error('intro')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="code">Mã sản phẩm</label>
                                <input class="form-control" type="text" value="{{ $product->code }}"
                                    placeholder="Mã sản phẩm" name="code" id="code">
                                @error('name')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="number">Số lượng sản phẩm</label>
                                <input class="form-control" type="number" value="{{ $product->num_qty }}"
                                    placeholder="Giá sản phẩm" name="number" id="number">
                            </div>
                            <div class="form-group">
                                <label for="customFile">Hình ảnh sản phẩm</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" name="file" id="customFile">
                                    <label class="custom-file-label" name="label_img" for="customFile"
                                        id="name_file">@php echo str_replace("public/admin/uploads/product/", '',$product->thumbnail ); @endphp</label>
                                    @error('file')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div id="image-container"><img id="previewImage" class="name-img"
                                        src="{{ url($product->thumbnail) }}"> </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="detail">Chi tiết sản phẩm</label>
                        <textarea name="detail" class="form-control" id="content-textarea" placeholder="... Chi tiết sản phẩm" cols="30"
                            rows="5">{!! $product->detail_product !!}</textarea>
                        @error('detail')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="files">Thêm hình ảnh mô tả (Không giới hạn hình ảnh , ví dụ: màu sắc , kích
                            thước)</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" multiple name="files[]" id="image-inputs">
                            <label class="custom-file-label" for="customFile" id="file_name">Chọn hình ảnh mô tả</label>
                            @error('files.*')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                            @error('files')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <ul id="image-lists">
                            @foreach ($images as $image)
                                <li class='item_image' onclick="delete_images({{ $image->id }})">
                                    <img src="{{ url($image->name) }}">
                                    <div name="button_images" id="image-{{ $image->id }}" class='delete_image'>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="">Danh mục</label>
                        @error('select_form')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                        <select class="form-control" name="select_form" id="">
                            <option>Chọn danh mục</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12 d-flex justify-content-between pl-0 pt-3">
                        <div class="form-group col-md-5 pl-0">
                            <label for="selling">Bán chạy</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="selling" value="selling"
                                    id="selling" {{ $product->selling == 'selling' ? 'checked' : '' }}>
                                Sản phẩm bán chạy
                            </div>
                        </div>
                        <div class="form-group col-md-5 pl-0">
                            <label for="">Trạng thái</label>
                            @foreach ($status as $item)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                        id="exampleRadios1" value="{{ $item->id }}"
                                        {{ $item->id == $product->status_id ? 'checked' : '' }}>
                                    {{ $item->name }}
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group" style="min-width:120px">
                            <label for="hightlight">Nổi bật</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="hightlight" value="hightlight"
                                    {{ $product->hightlight == 'hightlight' ? 'checked' : '' }} id="hightlight">
                                Sản phẩm nổi bật
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center pt-3">
                        <button type="submit" value="Update" id="new_add"
                            class="btn btn-primary mx-auto w-50 p-3">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
