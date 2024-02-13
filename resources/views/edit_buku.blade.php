@extends('layout.app')
@section('title', 'Edit Buku')
@section('content')

<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{ asset('assets/img/boy.png') }}" style="max-width: 60px">
                <span class="ml-3 d-none d-lg-inline text-white font-weight-bold">{{Auth::user()->username}} <br><span class="text-light font-weight-normal">{{ Auth::user()->role->name }}</span></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item">
                    <div class="font-weight-bold h4 text-center">{{Auth::user()->username}}</div>
                    <div class="h6 text-center">{{ Auth::user()->role->name }}</div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- Topbar -->

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Buku</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/books" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="/books-edit/{{$book->slug}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Kode Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="book_code" placeholder="Masukkan kode buku" value="{{ $book->book_code }}">
                        </div>
                        @error('book_code')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" placeholder="Masukkan judul buku" value="{{ $book->title }}">
                        </div>
                        @error('title')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Pengarang</label>
                            <input type="text" class="form-control" name="pengarang" placeholder="Masukkan pengarang" value="{{ $book->pengarang }}">
                        </div>
                        @error('pengarang')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" placeholder="Masukkan penerbit" value="{{ $book->penerbit }}">
                        </div>
                        @error('penerbit')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Tahun Terbit</label>
                            <input type="text" class="form-control" name="tahun_terbit" placeholder="Masukkan tahun terbit" value="{{ $book->tahun_terbit }}">
                        </div>
                        @error('tahun_terbit')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Gambar</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        @error('image')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="mb-3">
                            <label class="mt-3 d-flex">Gambar Saat Ini:</label>
                            @if($book->cover!='')
                            <img src="{{ asset('storage/cover/'.$book->cover) }}" alt="img" width="200">
                            @else
                            <img src="{{ asset('images/img_notfound3-01.png') }}" alt="img" width="200">
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="mt-2">Kategori <br><span class="small">~ Bisa pilih lebih dari satu</span></label>
                            <select name="categories[]" class="form-control select-multiple" multiple="multiple">
                                @foreach($categories as $kategori)
                                <option value="{{$kategori->id}}">{{$kategori->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('categories')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror
                        <label>Kategori Saat Ini:</label>
                        <ul>
                            @foreach($book->categories as $category)
                            <li>{{$category->name}}</li>
                            @endforeach
                        </ul>

                        <div class="form-group">
                            <label class="mt-2">Sinopsis Buku</label>
                            <textarea type="text" class="form-control" id="sinopsis" name="sinopsis" placeholder="Masukkan sinopsis buku" rows="5">{{ $book->sinopsis }}</textarea>
                        </div>
                        @error('sinopsis')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Stok Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="stock" value="{{ $book->stock }}">
                        </div>
                        @error('stock')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group mt-5">
                            <span class="text-danger">* Menunjukkan yang wajib diisi</span>
                        </div>

                        <button type="submit" class="btn btn-success mt-2">Update</button>
                        <a href="/books" class="btn btn-secondary mt-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <!--Row-->

        <!-- Modal Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin logout?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                        <a href="/logout" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!---Container Fluid-->

    @endsection