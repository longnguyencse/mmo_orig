@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="margin-top:5px; margin-left: -2px;">
                        <a href="{{ url('/admin/home') }}"><input type="submit" value="Quản lý TOOL" class="btn btn-primary"></a>
                    </div>        
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-2"></div>
                        <div class="col-md-10" style="color: red;font-weight: bold;">Bạn phải cập nhật Api, Client ID, Client Secret để có thể sử dụng Tool
                            <div style="">Xem hướng dẫn tại <a href="http://toolreup.ga/admin/home">Đây</a></div>
                            <div style="font-weight: bold;">Nhận ngay <span style="color: red">3 ngày </span>dùng thử <span style="color: red">FREE </span> bằng cách inbox cho mình email mà bạn đã đăng ký! <a target="_blank" href="https://goo.gl/AtTAMG">https://goo.gl/AtTAMG</a></div>
                        </div>

                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">Bạn còn <span style="font-weight: bold;font-size: 30px;"><?php echo $ngay<=0?0:round($ngay,3); ?></span> ngày sử dụng

                           <!--  <div><i style="color: red; font-weight: bold;">Lưu ý:</i> Khi không kích hoạt thì vẫn sử dụng được chức năng Free!</div> -->
                        </div>
                    </div>
                <form method="post" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-2">Api</div>
                        <div class="col-md-10">
                            <input type="text" name="api" value="<?php echo isset($arr->api)?$arr->api:""; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-2">Client ID</div>
                        <div class="col-md-10">
                            <input type="text" name="clientID" value="<?php echo isset($arr->clientID)?$arr->clientID:""; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-2">Client Secret</div>
                        <div class="col-md-10">
                            <input type="text" name="clientSecret" value="<?php echo isset($arr->clientSecret)?$arr->clientSecret:""; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-2">Password</div>
                        <div class="col-md-10">
                            <input type="password" name="password_1" value="" class="form-control" placeholder="Không đổi password thì không nhập thông tin vào ô textbox này" >
                        </div>
                    </div>  
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-2">Nhập lại Password</div>
                        <div class="col-md-10">
                            <input type="password" name="password_2" value="" class="form-control" placeholder="Không đổi password thì không nhập thông tin vào ô textbox này" >
                            
                        </div>
                    </div> 
                    <div class="row" style="margin-top:5px;">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <input type="submit" value="Cập nhật" class="btn btn-primary">
                        </div>
                    </div>           
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
