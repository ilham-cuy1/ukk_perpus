    @extends('layout.app')
    @section('title', 'List Buku')
    @section('content')
    <!-- TopBar -->
    <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
        <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            @if(Auth::check())
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="img-profile rounded-circle" src="{{ asset('assets/img/boy.png') }}" style="max-width: 60px">
                    <span class="ml-3 d-none d-lg-inline text-white font-weight-bold">{{ Auth::user()->username }}
                        <br><span class="text-light font-weight-normal">{{ Auth::user()->role->name }}</span></span>
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
            @endif
        </ul>
    </nav>
    <!-- Topbar -->

    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Buku</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Buku</li>
            </ol>
        </div>

        <form action="" method="get">
            <div class="row">
                <div class="col-12 col-sm-6 mb-4">
                    <select name="category" id="" class="form-control">
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach ($categories as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 mb-4">
                    <div class="input-group">
                        <input type="text" name="title" class="form-control" title="Search" placeholder="Cari Berdasarkan Judul Buku">
                        <div class="input-group-append" style="z-index: 0;">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <div class="row mb-5">
            @foreach ($books as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 border mt-4">
                    <img src="{{ $item->cover != null ? asset('storage/cover/'.$item->cover) : asset('images/img_notfound3-01.png') }}" class="card-img-top" alt="img" style="height: 450px;">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">{{ $item->title }}</h5>
                        <p class="card-text">{{ $item->book_code }}</p>
                        <p class="card-text">
                            @if($item->categories->isNotEmpty())
                            {{ $item->categories->pluck('name')->implode(', ') }}
                            @else
                            -
                            @endif
                        </p>
                        <hr>
                        <p class="card-text text-right">Stock: {{ $item->stock }}</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/book-list-detail/{{$item->slug}}" class="btn btn-primary mb-5">Lihat Sinopsis</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <span class="mx-auto mb-4 mt-3">{{ $books->links() }}</span>
        </div>
    </div>
    <!---Container Fluid-->

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
    @endsection