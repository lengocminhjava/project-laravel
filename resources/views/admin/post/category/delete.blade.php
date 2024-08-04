@extends('layouts.admin')
@section('content')
    <script type="text/javascript"></script>
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục

                    </div>
                    <div class="font-weight-bold" style="padding-left:1.25rem">
                        <a class="text-primary" href="{{ url('admin/post/cat/list') }}">Quay Lại</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($category->total() > 0)
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($category as $item)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr class="tr-data-{{ $item->id }}">
                                            <th scope="row">{{ $i }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->slug_url }}</td>
                                            <td>{{ $item->status->name }}</td>
                                            <td>
                                                <button class="btn btn-success btn-sm rounded-0 text-white cat_restore"
                                                    data-id="{{ $item->id }}" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Restore"><i
                                                        class="fa fa-window-restore"></i></button>
                                                <button class="btn btn-danger btn-sm rounded-0 text-white delete_cat_trash"
                                                    data-id="{{ $item->id }}" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="bg-white pb-0">Hiện không có bản ghi nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @if ($category->total() > 10)
                            <div class="card-body p-0" style="text-align:center">
                                <div style="display:inline-block; text-align:center">
                                    {{ $category->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/post.js') }}"></script>
@endsection
