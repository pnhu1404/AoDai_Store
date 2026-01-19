<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('chatlieu');

        if ($request->filled('search')) {
            $query->where('TenSanPham', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('MaLoaiSP', $request->category);
        }

        if ($request->filled('color')) {
            $query->where('MaLoaiMau', $request->color);
        }

        if ($request->sort == 'price_asc') {
            $query->orderBy('GiaBan', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('GiaBan', 'desc');
        } else {
            $query->orderBy('CreatedDate', 'desc');
        }

        $data["product"] = $query->paginate(8);
        $data["categories"] = Category::all();
        $data["colors"] = Color::all();

        // XỬ LÝ AJAX
        if ($request->ajax()) {
            $view = view('client.home', compact('data'));
            $sections = $view->getFactory()->make('client.home', compact('data'))->renderSections();

            return response()->json([
                'html' => $sections['product_list']
            ]);
        }

        return view('client.home', compact('data'));
    }

    public function detail($id)
    {
        $product = Product::with([
            'loaisanpham',
            'chatlieu',
            'loaimau',
            'sizes',
            'hinhanhsanpham'
        ])->where('MaSanPham', $id)->firstOrFail();
          // TĂNG LƯỢT XEM
        $product->increment('LuotXem');
        $allSizes = Size::where('TrangThai', 1)->get();
        
        // ĐIỂM ĐÁNH GIÁ TRUNG BÌNH (17)
    $avgRating = DB::table('danhgia')
        ->where('MaSanPham', $product->MaSanPham)
        ->where('TrangThai', 1)
        ->avg('SoSao');

    // DANH SÁCH ĐÁNH GIÁ (12)
    $dsDanhGia = DB::table('danhgia')
        ->join('taikhoan', 'danhgia.MaTaiKhoan', '=', 'taikhoan.MaTaiKhoan')
        ->where('danhgia.MaSanPham', $product->MaSanPham)
        ->where('danhgia.TrangThai', 1)
        ->orderByDesc('NgayDanhGia')
        ->select(
            'danhgia.*',
            'taikhoan.TenDangNhap'
        )
        ->get();

    // CHECK ĐÃ MUA CHƯA (16)
    $daMua = false;
    if (auth()->check()) {
        $daMua = DB::table('hoadon')
            ->join('chitiethoadon', 'hoadon.MaHoaDon', '=', 'chitiethoadon.MaHoaDon')
            ->where('hoadon.MaTaiKhoan', auth()->id())
            ->where('chitiethoadon.MaSanPham', $product->MaSanPham)
            ->where('hoadon.TrangThai', 'HoanThanh')
            ->exists();
    }

    // (TUỲ CHỌN) LƯỢT YÊU THÍCH (17)
    $soLuotThich = DB::table('yeuthich')
        ->where('MaSanPham', $product->MaSanPham)
        ->count();
    $isFavorite = false;

    if (Auth::check()) {
    $isFavorite = DB::table('yeuthich')
        ->where('MaTaiKhoan', Auth::id())
        ->where('MaSanPham', $product->MaSanPham)
        ->exists();
    }
    return view('client.products.detail', compact(
        'product',
        'allSizes',
        'avgRating',
        'dsDanhGia',
        'daMua',
        'soLuotThich',
        'isFavorite'
    ));
}
    
    public function showByCategory(Request $request, $id)
    {
        $category = Category::where('MaLoaiSP', $id)->firstOrFail();
        $products = Product::with('chatlieu')->where('MaLoaiSP', $id)->paginate(8);

        return view('client.products.showByCategory', compact('category', 'products'));
    }
    public function category(Request $request)
    {
        $categories = Category::all();
        $query = Product::with(['chatlieu', 'loaisanpham']);

        if ($request->filled('category')) {
            $query->where('MaLoaiSP', $request->category);
        }

        $products = $query->paginate(8);

        return view('client.products.category', compact('categories', 'products'));
    }
}
