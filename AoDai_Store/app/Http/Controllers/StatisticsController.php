<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class StatisticsController extends Controller
{
        public function index(Request $request)
    {
        // Lấy ngày lọc từ request
        $tuNgay  = $request->tu_ngay;
        $denNgay = $request->den_ngay;

        // Query gốc: chỉ lấy đơn đã giao
        $baseQuery = DB::table('hoadon')
            ->where('TrangThai', 'DaGiao');

        // Áp dụng lọc theo khoảng ngày nếu có
        if ($tuNgay && $denNgay) {
            $baseQuery->whereBetween('NgayTao', [
                $tuNgay . ' 00:00:00',
                $denNgay . ' 23:59:59'
            ]);
        }

        // Tổng doanh thu
        $tongDoanhThu = (clone $baseQuery)->sum('TongTien');

        // Số lượt mua (số đơn)
        $soLuotMua = (clone $baseQuery)->count();
        // lượt mua theo tháng
        $luotMuaTheoThang = DB::table('hoadon')
        ->selectRaw('MONTH(NgayTao) as thang, COUNT(*) as so_luot_mua')
        ->where('TrangThai', 'DaGiao')
        ->whereYear('NgayTao', date('Y'))
        ->groupBy('thang')
        ->orderBy('thang')
        ->get();

        // Doanh thu theo tháng (năm hiện tại)
        $doanhThuTheoThang = DB::table('hoadon')
            ->selectRaw('MONTH(NgayTao) as thang, SUM(TongTien) as tong_tien')
            ->where('TrangThai', 'DaGiao')
            ->whereYear('NgayTao', date('Y'))
            ->groupBy('thang')
            ->orderBy('thang')
            ->get();

        return view('admin.statistics.index', compact(
  'tongDoanhThu',
 'soLuotMua',
            'doanhThuTheoThang',
            'luotMuaTheoThang',
            'tuNgay',
            'denNgay'
            ));
    }
}


