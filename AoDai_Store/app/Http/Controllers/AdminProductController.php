<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Material;
use App\Models\Size;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {

        $query = Product::with('chatlieu');
        $query->withSum('sizes as tong_so_luong', 'sanpham_size.SoLuong');
        if ($request->filled('search')) {
            $query->where('TenSanPham', 'like', '%' . $request->search . '%')
                ->orWhere('MaSanPham', 'like', '%' . $request->search . '%');
            $query->whereHas('chatlieu', function ($q) use ($request) {
                $q->where('TenChatLieu', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('CreatedDate', 'desc')->get();
        $totalProducts = Product::count();

        return view('admin.products.index', compact('products', 'totalProducts'));
    }


    public function create()
    {

        return view('admin.products.create', [
            'materials' => Material::all(),
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
            'colors' => Color::all(),
            'sizes' => Size::all()
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'TenSanPham' => 'required|string|max:255',
            'MoTa' => 'required|string',
            'HinhAnh' => 'nullable|image',
            'GiaBan' => 'required|numeric',
            'MaLoaiSP' => 'required|exists:loaisanpham,MaLoaiSP',
            'MaChatLieu' => 'required|exists:chatlieu,MaChatLieu',
            'MaNCC' => 'required|exists:nhacungcap,MaNCC',
            'MaLoaiMau' => 'required|exists:loaimau,MaLoaiMau',
            'sizes' => 'required|array',
            'sizes.*' => 'integer|min:0'
        ]);

        $imagePath = null;
        if ($request->hasFile('HinhAnh')) {
            $imagePath = $request->file('HinhAnh')->store('products', 'public');
        }

        $product = Product::create([
            'TenSanPham' => $request->TenSanPham,
            'GiaBan' => $request->GiaBan,
            'MaLoaiSP' => $request->MaLoaiSP,
            'MaChatLieu' => $request->MaChatLieu,
            'MaNCC' => $request->MaNCC,
            'MaLoaiMau' => $request->MaLoaiMau,
            'HinhAnh' => $imagePath,
            'TrangThai' => 1,
            'MoTa' => $request->MoTa,
            'CreatedDate' => now(),
        ]);

        foreach ($request->sizes as $sizeId => $soLuong) {
            if ($soLuong > 0) {
                $product->sizes()->attach($sizeId, [
                    'SoLuong' => $soLuong
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm áo dài thành công');
    }


    public function edit($MaSanPham)
    {

        $product = Product::findOrFail($MaSanPham);
        $materials = Material::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.edit', compact('product', 'materials', 'categories', 'suppliers', 'colors', 'sizes'));
    }


    public function update(Request $request, $MaSanPham)
    {

        $product = Product::findOrFail($MaSanPham);
        $request->validate([
            'TenSanPham' => 'required|string|max:255',
            'MoTa' => 'required|string',
            'HinhAnh' => 'nullable|image',
            'GiaBan' => 'required|numeric',
            'MaLoaiSP' => 'required|exists:loaisanpham,MaLoaiSP',
            'MaChatLieu' => 'required|exists:chatlieu,MaChatLieu',
            'MaNCC' => 'required|exists:nhacungcap,MaNCC',
            'MaLoaiMau' => 'required|exists:loaimau,MaLoaiMau',
            'sizes' => 'required|array',
            'sizes.*' => 'integer|min:0'
        ]);

        $data = [
            'TenSanPham' => $request->TenSanPham,
            'GiaBan' => $request->GiaBan,
            'MaLoaiSP' => $request->MaLoaiSP,
            'MaChatLieu' => $request->MaChatLieu,
            'MaNCC' => $request->MaNCC,
            'MaLoaiMau' => $request->MaLoaiMau,
            'TrangThai' => 1,
            'MoTa' => $request->MoTa,

        ];

        if ($request->hasFile('HinhAnh')) {
            $data['HinhAnh'] = $request->file('HinhAnh')->store('products', 'public');
        }

        $product->update($data);

        $syncData = [];
        foreach($request->sizes as $sizeId  => $soluong) {
            if($soluong > 0) {
                $syncData[$sizeId] = [
                    'SoLuong' => $soluong
                ];
            }
        }
        $product->sizes()->sync($syncData);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật áo dài thành công');
    }


    public function destroy($MaSanPham)
    {

        Product::findOrFail($MaSanPham)->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa áo dài thành công');
    }
}
