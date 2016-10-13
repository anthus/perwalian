<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Halaman Login SIAKAD UNTAN Mahasiswa</title>

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        #body-login {
            background: url("{{ asset('images/siakad-img-background-2.jpg')  }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .box-login {
            padding: 50px;
            margin-top: 100px;
        }
        .form-login div {
            margin-bottom: 20px;
        }
        .form-login span{
            color: #fff;
            font-size: 12px;
        }
        .form-login input[type="text"],
        .form-login input[type="password"] {
            border: none;
            color: #fff;
            background: none;
            border-bottom: 1px solid #fff;
            box-shadow: none;
            padding-left: 0;
        }

        #text-information {
            background: rgba(255, 255, 255, 0.8);
            font-size: 15px;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        @media screen and (max-width: 500px) {
            .box-login {
                padding: 20px 50px 0 50px;
                margin-top: 0px;
            }
        }
    </style>
  </head>

    <body id="body-login">
        <div class="container">
            
            <div class="col-md-4 box-login">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{route('login')}}" method="POST" class="form-login">
                    <h1 style="color: #fff; text-shadow: none; margin-bottom: 20px;">Login Dosen</h1>
                    <div>
                        <span>NIP</span>
                        <input type="text" name="nip" class="form-control" required="" />
                    </div>
                    <div>
                        <span>Password</span>
                        <input type="password" name="password" class="form-control" required="" />
                    </div>
                    <div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-success btn-lg" style="margin-left: 0;" value="Masuk">
                    </div>    
                </form>
            </div>
            <div class="col-md-6 box-login">
                <img src="{{asset('images/siakad-untan-large-shadow.png')}}" alt="" class="img-responsive">
                <div id="text-information">
                    <h2 style="margin-left: 20px; font-size: 25px;"><i class="fa fa-info"></i> Informasi SIAKAD</h2>
                    <ol>
                        <li>Jika Lupa password dapat menghubungi petugas Akademik masing-masing fakultas</li>
                        <li>Kalender Akademik TA. 2016/2017 dapat di download di <a href="">sini</a></li>
                        <li>Jadwal Pengisian Rencana Studi (LIRS) dimulai dari tanggal 1 Agustus - Selesai</li>
                    </ol>
                </div>
            </div>
        </div>
        
        
    </body>
</html>