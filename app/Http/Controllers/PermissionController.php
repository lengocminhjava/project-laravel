<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'permission']);
            return $next($request);
        });
    }
    //
    function add()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.permission.add', compact('permissions'));
    }
    function action(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|string|max:255|unique:permissions',
                'slug' => 'required|string|max:255|unique:permissions',
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'min' => ':attrbute phải ít nhất là :min kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
            ],
            [
                'name' => 'Tiêu đề',
                'slug' => 'slug',
            ]
        );
        $product = new Permission();
        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->description = $request->input('description');
        $product->save();
        return redirect()->back()->with('status', 'Thêm quyền thành công');
    }
    function update($id)
    {
        $permission = Permission::find($id);
        return view('admin.permission.update', compact('permission'));
    }
    function edit(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:permissions,name,' . $id,
                'slug' => 'required|string|max:255|unique:permissions,slug,' . $id,
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'min' => ':attrbute phải ít nhất là :min kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
            ],
            [
                'name' => 'Tiêu đề',
                'slug' => 'slug',
            ]
        );
        Permission::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('permission.add')->with('status', 'Cập nhật bản ghi thành công');
    }
    function delete(Request $request)
    {
        $id = $request->id;
        Permission::find($id)->delete();
    }
}
