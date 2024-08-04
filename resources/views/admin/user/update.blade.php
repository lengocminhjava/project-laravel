@extends('layouts.admin')
@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div id="content" class="container-fluid" style="min-width:500px">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa người dùng
            </div>
            <div class="card-body">
                <form action="{{ route('update_validate', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" value="{{ $user->name }}" name="name"
                            id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" value="{{ $user->email }}" name="email" id="email"
                            disabled>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" value="" id="password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Xác nhận Mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label for="">Nhóm quyền</label>
                        @error('select_form')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <select class="form-control select2_init" name="select_form[]" multiple>
                            <option value=""></option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}"
                                    {{ in_array($item->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" value="Update" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script>
        $('.select2_init').select2({
            'placeholder': 'Chọn vai trò'
        })
    </script>
@endsection
