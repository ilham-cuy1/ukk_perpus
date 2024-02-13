<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowLogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookBorrowController extends Controller
{
    public function index()
    {
        // $anggota = User::all();
        $books = Book::all();
        // $borrowLogs = BorrowLogs::all();
        $userWithRoles = User::with(['role'])->get();
        $user = Auth::user();
        return view('peminjaman_buku', ['books' => $books, 'userWithRoles' => $userWithRoles, 'user' => $user]);
    }

    public function store(Request $request)
    {
        $request['borrow_date'] = Carbon::now()->toDateString();
        $request['return_date'] = Carbon::now()->addDay(7)->toDateString();

        $book = Book::findOrFail($request->book_id);

        if ($book->stock < $request->quantity) {
            return redirect('book-borrow')->with('error', 'Stok buku tidak mencukupi untuk jumlah yang diminta');
        } else {
            try {
                DB::beginTransaction();
                // process insert to borrow_logs table
                $user = Auth::user();
                $borrowLog = $user->borrowLogs()->create([
                    'user_id' => $request->user_id,
                    'book_id' => $request->book_id,
                    'quantity' => $request->quantity,
                    'borrow_date' => $request->borrow_date,
                    'return_date' => $request->return_date,
                ]);
                // process update books table
                $book->stock -= $request->quantity;
                $book->save();
                DB::commit();

                return redirect('book-borrow')->with('success', 'Berhasil meminjam buku');
            } catch (\Exception $e) {
                DB::rollBack();
                // Additional logging or error handling
                return redirect('book-borrow')->with('error', 'Gagal meminjam buku. Silakan coba lagi.');
            }
        }

        // if ($book->stock < $request->quantity) {
        //     return redirect('book-borrow')->with('error', 'Tidak dapat dipinjam');
        // } else {
        //     try {
        //         DB::beginTransaction();
        //         // process insert to borrow_logs table
        //         BorrowLogs::create([
        //             'user_id' => $request->user_id,
        //             'book_id' => $request->book_id,
        //             'quantity' => $request->quantity,
        //         ]);
        //         // process update books table
        //         $book = Book::findOrFail($request->book_id);
        //         $book->stock -= $request->quantity;
        //         $book->save();
        //         DB::commit();

        //         return redirect('book-borrow')->with('success', 'Berhasil pinjam');
        //     } catch (\Throwable $th) {
        //         DB::rollBack();
        //         return redirect('book-borrow')->with('error', 'Gagal meminjam buku. Silakan coba lagi.');
        //     }
        // }
    }

    public function returnBook()
    {
        $anggota = User::where(function($query){
            $query->where('role_id', '!=', 1)->where('role_id', '!=', 2);
        })->where('status', '!=', 'inactive')->get();

        $books = Book::all();
        $userWithRoles = User::with(['role'])->get();
        return view('book_return', ['anggota' => $anggota, 'books' => $books, 'userWithRoles' => $userWithRoles]);
    }

    public function storeReturnBook(Request $request)
    {
        $return = BorrowLogs::where('user_id', $request->user_id)->where('book_id', $request->book_id)->where('actual_return_date', null);
        $returnData = $return->first();
        $countData = $return->count();

        if ($countData == 1) {
            try {
                DB::beginTransaction();

                // // Menandai buku telah dikembalikan
                // $returnData->actual_return_date = Carbon::now()->toDateString();
                // $returnData->save();

                //menghitung jumlah hari keterlambatan
                $dueDate = Carbon::parse($returnData->return_date);
                $actualReturnDate = Carbon::parse($returnData->actual_return_date);
                $daysLate = max(0, $actualReturnDate->greaterThan($dueDate) ? $dueDate->diffInDays($actualReturnDate) : 0);

                //menghitung denda
                $lateFee = $daysLate * 1000;

                //menyinpam denda ke dalam late_fee
                $returnData->late_fee = $lateFee;

                // Menandai buku telah dikembalikan
                $returnData->actual_return_date = $actualReturnDate->toDateString();
                $returnData->save();

                // Mengembalikan jumlah buku yang dikembalikan ke stok buku
                $book = Book::find($request->book_id);
                $book->stock += $returnData->quantity; // Menggunakan kolom quantity dari BorrowLogs
                $book->save();

                DB::commit();

                return redirect('book-return')->with('success', 'Berhasil Dikembalikan. Denda yang harus dibayar: Rp ' . number_format($lateFee, 0, '.', '.'));
            } catch (\Throwable $th) {
                DB::rollBack();
                // Additional logging or error handling
                return redirect('book-return')->with('error', 'Gagal mengembalikan buku. Silakan coba lagi.');
            }
        } else {
            return redirect('book-return')->with('error', 'Gagal mengembalikan buku. Silakan coba lagi.');
        }


        // if($countData == 1) {
        //     // kita akan return buku
        //     $returnData->actual_return_date = Carbon::now()->toDateString();
        //     $returnData->save();

        //     return redirect('book-return')->with('success', 'Berhasil Dikembalikan');
        // } else {
        //     return redirect('book-return')->with('error', 'Error');
        // }
    }
}
