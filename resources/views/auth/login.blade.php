<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login | MPP Kota Batam</title>

    <!-- Custom fonts -->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon-mpp.png') }}">

</head>
   

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">
                                        <i class="fas fa-user mr-2"></i>
                                        Login Sistem</h1>
                                </div>

                                {{-- FORM LOGIN --}}
                                <form class="user" method="POST" action="{{ route('loginProses') }}">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email"
                                               name="email" value="{{ old('email') }}"
                                               class="form-control form-control-user @error('email') is-invalid @enderror"
                                               placeholder="Masukan Email"
                                               required>
                                        @error('email')
                                        <small class="text-danger">
                                        {{ $message }}
                                        </small>
                                        </div>
                                    @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password"
                                               name="password"
                                               class="form-control form-control-user @error('password') is-invalid @enderror"
                                               placeholder="Password"
                                               required>
                                         @error('password')
                                        <small class="text-danger">
                                        {{ $message }}
                                        </small>
                                        </div>
                                    @enderror
                                    </div>

                                   

                                    <button type="submit"
                                            class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <small> kembali ke beranda?
                                        <a href="{{ route('welcome') }}">klik disini </a> </small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script src="{{asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

    
@if(session('success'))
     <script>
        Swal.fire({
  title: "Sukses",
  text: "{{session('success')}}",
  icon: "success"
});
    </script> 
@endif

@if(session('error'))
     <script>
        Swal.fire({
  title: "Gagal",
  text: "{{session('error') }}",
  icon: "error"
});
    </script> 
@endif
  
</body>
</html>
