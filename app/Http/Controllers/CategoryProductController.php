<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoryProduct;
use App\Status;

class CategoryProductController extends Controller
{
    //
    function list(Request $request)
    {

        $list_new = CategoryProduct::all();
        $array = array();
        foreach ($list_new as $item) {
            $array[] = $item->parent_id;
        }
        $data =  array_unique($array);
        $count_all = $list_new->count();
        $count_trash = CategoryProduct::onlyTrashed()->count();
        $count = [$count_all, $count_trash];
        $list_new = CategoryProduct::all();
        $list_new = data_tree($list_new);
        $status = Status::all();
        $data_select = [0 => 'Chọn'];
        foreach ($list_new as $cat) {
            $data_select[$cat->id] = str_repeat('--*', $cat->level) . $cat->name;
        }
        return view('admin.product.category', compact('list_new', 'data_select', 'status', 'count', 'data'));
    }
    function request()
    {
        $category =  CategoryProduct::onlyTrashed()->paginate(10);
        return view('admin.product.category.delete', compact('category'));
    }
    function add(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:category_products',
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
        $category = new CategoryProduct();
        $category->name = $request->input('name');
        $category->slug_url = create_slug($request->input('name'));
        $category->status_id = $request->input('exampleRadios');
        $category->parent_id = $request->input('data_select');
        // $user->role_id = $request->input('select_form');
        $category->save();
        return redirect('admin/product/cat/list')->with('status', 'Đã thêm danh mục thành công');
    }
    function delete(Request $request)
    {
        $id = $request->id;
        $list_category = CategoryProduct::all();
        $list_parent_id = array();
        foreach ($list_category as $item) {
            $list_parent_id[] = $item->parent_id;
        }
        if (!in_array($id, $list_parent_id)) {
            CategoryProduct::find($id)->delete();
        }
    }
    function delete_trash(Request $request)
    {
        $id = $request->id;
        CategoryProduct::withTrashed()->find($id)->forceDelete();
    }
    function restore(Request $request)
    {
        $id = $request->id;
        CategoryProduct::withTrashed()->find($id)->restore();
    }
    function update($id)
    {
        $category = CategoryProduct::find($id);
        $list_category = CategoryProduct::all();
        $list_category = data_tree($list_category);
        $data_select = ["0" => "Chọn"];
        foreach ($list_category as $v) {
            $data_select[$v->id] = str_repeat("--*", $v->level) . $v->name;
        }
        $status = Status::all();

        return view('admin.product.category.update', compact('category', 'data_select', 'status'));
    }
    function edit(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255,unique:category_products,name,' . $id,
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
        CategoryProduct::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug_url' => create_slug($request->input('name')),
            'status_id' => $request->input('exampleRadios'),
            'parent_id' => $request->input('select_form'),
        ]);
        return redirect('admin/product/cat/list')->with('status', 'Đã cập nhật danh mục thành công');
    }
}
