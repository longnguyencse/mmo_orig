@extends('backend.layout')
@section('controller')
<style type="text/css">
	.body div{
		font-size: 20px; font-weight: bold;
	}
</style>
<div class="col-md-12" style="">
	<h3 style="text-align: center; font-weight: bold;">Hướng dẫn Auto Reup</h3>
	<div class="body" style="margin-left: 100px;">
		<div> - Auto Reup theo kênh</div>
		<div> - Tự động Upload khi kênh theo dõi có video mới</div>
		<div> - Có thể thêm 50 kênh Reup và mỗi kênh Reup có thể theo dõi 10 kênh khác để Reup theo</div>
		<div> - Có thể thêm video tùy ý vào để Reup</div>
		<div> - Cấu hình cho kênh Reup: thời gian giãn cách upload giữa các video, cắt đầu, cắt đuôi, auto chỉnh tiêu đề, mô tả, tag</div>
		<div> - Tùy chỉnh tiêu đề, mô tả, tag, thumb trước khi Upload</div>
		<div> - Thay thumb sau khi video đã Upload</div>
		<div> - Video đã Upload có thể Public, Private bằng tay hoặc hẹn giờ</div>
		<div style="text-align: center; margin-top: 20px;">
			<iframe width="640" height="360" src="https://www.youtube.com/embed/mIcdqsSSpRg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
	</div>
</div>
@endsection