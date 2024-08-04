<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Gate;
use App\Role_Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'permission']);
            return $next($request);
        });
    }
    //
    function list(Request $request)
    {
        if (!Gate::allows('role.view')) {
            abort(403);
        };
        $list_check = $request->input('list_check');
        $act = $request->input('select_form1');
        if ($request->input('btn-choose')) {
            if (!empty($list_check)) {
                if ($act == 'delete') {
                    Role::destroy($list_check);
                    return redirect('admin/role/list')->with('status', 'Bạn đã xóa thành công');
                } elseif ($act == 'chọn') {
                    return redirect('admin/role/list')->with('warning', 'Bạn chưa chọn hành động cần thực thi');
                }
            } else {
                return redirect('admin/role/list')->with('warning', 'vui lòng chọn phần tử cần xóa');
            }
        }
        $status = $request->input('status');
        if ($status == 'page_all') {
            $roles = Role::paginate(10);
            $count = Role::count();
            return view('admin.role.list', compact('roles', 'count'));
        }
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $roles = Role::where('name', 'LIKE', "%$keyword%")->orwhere('description', 'LIKE', "%$keyword%")->paginate(10);
        $count = Role::count();
        return view('admin.role.list', compact('roles', 'count'));
    }
    function add()
    {
        if (!Gate::allows('role.add')) {
            abort(403);
        };
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.role.add', compact('permissions'));
    }
    function action(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:roles',
                'content' => 'required',
                'permission' => 'nullable|array',
            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'min' => ':attrbute phải ít nhất là :min kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
            ],
            [
                'name' => 'Tên vai trò',
                'content' => 'Mô tả',
            ]
        );
        $role = Role::create([
            'name' => $request->input('name'),
            'description' => $request->input('content'),
        ]);

        $role->permissions()->attach($request->input('permission'));
        // if ($role->name) {
        //     $roles = Role::where('name', $request->input('name'))->first();
        //     $role_id = $roles->id;
        // }
        // foreach ($request->permission as $item) {
        //     $permission_id =  $item;
        //     $role_permission = new Role_Permission();
        //     $role_permission->role_id = $role_id;
        //     $role_permission->permission_id = $permission_id;
        //     $role_permission->save();
        // }
        return redirect()->route('role.list')->with('status', 'Thêm vai trò thành công');
    }
    function update(Role $role)
    {
        // if (!Gate::allows('role.update')) {
        //     abort(403);
        // };
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.role.update', compact('permissions', 'role'));
    }
    function edit(Request $request, Role $role)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
                'content' => 'required',
                'permission' => 'nullable|array',
                'permission.*' => 'exists:permissions,id',

            ],
            [
                'required' => ':attribute không dược để trống',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'min' => ':attrbute phải ít nhất là :min kí tự',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
            ],
            [
                'name' => 'Tên vai trò',
                'content' => 'Mô tả',
            ]
        );
        $role->update([
            'name' => $request->input('name'),
            'description' => $request->input('content'),
        ]);
        //Cập nhật giuw
        $role->permissions()->sync($request->input('permission', []));
        return redirect()->route('role.list')->with('status', 'Cập nhật trò thành công');
    }
    function delete(Request $request)
    {
        if (!Gate::allows('role.delete')) {
            abort(403);
        };
        $id = $request->id;
        Role::find($id)->delete();
    }
}
