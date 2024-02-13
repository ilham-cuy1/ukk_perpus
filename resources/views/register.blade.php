<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ asset('assets/img/logo/buku7.png') }}" rel="icon">
    <title>Resgistrasi - Perpustakaan</title>
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ruang-admin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css-fakeloader/fakeLoader.css') }}" rel="stylesheet">

    <style>
        body {
            background-image: url('images/perpustakaan-loker3.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>

<body class="bg-gradient-login">
    <div class="spinner-wrapper">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center mb-1">
                                        <img src="{{ asset('assets/img/logo/buku7.png') }}" alt="" style="max-width: 170px;">
                                    </div>
                                    <div class="text-center mb-5">
                                        <h2 class="h2 font-weight-bold" style="color: black; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">PERPUSTAKAAN</h2>
                                    </div>
                                    <div class="text-center">
                                        <h1 class="h2 text-gray-900 mb-4 font-weight-bold">Register</h1>
                                    </div>
                                    <hr>

                                    @if ($message = Session::get('status'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif

                                    @if ($message = Session::get('status_sukses'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif

                                    @if ($message = Session::get('invalid'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif

                                    <form class="user" action="" method="post">
                                        @csrf
                                        <div class="form-group mt-4">
                                            <label>Nama Lengkap</label>
                                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap">
                                        </div>
                                        @error('name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="form-group mt-3">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username" placeholder="Masukkan username">
                                        </div>
                                        @error('username')
                                        <div class="text-danger mb-3">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <label>Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Masukkan password">
                                            <div class="input-group-append">
                                                <label class="input-group-text" style="cursor: pointer;" id="togglePassword"><i class="far fa-eye"></i></label>
                                            </div>
                                        </div>
                                        @error('password')
                                        <div class="text-danger mt-3">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="form-group mt-3">
                                            <label>Nomor Telepon</label>
                                            <input type="number" class="form-control" name="phone" placeholder="Masukkan nomor telepon">
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Alamat</label>
                                            <textarea type="text" class="form-control" name="address" rows="3" placeholder="Masukkan alamat anda"></textarea>
                                        </div>
                                        @error('address')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> -->
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <span>Already have an account?</span><a class="font-weight-bold" href="/login"> Login Here!</a>
                                    </div>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/ruang-admin.min.js') }}"></script>

    <script>
        const passwordInput = document.getElementById('inputPassword');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.innerHTML = '<i class="far fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                togglePassword.innerHTML = '<i class="far fa-eye"></i>';
            }
        });
    </script>

    <script>
        const spinnerWrapperEl = document.querySelector('.spinner-wrapper');

        window.addEventListener('load', () => {
            spinnerWrapperEl.style.opacity = '0';

            setTimeout(() => {
                spinnerWrapperEl.style.display = 'none';
            }, 200);
        })
    </script>
</body>

</html>