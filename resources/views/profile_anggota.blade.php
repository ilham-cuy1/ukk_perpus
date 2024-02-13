@extends('layout.app')
@section('title', 'Profil Anda')
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
        <h1 class="h3 mb-0 text-gray-800">Profil Anda</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="/profile" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama lengkap" value="{{ $showProfile->name }}">
                        </div>
                        @error('name')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Username </label>
                            <input type="text" class="form-control" name="username" placeholder="Username" value="{{ $showProfile->username }}">
                        </div>
                        @error('username')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">New Password</span></label>
                            <input type="password" class="form-control" name="password" placeholder="New password" value="{{ old('password') }}">
                        </div>
                        @error('password')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Nomer Telepon</label>
                            <input type="number" class="form-control" name="phone" placeholder="Nomer telepon" value="{{ $showProfile->phone }}">
                        </div>
                        @error('phone')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Alamat </span></label>
                            <textarea type="text" class="form-control" name="address" placeholder="Alamat" rows="3">{{ $showProfile->address }}</textarea>
                        </div>
                        @error('address')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label class="mt-2">Level </label>
                            <select name="role" class="form-control" disabled style="cursor: not-allowed;">
                                <option value="{{$showProfile->role->id}}" selected>{{$showProfile->role->name}}</option>
                            </select>
                        </div>
                        @error('role')
                        <div class="text-danger mt-0">
                            {{ $message }}
                        </div>
                        @enderror

                        <button type="submit" class="btn btn-success mt-2">Simpan</button>
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