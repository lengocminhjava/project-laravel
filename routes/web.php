<?php
    
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'UnimartController@index');
// ->middleware('cacheResponse:600')
Route::get('/admin/login', function () {
return view('auth.login');
});
//     Route::get('storagelink', function () {
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
// });
Route::get('trang-chu', 'UnimartController@index');
Route::get('admin', 'UnimartController@index');
// ->middleware('cacheResponse:600')

Auth::routes(['verify' => true]);
Route::get('/home', 'AdminController@index')->name('home')->middleware('verified');
Route::get('http://localhost/Laravel/unimart_laravelpro/register/admin', 'AdminController@index')->middleware('verified');
// Route::get('admin', 'AdminController@index')->middleware('auth', 'CheckRole:admintrator');
// Route::get('admin/dashboard', 'AdminController@dashboard')->middleware('auth', 'CheckRole:admintrator');
//Ưu tiên middleware bên trái trước
//Theo nhóm Admin
Route::middleware('auth', 'verified')->group(function () {
    //accout
    Route::get('http://localhost/Laravel/unimart_laravelpro/register', function () {
        return view('auth.login');
    });
    Route::get('admin/user/account', 'AdminUserController@account');
    Route::get('admin/user/edit_pass', 'AdminUserController@edit_pass');
    Route::post('admin/user/reset_pass', 'AdminUserController@reset_pass');
    //dashboard
    Route::get('/dashboard', 'DashboardController@dashboard');
    //user
    Route::get('admin/user/list', 'AdminUserController@list');
    Route::get('admin/user/add', 'AdminUserController@add');
    Route::get('admin/user/update/{user}', 'AdminUserController@update')->name('update_user');
    Route::post('admin/user/create', 'AdminUserController@create')->name('create_user');
    Route::get('admin/user/delete/{id}', 'AdminUserController@delete')->name('delete_user');
    Route::get('admin/user/delete_trash/{id}', 'AdminUserController@delete_trash')->name('delete_user.trash');
    Route::get('admin/user/action', 'AdminUserController@action');
    Route::get('admin/user/restore', 'AdminUserController@restore');
    Route::post('admin/user/update_validate/{user}', 'AdminUserController@update_validate')->name('update_validate');
    Route::get('admin/user/ajax', 'AdminUserController@ajax');
    Route::get('admin/user/delete_vv', 'AdminUserController@delete_vv');
    //page
    Route::get('admin/page/list', 'AdminPageController@list');
    Route::get('admin/page/add', 'AdminPageController@add');
    Route::get('admin/page/update/{id}', 'AdminPageController@update')->name('update_page');
    Route::get('admin/page/delete', 'AdminPageController@delete');
    Route::post('admin/page/action', 'AdminPageController@action');
    Route::post('admin/page/edit/{id}', 'AdminPageController@edit');
    Route::get('admin/page/delete_trash', 'AdminPageController@delete_page_trash');
    Route::post('admin/page/request', 'AdminPageController@request');
    //slider
    Route::get('admin/slider/list', 'SliderController@list');
    Route::get('admin/slider/add', 'SliderController@add');
    Route::get('admin/slider/update/{id}', 'SliderController@update')->name('update_slider');
    Route::get('admin/slider/delete', 'SliderController@delete');
    Route::post('admin/slider/action', 'SliderController@action');
    Route::post('admin/slider/edit/{id}', 'SliderController@edit')->name('edit_slider');
    Route::get('admin/slider/delete_trash', 'SliderController@delete_slider_trash');
    Route::post('admin/slider/request', 'SliderController@request');
    //post
    Route::get('admin/post/list', 'AdminPostController@list');
    Route::get('admin/post/add', 'AdminPostController@add');
    Route::get('admin/post/update/{id}', 'AdminPostController@update')->name('update_post');
    Route::get('admin/post/delete/{id}', 'AdminPostController@delete')->name('delete_post');
    Route::get('admin/post/delete_trash', 'AdminPostController@delete_post_trash');
    Route::post('admin/post/request', 'AdminPostController@request');
    Route::get('admin/post/ajax', 'AdminPostController@ajax');
    Route::post('admin/post/create', 'AdminPostController@create');
    Route::post('admin/post/edit/{id}', 'AdminPostController@edit')->name('edit_post');
    // Route::post('admin/post/action', 'AdminPostController@action');
    //Category post
    Route::get('admin/post/cat/list', 'AdminCategoryPostController@list');
    Route::post('admin/post/cat/add', 'AdminCategoryPostController@add');
    Route::get('admin/post/cat/update/{id}', 'AdminCategoryPostController@update')->name('update_cat_post');
    Route::get('admin/post/cat/delete', 'AdminCategoryPostController@delete');
    Route::get('admin/post/cat/delete_trash', 'AdminCategoryPostController@delete_trash');
    Route::post('admin/post/cat/edit/{id}', 'AdminCategoryPostController@edit')->name('edit_cat_post');
    Route::get('admin/post/cat/request', 'AdminCategoryPostController@request');
    Route::get('admin/post/cat/restore', 'AdminCategoryPostController@restore');
    //products
    Route::get('admin/product/list', 'AdminProductController@list');
    Route::get('admin/product/add', 'AdminProductController@add');
    Route::get('admin/product/update/{id}', 'AdminProductController@update')->name('update_product');
    Route::get('admin/product/delete/{id}', 'AdminProductController@delete')->name('delete_product');
    Route::get('admin/product/delete_trash', 'AdminProductController@delete_trash');
    Route::post('admin/product/request', 'AdminProductController@request');
    Route::post('admin/product/edit/{id}', 'AdminProductController@edit')->name('product_edit');
    Route::get('admin/product/restore', 'AdminProductController@restore');
    Route::get('admin/product/ajax', 'AdminProductController@ajax');
    Route::get('admin/product/change_num', 'AdminProductController@change_num');
    Route::post('admin/product/create', 'AdminProductController@create');
        Route::get('admin/product/delete_img', 'AdminProductController@delete_img');
    //category_product
    Route::get('admin/product/cat/list', 'CategoryProductController@list');
    Route::post('admin/product/cat/add', 'CategoryProductController@add');
    Route::get('admin/product/cat/update/{id}', 'CategoryProductController@update')->name('update_cat');
    Route::get('admin/product/cat/delete', 'CategoryProductController@delete');
    Route::get('admin/product/cat/delete_trash', 'CategoryProductController@delete_trash');
    Route::post('admin/product/cat/edit/{id}', 'CategoryProductController@edit')->name('edit_cat');
    Route::get('admin/product/cat/request', 'CategoryProductController@request');
    Route::get('admin/product/cat/restore', 'CategoryProductController@restore');
    //Order
    Route::get('admin/order/list', 'AdminOrderController@list');
    Route::get('admin/order/detail/{id}', 'AdminOrderController@detail')->name('admin.order.detail');
    Route::post('admin/order/request', 'AdminOrderController@request');
    Route::get('admin/order/status/{id}', 'AdminOrderController@status')->name('admin.status.detail');
    Route::get('admin/order/delete', 'AdminOrderController@delete');
    //permission
    Route::get('admin/permission/add', 'PermissionController@add')->name('permission.add');
    Route::get('admin/permission/update/{id}', 'PermissionController@update')->name('permission.update');
    Route::post('admin/permission/action', 'PermissionController@action')->name('permission.action');
    Route::post('admin/permission/edit/{id}', 'PermissionController@edit')->name('permission.edit');
    Route::get('admin/permission/delete', 'PermissionController@delete');
    // ->middleware('can:permission.delete')
    //role
    Route::get('admin/role/list', 'RoleController@list')->name('role.list');
    Route::get('admin/role/add', 'RoleController@add')->name('role.add');
    Route::post('admin/role/action', 'RoleController@action')->name('role.action');
    Route::get('admin/role/update/{role}', 'RoleController@update')->name('role.update');
    Route::post('admin/role/edit/{role}', 'RoleController@edit')->name('role.edit');
    Route::get('admin/role/delete', 'RoleController@delete');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
// Route::resource('/user', AdminUserController::class);
// Route::get('admin/post/cat/getData', 'AdminCategoryPostController@getData');
Route::get('admin/post/cat/getdata', 'AdminCategoryPostController@getData');
//End Adminsearch
//Start Unimart

//Trang sản phẩm
Route::get('san-pham.html', 'UnimartController@product');
//Chi tiết sản phẩm
Route::get('san-pham/{slug}.html', 'UnimartController@product_detail');
Route::get('unimart.search.html', 'UnimartController@search');
Route::get('san-pham/{slug}.{id}.html', 'UnimartController@detail')->name('sanpham.detail');
Route::get('san-pham.html/arrange.html', 'UnimartController@arrange');
//Trang bài viết = blog
Route::get('bai-viet.html', 'UnimartController@post');
//Trang category bài viết
Route::get('bai-viet/danh-muc/{slug}.{id}.html', 'UnimartController@post_category')->name('post.post_category');
//Chi tiết bài viết -blog
Route::get('bai-viet/{slug}.{id}.html', 'UnimartController@post_detail')->name('post.detail');
//Liên hệ
Route::get('{slug}.html', 'UnimartController@contact')->name('unimart.contact');
Route::get('thanh-toan.san-pham.html', 'UnimartController@checkout')->name('unimart.checkout');
Route::get('gio-hang.san-pham.html', 'UnimartController@cart')->name('unimart.cart');
//cart
Route::get('unimart/card/add', 'UnimartController@add_card');
Route::get('unimart/card/add_now/{id}', 'UnimartController@add_card_now')->name("unimart.add_now");
Route::get('unimart/card/remove', 'UnimartController@remove');
Route::get('card/destroy', 'UnimartController@destroy');
Route::get('unimart/card/addmore', 'UnimartController@addmore');
Route::post('unimart/checkout', 'UnimartController@checkout_request');
Route::get('dat-hang-thanh-cong.san-pham.html/{id}/{created_at}', 'UnimartController@order_success')->name('unimart.success');
Route::get('unimart/card/ajax', 'UnimartController@ajax');
// Route::get('storagelink', function () {
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
//     echo 'ok';
// });
