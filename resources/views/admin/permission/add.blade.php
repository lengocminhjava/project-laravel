@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
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
        <div class="row" style="min-width:800px;">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm quyền
                    </div>
                    <div class="card-body">
                        <form action="{{ route('permission.action') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên quyền</label>
                                <input class="form-control" type="text" value="{{ old('name') }}" name="name"
                                    placeholder="Tên danh mục" id="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug
                                </label>
                                <span style="font-size:13px" class="d-block pb-1">Ví dụ:posts.add</span>
                                <input class="form-control" type="text" value="{{ old('slug') }}" name="slug"
                                    placeholder="Tên slug" id="slug">
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả
                                </label>
                                <textarea class="form-control" type="text" name="description" rows="3" placeholder="... Mô tả"
                                    id="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Quyền
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($permissions as $permissionName => $permission)
                                    <tr>
                                        <td></td>
                                        <td> <strong>Module {{ ucfirst($permissionName) }} </strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($permission as $item)
                                        <tr id="tr-data-{{ $item->id }}">
                                            <td scope="row">{{ $i++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->slug }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                <a href="{{ route('permission.update', $item->id) }}"
                                                    class="btn btn-success btn-sm small-button rounded-0 text-white mb-1"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"><i class="fa fa-edit"></i></a>
                                                <button
                                                    class="btn btn-danger btn-sm small-button rounded-0 text-white delete_permission"
                                                    type="button" data-toggle="tooltip" data-id="{{ $item->id }}"
                                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/permission.js') }}"></script>
@endsection
