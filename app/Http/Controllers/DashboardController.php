<?php

namespace App\Http\Controllers;

use App\Charts\LogPeminjamanChart;
use App\Models\Book;
use App\Models\BorrowLogs;
use App\Models\Category;
use App\Models\User;
use ConsoleTVs\Charts\ChartsServiceProvider;
use ConsoleTVs\Charts\Commands\ChartsCommand;
use ConsoleTVs\Charts\Facades\Charts;
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
        
        $logpeminjaman = $query->paginate(5);

        $countBelumKembali = BorrowLogs::with(['user', 'book'])->whereNull('actual_return_date')->count();
        $countSudahKembali = BorrowLogs::with(['user', 'book'])->whereNotNull('actual_return_date')->count();
        $countLogPeminjaman = BorrowLogs::with(['user', 'book'])->count();

        $chart = new LogPeminjamanChart($countBelumKembali, $countSudahKembali, $countLogPeminjaman);
        $chart->labels(['Peminjaman Belum Kembali', 'Peminjaman Sudah Kembali', 'Total Semua Data']);
        $chart->dataset('Total Data', 'bar', [$countBelumKembali, $countSudahKembali, $countLogPeminjaman])
            ->backgroundColor(['#6777EF', '#6777EF']);
        $chart->options([
            'responsive' => true,
            'maintainAspectRatio' => false,
        ]);

        $userWithRoles = User::with(['role'])->get();
        return view('dashboard', ['bookCount' => $bookCount, 'categoryCount' => $categoryCount, 'userCount' => $userCount, 
        'logpeminjaman' => $logpeminjaman, 'userWithRoles' => $userWithRoles, 'countBelumKembali' => $countBelumKembali, 
        'countSudahKembali' => $countSudahKembali, 'countLogPeminjaman' => $countLogPeminjaman, 'chart' => $chart]);
    }
}
