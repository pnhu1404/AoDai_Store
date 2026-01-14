<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class Adminpromotion extends Controller
{
    //
    public function index(){
        $promotions = Promotion::paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }
}
