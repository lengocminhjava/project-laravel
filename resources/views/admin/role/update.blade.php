@extends('layouts.admin')
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
                Thêm mới quyền
            </div>
            <div class="card-body">
                <form action="{{ route('role.edit', $role->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên vai trò</label>
                        <input class="form-control" type="text" placeholder="Tên vai trò" value="{{ $role->name }}"
                            name="name" id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Mô tả</label>
                        <textarea class="form-control" name="content" placeholder="Mô tả" id="content" rows="1">{{ $role->description }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div style="font-weight:600">Vai trò này có quyền gì?</div>
                        Click vào module hoặc các checkbox bên dưới để chọn quyền .
                    </div>
                    <div class="form-group">
                        @foreach ($permissions as $permissionName => $permission)
                            <table class="table table-striped table-checkall">
                                <tr>
                                    <td>
                                        <input type="checkbox" name="" class="check-name"><span
                                            style="text-transform:uppercase">
                                            Module
                                            {{ $permissionName }}</span>
                                    </td>
                                    @php
                                        $num = $permission->count();
                                    @endphp
                                    @for ($i = 0; $i < $num; $i++)
                                        <td></td>
                                    @endfor
                                </tr>
                                <tr class="d-flex justify-content-between">
                                    @foreach ($permission as $item)
                                        <td>
                                            <input type="checkbox" name="permission[]"
                                                {{ in_array($item->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}
                                                value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        @endforeach
                    </div>
                    <button type="submit" value="update" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
