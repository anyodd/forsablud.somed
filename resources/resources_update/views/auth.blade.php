<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | BLUD</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template') }}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav" style="height: auto;">
    <nav class="navbar navbar-expand navbar-light bg-white">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item col-2"></li>
            <li class="nav-item">
                <a href="#">
                    <img src="{{ asset('template') }}/dist/img/logo_rs/logo_forsa.png" alt="" class="img-circle elevation-5" style="opacity: .6" width="50">
                </a>
            </li>
        </ul>

        @if(Session::has('info'))
            <script>
                alert('Tahun Anggaran Belum Aktif')
            </script>
        @endif

        @if(Session::has('infolog'))
            <script>
                alert('Username atau Password Salah')
            </script>
        @endif

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#" role="button">
              Beranda
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#login" role="button" data-backdrop="static" data-keyboard="false">
              Login
            </a>
          </li>
        </ul>
    </nav>

    <div class="content">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('template') }}/dist/img/icon_login/BG11.png" alt="First slide" style="height: 700px;">
                    {{--<div class="carousel-caption"style="top: 20%;">
                        <div class="m">
                            <img src="{{ asset('template') }}/dist/img/logo_rs/logo_rs.png" alt="logo_rs" width="120px">
                        </div>
                    </div>
                    <div class="carousel-caption"style="top: 40%;">
                        <div class="card bg-secondary" style="opacity: .6">
                            <div class="card-body">
                                <h1><b>RUMAH SAKIT UMUM DAERAH</b></h1>
                            </div>
                        </div>
                    </div>--}}
                </div>
                {{-- <div class="carousel-item">
                <img class="d-block w-100" src="..." alt="Second slide">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="..." alt="Third slide">
                </div> --}}
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="modal fade" id="login">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times fa-xs"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6" style="float:none;margin:auto;">
                        <div class="login-logo">
                            <h5><strong>FORSA BLUD</strong></h5>
                            <h5>Silahkan Masukkan Akun Pengguna</h5>
                            <img src="{{ asset('template') }}/dist/img/icon_login/forsa.svg" alt="logo_rs" width="350px">
                        </div>
                        {{-- <h2 class="text-center">selamat datang di blud</h2> --}}
                    </div>
                    <div class="col-sm-6">
                        <form action="{{route('authenticate')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username"  placeholder="Username"  autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password"  placeholder="Password" required>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <input type="text" class="form-control bg-warning text-bold text-center" value="{{ getCaptchaQuestion() }}" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <input name="_answer" type="text" class="form-control" placeholder="Jawaban" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="tahun">Tahun Anggaran</label>
                              <select class="form-control" name="tahun" id="tahun">
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                              </select>
                            </div>
                           {{-- <div class="form-group">
                                <label for="tahun">Tahun Anggaran</label>
                                <input type="number" class="form-control" name="tahun" id="tahun" value="{{date('Y')}}">
                            </div> --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-lock"></i> Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>

<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
@section('script')
<script>
    $(function(){
        $('#login').modal({backdrop: 'static', keyboard: false})  
    })

</script>

@endsection
</body>
</html> 