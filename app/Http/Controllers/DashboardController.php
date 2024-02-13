<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowLogs;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $bookCount = Book::count();
        $categoryCount = Category::count();
        $userCount = User::where('role_id', 3)->count();
        
        $keyword = $request->keyword;
        
        $query = BorrowLogs::with(['user', 'book'])->latest();

        if(!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->whereHas('user', function($query) use ($keyword) {
                    $query->where('name', 'like', '%'.$keyword.'%')
                        ->orWhere('username', 'like', '%'.$keyword.'%');
                })->orWhereHas('book', function($query) use ($keyword) {
                    $query->where('title', 'like', '%'.$keyword.'%');
                });
            });
        }
        
        $logpeminjaman = $query->paginate(10);

        $countBelumKembali = BorrowLogs::with(['user', 'book'])->where('actual_return_date', null)->count();
        $userWithRoles = User::with(['role'])->get();
        return view('dashboard', ['bookCount' => $bookCount, 'categoryCount' => $categoryCount, 'userCount' => $userCount, 
        'logpeminjaman' => $logpeminjaman, 'userWithRoles' => $userWithRoles, 'countBelumKembali' => $countBelumKembali]);
    }
}
