<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Material;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        $query = Product::with('chatlieu');
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

    // Form thêm áo dài
    public function create()
    {
        return view('admin.products.create');
    }

    // Lưu áo dài mới
    public function store(Request $request)
    {
        $request->validate([
            'TenSanPham' => 'required|string|max:255',
            'GiaBan' => 'required|numeric',
            'HinhAnh' => 'nullable|image'
        ]);

        $imagePath = null;
        if ($request->hasFile('HinhAnh')) {
            $imagePath = $request->file('HinhAnh')->store('products', 'public');
        }

        Product::create([
            'TenSanPham' => $request->TenSanPham,
            'GiaBan' => $request->GiaBan,
            'MaChatLieu' => $request->MaChatLieu,
            'HinhAnh' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm áo dài thành công');
    }

    // Form sửa áo dài
    public function edit($MaSanPham)
    {
        $product = Product::findOrFail($MaSanPham);
        $materials = Material::all();
        return view('admin.products.edit', compact('product', 'materials'));
    }

    // Cập nhật áo dài
    public function update(Request $request, $MaSanPham)
    {
        $product = Product::findOrFail($MaSanPham);

        $request->validate([
        'TenSanPham' => 'required|string|max:255',
        'GiaBan'     => 'required|numeric',
        'MaChatLieu' => 'required|exists:chatlieu,MaChatLieu',
        'HinhAnh'    => 'nullable|image',
        ]);

        $data = [
        'TenSanPham' => $request->TenSanPham,
        'GiaBan'     => $request->GiaBan,
        'MaChatLieu' => $request->MaChatLieu,
        ];

        if ($request->hasFile('HinhAnh')) {
        $data['HinhAnh'] = $request->file('HinhAnh')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
        ->with('success', 'Cập nhật áo dài thành công');
    }

    // Xóa áo dài
    public function destroy($MaSanPham)
    {
        Product::findOrFail($MaSanPham)->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa áo dài thành công');
    }
}
