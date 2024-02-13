@extends('layout.app')
@section('title', 'Dashboard')
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
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
  </div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h2 class="text-gray-800 font-weight-bold">Selamat Datang, {{Auth::user()->username}}</h2>
  </div>

  <div class="row mb-3">
    <!-- Card Example Book -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2 mt-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">BUKU</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$bookCount}}</div>
              <!-- <div class="mt-2 mb-0 text-muted text-xs">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                <span>Since last month</span>
              </div> -->
            </div>
            <div class="col-auto mt-2">
              <i class="fas fa-book fa-2x text-primary"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Card Example Categories -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2 mt-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">kategori</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$categoryCount}}</div>
              <!-- <div class="mt-2 mb-0 text-muted text-xs">
                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                <span>Since last years</span>
              </div> -->
            </div>
            <div class="col-auto mt-2">
              <i class="fas fa-th-list fa-2x text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Card Example Users -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2 mt-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Anggota</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$userCount}}</div>
              <!-- <div class="mt-2 mb-0 text-muted text-xs">
                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                <span>Since last month</span>
              </div> -->
            </div>
            <div class="col-auto mt-2">
              <i class="fas fa-users fa-2x text-info"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Card Unknown -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2 mt-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Buku belum kembali</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countBelumKembali}}</div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i></span> -->
                <span></span>
              </div>
            </div>
            <div class="col-auto mt-2">
              <i class="fas fa-calendar-times fa-2x text-danger"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4 mt-3">
        <div class="card-header py-3 flex-row align-items-center justify-content-between">
          <div class="row">
            <div class="col mb-3">
              <h5 class="m-0 font-weight-bold text-primary">Log Peminjaman</h5>
            </div>
            <div class="col-lg-3">
              <form action="" method="get">
                <div class="input-group">
                  <input type="search" name="keyword" class="form-control" title="Search" placeholder="Cari data peminjaman...">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="table-responsive p-3">
          <x-log-peminjaman-table :logpeminjaman='$logpeminjaman' />
        </div>
        <div class="card-footer">
          <div class="row justify-content-between">
            <div class="">
              <p class="">Showing {{ $logpeminjaman->firstItem() }} to {{ $logpeminjaman->lastItem() }} of {{ $logpeminjaman->total() }} entries</p>
            </div>
            <div class="">
              <span>{{ $logpeminjaman->links() }}</span>
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