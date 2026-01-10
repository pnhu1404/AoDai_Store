<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class CartController extends Controller
{
    //


public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $quantity = $request->input('SoLuong', 1);
    $size = $request->input('MaSize', null); // Lấy kích thước nếu có
    if (Auth::check()) {
        // Người dùng đã đăng nhập
        $cartItem = Cart::where('MaSanPham', $id)
            ->where('MaTaiKhoan', Auth::id())
            ->first();
        if ($cartItem) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
            $cartItem->SoLuong += $quantity;
            $cartItem->save();
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            Cart::create([
                'MaSanPham' => $id,
                'MaSize' => $size,
                'MaTaiKhoan' => Auth::id(),
                'SoLuong' => $quantity,
            ]);
        }
    } else {
        // Người dùng chưa đăng nhập, sử dụng SessionID
        $sessionId = session()->getId();
        $cartItem = Cart::where('MaSanPham', $id)
            ->where('SessionID', $sessionId)
            ->first();
        

        if ($cartItem) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
            $cartItem->increment('SoLuong', $quantity);


            // dd($cartItem);
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            Cart::create([
                'MaSanPham' => $id,
                'MaSize' => $size,
                'SessionID' => $sessionId,
                'SoLuong' => $quantity,
            ]);
        }
    }
    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
}

    public function removeFromCart($id){
        if(Auth::check()){
            Cart::where('MaSanpham',$id)
                ->where('MaTaiKhoan',Auth::id())
                ->delete();
        }
        else{
            $sessionId=session()->getId();
            Cart::where('MaSanPham',$id)
                ->where('SessionID',$sessionId)
                ->delete();
        }
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }
    public function viewCart()
    {
        // Fetch cart items from database or session
        if(Auth::check()){

            $cartItems = Cart::with('sanpham')
            ->where('MaTaiKhoan', Auth::id())->get();
        }
        else{
            $sessionId=session()->getId();
            $cartItems=Cart::with('sanpham')->where('SessionID', $sessionId)->get();
        }
        $totalPrice = $cartItems->sum(function($item) {
        // Kiểm tra nếu sản phẩm tồn tại để tránh lỗi null
        return $item->sanpham ? ($item->sanpham->GiaBan * $item->SoLuong) : 0;
    });
        return view('client.cart.index', compact('cartItems', 'totalPrice'));
    }
}
