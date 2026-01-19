<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|string',
            'MatKhau' => 'required|string',
        ]);

        // Lấy user theo TenDangNhap và TrangThai
        $user = Account::where('TenDangNhap', $request->TenDangNhap)
                        ->where('TrangThai', 1)
                        ->first();

        if (!$user) {
            return back()->withErrors([
                'TenDangNhap' => 'Tên đăng nhập hoặc mật khẩu sai / tài khoản không hoạt động',
            ]);
        }

        $credentials = [
            'TenDangNhap' => $request->TenDangNhap,
            'password' => $request->MatKhau, // Laravel sẽ tự check hash
        ];
         
          $cartController = new CartController();
         
            $oldSessionId = session()->getId();
        if (Auth::attempt($credentials)) {
             
             
            $request->session()->regenerate();
             $cartController->mergeCartAfterLogin($oldSessionId);
             $user = Auth::user();
            if($user->Role == 'Admin'){
                return redirect()->intended('admin.dashboard');
            } elseif ($user->Role == 'User') {
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'TenDangNhap' => 'Tên đăng nhập hoặc mật khẩu sai',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
