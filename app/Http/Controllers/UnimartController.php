<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\CategoryProduct;
use App\ImagesProduct;
use App\Product;
use App\Post;
use App\Page;
use App\Slider;
use App\Client;
use App\Order;
use App\DetailOrder;
use App\Category_Post;

class UnimartController extends Controller
{
    //
    function index()
    {
        $categorys =  CategoryProduct::all();
        //Sản phẩm nổi bật
        $product_hightlights =  Product::where([['hightlight', 'hightlight'], ['num_qty', '>', 0],['status_id','=',6]])->get();
        //Sản phẩm bán chạy
        $product_sellings =  Product::where([['selling', '=', 'selling'], ['num_qty', '>', 0],['status_id','=',6]])->get();
        //Điện thoại
        $product_mobiles =  list_product_num(1);
        $product_laptops = list_product_num(3);
        $product_tablets = list_product_num(2);
        $product_accessorys = list_product_num(22);
    // Lap top Table
        $product_pauses =  Product::where('num_qty', 0)->where('status_id',6)->get();
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $sliders = Slider::where('status_id',6)->get();
        return view('unimart.home', compact('categorys', 'product_pauses', 'product_tablets', 'product_mobiles', 'product_laptops', 'sliders', 'product_hightlights', 'product_sellings', 'product_accessorys', 'headers'));
    }
    function product(Request $request)
    {
        
        $total =  Product::where('status_id', 6)->where('num_qty','>',0)->count();
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $arrange = $request->input('select_arrange');
        $categorys =  CategoryProduct::all();
        $products = Product::where('num_qty', '>', 0)->paginate(9);
        $category_prs =  CategoryProduct::where('parent_id', 0)->get();
        $price = $request->input('price');
        $brand = $request->input('brand');
        if ($brand) {
            $list = data_tree($categorys, $brand);
            //Tìm danh sách theo id
            $list_parent =  array(CategoryProduct::where('id', $brand)->first());
            //Nhóm lại
            $list_pro = array_merge($list, $list_parent);
            $result = array();
            if (!empty($list_pro))
                //In ra các id thỏa mãn
                foreach ($list_pro as $item) {
                    $result[] = (int)$item['id'];
                }
            if (empty($price)) {
                $products = Product::whereIn('category_id', $result)->paginate(10);
            } else {
                if ($price == 1) {
                    $products = Product::whereIn('category_id', $result)->where('price', '<', 500000)->where('status_id',6)->paginate(10);
                }
                if ($price == 2) {
                    $products = Product::whereIn('category_id', $result)->whereBetween('price',  [500000, 1000000])->where('status_id',6)->paginate(10);
                }
                if ($price == 3) {
                    $products = Product::whereIn('category_id', $result)->whereBetween('price',  [1000000, 5000000])->where('status_id',6)->paginate(10);
                }
                if ($price == 4) {
                    $products = Product::whereIn('category_id', $result)->whereBetween('price',  [5000000, 10000000])->where('status_id',6)->paginate(10);
                }
                if ($price == 5) {
                    $products = Product::whereIn('category_id', $result)->where('price', '>', 10000000)->where('status_id',6)->paginate(10);
                }
            }
        } elseif ($price && empty($brand)) {
            if ($price == 1) {
                $products = Product::where('price', '<', 500000)->paginate(10);
            }
            if ($price == 2) {
                $products = Product::whereBetween('price',  [500000, 1000000])->where('status_id',6)->paginate(10);
            }
            if ($price == 3) {
                $products = Product::whereBetween('price',  [1000000, 5000000])->where('status_id',6)->paginate(10);
            }
            if ($price == 4) {
                $products = Product::whereBetween('price',  [5000000, 10000000])->where('status_id',6)->paginate(10);
            }
            if ($price == 5) {
                $products = Product::where('price', '>', 10000000)->where('status_id',6)->paginate(10);
            }
        }
         $request->validate(
            [
                'select_arrange' => 'regex:/^[1-9]+$/',
            ],
            [
                'regex' => 'Vui lòng chọn hình thức sắp xếp',
            ]
        );
       $arrange = $request->input('select_arrange');
         if ($arrange == 3) {
            $products = Product::where('num_qty', '>', 0)->where('status_id',6)->orderBy('price', 'desc')->paginate(20);
              return view('unimart.product.index', compact('categorys', 'products', 'category_prs', 'headers', 'price', 'brand', 'arrange','total'));
        }
        if ($arrange == 4) {
            $products = Product::where('num_qty', '>', 0)->where('status_id',6)->orderBy('price', 'asc')->paginate(20);
              return view('unimart.product.index', compact('categorys', 'products', 'category_prs', 'headers', 'price', 'brand', 'arrange','total'));
            
        }
        return view('unimart.product.index', compact('categorys', 'products', 'category_prs', 'headers', 'price', 'brand', 'arrange','total'));
    }
    function product_detail(Request $request, $slug)
    {
        $total =  Product::where('status_id', 6)->count();
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $categorys =  CategoryProduct::all();
        $categorys_pr = CategoryProduct::where('parent_id', 0)->get();
        $id = CategoryProduct::where('slug_url', $slug)->first()->id;
        $name = CategoryProduct::where('slug_url', $slug)->first()->name;
        $categorys = CategoryProduct::all();
        $slugs = array();
        foreach ($categorys as $item) {
            $slugs[] = $item['slug_url'];
        }
        //Kiểm tra xem có id thuộc  vào danh sách ko
        if (in_array($slug, $slugs)) {
            // Tìm danh sách theo parent_id
            $list = data_tree($categorys, $id);
            //Tìm danh sách theo id
            $list_parent =  array(CategoryProduct::where('slug_url', $slug)->first());
            //Nhóm lại
            $list_pro = array_merge($list, $list_parent);
        } else {
            // In ra products
            $products = Product::where('category_id', $id)->where('status_id',6)->paginate(10);
        }
        $result = array();
        if (!empty($list_pro))
            //In ra các id thỏa mãn
            foreach ($list_pro as $item) {
                $result[] = (int)$item['id'];
            }
        if (!empty($result))
            //Danh sách của sản phẩm 
            $products = Product::whereIn('category_id', $result)->where('status_id',6)->paginate(10);
        $price = $request->input('price');
        $brand = $request->input('brand');
        if ($brand) {
            $list = data_tree($categorys, $brand);
            //Tìm danh sách theo id
            $list_parent =  array(CategoryProduct::where('id', $brand)->first());
            //Nhóm lại
            $list_pro = array_merge($list, $list_parent);
            $result = array();
            if (!empty($list_pro))
                //In ra các id thỏa mãn
                foreach ($list_pro as $item) {
                    $result[] = (int)$item['id'];
                }
            if (empty($price)) {
                $products = Product::whereIn('category_id', $result)->where('status_id',6)->paginate(10);
            } else {
                if ($price == 1) {
                    $products = Product::whereIn('category_id', $result)->where('price', '<', 500000)->where('status_id',6)->paginate(10);
                }
                if ($price == 2) {
                    $products = Product::whereIn('category_id', $result)->whereBetween('price',  [500000, 1000000])->where('status_id',6)->paginate(10);
                }
                if ($price == 3) {
                    $products = Product::whereIn('category_id', $result)->whereBetween('price',  [1000000, 5000000])->where('status_id',6)->paginate(10);
                }
                if ($price == 4) {
                    $products = Product::whereIn('category_id', $result)->whereBetween('price',  [5000000, 10000000])->where('status_id',6)->paginate(10);
                }
                if ($price == 5) {
                    $products = Product::whereIn('category_id', $result)->where('price', '>', 10000000)->where('status_id',6)->paginate(10);
                }
            }
        } elseif ($price && empty($brand)) {
            if ($price == 1) {
                $products = Product::where('price', '<', 500000)->where('status_id',6)->paginate(10);
            }
            if ($price == 2) {
                $products = Product::whereBetween('price',  [500000, 1000000])->where('status_id',6)->paginate(9);
            }
            if ($price == 3) {
                $products = Product::whereBetween('price',  [1000000, 5000000])->where('status_id',6)->paginate(9);
            }
            if ($price == 4) {
                $products = Product::whereBetween('price',  [5000000, 10000000])->where('status_id',6)->paginate(9);
            }
            if ($price == 5) {
                $products = Product::where('price', '>', 10000000)->where('status_id',6)->paginate(9);
            }
        }

        return view('unimart.product.detail', compact('products', 'categorys', 'headers', 'brand', 'price', 'categorys_pr', 'name','total'));
    }
    function arrange(Request $request)
    {
        $total =  Product::where('status_id', 6)->where('num_qty','>',0)->count();
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $categorys =  CategoryProduct::all();
        $category_prs =  CategoryProduct::where('parent_id', 0)->get();
        $price = $request->input('price');
        $brand = $request->input('brand');
        $request->validate(
            [
                'select_arrange' => 'regex:/^[1-9]+$/',
            ],
            [
                'regex' => 'Vui lòng chọn hình thức sắp xếp',
            ]
        );
        $arrange = $request->input('select_arrange');
      
        if ($arrange == 3) {
            $products = Product::where('num_qty', '>', 0)->where('status_id',6)->orderBy('price', 'desc')->paginate(9);

        }
        if ($arrange == 4) {
            $products = Product::where('num_qty', '>', 0)->where('status_id',6)->orderBy('price', 'asc')->paginate(9);
            
        }
          return view('unimart.product.index', compact('categorys', 'headers', 'products', 'category_prs', 'price', 'brand', 'arrange','total'));
    }
    function detail(Request $request, $slug, $id)
    {
        $product_pauses =  Product::where('num_qty', 0)->get();
        $product_sellings =  Product::where([['selling', '=', 'selling'], ['num_qty', '>', 0],['status_id','=',6]])->get();
        $headers = Page::orderBy('id', 'desc')->get()->where('status_id',6);
        $product = Product::find($id);
        //file_product
        $parent_id = CategoryProduct::where('name', $product->category->name)->first()->parent_id;
        $category_name = CategoryProduct::where('id', $parent_id)->first()->name;
        $products =  Product::where('name', 'LIKE', "%{$category_name}%")->where('status_id',6)->orwhere('name', 'LIKE', "%{$product->category->name}%")->get();
        $name_file = str_replace("public/admin/uploads/product/", '', $product->thumbnail);
        // return $name_file;
        $image = Image::make(public_path('admin/uploads/product/'.$name_file))->resize(700, 700);
        $image->save(public_path('admin/uploads/product/resized/'.$name_file));
        $images  = ImagesProduct::where('product_id', $id)->get();
        if ($images) {
            foreach ($images as $item) {
                $name = $item->name;
                $name_images = str_replace("public/admin/uploads/product/", '',  $name);

                //700
        $imagess = Image::make(public_path('admin/uploads/product/'.$name_images))->resize(700, 700);
        $imagess->save(public_path('admin/uploads/product/resized/'.$name_images));
            }
        }
        //file_image_product

        return view('unimart.product.product_detail', compact('product', 'product_sellings', 'product_pauses', 'headers', 'images', 'name_file', 'category_name', 'products'));
    }
    function post()
    {
        $categorys = Category_Post::all();
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $posts = Post::where('status_id',6)->paginate(10);
        $product_sellings =  Product::where([['selling', '=', 'selling'], ['num_qty', '>', 0],['status_id','=',6]])->get();
        return view('unimart.post.index', compact('posts', 'headers', 'product_sellings','categorys'));
    }
    function cart()
    {
        // return Cart::content();
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        return view('unimart.product.cart', compact('headers'));
    }
    function remove(Request $request)
    {
        $rowId = $request->id_cart;
        Cart::remove($rowId);
    }
    function destroy()
    {
        Cart::destroy();
        return redirect('gio-hang.san-pham.html');
    }
    function add_card_now(Request $request, $id)
    {
        $id = $request->id;
        $product = Product::find($id);
        $searchResults = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        });
        if ($searchResults->isNotEmpty()) {
            $cartItem = $searchResults->first();
            // Lấy Cart Item đầu tiên trong Collection $rowId = $cartItem->qty;
            $qty =  $cartItem->qty + 1;
        } else {
            $qty = 1;
        }
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'code' => $product->code,
            'options' => ['thumbnail' => $product->thumbnail, 'category' => $product->category->name]
        ]);
        return redirect('thanh-toan.san-pham.html')->with('status', 'Sản phẩm đã được thêm vào giỏ hàng đặt mua thành công');
    }
    function add_card(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'code' => $product->code,
            'options' => ['thumbnail' => $product->thumbnail, 'category' => $product->category->name]
        ]);
        $output = "";
        $output .= '
        <p class="desc" id="dest_update">Có <span> ' . Cart::count() . '</span> sản
        phẩm trong giỏ
        hàng</p>
    <ul class="list-cart">';
        foreach (Cart::content() as $item) {
            $output .= '
            <li class="clearfix">
                <a href="http://localhost/Laravel/unimart_laravelpro/gio-hang.san-pham.html" title=""
                    class="thumb fl-left">
                    <img src="http://localhost/Laravel/unimart_laravelpro/' . $item->options->thumbnail . '"
                        alt="">
                </a>
                <div class="info fl-right">
                    <a href="http://localhost/Laravel/unimart_laravelpro/gio-hang.san-pham.html" title=""
                        class="product-name">' . $item->name . '</a>
                    <p class="price"style="color:rgb(187, 41, 15)">
                        ' . number_format($item->price) . 'đ</p>
                    <p class="qty" style="color:black">Số lượng:
                        <span>' . $item->qty . '</span>
                    </p>
                </div>
            </li>';
        }
        $output .= ' </ul>
    <div class="total-price clearfix">
        <p class="title fl-left">Tổng:</p>
        <p class="price fl-right" style="color:rgb(187, 41, 15)">
            ' . Cart::total() . 'đ
        </p>
    </div>
    <div class="action-cart clearfix">
        <a href="http://localhost/Laravel/unimart_laravelpro/gio-hang.san-pham.html" title="Giỏ hàng"
            class="view-cart fl-left">Giỏ hàng</a>
        <a href="http://localhost/Laravel/unimart_laravelpro/thanh-toan.san-pham.html" title="Thanh toán"
            class="checkout fl-right">Thanh
            toán</a>
    </div>';
        $number = Cart::count();
        $data = array(
            'cart' => Cart::content(),
            'number' => $number,
            'output' => $output
        );
        echo json_encode($data);
    }

    function checkout()
    {
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        return view('unimart.product.checkout', compact('headers'));
    }
    function post_detail(Request $request, $slug, $id)
    {
        $categorys =  Category_Post::all();
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $post = Post::find($id);
        $product_sellings =  Product::where([['selling', '=', 'selling'], ['num_qty', '>', 0],['status_id','=',6]])->get();
        return view('unimart.post.detail', compact('post', 'product_sellings', 'headers','categorys'));
    }
    function contact($slug)
    {
        // $slug = Page::find()
        $categorys = Category_Post::all();
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $pages = Page::where('status_id',6)->get();
        foreach ($pages as $item) {
            if ($slug == create_slug($item->name)) {
                $contact  = Page::where('name', $item->name)->first();
            }
        }
        $product_sellings =  Product::where([['selling', '=', 'selling'], ['num_qty', '>', 0],['status_id','=',6]])->get();
        // $contact = 
        return view('unimart.contact', compact('product_sellings', 'contact', 'headers','categorys'));
    }
    function search(Request $request)
    {
        if ($request->text) {
            $products = Product::where('name', 'LIKE', "%{$request->text}%")->where('status_id',6)->get();
        } else {
            $products = Product::where('name', 'LIKE', "+++==")->get();
        }
        $html = "";
        foreach ($products as $v) {
            $html .= '
            <div class="search-ajax-result"
            style="margin-bottom: 3px;padding-bottom:3px; border-bottom:1px solid #333">
            <div class="search-ajax-result">
                <div class="media" style="margin-left:5px;">
                    <a class="pull-left" href="http://localhost/Laravel/unimart_laravelpro/san-pham/' . create_slug($v['name']) . '.' . $v['id'] . '.html' . '">
                        <img class="media-pbject" width="80"
                            src="http://localhost/Laravel/unimart_laravelpro/' . $v['thumbnail'] . '"
                            alt="images" />
                    </a>
                    <div class="media-body" style="padding-left:10px">
                        <h4 class="media-heading"><a href="http://localhost/Laravel/unimart_laravelpro/san-pham/' . create_slug($v['name']) . '.' . $v['id'] . '.html' . '">' . $v['name'] . '</a>
                        </h4>
                        <p><span class="new"> Mã code : ' . $v['code'] . ' </span>
                            <span class="old" style="color:tomato;display:block">' . number_format($v['price']) . 'đ</span></p>
                    </div>
                </div>
            </div>
        </div>';
        };
        $data = array(
            'html' => $html
        );
        echo json_encode($data);
    }
    function addmore(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        $quantity = $request->quantity;
        $searchResults = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        });
        if ($searchResults->isNotEmpty()) {
            $cartItem = $searchResults->first();
            // Lấy Cart Item đầu tiên trong Collection $rowId = $cartItem->qty;
            $qty =  $cartItem->qty + $qty;
            if ($qty > $quantity) {
                $qty = $quantity;
            }
        } else {
            $qty = $request->qty;
        }
        $product = Product::find($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'code' => $product->code,
            'options' => ['thumbnail' => $product->thumbnail, 'category' => $product->category->name]
        ]);
    }
    function checkout_request(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|string|min:2|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => ['required', 'numeric', "regex:/^(09|08|03|01[2|6|8|9])+([0-9]{8,12})$/"],
                'address' => 'required|string|',
                'district_' => 'required|string',
                'note' => 'nullable',
            ],
            [
                'required' => ':attribute không dược để trống',
                'numeric' => 'Phone_number phải là 1 số',
                'max' => ':attrbute có độ dài tối đa :max kí tự',
                'min' => ':attrbute có độ dài tối thiểu :min kí tự',
                'fullname.min' => 'Họ tên có độ dài tối thiểu :min kí tự',
                'number.lte' => ':attribute không được lớn hơn $maxQuantity.',
                'unique' => ':attrbute đã tồn tại trong hệ thống',
                'regex' => 'Số điện thoại không đúng'
            ],
            [
                'fullname' => 'Họ tên',
                'phone' => 'Số điện thoại',
                'district_' => 'Quận huyện',
                'address' => 'Địa chỉ'
            ]
        );
        if (empty($request->input('note'))) {
            $note = "";
        } else {
            $note =  $request->input('note');
        }
        $client =  Client::create([
            'name' => $request->input('fullname'),
            'address' => $request->input('number') . ' Huyện: ' . $request->input('district_') . ' Tỉnh: ' . $request->input('address'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone'),
            'note' => $note,
        ]);
        if ($client) {
            $client_id = Client::where('email', $request->input('email'))->where('created_at', $client->created_at)->first()->id;
        }
        $num = 0;
        if (Cart::content()) {
            foreach (Cart::content() as $item) {
                $num = $num + $item->qty;
            }
            $float = floatval(str_replace(',', '', Cart::total()));
            $order = Order::create([
                'num' => $num,
                'total' => $float,
                'client_id' => $client_id,
                'note' => $note,
                'status_id' => 6,
                'id_status' => 1,
                'code' => "#DH" . $client_id,
                'pay' => $request->input('payment-method'),
            ]);
        }
        if ($order) {
            $order_id =  $order->id;
        }
        foreach (Cart::content() as $item) {
            $product_id = Product::where('name', $item->name)->first()->id;
            $orders =   DetailOrder::create([
                'num' => $item->qty,
                'price' => $item->price,
                'product_id' => $product_id,
                'order_id' => $order_id,

            ]);
        }
        //Gửi mail
        $clientss = Client::find($client_id);
        $created_at = $clientss->created_at;
        $data = [
            // 'count' => $orderss->count(),
            'name' => $clientss->name,
            'address' => $clientss->address,
            'phone_number' => $clientss->phone_number,
            'email' => $clientss->email,
            'note' => $clientss->note,
            'pay' => $request->input('payment-method'),
            'code' => "#DH" . $client_id,
        ];
        if ($request->input('email')) {
            Mail::to($request->input('email'))->send(new SendMail($data));
        }
        return redirect()->route('unimart.success', ['id' => $client_id, 'created_at' => $created_at]);
    }
    function order_success($id, $created_at)
    {
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $orders = Order::where('created_at', $created_at)->where('client_id', $id)->first();
        $order_id = $orders->id;
        $order_detail = DetailOrder::where('order_id', $orders->id)->where('created_at', $created_at)->count();
        $client = Client::find($id);
        return view('unimart.order-success', compact('client', 'orders', 'headers', 'order_detail'));
    }
    function ajax(Request $request)
    {

        $rowId = $request->rowId;
        $qty = $request->qty_;
        $carts = Cart::update($rowId, $qty);
        $cartItem = Cart::get($rowId);
        if ($cartItem) {
            $total_item =  number_format($cartItem->total) . 'đ';
            $num_qty = $cartItem->qty;
        }
        // Tìm thấy sản phẩm trong giỏ hàng
        $total = Cart::total().' Đ';
        $num_total=  Cart::count();
        $data = [
            'carts' => $carts,
            'total' => $total,
            'total_item' => $total_item,
            'num' => $num_qty ,
            'total_num'=> $num_total
        ];

        echo json_encode($data);
    }
    function post_category($slug, $id)
    {
        $headers = Page::orderBy('id', 'desc')->where('status_id',6)->get();
        $categorys =  Category_Post::all();
        $categorys_pr = Category_Post::where('parent_id', 0)->get();
        $id = Category_Post::where('slug_url', $slug)->first()->id;
        $name = Category_Post::where('slug_url', $slug)->first()->name;
        $product_sellings =  Product::where([['selling', '=', 'selling'], ['num_qty', '>', 0]])->get();
        $categorys = Category_Post::all();
        $slugs = array();
        foreach ($categorys as $item) {
            $slugs[] = $item['slug_url'];
        }
        //Kiểm tra xem có id thuộc  vào danh sách ko
        if (in_array($slug, $slugs)) {
            // Tìm danh sách theo parent_id
            $list = data_tree($categorys, $id);
            //Tìm danh sách theo id
            $list_parent =  array(Category_Post::where('slug_url', $slug)->first());
            //Nhóm lại
            $list_pro = array_merge($list, $list_parent);
        } else {
            // In ra products
            $posts = Post::where('category_id', $id)->where('status_id',6)->paginate(10);
        }
        $result = array();
        if (!empty($list_pro))
            //In ra các id thỏa mãn
            foreach ($list_pro as $item) {
                $result[] = (int)$item['id'];
            }
        if (!empty($result))
            //Danh sách của sản phẩm 
            $posts = Post::whereIn('category_id', $result)->where('status_id',6)->paginate(10);
        return view('unimart.post.category', compact('posts', 'headers', 'categorys', 'product_sellings'));
    }
}
