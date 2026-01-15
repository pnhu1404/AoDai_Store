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
    public function create(){
        return view('admin.promotions.create');
    }
    public function edit($id){
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact('promotion'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'TenKhuyenMai' => 'required|string|max:255',
            'MaCode' => 'required|string|max:100|unique:khuyenmai,MaCode',
            'LoaiGiam' => 'required',
            'GiamToiDa' => 'nullable|numeric',
            'GiaTriGiam' => 'required|numeric',
            'DieuKienKhuyenMai' => 'nullable|integer',
            'Soluong' => 'required|integer',
            'NgayBatDau' => 'required|date',
            'NgayKetThuc' => 'required|date|after_or_equal:NgayBatDau',
            'TrangThai' => 'required|boolean',
        ]);
        Promotion::create($data);


        return redirect()->route('promotions.index');
    }
    public function update(Request $request, $id){
        $promotion = Promotion::findOrFail($id);
        $data=$request->validate([
            'TenKhuyenMai' => 'required|string|max:255',
            'MaCode' => 'required|string|max:100|unique:khuyenmai,MaCode,'.$promotion->MaKhuyenMai.',MaKhuyenMai',
            'LoaiGiam' => 'required',
            'GiamToiDa' => 'nullable|numeric',
            'GiaTriGiam' => 'required|numeric',
            'DieuKienKhuyenMai' => 'nullable|integer',
            'Soluong' => 'required|integer',
            'NgayBatDau' => 'required|date',
            'NgayKetThuc' => 'required|date|after_or_equal:NgayBatDau',
            'TrangThai' => 'required|boolean',
        ]);
        $promotion->update($data);
        return redirect()->route('promotions.index');
    }
    public function destroy($id){
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        return redirect()->route('promotions.index');
    }
}
