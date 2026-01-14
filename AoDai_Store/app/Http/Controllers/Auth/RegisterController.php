<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|unique:taikhoan,TenDangNhap',
            'MatKhau'     => 'required|min:6|confirmed',
            'HoTen'       => 'required',
            'Email'       => 'required|email|unique:taikhoan,Email',
        ], [
            'TenDangNhap.unique' => 'Tên đăng nhập đã tồn tại.',
            'MatKhau.confirmed'  => 'Mật khẩu xác nhận không khớp.',
            'Email.unique'       => 'Email này đã được sử dụng.',
        ]);

        Account::create([
            'TenDangNhap' => $request->TenDangNhap,
            'MatKhau'     => Hash::make($request->MatKhau), 
            'HoTen'       => $request->HoTen,
            'Email'       => $request->Email,
            'SDT'         => $request->SoDienThoai,
            'DiaChi'      => $request->DiaChi,
            'Role'        => 'User', 
            'TrangThai'   => 1,
            'CreatedDate' => now(),
        ]);

        return redirect('/login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}
