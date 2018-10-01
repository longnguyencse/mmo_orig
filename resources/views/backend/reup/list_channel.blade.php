@extends('backend.layout')
@section('controller')
<script type="text/javascript">
	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});
</script>

<div class="col-md-12">
	<div style="margin-bottom:5px;">
		<h2>Bạn đã dùng <b style="color: red;"><?php echo $count."/".$sl ?></b> kênh!</h2>
		@can('sl',$count)<a href="{{ url('admin/autoreup/channel/add') }}" class="btn btn-danger">Thêm kênh REUP</a>@endcan('sl',$count)
		<span class="btn btn-primary" onclick="checkall()" >Chọn tất cả</span>
		<span class="btn btn-primary" onclick="uncheckall()" >Bỏ chọn tất cả</span>
		<span class="btn btn-primary" onclick="update()" >SETUP</span>
		<div style="font-style: italic; color: red; font-size: 16px; margin-top:7px;">*** Trạng thái <span style="color: green; font-weight: bold;">Auto</span>: Bật chế độ tự động REUP khi có video mới ***</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">Danh sách kênh REUP</div>
		<div class="panel-body" style=";">
			<table class="table table-bordered table-hover" style="text-align: center;">
				<tr>
					<th style="width:50px">STT</th>
					<th style="text-align: center; vertical-align: middle;">Name</th>
					<th style="text-align: center; vertical-align: middle;">Ghi chú</th>
					<th style="text-align: center; vertical-align: middle;">View</th>
					<th style="text-align: center; vertical-align: middle;">Sub</th>
					<th style="text-align: center; vertical-align: middle;">Set Auto</th>
					<th style="text-align: center; vertical-align: middle;">Trạng thái</th>
					<th style="text-align: center; vertical-align: middle;">Cắt video</th>
					<th style="text-align: center; vertical-align: middle;">Upload video</th>
					<th style="text-align: center; vertical-align: middle;">Uploaded/Tổng</th>
					<th style="text-align: center; vertical-align: middle;">Nguyên nhân die</th>
					<th style="text-align: center; vertical-align: middle;">
						Quản lý
						<div><i style="color: red; font-weight: normal;">Nền đen: Kênh die hoặc API limit</i></div>
					</th>
				</tr>
				<tbody style="overflow-x: hidden;overflow-y: auto;height: 400px;">
				<?php 
					$stt=0;
					foreach ($arr as $rows)
					{
						$viewtang=DB::table('channel')->where('c_link','=',$rows->link)->first();
						$stt++;
						$count=DB::table('reupvideo')->where('die','=',0)->where('fk_reupchannel_id','=',$rows->pk_reupchannel_id)->where('link','=','')->where('run','=',1)->count();
						$uploaded=DB::table('reupvideo')->where('fk_reupchannel_id','=',$rows->pk_reupchannel_id)->where('link','!=','')->count();
						$tong=DB::table('reupvideo')->where('fk_reupchannel_id','=',$rows->pk_reupchannel_id)->count();
				?>
				<tr>
					<td style="vertical-align: middle;"><?php echo $stt; ?></td>
					<td style="vertical-align: middle;"><a href="{{ url('admin/autoreup/video/'.$rows->pk_reupchannel_id) }}"><?php echo urldecode($rows->name); ?></a></td>
					<td style="vertical-align: middle;"><?php echo $rows->ghichu; ?></td>
					<td style="vertical-align: middle;">
						<?php
						if(isset($viewtang->c_viewtang)){
							$viewchannel = $viewtang->c_viewtang-$viewtang->c_view;
							if($viewchannel<=0) $viewchannel=0;
							if ($viewchannel!=0) {
								echo $viewtang->c_view.'(<span style="color:red">+'.$viewchannel.'</span>)'; 
							} else{
								echo $viewtang->c_view;
							}
						}
						?>
					</td>
					<td style="text-align: center; vertical-align: middle;">
						<?php
						if(isset($viewtang->c_subtang)){
							$subchannel = $viewtang->c_subtang-$viewtang->c_sub;
							if($subchannel<=0) $subchannel=0;
							if ($subchannel!=0) {
								echo $viewtang->c_sub.'(<span style="color:red">+'.$subchannel.'</span>)'; 
							} else{
								echo $viewtang->c_sub;
							}
						}
						?>
					</td>
					<td style="width: 70px;vertical-align: middle;">
						<input style="zoom:2.5" class="box box<?php echo $stt; ?>" id="<?php echo $rows->pk_reupchannel_id; ?>" type="checkbox" <?php echo $rows->auto==1?'checked':''; ?> name="<?php echo $rows->pk_reupchannel_id; ?>">
					</td>
					<td class="status<?php echo $stt; ?>" style="width: 100px;vertical-align: middle;
						<?php 
							if ($rows->auto == 1) {
								echo "background-color: green; color:white;";
							}
							else if ($rows->auto==1) {
								echo "background-color: yellow;";
							}
						?>
					">
						<?php  
							if ($rows->auto == 1) {
								echo "Auto";
							} else{
								echo "Not Auto";
							}
						?>
					</td>
					<td style="vertical-align: middle;">
						<div>Đầu: <?php echo $rows->catdau; ?> giây</div>
						<div>Cuối: <?php echo $rows->catduoi; ?> giây</div>
					</td>
					<td style="vertical-align: middle;
						<?php 
							if ($rows->loi==1) {
								echo "background-color: black; color: white";
							} else{
								echo $count==0?"background-color: green; color: white":"background-color: yellow; color:black";
							}
						?>
					">
						<?php 
							if ($rows->loi==1) {
								echo "Lỗi";
							} else{
								echo $count==0?"Hoàn thành":"Đang chạy...";
							}
						?>
					</td>
					<td style="vertical-align: middle;"><?php echo $uploaded."/".$tong; ?></td>
					<td style="text-align: center; vertical-align: middle;">
					<?php 
						if(isset($viewtang->die_do) && $viewtang->die==1){
					?>
						<textarea class="form-control" readonly style="height: 100px" id="" value cols="20" rows="10"><?php echo isset($viewtang->die_do)?$viewtang->die_do:''; ?></textarea>
					<?php
						}
					?>
					</td>
					<td style="vertical-align: middle;
					<?php 
						if(isset($viewtang->die_do) && $viewtang->die==1){
							echo "background-color: black";
						}
					?>
					">
						<a href="{{ url('admin/autoreup/channel/edit/'.$rows->pk_reupchannel_id) }}">Kênh Reup</a> - <a href="{{ url('admin/autoreup/channel/cauhinh/'.$rows->pk_reupchannel_id) }}">Cấu hình</a> - <a target="_blank" href="https://www.youtube.com/channel/<?php echo $rows->link?>/videos">Xem kênh</a> - <a href="{{ url('admin/autoreup/channel/delete/'.$rows->pk_reupchannel_id) }}" onclick="return window.confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function checkall(){
		$('.box').attr("checked","");
	}
	function uncheckall(){
		$('.box').attr("checked",false);
	}
	function update(){
		numItems = $('.box').length;
		for(i=1;i<=numItems;i++){
			
			checked=0;
			if ($('.box'+i).is(':checked')){
				checked=1;
				$('.status'+i).html('Auto');
				$('.status'+i).attr("style","width: 100px;background-color: green; color:white;vertical-align: middle;");
			} else {
				$('.status'+i).html('Not Auto');
				$('.status'+i).attr("style","width: 100px;background-color:none;vertical-align: middle;");
			}
			pk_reupchannel_id = $('.box'+i).attr('id');
			$.ajax({
	          type:'post',
	          url:'admin/auto/update',
	          data:{
	          	pk_reupchannel_id,checked
	          },
	          success: function(data){
	            // console.log(data);
	          }
	        });	
		}
	}
	
	
</script>
@endsection