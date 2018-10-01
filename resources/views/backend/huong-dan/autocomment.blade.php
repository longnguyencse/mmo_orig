@extends('backend.layout')
@section('controller')
<style type="text/css">
	.body div{
		font-size: 20px; font-weight: bold;
	}
</style>
<div class="col-md-12" style="">
	<h3 style="text-align: center; font-weight: bold;">Hướng dẫn theo dõi kênh</h3>
	<div class="body" style="margin-left: 100px;">
		<div> - Auto trả lời các comment trong video</div>
		<div> - Comment random câu trả lời</div>
		
		<div style="text-align: center; margin-top: 20px;">
			<iframe width="640" height="360" src="https://www.youtube.com/embed/FHxpJylakDg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
	</div>
</div>
@endsection