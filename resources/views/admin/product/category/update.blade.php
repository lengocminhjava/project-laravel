@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid d-flex justify-content-center align-items-center"
        style="min-width:500px;>
        <div class="card" style="width:60%;">
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
            Cập nhật danh mục
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('edit_cat', $category->id) }}">
                @csrf
                <div class="form-group">
                    <label for="name">Tên danh mục</label>
                    <input class="form-control" type="text" value="{{ $category->name }}" name="name" id="name">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Danh mục cha</label>
                    <select class="form-control" name="select_form" id="">
                        @foreach ($data_select as $k => $v)
                            <option value="{{ $k }}"{{ $k == $category->parent_id ? 'selected' : '' }}>
                                {{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    @foreach ($status as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                value="{{ $item->id }}" {{ $category->status_id == $item->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleRadios1">
                                {{ $item->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" value="Sửa"class="btn btn-primary">Cập nhật</button>
            </form>
        </div>

    </div>
    </div>
@endsection
