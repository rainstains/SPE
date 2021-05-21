<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SPE</title>

    <!-- Scripts 
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    -->
    <script src="{{ asset('js/table2excel.js') }}"></script>

    <!-- Styles -->
    <!-- Custom fonts for this template-->
    <link href="{{asset('sbadmin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('sbadmin/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    
    <style>
        body {
        background-image: url("{{asset('bgLogin.png')}}");
        background-repeat: no-repeat;
        background-attachment: fixed; 
        background-size: 100% 100%;
        }
        html, body {
            height: 100%;
        }
        .jumbotron {
            background: transparent;

        }  
        .vertical-center {
            margin: 0;
            position: absolute;
            width: 100%;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
        }
        .row{
            text-align: center;
        }
        hr{
            display: block;
            height: 1px;
            border: 0; 
            border-top: 2px solid #F7F0F0;
            margin: 1em 0; 
            padding: 0;
        }
        p{
            text-align: justify;
            color: #F7F0F0; 
            font-size: 20px;
            font-weight: 700;
        }
    </style>

</head>
<body>
    <main class="py-4">
        <div class="jumbotron vertical-center">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-5" style="padding:100px;">
                    <h4 style="color: #F7F0F0; font-weight: 900;">Selamat Datang di<br>Sistem Pengelolaan Ekstrakurikuler</h4>
                    <hr>
                    <p>
                    Sistem Pengelolan Ekstrakurikuler (SPE) merupakan sebuah sistem yang bertujuan untuk mengelola ekstrakulikuler pada suatu sekolah. Tujuannya untuk mempermudah dan mempercepat proses dalam sistem pengelolaan ekstrakulikuler.
                    </p>

                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-5" style="padding-left:50px;">
                    <div class="col-md-6">
                        <img src="{{asset('logo.png')}}" alt="" style="width:100px; height: 100px; margin-bottom: 10px">
                    </div>
                <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="username" type="text" placeholder="username" class="form-control @error('username') is-invalid @enderror"  name="username" value="{{ old('username') }}" required autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success" style="width: 150px; font-size: 25px;">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('sbadmin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('sbadmin/js/sb-admin-2.min.js')}}"></script>

    @yield('scriptplus')
</body>
</html>
