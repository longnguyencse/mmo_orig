@extends('backend.layout')
@section('controller')
<div class="col-md-6 col-xs-offset-3">
	<div class="panel panel-primary">
		<div class="panel-heading">Home</div>
		<div class="panel-body">
			<div style="font-weight: bold;font-size: 25px">Xin chào {{ Auth::user()->name }}! </div>
			<div style="font-weight: bold;font-size: 25px">Hãy xem hướng dẫn chi tiết bên dưới</div>
			<div style="font-weight: bold;">Link group FB: <a href="https://goo.gl/yd3CbJ" target="_blank">https://goo.gl/yd3CbJ</a></div>
			<div style="color: red;font-weight: bold;">Nhận 3 ngày dùng thử FREE bằng cách inbox cho mình email mà bạn đã đăng ký! <a href="https://goo.gl/AtTAMG" target="_blank">https://goo.gl/AtTAMG</a></div>
		</div>
	</div>
</div>
<div class="col-md-12 text-center">
	<h3 style="margin-bottom: 0px">Hãy xem hướng dẫn và cập nhật thông tin <a href="{{ url('/home') }}">Tài khoản</a> trước khi sử dụng</h3>
<div class="col-md-12">
	<a href="{{ url('/huong-dan/api') }}"><h3 style="margin-bottom: 0px">Hướng dẫn thêm api chi tiết</h3></a>
</div>
<div class="col-md-12">
	<a href="{{ url('/huong-dan/auto-reup') }}"><h3 style="margin-bottom: 0px">Hướng dẫn sử dụng chức năng Auto Reup</h3></a>
</div>
<div class="col-md-12">
	<a href="{{ url('/huong-dan/tim-key') }}"><h3 style="margin-bottom: 0px">Hướng dẫn tìm key ngon chơi reup</h3></a>
</div>
<div class="col-md-12">
	<a href="{{ url('/huong-dan/theo-doi') }}"><h3 style="margin-bottom: 0px">Hướng dẫn thống kê view của kênh và video</h3></a>
</div>
<div class="col-md-12">
	<a href="{{ url('/huong-dan/auto-comment') }}"><h3 style="margin-bottom: 0px">Hướng dẫn dùng tool Auto Comment</h3></a>
</div>
</div>

<!-- <div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading" style="font-weight: bold;">Phần 1: Hướng dẫn tạo api</div>
		<div class="panel-body">
			<video width="100%" controls>
			  <source src="{{ url('/public/images/tao.mp4') }}" type="video/mp4">
			  
			</video>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading" style="font-weight: bold;">Phần 2: Hướng dẫn tìm key</div>
		<div class="panel-body">
			<video width="100%" controls>
			  <source src="{{ url('/public/images/tim.mp4') }}" type="video/mp4">
			  
			</video>
		</div>
	</div>
</div>

<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading" style="font-weight: bold;">Phần 3: Chức năng theo dõi view,sub của kênh và video!</div>
		<div class="panel-body">
			<video width="100%" controls>
			  <source src="{{ url('/public/images/theodoi.mp4') }}" type="video/mp4">
			  
			</video>
			<div style="color: red; font-style: italic;"></div>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading" style="font-weight: bold;">Phần 4: Hướng dẫn dùng auto spam comment</div>
		<div class="panel-body">
			<video width="100%" controls>
			  <source src="{{ url('/public/images/comment.mp4') }}" type="video/mp4">
			  
			</video>
			<div style="color: red; font-style: italic;">Lưu ý: Lạm dụng auto spam commnent có thể dẫn tới chết kênh!</div>
		</div>
	</div>
</div> -->
@endsection