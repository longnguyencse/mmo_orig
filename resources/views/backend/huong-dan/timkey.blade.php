@extends('backend.layout')
@section('controller')
<style type="text/css">
	.body div{
		font-size: 20px; font-weight: bold;
	}
</style>
<div class="col-md-12" style="">
	<h3 style="text-align: center; font-weight: bold;">Hướng dẫn tìm key</h3>
	<div class="body" style="margin-left: 100px;">
		<div> - Tìm video theo cách trong tiêu đề bắt buộc có từ khóa hoặc không</div>
		<div> - Tìm video được Upload giữa 2 khoảng thời gian</div>
		<div> - Tìm video lớn hoặc nhỏ hơn 20 phút</div>
		<div> - Giao diện đơn giản, tiện lợi</div>
		<div style="text-align: center; margin-top: 20px;">
			<iframe width="640" height="360" src="https://www.youtube.com/embed/tqZug3RfYGI" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
	</div>
</div>
@endsection