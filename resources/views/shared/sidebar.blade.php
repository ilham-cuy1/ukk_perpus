 <!-- Sidebar -->
 <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
   <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
     <div class="sidebar-brand-icon">
       <img src="{{ asset('assets/img/logo/buku7.png') }}">
     </div>
     <div class="sidebar-brand-text mx-2">PERPUSTAKAAN</div>
   </a>
   @if (Auth::user())
   @if (Auth::user()->role_id == 1)
   <hr class="sidebar-divider my-0">
   <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
     <a class="nav-link" href="/dashboard">
       <i class="fas fa-fw fa-tachometer-alt"></i>
       <span>Dashboard</span></a>
   </li>
   <hr class="sidebar-divider">
   <div class="sidebar-heading">Data</div>
   <li class="nav-item {{ request()->is('books') || request()->is('books-add') || request()->is('books-edit/*') ? 'active' : '' }}">
     <a class="nav-link" href="/books">
       <i class="fas fa-book"></i>
       <span>Buku</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('categories') || request()->is('category-add') || request()->is('category-edit/*') ? 'active' : '' }}">
     <a class="nav-link" href="/categories">
       <i class="fas fa-list-ul"></i>
       <span>Kategori</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('anggota') || request()->is('registered-anggota') || request()->is('detail-anggota/*') || request()->is('blocked-anggota') ? 'active' : '' }}">
     <a class="nav-link" href="/anggota">
       <i class="fas fa-user-graduate"></i>
       <span>Data Anggota</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('log-peminjaman') ? 'active' : '' }}">
     <a class="nav-link" href="/log-peminjaman">
       <i class="fas fa-history"></i>
       <span>Log Peminjaman</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('pengguna') || request()->is('pengguna-add') || request()->is('pengguna-edit/*') ? 'active' : '' }}">
     <a class="nav-link" href="/pengguna">
       <i class="fas fa-users"></i>
       <span>Data Pengguna</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('peminjaman-sudah-kembali') ? 'active' : '' }}">
     <a class="nav-link" href="/peminjaman-sudah-kembali">
       <i class="fas fa-history"></i>
       <span>Peminjaman Sudah Kembali</span>
     </a>
   </li>

   <li class="nav-item {{ request()->is('book-return') ? 'active' : '' }}">
     <a class="nav-link" href="/book-return">
       <i class="fas fa-book-open"></i>
       <span>Pengembalian Buku</span>
     </a>
   </li>
   @elseif(Auth::user()->role_id == 2)
   <hr class="sidebar-divider my-0">
   <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
     <a class="nav-link" href="/dashboard">
       <i class="fas fa-fw fa-tachometer-alt"></i>
       <span>Dashboard</span></a>
   </li>
   <hr class="sidebar-divider">
   <div class="sidebar-heading">Data</div>
   <li class="nav-item {{ request()->is('books') || request()->is('books-add') || request()->is('books-edit/*') ? 'active' : '' }}">
     <a class="nav-link" href="/books">
       <i class="fas fa-book"></i>
       <span>Buku</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('categories') || request()->is('category-add') || request()->is('category-edit/*') ? 'active' : '' }}">
     <a class="nav-link" href="/categories">
       <i class="fas fa-list-ul"></i>
       <span>Kategori</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('anggota') || request()->is('registered-anggota') || request()->is('detail-anggota/*') || request()->is('blocked-anggota') ? 'active' : '' }}">
     <a class="nav-link" href="/anggota">
       <i class="fas fa-user-graduate"></i>
       <span>Data Anggota</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('log-peminjaman') ? 'active' : '' }}">
     <a class="nav-link" href="/log-peminjaman">
       <i class="fas fa-history"></i>
       <span>Log Peminjaman</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('peminjaman-sudah-kembali') ? 'active' : '' }}">
     <a class="nav-link" href="/peminjaman-sudah-kembali">
       <i class="fas fa-history"></i>
       <span>Peminjaman Sudah Kembali</span>
     </a>
   </li>

   <li class="nav-item {{ request()->is('book-return') ? 'active' : '' }}">
     <a class="nav-link" href="/book-return">
       <i class="fas fa-book-open"></i>
       <span>Pengembalian Buku</span>
     </a>
   </li>
   @else
   <li class="nav-item {{ request()->is('log-peminjaman-anggota') ? 'active' : '' }}">
     <a class="nav-link" href="/log-peminjaman-anggota">
       <i class="fas fa-sticky-note"></i>
       <span>Log Peminjaman Anda</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
     <a class="nav-link" href="/profile">
       <i class="fas fa-user"></i>
       <span>Profil</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('book-borrow') ? 'active' : '' }}">
     <a class="nav-link" href="/book-borrow">
       <i class="fas fa-book-open"></i>
       <span>Peminjaman Buku</span>
     </a>
   </li>
   <li class="nav-item {{ request()->is('/') || request()->is('book-list-detail/*') ? 'active' : '' }}">
     <a class="nav-link" href="/">
       <i class="fas fa-book-open"></i>
       <span>List Buku</span>
     </a>
   </li>
   @endif
   @else
   <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
     <a href="/login" class="btn btn-info my-4 mx-4"><i class="fas fa-sign-in-alt"></i> Login</a>
   </li>
   @endif

   <hr class="sidebar-divider">
   <div class="version">Version 1</div>
 </ul>