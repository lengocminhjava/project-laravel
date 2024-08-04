<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\User;
use App\CategoryProduct;
use App\Status;
use App\ImagesProduct;
use App\Order;




class AdminProductController extends Controller
{
    //

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        // return User::withTrashed()->get();
        $cout_all =  Product::count();
        $count_trash = Product::onlyTrashed()->count();
        $count_posted = Product::where('status_id', 6)->count();
        $count_pendding = Product::where('status_id', 5)->count();
        $count = [$count_trash, $cout_all, $count_pendding,  $count_posted];
        $id = Auth::id();
        $stock_name = [
            'still' => 'Còn hàng',
            'over' => 'Hết hàng',
            'hightlight' => 'Nổi bật',
            'selling' => 'Bán chạy'
        ];
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
                'delete_product_trash' => 'Xoá vĩnh viễn',
                'restore' => 'Khôi phục'
            ];
            $products =  Product::onlyTrashed()->paginate(10);
            // return view('admin.page.list', compact('pages', 'count'));
        } elseif ($act == 'posted') {
            $products =  Product::where('status_id', 6)->orderBy(Product::raw("CASE WHEN poster_id = $id THEN 0 ELSE 1 END"), 'asc')->paginate(10);
        } elseif ($act == 'Pending') {
            $products =  Product::where('status_id', 5)->orderBy(Product::raw("CASE WHEN poster_id = $id THEN 0 ELSE 1 END"), 'asc')->paginate(10);
        } elseif ($act == 'page_all') {
            return redirect('admin/product/list');
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
                // ->orderBy(Product::raw("CASE WHEN poster_id = $id THEN 0 ELSE 1 END"), 'asc')->orderBy('id', 'desc')
                $products = Product::where('name', 'LIKE', "%$keyword%")->orwhereIn('poster_id', $user_id)->paginate(10);
                // return $pages;
                return view('admin.product.list', compact('products', 'count', 'act', 'status', 'stock_name'));
            }
            $products = Product::where('name', 'LIKE', "%$keyword%")->orwhere('code', 'LIKE', "%$keyword%")->orderBy('id', 'desc')->paginate(10);
        }

        return view('admin.product.list', compact('products', 'count', 'act', 'status', 'stock_name'));
    }
    function add()
    {
        $categorys = CategoryProduct::all();
        $status = Status::all();
        $list_parent_id = array();
        foreach ($categorys as $item) {
            $list_parent_id[] = $item->parent_id;
        }
        $list_id = array();
        foreach ($categorys as $item) {
            if (!in_array($item->id, $list_parent_id)) {
                $list_id[] = $item->id;
            }
        }
        $category = CategoryProduct::whereIn('id', $list_id)->get();
        return view('admin.product.add', compact('category', 'status'));
    }
    function create(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:products',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
                'images' => 'required',
                'intro' => 'required',
                'select_form' => 'regex:/^[0-9]+$/',
                'code' => 'required|string|max:100|unique:products',
                'detail' => 'required',
                'intro' => 'required',
                'price' => 'required',
            ],
            [
                'required' => 'Bạn đã quên nhập :attribute',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'unique' => 'Tiêu đề đã tồn tại trong hệ thống',
                'regex' => 'Chưa chọn danh mục',
                'file.required' => 'Vui lòng chọn tệp ảnh',
                'image' => 'Tệp bạn chọn phải là một tệp ảnh',
                'mimes' => 'Định dạng tệp không đúng. Chỉ chấp nhận JPEG, PNG, JPG hoặc GIF',
                'file.max' => 'Tệp ảnh của bạn không được quá 20MB',
                'images.*.max' => 'Tệp ảnh của bạn không được quá 20MB',
                'images.required' => 'Bạn chưa chọn ảnh mô tả'
            ],
            [
                'name' => 'Tiêu đề',
                'select_form' => 'Danh mục',
                'detail' => 'Chi tiết sản phẩm',
                'intro' => 'Mô tả sản phẩm',
            ]
        );
        if ($request->hasFile('file')) {

            $file = $request->file;

            $name = $file->getClientOriginalName();
            $path =  $file->move('public/admin/uploads/product', $name);
        }
        $price_old = $request->input('price_old');
        if (empty($price_old)) {
            $price_old = 0;
        }
        $num_qty = $request->input('number');
        $stock = 'still';
        if (empty($num_qty)) {
            $num_qty = 0;
            $stock = 'over';
        }
        $product = new Product();
        $product->name = $request->input('name');
        $product->code = $request->input('code');
        $product->price =  $request->input('price');
        $product->price_old =  $price_old;
        $product->num_qty =  $num_qty;
        $product->stock = $stock;
        $product->description = $request->input('intro');
        $product->detail_product = $request->input('detail');
        $product->category_id = $request->input('select_form');
        $product->status_id =  $request->input('exampleRadios');
        $product->poster_id = Auth::id();
        $product->base_url = create_slug($request->input('name'));
        $product->hightlight = $request->input('hightlight');
        $product->selling = $request->input('selling');
        $product->thumbnail =   $path;
        $product->save();


        //Imanges
        if ($product) {
            $product_id = Product::where('code', $request->input('code'))->first()->id;
        }
        $urls = array();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = $file->getClientOriginalName();
                // return $file;
                $file->move('public/admin/uploads/product', $name);
                $urls[] = $name;
            }
        }
        foreach ($urls as $item) {
            // return $item;
            $image = new ImagesProduct();
            $image->name = 'public/admin/uploads/product/' . $item;
            $image->product_id = $product_id;
            $image->thumbnail = 'public/admin/uploads/product/' . $item;
            $image->save();
        }
        return redirect('admin/product/list')->with('status', 'Tạo sản phẩm thành công');
    }
    function update($id)
    {

        $product = Product::find($id);
        // return $product->thumbnail;


        // đổi đường dẫn sử dụng phương thức path() của UploadedFile

        $images = ImagesProduct::where('product_id', $id)->get();
     $categorys = CategoryProduct::all();
        $status = Status::all();
        $list_parent_id = array();
        foreach ($categorys as $item) {
            $list_parent_id[] = $item->parent_id;
        }
        $list_id = array();
        foreach ($categorys as $item) {
            if (!in_array($item->id, $list_parent_id)) {
                $list_id[] = $item->id;
            }
        }
        $category = CategoryProduct::whereIn('id', $list_id)->get();
        return view('admin.product.update', compact('category', 'status', 'product', 'images'));
    }
    function edit(Request $request, $id)
    {

        $request->validate(
            [
                'name' => 'required|string|max:255|unique:products,name,' . $id,
                'file' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480|unique:images_products,name,' . $id,
                'files.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480|unique:images_products,name,' . $id,
                'intro' => 'required',
                'select_form' => 'regex:/^[0-9]+$/',
                'code' => 'required|string|max:100|unique:products,code,' . $id,
                'detail' => 'required',
                'intro' => 'required',
                'price' => 'required',
            ],
            [
                'required' => 'Bạn đã quên nhập :attribute',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'unique' => 'Tiêu đề đã tồn tại trong hệ thống',
                'regex' => 'Chưa chọn danh mục',
                'image' => 'Tệp bạn chọn phải là một tệp ảnh',
                'mimes' => 'Định dạng tệp không đúng. Chỉ chấp nhận JPEG, PNG, JPG hoặc GIF',
                'file.max' => 'Tệp ảnh của bạn không được quá 20MB',
                'images.*.max' => 'Tệp ảnh của bạn không được quá 20MB',
                'files.*.max' => 'Tệp ảnh của bạn không được quá 20MB',
            ],
            [
                'name' => 'Tiêu đề',
                'select_form' => 'Danh mục',
                'detail' => 'Chi tiết sản phẩm',
                'intro' => 'Mô tả sản phẩm',
            ]
        );
        
          $images = ImagesProduct::where('product_id', $id)->get();
            if (!$request->hasFile('files') && $images->isEmpty()) {
                return redirect()->back()->with('warning', 'Sản phẩm cần có ít nhất một hình ảnh mô tả');
            }
        
        $product = Product::find($id);
        $path = $product->thumbnail;
        if ($request->hasFile('file')) {
            $file = $request->file;
            $name = $file->getClientOriginalName();
            $path =  $file->move('public/admin/uploads/product', $name);
        }
        $price_old = $request->input('price_old');
        if (empty($price_old)) {
            $price_old = 0;
        }
        $num_qty = $request->input('number');
        $stock = 'still';
        if (empty($num_qty)) {
            $num_qty = 0;
            $stock = 'over';
        }
        Product::where('id', $id)->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'price' => $request->input('price'),
            'price_old' => $price_old,
            'num_qty' =>  $num_qty,
            'stock' => $stock,
            'description' =>  $request->input('intro'),
            'detail_product' =>  $request->input('detail'),
            'category_id' =>  $request->input('select_form'),
            'status_id' => $request->input('exampleRadios'),
            'poster_id' =>  Auth::id(),
            'base_url' =>  create_slug($request->input('name')),
            'hightlight' => $request->input('content'),
            'selling' => create_slug($request->input('name')),
            'hightlight' => $request->input('hightlight'),
            'selling' => $request->input('selling'),
            'thumbnail' => $path,
        ]);
        $images = ImagesProduct::where('product_id', $id);
        foreach ($images  as $image) {
            ImagesProduct::where('id', $id)->update([
                'name' => 'public/admin/uploads/product/' . $image,
                'product_id' => $id,
                'thumbnail' => 'public/admin/uploads/product/' . $image,
            ]);
        }
        $files = array();
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $name = $file->getClientOriginalName();
                // return $file;
                $file->move('public/admin/uploads/product', $name);
                $files[] = $name;
            }
            $image_name = ImagesProduct::where('product_id', $id)->get();

            $images = array();
            foreach ($image_name as $item) {
                $images[] = $item->name;
            }
            foreach ($files  as $item) {
                if (in_array('public/admin/uploads/product/' . $item, $images)) {
                    unset($files[$item]);
                } else {
                    $image = new ImagesProduct();
                    $image->name = 'public/admin/uploads/product/' . $item;
                    $image->product_id = $id;
                    $image->thumbnail = 'public/admin/uploads/product/' . $item;
                    $image->save();
                }
            }
        }

        $urls = array();
        if ($request->hasFile('images')) {
            ImagesProduct::withTrashed()->where('product_id', $id)->forceDelete();
            foreach ($request->file('images') as $file) {
                $name = $file->getClientOriginalName();
                // return $file;
                $file->move('public/admin/uploads/product', $name);
                $urls[] = $name;
            }
            foreach ($urls as $item) {
                // return $item;
                $image = new ImagesProduct();
                $image->name = 'public/admin/uploads/product/' . $item;
                $image->product_id = $id;
                $image->thumbnail = 'public/admin/uploads/product/' . $item;
                $image->save();
            }
        }
        return redirect('admin/product/list')->with('status', 'Cập nhật sản phẩm thành công');
    }
    function category()
    {
        return view('admin.product.category');
    }
    function delete_trash(Request $request)
    {
        $id = $request->id;
        Product::withTrashed()->find($id)->forceDelete();
    }
    function restore(Request $request)
    {
        $id = $request->id;
        Product::withTrashed()->find($id)->restore();
    }
    function delete_product_trash($id)
    {
        Product::withTrashed()->find($id)->forceDelete();
        return redirect('admin/product/list')->with('status', 'Bạn đã xóa vĩnh viễn một sản phẩm ra khỏi hệ thống thành công');
    }
    function request(Request $request)
    {
        //Thực thi nhiều hành động
        $list_check = $request->input('list_id');
        $act = $request->input('select_status');
        // Code xử lý khi form được submit

        if ($list_check) {
            if ($act == 'delete') {
                Product::destroy($list_check);
                return redirect('admin/product/list')->with('status', 'Bạn đã chuyển page vào thùng rác thành công');
            } elseif ($act == 'restore') {
                Product::withTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/product/list')->with('status', 'Bạn đã khôi phục thành công user bị xóa tạm thời');
            } elseif ($act == 'delete_product_trash') {
                Product::withTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/product/list')->with('status', 'Bạn đã xóa vinh viễn user ra khỏi hệ thống');
            } elseif ($act == 'public') {
                Product::whereIn('id', $list_check)->update(['status_id' => 6]);
                return redirect('admin/product/list')->with('status', 'Trạng thái công khai đã sẵn sàng');
            } elseif ($act == 'pending') {
                Product::whereIn('id', $list_check)->update(['status_id' => 5]);
                return redirect('admin/product/list')->with('status', 'Trạng thái chờ duyệt đã sẵn sàng');
            } else {
                return redirect('admin/product/list')->with('warning', 'Bạn chưa chọn hành động cần thực thi');
            }
        } else {
            return redirect('admin/product/list')->with('warning', 'Vui lòng chọn phần tử cần thực thi');
        }
    }
    function ajax(Request $request)
    {
        $id = $request->id;
        Product::find($id)->delete();
    }
    function change_num(Request $request)
    {
   $num_qty = $request->num_qty;
        $id =  $request->id;
        if ($num_qty != 'NaN') {
            Product::where('id', $id)->update([
                'num_qty' => $num_qty,
            ]);
        }
        $product = Product::find($id);
        if ($product->num_qty > 0) {
            $update =   Product::where('id', $id)->update([
                'stock' => 'still',
            ]);
            $chang_name = "  <span class='d-block badge badge-info text-center'>Còn hàng</span>";
        } else {
            $chang_name = "<span class='d-block badge badge-secondary text-center'>Hết hàng</span>";
            $update =  Product::where('id', $id)->update([
                'stock' => 'over',
            ]);
        }
        $data = [
            'num_qty' => $num_qty,
            'chang_name' => $chang_name,
            'update' =>  $update
        ];
        echo json_encode($data);
    }
        function delete_img(Request $request)
    {
        $id = $request->id;
        ImagesProduct::find($id)->delete();
    }
}
