@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid d-flex justify-content-center align-items-center" style="min-width:500px">
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
                Cập nhật vai trò
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('permission.edit', $permission->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên vai trò</label>
                        <input class="form-control" type="text" value="{{ $permission->name }}" name="name"
                            id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">slug</label>
                        <p>Ví dụ : post.edit</p>
                        <input class="form-control" type="text" value="{{ $permission->slug }}" name="slug"
                            id="slug">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Tên mô tả</label>
                        <input class="form-control" type="text" value="{{ $permission->description }}" name="description"
                            id="description">
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" value="Sửa"class="btn btn-primary">Cập nhật</button>
                </form>
            </div>

        </div>
    </div>
@endsection
