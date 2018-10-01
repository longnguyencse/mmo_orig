@extends('backend.layout')
@section('controller')
<style type="text/css">
	img {
		width: 800px;
	}
	.body div{
		font-size: 20px; font-weight: bold; padding-bottom: 20px;padding-top: 20px;
	}
	.body p{
		font-weight: bold; color: red; font-size: 16px;
	}
</style>
<div class="col-md-12" style="">
	<h3 style="text-align: center; font-weight: bold;">Hướng dẫn thêm chi tiết api</h3>
	<div class="body" style="margin-left: 100px;">
		<div>Tạo Project mới</div>
		<img src="public/images/api/1.png">
		<img src="public/images/api/2.png">
		<img src="public/images/api/3.png">
		<img src="public/images/api/4.png">
		<img src="public/images/api/5.png">
		<img src="public/images/api/6.png">
		<div>Tạo Api</div>
		<img src="public/images/api/7.png">
		<img src="public/images/api/8.png">
		<div>2 thông tin quan trọng phải điền</div>
		<p>{{ url('') }}</p>
		<p>{{ url('/index.php/admin/autoreup/channel/add') }}</p>
		<img src="public/images/api/9.png">
		<div>Copy những thông tin vừa tạo sang tool là các bạn có thể chạy được Auto Reup</div>
		<img src="public/images/api/10.png">
		<div>Bạn có thể tham khảo thêm video tạo api chi tiết. Nhớ là đổi freetoolyt.ga thành toolreup.ga</div>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/fw0E9ao5w_8" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
	</div>
</div>
@endsection