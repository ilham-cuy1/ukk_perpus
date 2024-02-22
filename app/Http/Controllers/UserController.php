<?php

namespace App\Http\Controllers;

use App\Models\BorrowLogs;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile() {
        $logpeminjaman = BorrowLogs::with(['user', 'book'])->where('user_id', Auth::user()->id)->latest()->paginate(10);
        $userWithRoles = User::with(['role'])->get();
        return view('log_peminjaman_anggota', ['logpeminjaman' => $logpeminjaman, 'userWithRoles' => $userWithRoles]);
    }

    public function index(Request $request) {
        $keyword = $request->keyword;

        $usersQuery = User::where('role_id', 3)->where('status', 'active');
        
        if(!empty($keyword)) {
            $usersQuery->where(function($query) use ($keyword) {
                $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('username', 'LIKE', '%'.$keyword.'%');
            });
        }

        $users = $usersQuery->latest()->paginate(10);
        $userWithRoles = User::with(['role'])->get();
        return view('anggota', ['users' => $users, 'userWithRoles' => $userWithRoles]);
    }

    public function registeredAnggota(Request $request) {
        $keyword = $request->keyword;
        
        $usersQuery = User::where('role_id', 3)->where('status', 'inactive');
        
        if(!empty($keyword)) {
            $usersQuery->where(function($query) use ($keyword) {
                $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('username', 'LIKE', '%'.$keyword.'%');
            });
        }

        $registeredAnggota = $usersQuery->latest()->paginate(10);
        $userWithRoles = User::with(['role'])->get();
        return view('registered_anggota', ['registeredAnggota' => $registeredAnggota, 'userWithRoles' => $userWithRoles]);
    }

    public function show($slug) {
        $anggota = User::where('slug', $slug)->first();
        $logpeminjaman = BorrowLogs::with(['user', 'book'])->where('user_id', $anggota->id)->latest()->paginate(10);
        $userWithRoles = User::with(['role'])->get();
        return view('detail_anggota', ['anggota' => $anggota, 'logpeminjaman' => $logpeminjaman, 'userWithRoles' => $userWithRoles]);
    }

    public function approve($slug) {
        $anggota = User::where('slug', $slug)->first();
        $anggota->status = 'active';
        $anggota->save();

        return redirect('detail-anggota/'.$slug)->with('success', 'Anggota Berhasil Disetujui');
    }

    public function block($slug) {
        $anggota = User::where('slug', $slug)->first();
        $anggota->delete();

        return redirect('anggota')->with('success', 'Anggota Berhasil Diblokir');
    }

    public function blockedAnggota(Request $request) {
        $keyword = $request->keyword;
        
        $queryAnggota = User::onlyTrashed()->where('role_id', 3)->latest();

        if(!empty($keyword)) {
            $queryAnggota->where(function($query) use ($keyword) {
                $query->where('name', 'like', '%'.$keyword.'%')
                    ->orWhere('username', 'like', '%'.$keyword.'%');
            });
        }

        $blockedAnggota = $queryAnggota->paginate(10);
        $userWithRoles = User::with(['role'])->get();
        return view('blocked_anggota', ['blockedAnggota' => $blockedAnggota, 'userWithRoles' => $userWithRoles]);
    }

    public function unblockAnggota($slug) {
        $anggota = User::withTrashed()->where('slug', $slug)->first();
        $anggota->restore();

        return redirect('anggota')->with('success', 'Buka Blokir Anggota Berhasil');
    }

    public function pengguna(Request $request) {
        $keyword = $request->keyword;

        $queryUsers = User::where(function($query){
            $query->where('role_id', 1)->orWhere('role_id', 2);
        })->where('status', 'active')->latest();
        
        if(!empty($keyword)) {
            $queryUsers->where(function($query) use ($keyword) {
                $query->where('name', 'like', '%'.$keyword.'%')
                    ->orWhere('username', 'like', '%'.$keyword.'%');
            });
        }

        $users = $queryUsers->paginate(10);
        $userWithRoles = User::with(['role'])->get();
        return view('pengguna', ['users' => $users, 'userWithRoles' => $userWithRoles]);   
    }

    public function addPengguna() {
        $roles = Role::whereIn('name', ['Admin', 'Petugas'])->get();
        return view('tambah_pengguna', ['roles' => $roles]);
    }

    public function prosesAddPengguna(Request $request) {
        $credentials = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'password' => 'required|max:255',
            'phone' => 'max:255',
            'address' => 'required',
            'role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah ada.',
            'password.min' => 'Minimal panjangnya 8 karakter.',
            'password.required' => 'Password wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'role.required' => 'Level wajib diisi.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => $request->role,
            'status' => 'active',
        ]);

        return redirect('pengguna')->with('success', 'Pengguna Berhasil Ditambahkan');
    }

    public function showProfile() {
        $showProfile = Auth::user();
        $roles = Role::whereIn('name', ['Admin', 'Petugas'])->get();
        return view('profile_anggota', ['showProfile' => $showProfile, 'roles' => $roles]);
    }

    public function updateProfile(Request $request) {
        $updateProfile = Auth::user();

        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'max:255',
            'phone' => 'max:255',
            'address' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        if($request->filled('password')) {
            $updateProfile->update(['password' => bcrypt($request->password)]);
        }
        
        $updateProfile->slug = null;
        $updateProfile->update($request->except('password'));

        return redirect('profile')->with('success', 'Profil Berhasil Diubah');
    }

    public function destroyPengguna($slug) {
        $users = User::where('slug', $slug)->first();
        $users->delete();

        return redirect('pengguna')->with('success', 'Pegguna Berhasil Dihapus');
    }

    public function editPengguna($slug) {
        $users = User::where('slug', $slug)->first();

        $roles = Role::whereIn('name', ['Admin', 'Petugas'])->get();
        return view('edit_pengguna', ['roles' => $roles, 'users' => $users]);
    }

    public function updatePengguna(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'max:255',
            'phone' => 'max:255',
            'address' => 'required',
            'role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah ada.',
            'password.min' => 'Minimal panjangnya 8 karakter.',
            'password.required' => 'Password wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'role.required' => 'Level wajib diisi.',
        ]);

        $user = User::where('slug', $request->slug)->firstOrFail();

        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role_id = $request->role;

        if(!is_null($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->slug = null;
        $user->save();

        return redirect('pengguna')->with('success', 'Pengguna Berhasil Diedit');
    }
}
