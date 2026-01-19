<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Promotion;
class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalAccounts = Account::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalPromotions = Promotion::count();

        return view('admin.dashboard', compact('totalAccounts', 'totalOrders', 'totalProducts', 'totalCategories', 'totalSuppliers', 'totalPromotions'));
    }
    
}
