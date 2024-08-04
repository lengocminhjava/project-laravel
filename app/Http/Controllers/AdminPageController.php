<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Page;
use App\Status;
use App\Role;

class AdminPageController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        //Đếm số lượng
        $cout_all =  Page::count();
        $count_trash = Page::onlyTrashed()->count();
        $count_posted = Page::where('status_id', 6)->count();
        $count_pendding = Page::where('status_id', 5)->count();
        $count = [$count_trash, $cout_all, $count_pendding,  $count_posted];
        //Act
        $act = $request->input('status');
        //request
        // $request = $request->input('select_status');
        // $selected = 'selected';
        // $array = '';
        //Status
        $status = [
            'delete' => 'Thùng rác',
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt'
        ];
        //Phân trang
        if ($act == 'Trash') {
            $status = [
                'delete_page_trash' => 'Xoá vĩnh viễn',
                'restore' => 'Khôi phục'
            ];
            $pages =  Page::onlyTrashed()->paginate(10);
            // return view('admin.page.list', compact('pages', 'count'));
        } elseif ($act == 'posted') {
            $pages =  Page::where('status_id', 6)->paginate(10);
        } elseif ($act == 'Pending') {
            $pages =  Page::where('status_id', 5)->paginate(10);
        } elseif ($act == 'page_all') {
            $pages =  Page::paginate(10);
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
                $pages = Page::where('name', 'LIKE', "%$keyword%")->orwhereIn('page_id', $user_id)->paginate(10);
                // return $pages;
                return view('admin.page.list', compact('pages', 'count', 'act', 'status'));
            }
            $pages = Page::where('name', 'LIKE', "%$keyword%")->paginate(10);
        }

        return view('admin.page.list', compact('pages', 'count', 'act', 'status'));
    }
    function update(Request $request, $id)
    {
        $page = Page::find($id);
        $status = Status::all();
        return view('admin.page.update', compact('page', 'status'));
    }
    function add()
    {
        $status = Status::all();
        return view('admin.page.add', compact('status'));
    }
    function action(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:pages',
                'select_form' => 'regex:/^[0-9]+$/',
                'content' => 'required|string|min:10'
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'min' => ':attrbute có độ dài tối thiểu :min kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
                'regex' => 'Vui lòng chọn quyền'
            ],
            [
                'name' => 'Tiêu đề',
                'content' => 'Nội dung'
            ]
        );
        $page = new Page();
        $page->name = $request->input('name');
        $page->content = $request->input('content');
        $page->status_id = $request->input('select_form');
        $page->page_id = Auth::id();
        $page->save();
        return redirect('admin/page/list')->with('status', 'Đã thêm trang thành công');
    }
    function edit(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'select_form' => 'regex:/^[0-9]+$/',
                'content' => 'required|string|min:10'
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
                'regex' => 'Vui lòng chọn trạng thái'
            ],
            [
                'name' => 'Tiêu đề',
                'content' => 'Nội dung'
            ]
        );
        Page::where('id', $id)->update([
            'name' => $request->input('name'),
            'page_id' => Auth::id(),
            'status_id' => $request->input('select_form'),
            'content' => $request->input('content'),
        ]);
        return redirect('admin/page/list')->with('status', 'Đã chỉnh sửa trang thành công');
    }
    function delete(Request $request)
    {
        $id = $request->id;
        Page::find($id)->delete();
    }
    function delete_page_trash(Request $request)
    {
        $id = $request->id;
        Page::withTrashed()->find($id)->forceDelete();
    }
    function request(Request $request)
    {
        //Thực thi nhiều hành động

        $list_check = $request->input('list_id');
        $act = $request->input('select_status');
        if ($list_check) {
            if ($act == 'delete') {
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('status', 'Bạn đã chuyển page vào thùng rác thành công');
            } elseif ($act == 'restore') {
                Page::withTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/page/list')->with('status', 'Bạn đã khôi phục thành công user bị xóa tạm thời');
            } elseif ($act == 'delete_page_trash') {
                Page::withTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/page/list')->with('status', 'Bạn đã xóa vinh viễn user ra khỏi hệ thống');
            } elseif ($act == 'public') {
                Page::whereIn('id', $list_check)->update(['status_id' => 6]);
                return redirect('admin/page/list')->with('status', 'Trạng thái công khai đã sẵn sàng');
            } elseif ($act == 'pending') {
                Page::whereIn('id', $list_check)->update(['status_id' => 5]);
                return redirect('admin/page/list')->with('status', 'Trạng thái chờ duyệt đã sẵn sàng');
            } else {
                return redirect('admin/page/list')->with('warning', 'Bạn chưa chọn hành động cần thực thi');
            }
        } else {
            return redirect('admin/page/list')->with('warning', 'Vui lòng chọn phần tử cần thực thi');
        }
    }
}
