<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->keyword;

        $books = Book::latest()->where('title', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('book_code', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('pengarang', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('penerbit', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('tahun_terbit', 'LIKE', '%'.$keyword.'%')
                            ->orWhereHas('categories', function($query) use ($keyword) {
                                $query->where('name', 'LIKE', '%'.$keyword.'%');
                            })->paginate(10);
        $userWithRoles = User::with(['role'])->get();

        return view('buku', ['books' => $books, 'userWithRoles' => $userWithRoles]);
    }

    public function exportPdf() {
        $books = Book::all();
        // return view('pdf.export_data_buku', ['books' => $books]);
        $pdf = Pdf::loadView('pdf.export_data_buku', ['books' => $books]);
        return $pdf->download('Export_data_buku_'.Carbon::now()->timestamp.'.pdf');
    }

    public function printLaporan() {
        $books = Book::all();
        return view('print.print_laporan_buku', ['books' => $books]);
    }

    public function addData() {
        $categories = Category::all();
        $userWithRoles = User::with(['role'])->get();
        return view('tambah_buku', ['categories' => $categories, 'userWithRoles' => $userWithRoles]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'book_code' => 'required|unique:books|max:255',
            'title' => 'required|max:255',
            'stock' => 'required|max:255',
            'pengarang' => 'max:255',
            'penerbit' => 'max:255',
            'tahun_terbit' => 'max:4',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'sinopsis' => 'nullable|min:8',

        ], [
            'book_code.required' => 'Kode Buku wajib diisi.',
            'book_code.unique' => 'Kode Buku sudah ada.',
            'title.required' => 'Judul Buku wajib diisi.',
            'stock.required' => 'Stok Buku wajib diisi.',
            'tahun_terbit.max' => 'Maksimal panjangnya 4 karakter',
        ]); 
        
        $newName = '';
        if($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = Str::random(10).'-'.now()->timestamp.'.'.$extension;
            $request->file('image')->storeAs('cover', $newName);
        }

        $request['cover'] = $newName;
        $book = Book::create($request->all());
        $book->categories()->sync($request->categories);
        return redirect('books')->with('success', 'Buku Berhasil Ditambahkan');
    } 

    public function edit($slug) {
        $book = Book::where('slug', $slug)->first();
        $categories = Category::all();
        $userWithRoles = User::with(['role'])->get();
        return view('edit_buku', ['categories' => $categories, 'book' => $book, 'userWithRoles' => $userWithRoles]);
    }

    public function update(Request $request, $slug) {
        $validated = $request->validate([
            'book_code' => 'required|max:255',
            'title' => 'required|max:255',
            'stock' => 'required|max:255',
            'pengarang' => 'max:255',
            'penerbit' => 'max:255',
            'tahun_terbit' => 'max:4',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'sinopsis' => 'nullable|min:8',

        ], [
            'book_code.required' => 'Kode Buku wajib diisi.',
            'book_code.unique' => 'Kode Buku sudah ada.',
            'title.required' => 'Judul Buku wajib diisi.',
            'stock.required' => 'Stok Buku wajib diisi.',
            'tahun_terbit.max' => 'Maksimal panjangnya 4 karakter.',
        ]); 

        if($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = Str::random(10).'-'.now()->timestamp.'.'.$extension;
            $request->file('image')->storeAs('cover', $newName);
            $request['cover'] = $newName;
        }

        $book = Book::where('slug', $slug)->first();
        $book->slug = null;
        $book->update($request->all());

        if($request->categories) {
            $book->categories()->sync($request->categories);
        }

        return redirect('books')->with('success', 'Buku Berhasil Diedit');
    }

    public function destroy($slug) {
        $deleteBook = Book::where('slug', $slug)->first();
        $deleteBook->delete();

        return redirect('books')->with('success', 'Buku Berhasil Dihapus');
    }

    public function show($slug) {
        $books = Book::where('slug', $slug)->first();

        return view('detail_buku', ['books' => $books]);
    }

    
}
