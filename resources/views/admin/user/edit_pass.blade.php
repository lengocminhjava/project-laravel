@extends('layouts.admin-account')
@section('content')
    <div id="content" class="container-fluid" style="display:flex;justify-content:center;align-items:center;min-width:500px">
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
                Cập nhật mật khẩu
            </div>
            <div class="card-body">
                <form action="{{ url('admin/user/reset_pass') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Mật khẩu cũ</label>
                        <input class="form-control" type="password_old" placeholder="Nhập mật khẩu cũ" name="password_old"
                            id="name">
                        @error('password_old')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Mật khẩu mới</label>
                        <input class="form-control" type="password" placeholder="Nhập mật khẩu mới" name="password"
                            id="name">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" placeholder="Xác nhận mật khẩu"
                            name="password_confirmation" id="name">
                    </div>
                    <button type="submit" name="update_pass" value="update" class="btn btn-primary">Chấp nhận</button>
                </form>
            </div>
        </div>
    </div>
@endsection
