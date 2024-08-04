<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Client;
use App\DetailOrder;
use App\StatusOrder;

class AdminOrderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $cout_all =  Order::count();
        $count_success = Order::where('id_status', 3)->count();
        $count_canceled = Order::where('id_status', 2)->count();
        $count_transporting = Order::where('id_status', 1)->count();
        $count = [$cout_all, $count_success,  $count_canceled, $count_transporting];
        $status = [
            'success' => 'Thành công',
            'canceled' => 'Đang hủy',
            'transporting' => 'Đang xử lí',
            'delete' => 'Xóa',
        ];
        if ($request->input('status') == 'cancel') {
            $orders = Order::where('status_id', 6)->where('id_status', 2)->paginate(10);
        } elseif ($request->input('status') == 'processing') {
            $orders = Order::where('status_id', 6)->where('id_status', 1)->paginate(10);
        } elseif ($request->input('status') == 'successs') {
            $orders = Order::where('status_id', 6)->where('id_status', 3)->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $clients = Client::where('name', 'LIKE', "%$keyword%")->get();
            if ($clients->count() > 0) {
                foreach ($clients as $k => $value) {
                    $client_id[$k] = $value->id;
                }
                // return $user_id;
                // ->orderBy(Product::raw("CASE WHEN poster_id = $id THEN 0 ELSE 1 END"), 'asc')->orderBy('id', 'desc')
                $orders = Order::where('code', 'LIKE', "%$keyword%")->orwhereIn('client_id', $client_id)->paginate(10);
                return view('admin.order.list', compact('orders', 'count', 'status'));
            }
            $orders = Order::where('code', 'LIKE', "%$keyword%")->orwhere('num', 'LIKE', "%$keyword%")->orderBy('id', 'desc')->paginate(10);
        }
        return view('admin.order.list', compact('orders', 'count', 'status'));
    }
    function request(Request $request)
    {
        $list_check = $request->input('list_id');
        $act = $request->input('select_status');
        // Code xử lý khi form được submit

        if ($list_check) {
            if ($act == 'delete') {
                Order::destroy($list_check);
                return redirect('admin/order/list')->with('status', 'Bạn đã chuyển page vào thùng rác thành công');
            } elseif ($act == 'success') {
                Order::whereIn('id', $list_check)->update(['id_status' => 3]);
                return redirect('admin/order/list')->with('status', 'Trạng thái thành công');
            } elseif ($act == 'canceled') {
                Order::whereIn('id', $list_check)->update(['id_status' => 2]);
                return redirect('admin/order/list')->with('status', 'Trạng thái hàng hủy');
            } elseif ($act == 'transporting') {
                Order::whereIn('id', $list_check)->update(['id_status' => 1]);
                return redirect('admin/order/list')->with('status', 'Trạng thái đang vận chuyển');
            } else {
                return redirect('admin/order/list')->with('warning', 'Bạn chưa chọn hành động cần thực thi');
            }
        } else {
            return redirect('admin/order/list')->with('warning', 'Vui lòng chọn phần tử cần thực thi');
        }
    }
    function detail($id)
    {
        $order = DetailOrder::where('order_id', $id)->get();
        $orders = Order::find($id);
        $status = StatusOrder::all();
        return view('admin.order.detail', compact('order', 'orders', 'status'));
    }
    function status(Request $request, $id)
    {
        $status = $request->input('select-status');
        $orders = Order::where('id', $id)->update([
            'id_status' =>  $request->input('select-status'),
        ]);
        return redirect('admin/order/list')->with('status', 'Cập nhật trạng thái đơn hàng thành công');
    }
    function ajax(Request $request)
    {
        $id = $request->id;
        Order::find($id)->delete();
    }
    function delete(Request $request)
    {
        $id = $request->id;
        Order::find($id)->delete();
    }
}
