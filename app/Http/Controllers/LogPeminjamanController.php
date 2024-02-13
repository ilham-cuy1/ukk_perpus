<?php

namespace App\Http\Controllers;

use App\Models\BorrowLogs;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $query = BorrowLogs::with(['user', 'book'])->latest();

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('username', 'like', '%' . $keyword . '%');
                })->orWhereHas('book', function ($query) use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%');
                });
            });
        }

        $logpeminjaman = $query->paginate(10);
        $userWithRoles = User::with(['role'])->get();

        return view('log_peminjaman', ['logpeminjaman' => $logpeminjaman, 'userWithRoles' => $userWithRoles]);
    }

    public function exportPdf()
    {
        $peminjamanlog = BorrowLogs::with(['user', 'book'])->get();
        // return view('pdf.export_data_peminjaman', ['peminjamanlog' => $peminjamanlog]);
        $pdf = Pdf::loadView('pdf.export_data_peminjaman', ['peminjamanlog' => $peminjamanlog]);
        return $pdf->download('Export_data_peminjaman_' . Carbon::now()->timestamp . '.pdf');
    }

    public function printLaporan()
    {
        $logpeminjaman = BorrowLogs::with(['user', 'book'])->get();
        return view('print.print_laporan_peminjaman', ['logpeminjaman' => $logpeminjaman]);
    }

    public function pinjamKembali(Request $request)
    {

        $keyword = $request->keyword;

        $query = BorrowLogs::with(['user', 'book'])->whereNotNull('actual_return_date')->latest();

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('username', 'like', '%' . $keyword . '%');
                })->orWhereHas('book', function ($query) use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%');
                });
            });
        }

        $peminjamankembali = $query->paginate(10);
        $userWithRoles = User::with(['role'])->get();
        return view('peminjaman_sudah_kembali', ['peminjamankembali' => $peminjamankembali, 'userWithRoles' => $userWithRoles]);
    }

    public function exportPdfPengembalian()
    {
        $peminjamankembali = BorrowLogs::with(['user', 'book'])->whereNotNull('actual_return_date')->get();
        // return view('pdf.export_data_peminjaman', ['peminjamanlog' => $peminjamanlog]);
        $pdf = Pdf::loadView('pdf.export_data_sudah_mengembalikan', ['peminjamankembali' => $peminjamankembali]);
        return $pdf->download('Export_data_peminjaman_sudah_kembali_' . Carbon::now()->timestamp . '.pdf');
    }

    public function printLaporanPengembalian()
    {
        $peminjamankembali = BorrowLogs::with(['user', 'book'])->whereNotNull('actual_return_date')->get();
        return view('print.print_laporan_sudah_mengembalikan', ['peminjamankembali' => $peminjamankembali]);
    }
}
