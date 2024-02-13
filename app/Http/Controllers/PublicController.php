<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {

        $q = Book::query();

        if ($request->category) {
            $q->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->title) {
            $q->where('title', 'like', '%' . $request->title . '%');
        }

        $books = $q->paginate(8);
        $categories = Category::all();


        // $categories = Category::all();

        // if ($request->category || $request->title) {
        //     $buku = Book::where('title', 'like', '%'.$request->title.'%')
        //                 ->orWhereHas('categories', function($b) use($request) {
        //                     $b->where('categories.id', $request->category);
        //                 })
        //                 ->get();
        // } else {
        //     $buku = Book::all();
        // }
        $userWithRoles = User::with(['role'])->get();
        return view('list_buku', ['books' => $books, 'categories' => $categories, 'userWithRoles' => $userWithRoles]);
    }

    public function showSinopsis($slug) {
        $books = Book::where('slug', $slug)->first();

        return view('detail_list_buku', ['books' => $books]);
    }
}
