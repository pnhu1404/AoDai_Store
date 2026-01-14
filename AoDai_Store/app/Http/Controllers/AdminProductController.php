<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Material;
use App\Models\Size;
use App\Models\Supplier;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['chatlieu', 'loaisanpham']);
        $categories = Category::all();

        $query->withSum('sizes as tong_so_luong', 'sanpham_size.SoLuong');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('TenSanPham', 'like', '%' . $search . '%')
                    ->orWhere('MaSanPham', 'like', '%' . $search . '%')
                    ->orWhereHas('chatlieu', function ($sub) use ($search) {
                        $sub->where('TenChatLieu', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where('MaLoaiSP', $request->category);
        }

        $products = $query->orderBy('CreatedDate', 'desc')->paginate(10);
        $products->appends($request->all());
        $totalProducts = Product::count();

        return view('admin.products.index', compact('products', 'totalProducts', 'categories'));
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
            'HinhAnh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'AlbumHinh.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'GiaBan' => 'required|numeric',
            'MaLoaiSP' => 'required|exists:loaisanpham,MaLoaiSP',
            'MaChatLieu' => 'required|exists:chatlieu,MaChatLieu',
            'MaNCC' => 'required|exists:nhacungcap,MaNCC',
            'MaLoaiMau' => 'required|exists:loaimau,MaLoaiMau',
            'sizes' => 'required|array',
            'sizes.*' => 'integer|min:0'
        ]);

        $fileNameMain = null;
        if ($request->hasFile('HinhAnh')) {
            $file = $request->file('HinhAnh');
            $fileNameMain = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/products'), $fileNameMain);
        }

        $product = Product::create([
            'TenSanPham' => $request->TenSanPham,
            'GiaBan' => $request->GiaBan,
            'MaLoaiSP' => $request->MaLoaiSP,
            'MaChatLieu' => $request->MaChatLieu,
            'MaNCC' => $request->MaNCC,
            'MaLoaiMau' => $request->MaLoaiMau,
            'HinhAnh' => $fileNameMain,
            'TrangThai' => 1,
            'MoTa' => $request->MoTa,
            'CreatedDate' => now(),
        ]);

        if ($request->hasFile('AlbumHinh')) {
            foreach ($request->file('AlbumHinh') as $file) {
                $fileNameSub = time() . '_album_' . $file->getClientOriginalName();
                $file->move(public_path('img/products'), $fileNameSub);

                // Lưu vào CSDL theo cấu trúc bảng của bạn (MaSanPham, TenHinh)
                ProductImage::create([
                    'MaSanPham' => $product->MaSanPham,
                    'TenHinh' => $fileNameSub,
                ]);
            }
        }

        // 5. Lưu kích thước và số lượng
        foreach ($request->sizes as $sizeId => $soLuong) {
            if ($soLuong > 0) {
                $product->sizes()->attach($sizeId, [
                    'SoLuong' => $soLuong
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm áo dài và ảnh thành công');
    }
    public function edit($MaSanPham)
    {
        $product = Product::with('hinhanhsanpham')->where('MaSanPham', $MaSanPham)->firstOrFail();
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
            'HinhAnh' => 'nullable|image|max:2048',
            'replace_images.*' => 'nullable|image|max:2048',
            'AlbumHinh.*' => 'nullable|image|max:2048',
            'GiaBan' => 'required|numeric',
            'MaLoaiSP' => 'required|exists:loaisanpham,MaLoaiSP',
            'MaChatLieu' => 'required|exists:chatlieu,MaChatLieu',
            'MaNCC' => 'required|exists:nhacungcap,MaNCC',
            'MaLoaiMau' => 'required|exists:loaimau,MaLoaiMau',
            'sizes' => 'required|array',
            'sizes.*' => 'integer|min:0'
        ]);

        $data = $request->only([
            'TenSanPham',
            'GiaBan',
            'MaLoaiSP',
            'MaChatLieu',
            'MaNCC',
            'MaLoaiMau',
            'MoTa'
        ]);
        $data['TrangThai'] = $request->TrangThai ?? 1;

        if ($request->hasFile('HinhAnh')) {
            if ($product->HinhAnh && file_exists(public_path('img/products/' . $product->HinhAnh))) {
                unlink(public_path('img/products/' . $product->HinhAnh));
            }

            $file = $request->file('HinhAnh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/products'), $fileName);
            $data['HinhAnh'] = $fileName;
        }

        $product->update($data);

        // Xử lý Album ảnh chi tiết (Quan hệ: hinhanhsanpham)

        // THAY THẾ ảnh cũ bằng ảnh mới
        if ($request->hasFile('replace_images')) {
            foreach ($request->file('replace_images') as $id => $file) {
                $imageRecord = ProductImage::find($id);
                if ($imageRecord) {
                    // Xóa file cũ 
                    if (file_exists(public_path('img/products/' . $imageRecord->TenHinh))) {
                        unlink(public_path('img/products/' . $imageRecord->TenHinh));
                    }
                    // Lưu file mới
                    $newFileName = time() . '_replaced_' . $file->getClientOriginalName();
                    $file->move(public_path('img/products'), $newFileName);
                    $imageRecord->update(['TenHinh' => $newFileName]);
                }
            }
        }

        // XÓA ảnh nếu người dùng tích chọn
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $id) {
                $imageRecord = ProductImage::find($id);
                if ($imageRecord) {
                    $filePath = public_path('img/products/' . $imageRecord->TenHinh);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $imageRecord->delete();
                }
            }
        }

        // THÊM ẢNH MỚI hoàn toàn vào album
        if ($request->hasFile('AlbumHinh')) {
            foreach ($request->file('AlbumHinh') as $file) {
                $fileNameAdd = time() . '_album_' . $file->getClientOriginalName();
                $file->move(public_path('img/products'), $fileNameAdd);

                ProductImage::create([
                    'MaSanPham' => $product->MaSanPham,
                    'TenHinh' => $fileNameAdd
                ]);
            }
        }

        $syncData = [];
        foreach ($request->sizes as $sizeId => $soluong) {
            $syncData[$sizeId] = ['SoLuong' => $soluong];
        }
        $product->sizes()->sync($syncData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm và album ảnh thành công');
    }
    public function destroy($MaSanPham)
    {
        Product::findOrFail($MaSanPham)->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa áo dài thành công');
    }
}
