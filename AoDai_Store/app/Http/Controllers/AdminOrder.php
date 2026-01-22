<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $newStatus = $request->status;
        $currentStatus = $order->TrangThai;

        // Định nghĩa quy tắc: Trạng thái hiện tại => Các trạng thái mới được phép
        $rules = [
            'ChoXacNhan' => ['DaXacNhan', 'DaHuy'],
            'DaXacNhan'  => ['DangGiao', 'DaHuy'],
            'DangGiao'   => ['DaGiao', 'DaHuy'],
            'DaGiao'     => [], // Không được đi đâu hết
            'DaHuy'      => [], // Không được đi đâu hết
        ];

        // Nếu trạng thái mới không nằm trong danh sách được cho phép của trạng thái cũ
        if ($newStatus !== $currentStatus && !in_array($newStatus, $rules[$currentStatus] ?? [])) {
            return back()->with('error', 'Chuyển đổi trạng thái không hợp lệ!');
        }

        $order->update(['TrangThai' => $newStatus]);

        // Thêm logic phụ: Nếu là DaGiao thì cập nhật NgayThanhToan nếu chưa có
        if ($newStatus === 'DaGiao' && !$order->NgayThanhToan) {
            $order->update(['NgayThanhToan' => now()]);
        }

        return back()->with('success', 'Cập nhật trạng thái thành công.');
    }
    public function show($id)
{
    // Lấy thông tin hóa đơn
    $order = Order::where('MaHoaDon', $id)->firstOrFail();
    
    // Lấy chi tiết các sản phẩm trong hóa đơn đó (kèm theo thông tin sản phẩm để lấy ảnh/tên)
    $orderDetails = OrderDetail::where('MaHoaDon', $id)->with('product')->get();

    return view('admin.order.show', compact('order', 'orderDetails'));
}
 public function confirmstatus($id, Request $request)
    {
      //  dd($request->input('status'));
        $status = $request->input('status');
        if($status=='DangGiao'){
            $order =Order::where('MaHoaDon', $id)
            
            ->where('MaTaiKhoan', Auth::id())
            ->where('TrangThai', 'DaXacNhan')
            ->first();
        }
        else if($status=='DaGiao'){
            $order =Order::where('MaHoaDon', $id)
            
            ->where('MaTaiKhoan', Auth::id())
            ->where('TrangThai', 'DangGiao')
            ->first();
        }
        else if($status=='DaHuy'){
             $order =Order::where('MaHoaDon', $id)
            
            ->where('MaTaiKhoan', Auth::id())
            ->whereIn('TrangThai', ['ChoXacNhan','DaXacNhan','DangGiao'])
            ->first();
        }
        else{
        $order =Order::where('MaHoaDon', $id)
            
            ->where('MaTaiKhoan', Auth::id())
            ->where('TrangThai', 'ChoXacNhan')
            ->first();
        }

        if (!$order) {
            return back()->with('error', 'Không thể hủy đơn hàng này.');
        }

        Order::where('MaHoaDon', $id)
            ->update([
                'TrangThai' => '' . $status . ''
            ]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}