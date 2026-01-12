<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrder extends Controller
{
    //
    public function index(){
        $orders = Order::paginate(10);
        $monthlyRevenue = Order::whereMonth('NgayTao', now()->month)
                            ->whereYear('NgayTao', now()->year)
                            ->where('TrangThai', 'DaGiao') // Quan trọng: Chỉ tính đơn thành công
                            ->sum('TongTien');
        return view('admin.order.index', compact('orders', 'monthlyRevenue'));
    }
    
}
