@extends('layout.app')
@section('title', 'Lihat Sinopsis Buku')
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
        @endif
    </ul>
</nav>
<!-- Topbar -->

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sinopsis Buku</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a></li>
        </ol>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        @if($books->cover!='')
                        <img src="{{ asset('storage/cover/'.$books->cover) }}" class="card-img img-fluid rounded" alt="img" style="max-height: 620px;">
                        @else
                        <img src="{{ asset('images/img_notfound3-01.png') }}" class="card-img img-fluid rounded" alt="img" style="max-height: 620px;">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-body mt-2">
                            <h3 class="card-title h2 font-weight-bold">{{ $books->title }}</h3>
                            <p class="card-text h5 mb-4">Kategori:
                                @if($books->categories->isNotEmpty())
                                {{ $books->categories->pluck('name')->implode(', ') }}
                                @else
                                -
                                @endif
                            </p>
                            <p class="card-text h4 font-weight-bold mb-2">Sinopsis</p>
                            <p class="card-text h4">
                                @if($books->sinopsis)
                                {!! $books->sinopsis !!}
                                @else
                                -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
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