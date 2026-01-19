<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\User;
use Illuminate\Http\Request;

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
        $data["colors"] = Color::all();

         $data['bestSellers'] = Product::orderBy('CreatedDate', 'desc')
        ->take(8)
        ->get();

        $data['newProducts'] = Product::orderBy('CreatedDate', 'desc')
            ->take(8)
            ->get();

        $data['categories'] = Category::with(['sanpham' => function ($q) {
            $q->take(4);
        }])->take(4)->get();

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

        $allSizes = Size::where('TrangThai', 1)->get();

        return view('client.products.detail', compact('product', 'allSizes'));
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
    public function productList()
    {
        $categories = Category::all();

        $products = Product::with(['chatlieu', 'loaisanpham'])
                        ->paginate(8);

        return view('client.products.index', compact('categories', 'products'));
    }

}
