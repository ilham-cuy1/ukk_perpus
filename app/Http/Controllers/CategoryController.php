<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->keyword;

        $categories = Category::latest()->where('name', 'LIKE', '%'.$keyword.'%')->paginate(10);
        $userWithRoles = User::with(['role'])->get();
        return view('kategori', ['categories' => $categories, 'userWithRoles' => $userWithRoles]);
    }

    public function addData() {
        $userWithRoles = User::with(['role'])->get();
        return view('tambah_kategori', ['userWithRoles' => $userWithRoles]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:100',
        ],[
            'name.required' => 'Nama Kategori wajib diisi.',
            'name.unique' => 'Kategori sudah ada.',
            'name.max' => 'Maksimal panjangnya 100 karakter.',
        ]); 

        $category = Category::create($request->all());
        return redirect('categories')->with('success', 'Kategori Berhasil Ditambahkan');
    }

    public function edit($slug) {
        $category = Category::where('slug', $slug)->first();
        $userWithRoles = User::with(['role'])->get();
        return view('edit_kategori', ['category' => $category, 'userWithRoles' => $userWithRoles]);   
    }

    public function update(Request $request, $slug) {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:100',
        ],[
            'name.required' => 'Nama Kategori wajib diisi.',
            'name.unique' => 'Kategori sudah ada.',
            'name.max' => 'Maksimal panjangnya 100 karakter.',
        ]); 

        $category = Category::where('slug', $slug)->first();
        $category->slug = null;
        $category->update($request->all());
        return redirect('categories')->with('success', 'Kategori Berhasil Diedit');

    }

    public function delete($slug) {
        $category = Category::where('slug', $slug)->first();
        $category->delete();

        return redirect('categories')->with('success', 'Data Kategori Berhasil Dihapus');
    }
}
