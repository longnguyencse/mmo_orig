<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Auto Reup</title>
	<meta property="og:image" content="public/images/ngon.png" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
        <!-- Styles -->
        <style>
            html, body {
                /*background-color: #fff;*/
                /*color: #636b6f;*/
                /*font-family: 'Raleway', sans-serif;*/
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #f1f1f1;
      /*color: white;*/
      padding: 15px;
      margin-top: 30px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
    </head>
    <body>
    <div>
        @if (Route::has('login'))
            <div>
                <h1 style="color: #fc3955"><b> Autoreup.online </b></h1>
                @if (Auth::check())
                    <div class=" w3l-login-form">
                        {{--<a href="{{ url('admin/home') }}">Quản lý Tool</a>--}}
                        {{--<a href="{{ url('admin/logout') }}">Đăng xuất</a>--}}
                        <a href="{{ url('admin/home') }}" class="w3l-login-form__ip">Quản lý Tool</a>
                        <a href="{{ url('admin/logout') }}" class="w3l-login-form__ip w3l-login-form__ip--green">Đăng xuất</a>
                    </div>
                @else
                    <div class=" w3l-login-form">
                        <a href="{{ url('/login') }}" class="w3l-login-form__ip">Đăng nhập</a>
                        <a href="{{ url('/register') }}" class="w3l-login-form__ip w3l-login-form__ip--green">Đăng ký</a>
                    </div>
                    {{----}}
                    {{--<a href="{{ url('/login') }}">Đăng nhập</a>--}}
                    {{--<a href="{{ url('/register') }}">Đăng ký</a>--}}
                    <div> <h1 ><b >Bảng giá</b></h1></div>
                    <h2 style="color: #fc3955"><b> Mua 100 mail cổ tặng tool trong 3 tháng </b></h2>
                    <h2 style="color: #fc3955"><b> Gói 50 kênh 200k/2 tháng </b></h2>
                    <h2 style="color: #fc3955"><b> Gói 100 kênh 300k/2 tháng </b></h2>
                    <h2 style="color: #fc3955"><b> Cài Sever riêng không giới hạn cho team=> Liên hệ <a style="background-color: #fc3955 " href="https://www.facebook.com/dinhchuong47">Support</a> </b></h2>

                    <a href="https://www.facebook.com/dinhchuong47">Support</a>

                @endif
            </div>
        @endif

    </div>
    {{--<div class="content">--}}
    {{--<!-- <div class="title m-b-md">--}}
    {{--Try to get 1k$/1 month--}}
    {{--</div> -->--}}
    {{--<div class="jumbotron text-center">--}}
    {{--<h1>AUTO REUP</h1>--}}
    {{--<p style="color: red; font-weight: bold;">Auto Reup: Theo dõi kênh đối thủ và tự Up khi có video mới xuất hiện</p> --}}
    {{--<!-- <div style="font-weight: bold;">Vào group Facebook để được xem hướng dẫn: <a target="_blank" href="https://goo.gl/yd3CbJ">https://goo.gl/yd3CbJ</a></div> -->--}}
    {{--</div>--}}


    {{--</div>--}}
    {{--<div class="container">--}}
    {{--<div class="container-fluid text-center">    --}}
    {{--<div class="row content">--}}
    {{--<!-- <div class="col-sm-2 sidenav">--}}
    {{--<p><a href="#">Link</a></p>--}}
    {{--<p><a href="#">Link</a></p>--}}
    {{--<p><a href="#">Link</a></p>--}}
    {{--</div> -->--}}
    {{--<div class="col-sm-12 text-left"> --}}
    {{--<div>--}}
    {{--<img src="public/images/anhnen.png" class="img-responsive" style="margin: 0 auto">--}}
    {{--<div style="text-align: center;font-weight: bold;color: red; font-size: 20px"><a href="{{ url('/admin/home') }}">Giới thiệu về Auto Reup</a></div>--}}
    {{--</div>--}}
    {{--<div class="col-md-6 text-center">--}}
    {{--<h2 style="font-weight: bold;color: red">150k</h2>--}}
    {{--<h3>REUP và Theo dõi 50 kênh - 30 ngày</h3>--}}
    {{--</div>--}}
    {{--<div class="col-md-6 text-center">--}}
    {{--<h2 style="font-weight: bold;color: red">400k</h2>--}}
    {{--<h3>REUP và Theo dõi 50 kênh - 90 ngày</h3>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!-- <div class="col-sm-2 sidenav">--}}
    {{--<div class="well">--}}
    {{--<p>ADS</p>--}}
    {{--</div>--}}
    {{--<div class="well">--}}
    {{--<p>ADS</p>--}}
    {{--</div>--}}
    {{--</div> -->--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<!-- <footer class="container-fluid text-center">--}}
    {{--<a href="https://goo.gl/enkx6Z" target="_blank" ><i class="fa fa-facebook-official" style="font-size:30px;color:#4267b2"></i></a>--}}
    {{--</footer> -->--}}
    {{--</div>--}}
    </body>
</html>
