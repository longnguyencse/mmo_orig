@extends('backend.layout')
@section('controller')

<div class="col-md-8 col-xs-offset-2">
<h2>Bạn đã theo dõi <b style="color: red;"><?php echo $dem."/".Auth::user()->kenhreup; ?></b> kênh Reup!</h2>
	<div class="panel panel-primary">
		<div class="panel-heading">Thêm kênh muốn REUP</div>
		<div class="panel-body">
			<form method="GET">
			  @can('kenhreup',$dem)
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3">ID kênh muốn reup: </div>
			    <div class="col-md-9">
					<input type="search" id="linkreup" name="linkreup" placeholder="UCuZaaBsuCCkAX7W7tAbkITa" class="form-control">
					<input type="text" id="linkreupchannel" name="linkreupchannel" value="<?php echo $arr->link;?>" hidden>
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3">Số lượng video: </div>
			    <div class="col-md-9">
					<input type="number" value="0" min="0" max="" id="sl" name="sl" > <i style="color: red">Chọn 0: Là lấy tất cả video trong kênh.</i>
				</div>
			  </div>
			  	@endcan('kenhreup',$dem)

			<?php 
				foreach ($arr1 as $arr_rows) 
					{
			?>
			  <!-- list channel reup -->
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3"></div>
			    <div class="col-md-7" style="
			    <?php 
					if($arr_rows->die==1){
						echo "background-color: black";
					}
				?>
			    ">
					<a href="https://www.youtube.com/channel/<?php echo $arr_rows->link; ?>/videos" target="_blank"><?php echo $arr_rows->link; ?></a>
				</div>
				<div class="col-md-2">
					<a href="{{ url('admin/autoreup/channelreup/delete/'.$arr_rows->pk_reupchanneltd_id) }}" onclick="return window.confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
				</div>
			  </div>
			  <!-- end list channel reup -->
			<?php } ?>
			  <div class="row" style="margin-top:5px;">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<input type="submit" value="Cập nhật" class="btn btn-primary">
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>


@endsection