<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Category_Post;
use App\Status;
use Illuminate\Support\Facades\Gate;

class AdminCategoryPostController extends Controller
{
    //
    function list(Request $request)
    {
        $list_new = Category_Post::all();
        $array = array();
        foreach ($list_new as $item) {
            $array[] = $item->parent_id;
        }
        $data =  array_unique($array);
        $count_all = $list_new->count();
        $count_trash = Category_Post::onlyTrashed()->count();
        $count = [$count_all, $count_trash];
        $list_new = Category_Post::all();
        $list_new = data_tree($list_new);
        $status = Status::all();
        $data_select = [0 => 'Chọn'];
        foreach ($list_new as $cat) {
            $data_select[$cat->id] = str_repeat('--*', $cat->level) . $cat->name;
        }

        return view('admin.post.category', compact('list_new', 'data_select', 'status', 'count', 'data'));
    }
    function request()
    {
        $category =  Category_Post::onlyTrashed()->paginate(10);
        return view('admin.post.category.delete', compact('category'));
    }
    function add(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:category_posts',
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'unique' => ':attribute đã tồn tại trong hệ thống',
            ],
            [
                'name' => 'Tên người dùng',
            ]
        );
        $category = new Category_Post();
        $category->name = $request->input('name');
        $category->slug_url = create_slug($request->input('name'));
        $category->status_id = $request->input('exampleRadios');
        $category->parent_id = $request->input('data_select');
        // $user->role_id = $request->input('select_form');
        $category->save();
        return redirect('admin/post/cat/list')->with('status', 'Đã thêm danh mục thành công');
    }
    function delete(Request $request)
    {
        $id = $request->id;
        $list_category = Category_Post::all();
        $list_parent_id = array();
        foreach ($list_category as $item) {
            $list_parent_id[] = $item->parent_id;
        }
        if (!in_array($id, $list_parent_id)) {
            Category_Post::find($id)->delete();
        }
    }
    function delete_trash(Request $request)
    {
        $id = $request->id;
        Category_Post::withTrashed()->find($id)->forceDelete();
    }
       function restore(Request $request)
    {
        $id = $request->id;
        Category_Post::withTrashed()->find($id)->restore();
    }
    function update($id)
    {
        $category = Category_Post::find($id);
        $list_category = Category_Post::all();
        $list_category = data_tree($list_category);
        $data_select = ["0" => "Chọn"];
        foreach ($list_category as $v) {
            $data_select[$v->id] = str_repeat("--*", $v->level) . $v->name;
        }
        $status = Status::all();

        return view('admin.post.category.update', compact('category', 'data_select', 'status'));
    }
    function edit(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
            ],
            [
                'name' => 'Tên người dùng',
            ]
        );
        Category_Post::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug_url' => create_slug($request->input('name')),
            'status_id' => $request->input('exampleRadios'),
            'parent_id' => $request->input('select_form'),
        ]);
        return redirect('admin/post/cat/list')->with('status', 'Đã cập nhật danh mục thành công');
    }
}
