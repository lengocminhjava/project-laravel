<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use MicrosoftAzure\Storage\Common\Internal\Validate;
use App\User;
use App\Role;
use App\User_Role;

class AdminUserController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    function index()
    {
        //Trao quyền
        // $role = Role::find(18);
        // $permission = Permission::find(20);
        // $role->givePermissionTo($permission);
        //
        // OR
        //
        // sync Thêm rồi k thêm nữa
        // assign Có thể thêm tiếp  
        // $permission->assignRole($role);

        //Thêm nhiều sử dụng
        // $role->syncPermissions($permissions);
        // or
        // $permission->syncRoles($roles);

        //Xóa quyền
        // $role->revokePermissionTo($permission);
        // or
        // $permission->removeRole($role);

        // $user = User::with('roles', 'permissions')->orderBy('id', 'DESC')->get();

        // $users = DB::table('users')->join('roles', 'users.role_id', '=', 'roles.id')->select('users.name', 'roles.name as title')->get();
        // echo "<pre>";
        // print_r($users);
        // $role = Role::create(['name' => 'user manager']);

        // $permission = Permission::create(['name' => 'delete category product']);
        return view('admin.user.spatie');
    }
    function list(Request $request)
    {
        //Đếm số lượng

        // $count = [$count_user_active, $count_user_trash, $count_user_sub, $count_user_admin, $count_user_product, $count_user_post];
        //status
        $user_public =  User::paginate(10);
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->paginate(10);
        $post_manager =  User::whereHas('roles', function ($query) {
            $query->where('name', 'post-manager')->orwhere('name', 'admin');
        })->paginate(10);
        $product_manager =  User::whereHas('roles', function ($query) {
            $query->where('name', 'product-manager')->orwhere('name', 'admin');
        })->paginate(10);
        $order_manager = User::whereHas('roles', function ($query) {
            $query->where('name', 'order-manager')->orwhere('name', 'admin');
        })->paginate(10);
        $num_admin = $admin->total();
        $num_post = $post_manager->total();
        $num_product = $product_manager->total();
        $num_order =  $order_manager->total();
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash,  $num_admin, $num_post,  $num_product, $num_order];
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời'
        ];
        if ($status == 'active') {
            $users =  $user_public;
        } elseif ($status == 'post') {
            $users = $post_manager;
        } elseif ($status == 'product') {
            $users = $product_manager;
        } elseif ($status == 'order') {
            $users =  $order_manager;
        } elseif ($status == 'admin') {
            $users = $admin;
        } else
        if ($status == 'trash') {
            $list_act = [
                'delete_trash' => 'Xóa vĩnh viễn',
                'restore' => 'Khôi phục'
            ];
            $users = User::onlyTrashed()->paginate(10);
        } else {
            $keyword = "";

            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'LIKE', "%$keyword%")->orwhere('email', 'LIKE', "%$keyword%")->orderBy('id', 'asc')->paginate(10);
        }
        return view('admin.user.list', compact('users', 'count', 'list_act', 'status'));
    }
    function add(Request $request)
    {
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }
    function create(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed|',
                'select_form' => 'nullable|array',
            ],
            [
                'required' => ':attribute không dược để trống',
                'min' => ':attrbute có độ dài ít nhât :min kí tự',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'confirmed' => 'Mật khẩu đăng kí nhập phải khớp nhau',
                'unique' => 'Email đã tồn tại trong hệ thống',
                'select_form.required' => 'Vui lòng chọn quyền'
            ],
            [
                'fullname' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ]
        );
        $user = User::create([
            'name' => $request->input('fullname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->roles()->attach($request->input('select_form'));
        return redirect('admin/user/list')->with('status', 'Đã thêm thành viên thành công');
    }
    function delete($id)
    {
        if (Auth::id() != $id) {
            User::find($id)->delete();
            return redirect('admin/user/list')->with('status', 'Bạn đã xóa user ra khỏi hệ thống thành công');
        } else {
            return redirect('admin/user/list')->with('warning', 'Bạn không thể tự xóa mình ra khỏi hệ thống');
        }
    }
    function delete_trash($id)
    {
        User::withTrashed()->find($id)->forceDelete();
    }
    function delete_vv(Request $request)
    {
        $id = $request->id;
        User::withTrashed()->where('id', $id)->forceDelete();
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if ($list_check) {
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status', 'Bạn đã xóa tạm thời thành công user');
                } elseif ($act == 'restore') {
                    User::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/user/list')->with('status', 'Bạn đã khôi phục thành công user bị xóa tạm thời');
                } elseif ($act == 'delete_trash') {
                    User::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect('admin/user/list')->with('status', 'Bạn đã xóa vinh viễn user ra khỏi hệ thống');
                } else {
                    return redirect('admin/user/list')->with('warning', 'Bạn chưa chọn hành động cần thực thi');
                }
            } else {
                return redirect('admin/user/list')->with('warning', 'Bạn không thể thao tác trên user của bạn');
            }
        } else {
            return redirect('admin/user/list')->with('warning', 'vui lòng chọn phần tử cần xóa');
        }
    }
    function update(User $user)
    {
        $roles = Role::all();
        return view('admin.user.update', compact('user', 'roles'));
    }
    function update_validate(User $user, Request $request)
    {
        $request->validate(
            [
                'name' => 'bail|required|string|max:255',
                'password' => 'bail|confirmed|',
                'select_form' => 'nullable|array',
                'select_form.*' => 'exists:roles,id',
            ],
            [
                'required' => ':attribute không dược để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự',
                'max' => ':attribute có độ dài tối đa :max kí tự',
                'confirmed' => 'Mật khẩu đăng kí nhập phải khớp nhau',
                'unique' => 'Email đã tồn tại trong hệ thống',
                'exists' => 'id không hợp lệ'
            ],
            [
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu',
            ]
        );
        if (!empty($request->input('password'))) {
            $user->update([
                'name' => $request->input('name'),
                 'password' => bcrypt($request->input('password')),
            ]);
        } else {
            $user->update([
                'name' => $request->input('name'),
            ]);
            //Cập nhật giuw
        }
        $user->roles()->sync($request->input('select_form', []));

        // if (!empty($request->input('password'))) {
        //     User::where('id', $id)->update([
        //         'name' => $request->input('name'),
        //         'password' => Hash::make($request->input('password')),

        //     ]);
        // } else {
        //     User::where('id', $id)->update([
        //         'name' => $request->input('name'),
        //     ]);
        // }
        // User_Role::where('user_id', $id)->delete();
        // foreach ($request->input('select_form') as $item) {
        //     $role = new User_Role();
        //     $role->user_id = $id;
        //     $role->role_id = $item;
        //     $role->save();
        // }
        return redirect('admin/user/list')->with('status', 'Đã chỉnh sửa thành viên thành công');
    }
    function ajax(Request $request)
    {
        $id = $request->id;
        return redirect(route('delete_user', $id));
    }
    function account(Request $request)
    {
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $users = User::where('name', 'LIKE', "%$keyword%")->paginate(10);
        return view('admin.user.account', compact('users'));
    }
    function edit_pass()
    {
        return view('admin.user.edit_pass');
    }
    function reset_pass(Request $request)
    {

        $request->validate([
            'password_old' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('Mật khẩu cũ không đúng'));
                    }
                },
            ],
            [
                'password' => 'bail|required|string|min:8|confirmed|',
            ],
            [
                'required' => ':attribute không dược để trống',
                'min' => ':attrbute có độ dài ít nhât :min kí tự',
                'confirmed' => 'Mật khẩu đăng kí nhập phải khớp nhau',
            ],
            [
                'password' => 'Mật khẩu',
            ]
        ]);

        // Update password
        User::where('id', Auth::id())->update([
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->back()->with('status', 'Mật khẩu đã được thay đổi thành công');
    }
    function restore(Request $request)
    {
        $id = $request->id;
        User::withTrashed()->find($id)->restore();
    }
}
