<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\StatusOrder;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    //
    function index()
    {
        $count_sucess = Order::where('id_status', 3)->count();
        $count_cannel = Order::where('id_status', 2)->count();
        $count_tranpost = Order::where('id_status', 1)->count();
        $total =  Order::where('id_status', 3)->sum('total');
        $count = [$count_sucess, $count_cannel, $count_tranpost];
        $orders = Order::where('status_id', 6)->orderBy('id', 'DESC')->paginate();
        return view('admin.dashboard', compact('orders', 'count', 'total'));
    }
}
