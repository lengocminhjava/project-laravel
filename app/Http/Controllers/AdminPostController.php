<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Post;
use App\Category_Post;
use App\Status;
use App\User;

class AdminPostController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $cout_all =  Post::count();
        $count_trash = Post::onlyTrashed()->count();
        $count_posted = Post::where('status_id', 6)->count();
        $count_pendding = Post::where('status_id', 5)->count();
        $count = [$count_trash, $cout_all, $count_pendding,  $count_posted];
        //Act
        $act = $request->input('status');
        $status = [
            'delete' => 'Thùng rác',
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt'
        ];
        //Phân trang
        if ($act == 'Trash') {
            $status = [
                'delete_post_trash' => 'Xoá vĩnh viễn',
                'restore' => 'Khôi phục'
            ];
            $posts =  Post::onlyTrashed()->paginate(10);
            // return view('admin.page.list', compact('pages', 'count'));
        } elseif ($act == 'posted') {
            $posts =  Post::where('status_id', 6)->paginate(10);
        } elseif ($act == 'Pending') {
            $posts =  Post::where('status_id', 5)->paginate(10);
        } elseif ($act == 'page_all') {
            $posts =  Post::paginate(10);
        } else {

            $keyword = "";

            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'LIKE', "%$keyword%")->get();
            if ($users->count() > 0) {
                foreach ($users as $k => $value) {
                    $user_id[$k] = $value->id;
                }
                // return $user_id;
                $posts = Post::where('name', 'LIKE', "%$keyword%")->orwhereIn('poster_id', $user_id)->paginate(10);
                // return $pages;
                return view('admin.post.list', compact('posts', 'count', 'act', 'status'));
            }
            $posts = Post::where('name', 'LIKE', "%$keyword%")->paginate(10);
        }

        return view('admin.post.list', compact('posts', 'count', 'act', 'status'));
    }
    function add()
    {
        $category = Category_Post::all();
        $status = Status::all();
        $list_parent_id = array();
        foreach ($category as $item) {
            $list_parent_id[] = $item->parent_id;
        }
        $list_id = array();
        foreach ($category as $item) {
            if (!in_array($item->id, $list_parent_id)) {
                $list_id[] = $item->id;
            }
        }
        $list_category = Category_Post::whereIn('id', $list_id)->get();
        return view('admin.post.add', compact('status', 'list_category'));
    }
    function create(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:posts',
                'select_form' => 'regex:/^[0-9]+$/',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
                'intro' => 'required|string|min:10',
                'content' => 'required|string|min:10',
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'unique' => 'Tiêu đề đã tồn tại trong hệ thống',
                'regex' => 'Chưa chọn danh mục',
                'file.required' => 'Vui lòng chọn tệp ảnh',
                'image' => 'Tệp bạn chọn phải là một tệp ảnh',
                'mimes' => 'Định dạng tệp không đúng. Chỉ chấp nhận JPEG, PNG, JPG hoặc GIF',
                'file.max' => 'Tệp ảnh của bạn không được quá 20MB',
            ],
            [
                'name' => 'Tiêu đề',
                'content' => 'Nội dung',
                'select_form' => 'Danh mục',
                'intro' => 'Đoạn mô tả'
            ]
        );
        $file = $request->file;
        $name = $file->getClientOriginalName();
        $path =  $file->move('public/admin/uploads/post', $name);
        Post::create([
            'name' => $request->input('name'),
            'poster_id' => Auth::id(),
            'category_id' => $request->input('select_form'),
            'status_id' => $request->input('exampleRadios'),
            'thumbnail' =>  $path,
            'content' => $request->input('content'),
            'intro' => $request->input('intro'),
        ]);
        return redirect('admin/post/list')->with('status', 'Bạn đã thêm bài viết thành công');
    }
    function ajax_file(Request $request)
    {

        $file = $request->file;
        $name = $file->getClientOriginalName();

        echo json_encode($name);
    }
    function delete($id)
    {
        Post::find($id)->delete();
    }
    function delete_post_trash(Request $request)
    {
        $id = $request->id;
        Post::withTrashed()->find($id)->forceDelete();
    }
    function update(Request $request, $id)
    {
        $post = Post::find($id);
        $category = Category_Post::all();
        $status = Status::all();
        $list_parent_id = array();
        foreach ($category as $item) {
            $list_parent_id[] = $item->parent_id;
        }
        $list_id = array();
        foreach ($category as $item) {
            if (!in_array($item->id, $list_parent_id)) {
                $list_id[] = $item->id;
            }
        }
        $list_category = Category_Post::whereIn('id', $list_id)->get();
        return view('admin.post.update', compact('post', 'status', 'list_category'));
    }
    function edit(Request $request, $id)
    {
        $post = Post::find($id);
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:posts,name,' . $id,
                'select_form' => 'regex:/^[0-9]+$/',
                'file' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
                'content' => 'required|string|min:10',
                'intro' => 'required|string|min:10',

            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'regex' => 'Chưa chọn danh mục',
                'file.required' => 'Vui lòng chọn tệp ảnh',
                'image' => 'Tệp bạn chọn phải là một tệp ảnh',
                'mimes' => 'Định dạng tệp không đúng. Chỉ chấp nhận JPEG, PNG, JPG hoặc GIF',
                'file.max' => 'Tệp ảnh của bạn không được quá 20MB',
            ],
            [
                'name' => 'Tiêu đề',
                'content' => 'Nội dung',
                'select_form' => 'Danh mục',
                'intro' => 'Đoạn mô tả'
            ]
        );
        $path = $post->thumbnail;
        if ($request->hasFile('file')) {
            $file = $request->file;
            $name = $file->getClientOriginalName();
            $path =  $file->move('public/admin/uploads/post', $name);
        }
        Post::where('id', $id)->update([
            'name' => $request->input('name'),
            'poster_id' => Auth::id(),
            'category_id' => $request->input('select_form'),
            'status_id' => $request->input('exampleRadios'),
            'thumbnail' =>  $path,
            'content' => $request->input('content'),
            'intro' => $request->input('intro'),

        ]);
        return redirect('admin/post/list')->with('status', 'Bạn đã chỉnh sửa bài viết thành công');
    }

    function request(Request $request)
    {
        //Thực thi nhiều hành động

        $list_check = $request->input('list_id');
        $act = $request->input('select_status');
        if ($list_check) {
            if ($act == 'delete') {
                Post::destroy($list_check);
                return redirect('admin/post/list')->with('status', 'Bạn đã chuyển page vào thùng rác thành công');
            } elseif ($act == 'restore') {
                Post::withTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/post/list')->with('status', 'Bạn đã khôi phục thành công user bị xóa tạm thời');
            } elseif ($act == 'delete_post_trash') {
                Post::withTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/post/list')->with('status', 'Bạn đã xóa vinh viễn user ra khỏi hệ thống');
            } elseif ($act == 'public') {
                Post::whereIn('id', $list_check)->update(['status_id' => 6]);
                return redirect('admin/post/list')->with('status', 'Trạng thái công khai đã sẵn sàng');
            } elseif ($act == 'pending') {
                Post::whereIn('id', $list_check)->update(['status_id' => 5]);
                return redirect('admin/post/list')->with('status', 'Trạng thái chờ duyệt đã sẵn sàng');
            } else {
                return redirect('admin/post/list')->with('warning', 'Bạn chưa chọn hành động cần thực thi');
            }
        } else {
            return redirect('admin/post/list')->with('warning', 'Vui lòng chọn phần tử cần thực thi');
        }
    }
    function ajax(Request $request)
    {
        $id = $request->id;
        Post::find($id)->delete();
    }
}
