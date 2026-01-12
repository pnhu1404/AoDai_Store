<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {

        $query = Category::withCount('sanpham');

        if ($request->filled('search')) {
            $query->where('TenLoaiSP', 'like', '%' . $request->search . '%')
                ->orWhere('MaLoaiSP', $request->search);
        }

        $categories = $query->orderBy('CreatedDate', 'desc')->get();
        $totalCategories = Category::count();

        return view('admin.categories.index', compact('categories', 'totalCategories'));
    }
    public function create()
    {

        return view('admin.categories.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'TenLoaiSP' => 'required|string|max:255',
            'MoTa' => 'required|string',
        ]);

        Category::create([
            'TenLoaiSP' => $request->TenLoaiSP,
            'MoTa' => $request->MoTa,
            'TrangThai' => 1,
            'CreatedDate' => now(),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công');
    }

    public function destroy($MaLoaiSP) {

        $category = Category::findOrFail($MaLoaiSP);
        $productCount = Product::where('MaLoaiSP', $MaLoaiSP)->count();

        if($productCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa! Danh mục tồn tại sản phẩm'
            ]);
        } 

        $category->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Xóa thành công!'
        ]);
    }
}
