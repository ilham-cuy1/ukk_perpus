@extends('layout.app')
@section('title', 'Data Anggota Baru')
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
        <h1 class="h3 mb-0 text-gray-800">Data Anggota Baru Terdaftar</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Anggota</li>
        </ol>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 flex-row align-items-center justify-content-between">
                    <div class="row">
                        <div class="col mb-3">
                            <a href="/anggota" class="btn btn-primary">Lihat Anggota Yang Disetujui</a>
                        </div>
                        <div class="col-lg-3">
                            <form action="" method="get">
                                <div class="input-group">
                                    <input type="search" name="keyword" class="form-control" title="Search" placeholder="Cari anggota...">
                                    <div class="input-group-append" style="z-index: 0;">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-bordered align-items-center table-flush bordered" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Nomer Telepon</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $i = $registeredAnggota->firstItem();
                        ?>
                        <tbody>
                            @foreach($registeredAnggota as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>
                                    @if($item->phone)
                                    {{ $item->phone }}
                                    @else
                                    -
                                    @endif

                                </td>
                                <td>{{ $item->address }}</td>
                                <td><span class="badge badge-pill badge-danger">{{$item->status}}</span></td>
                                <td>
                                    <a href="/detail-anggota/{{$item->slug}}" class="btn btn-sm btn-primary" title="Detail"><i class="fas fa-info-circle"></i> Detail</a>
                                </td>
                            </tr>
                            @endforeach

                            @if(count($registeredAnggota) === 0)
                            <div class="alert alert-danger">
                                Tidak Ada Data Untuk Ditampilkan
                            </div>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-between">
                        <div class="">
                            <p class="">Showing {{ $registeredAnggota->firstItem() }} to {{ $registeredAnggota->lastItem() }} of {{ $registeredAnggota->total() }} entries</p>
                        </div>
                        <div class="">
                            <span>{{ $registeredAnggota->links() }}</span>
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