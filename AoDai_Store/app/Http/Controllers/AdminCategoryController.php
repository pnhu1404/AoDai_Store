<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $query->where('TenLoaiSP', 'like', '%' . $request->search . '%')
                  ->orWhere('MaLoaiSP', $request->search);
        }

        $categories = $query->orderBy('CreatedDate', 'desc')->get();
        $totalCategories = Category::count();

        return view('admin.categories.index', compact(  'categories', 'totalCategories'
        ));
    }
}
