<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index() 
    {
        $data["product"]= Product::all();

        return view('client.home')->with('data',$data);
    }
   public function detail($id)
{
    // Nạp sản phẩm cùng các quan hệ liên quan để tối ưu truy vấn
    $product = Product::with(['loaisanpham', 'chatlieu', 'loaimau', 'sizes'])
                      ->where('MaSanPham', $id)
                      ->firstOrFail();
    $allSizes = Size::where('TrangThai', 1)->get();
    return view('client.products.detail', compact('product', 'allSizes'));
}
}
