<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Slider;
use App\User;
use App\Status;

class SliderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        //Đếm số lượng
        $cout_all =  Slider::count();
        $count_trash = Slider::onlyTrashed()->count();
        $count_posted = Slider::where('status_id', 6)->count();
        $count_pendding = Slider::where('status_id', 5)->count();
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
                'delete_slider_trash' => 'Xoá vĩnh viễn',
                'restore' => 'Khôi phục'
            ];
            $sliders =  Slider::onlyTrashed()->paginate(10);
            // return view('admin.slider.list', compact('sliders', 'count'));
        } elseif ($act == 'posted') {
            $sliders =  Slider::where('status_id', 6)->paginate(10);
        } elseif ($act == 'Pending') {
            $sliders =  Slider::where('status_id', 5)->paginate(10);
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
                $sliders = Slider::where('name', 'LIKE', "%$keyword%")->orwhereIn('user_id', $user_id)->paginate(10);
                // return $sliders;
                return view('admin.slider.list', compact('sliders', 'count', 'act', 'status'));
            }
            $sliders = Slider::where('name', 'LIKE', "%$keyword%")->paginate(10);
        }

        return view('admin.slider.list', compact('sliders', 'count', 'act', 'status'));
    }
    function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        $status = Status::all();
        return view('admin.slider.update', compact('slider', 'status'));
    }
    function add()
    {
        $status = Status::all();
        return view('admin.slider.add', compact('status'));
    }
    function action(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:sliders',
                'select_form' => 'regex:/^[0-9]$/',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
                'regex' => 'Bạn chưa chọn trạng thái',
                'image' => 'Tệp bạn chọn phải là một tệp ảnh',
                'mimes' => 'Định dạng tệp không đúng. Chỉ chấp nhận JPEG, PNG, JPG hoặc GIF',
                'file.max' => 'Tệp ảnh của bạn không được quá 20MB',

            ],
            [
                'name' => 'Tiêu đề',

            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file;
            $name = $file->getClientOriginalName();
            $path =  $file->move('public/admin/uploads/slider/', $name);
        }
        $slider = new Slider();
        $slider->name = $request->input('name');
        $slider->status_id = $request->input('select_form');
        $slider->user_id = Auth::id();
        $slider->thumbnail = $path;
        $slider->slug_url = create_slug($request->input('name'));
        $slider->save();
        return redirect('admin/slider/list')->with('status', 'Đã thêm trang thành công');
    }
    function edit(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'select_form' => 'regex:/^[0-9]$/',
                'file' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
                'regex' => 'Vui lòng chọn quyền',
                'image' => 'Tệp bạn chọn phải là một tệp ảnh',
                'mimes' => 'Định dạng tệp không đúng. Chỉ chấp nhận JPEG, PNG, JPG hoặc GIF',
                'file.max' => 'Tệp ảnh của bạn không được quá 20MB',
            ],
            [
                'name' => 'Tiêu đề',
            ]
        );
        $image = Slider::find($id);
        $path =  $image->thumbnail;
        if ($request->hasFile('file')) {
            $file = $request->file;
            $name = $file->getClientOriginalName();
            $path =  $file->move('public/admin/uploads/slider/', $name);
        }
        Slider::where('id', $id)->update([
            'name' => $request->input('name'),
            'user_id' => Auth::id(),
            'status_id' => $request->input('select_form'),
            'thumbnail' => $path,
            'slug_url' =>  create_slug($request->input('name'))
        ]);
        return redirect('admin/slider/list')->with('status', 'Đã chỉnh sửa trang thành công');
    }
    function delete(Request $request)
    {
        $id = $request->id;
        Slider::find($id)->delete();
    }
    function delete_slider_trash(Request $request)
    {
        $id = $request->id;
        Slider::withTrashed()->find($id)->forceDelete();
    }
    function request(Request $request)
    {
        //Thực thi nhiều hành động

        $list_check = $request->input('list_id');
        $act = $request->input('select_status');
        if ($list_check) {
            if ($act == 'delete') {
                Slider::destroy($list_check);
                return redirect('admin/slider/list')->with('status', 'Bạn đã chuyển slider vào thùng rác thành công');
            } elseif ($act == 'restore') {
                Slider::withTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/slider/list')->with('status', 'Bạn đã khôi phục thành công user bị xóa tạm thời');
            } elseif ($act == 'delete_slider_trash') {
                Slider::withTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/slider/list')->with('status', 'Bạn đã xóa vinh viễn user ra khỏi hệ thống');
            } elseif ($act == 'public') {
                Slider::whereIn('id', $list_check)->update(['status_id' => 6]);
                return redirect('admin/slider/list')->with('status', 'Trạng thái công khai đã sẵn sàng');
            } elseif ($act == 'pending') {
                Slider::whereIn('id', $list_check)->update(['status_id' => 5]);
                return redirect('admin/slider/list')->with('status', 'Trạng thái chờ duyệt đã sẵn sàng');
            } else {
                return redirect('admin/slider/list')->with('warning', 'Bạn chưa chọn hành động cần thực thi');
            }
        } else {
            return redirect('admin/slider/list')->with('warning', 'Vui lòng chọn phần tử cần thực thi');
        }
    }
}
