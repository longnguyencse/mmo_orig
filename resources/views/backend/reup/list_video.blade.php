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
	<div style="font-size: 20px;">
		<a style="color: red; font-weight: bold;" href="{{ url('admin/autoreup/channel/edit/'.$channel) }}">Kênh Reup</a>
		- <a style="color: red; font-weight: bold;" href="{{ url('admin/autoreup/channel/cauhinh/'.$channel) }}">Cấu hình</a> -
		Kênh: <a style="font-weight: bold;" target="_blank" href="https://www.youtube.com/channel/<?php echo $kenh->link?>/videos"><?php echo urldecode($kenh->name); ?></a>
	</div>
	<div style="margin-bottom:5px;">
		<a href="{{ url('admin/autoreup/video/add').'/'.$channel }}" class="btn btn-danger">Thêm video REUP</a>
		<span class="btn btn-default" onclick="checkall()" >Chọn tất cả</span>
		<span class="btn btn-default" onclick="uncheckall()" >Bỏ chọn tất cả</span>
		<span class="btn btn-default" onclick="update()" >Sẵn Sàng</span>
		<span class="btn btn-default" onclick="updatehuy()" >Không sẵn Sàng</span>
		<span><input type="number" value="1" id="time" min="1" style="width: 100px"></span>
		<span class="btn btn-default" onclick="publicca()" >Public</span>
		<span class="btn btn-default" onclick="privateca()" >Private</span>
		<span class="btn btn-danger" onclick="xoaca()">Xóa</span>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">Danh sách video REUP</div>
		<div class="panel-body" style="">
			<table class="table table-bordered table-hover" style="text-align: center;">
				<tr>
					<th style="width:50px">STT</th>
					<th style="text-align: center; width: 300px">Tên</th>
					<th style="text-align: center;">Video của bạn</th>
					<th style="text-align: center;">Video reup</th>
					<th style="text-align: center;">Ảnh</th>
					<th style="text-align: center;">View</th>
					<th style="text-align: center;">RUN</th>
					<th style="text-align: center;">Trạng thái</th>
					<th style="text-align: center;">Quản lý</th>
				</tr>
				<tbody style="overflow-x: hidden;overflow-y: auto;height: 370px;">
					<?php 
						$stt=0;
						foreach ($arr as $rows) 
						{
							$stt++;
					?>
					<tr class="<?php echo $rows->pk_reupvideo_id;?>">
						<td style="vertical-align: middle;"><?php echo $stt; ?></td>
						<td style="width: 150px;vertical-align: middle;"><?php echo urldecode($rows->name); ?></td>
						<td style="width: 150px;vertical-align: middle;">
							<a class="link<?php echo $stt; ?>" href="https://www.youtube.com/watch?v=<?php echo $rows->link ?>" target='_blank'><?php echo $rows->link ?></a>
							<?php if ($rows->die==1) { echo 'Không tồn tại';} ?>
						</td>
						<td style="width: 150px;vertical-align: middle;"><a href="https://www.youtube.com/watch?v=<?php echo $rows->linkreup ?>" target='_blank'><?php echo $rows->linkreup ?></a></td>
						<td style="width: 150px;vertical-align: middle;"><img style="width: 100px;" src="
							<?php
							if($rows->link=='')
								if(file_exists($rows->img))
									echo $rows->img;
								else
									echo "https://i.ytimg.com/vi/".$rows->linkreup."/default.jpg";
							else
								if(file_exists($rows->img))
									echo $rows->img;
								else
									echo "https://i.ytimg.com/vi/".$rows->link."/default.jpg";
							?>
						"></td>
						<td style="width: 100px;vertical-align: middle;"><?php echo $rows->view ?></td>

						<td style="width: 70px;vertical-align: middle;">
							<input style="zoom:2.5" class="box box<?php echo $stt; ?>" id="<?php echo $rows->pk_reupvideo_id; ?>" type="checkbox" name="<?php echo $rows->pk_reupvideo_id; ?>">
						</td>
						<td class="status<?php echo $stt; ?>" style="width: 100px;padding: 0;vertical-align: middle;
							<?php 
								if ($rows->link != '') {
									echo "background-color: green; color:white;";
								}
								else if ($rows->run==1) {
									echo "background-color: yellow;";
								}
							?>
						">
							<?php  
								if ($rows->link != '') {
									if($rows->trangthai1 != $rows->trangthai){
										if($rows->trangthai1==1){
											$p2='background-color: red;';
											$p1='color: black;background-color: yellow;';
										} else{
											$p1='background-color: red;';
											$p2='color: black;background-color: yellow;';
										}
									} else{
										$p1=$rows->trangthai1==1?'background-color: white; color: black':'background-color: red;';
										$p2=$rows->trangthai1==0?'background-color: white; color: black':'background-color: red;';
									}
									echo "
									<div style='height: 50px; padding-top: 14px;'>Uploaded</div>
									<table>
										<tr>
											<td class='public$rows->pk_reupvideo_id' id='$rows->pk_reupvideo_id' style='width: 50px; cursor:pointer; height: 50px;$p1' onclick=public(this.id); >Public</td>
											<td class='private$rows->pk_reupvideo_id' id='$rows->pk_reupvideo_id' style='width: 50px; cursor:pointer; height: 50px;$p2' onclick=private(this.id); >Private</td>
										</tr>
									</table>
									";
								} else if( $rows->run==1){
									echo "Sẵn sàng Reup";
								} else echo "Chưa sẵn sàng Reup";
							?>
							
						</td>
						<td style="vertical-align: middle;
							<?php if ($rows->die==1) {
								echo "background-color: black; color: white;";
							} ?>	
							">

							<?php 
								if($rows->die==0) {
									if ($rows->link == '') 
										{ 
							?>
								<a style="font-weight: bold;" href="{{ url('admin/autoreup/video/edit/'.$rows->pk_reupvideo_id) }}">Cấu hình</a> -
							<?php 		} ?>
								<a style="
									font-weight: bold;
									<?php echo $rows->sua==1?"color: red":"color: green"; ?>
									" href="{{ url('admin/autoreup/video/sua/'.$rows->pk_reupvideo_id) }}">Sửa</a>
							<?php 
								} else
									echo "Video bị xóa hoặc chặn quốc gia!";
							?>
							<!-- <?php //if($stt!=1){ ?> -->
							 <div style="cursor: pointer; font-weight: bold;" id="<?php echo $rows->pk_reupvideo_id; ?>" onclick="xoa(this.id);" >Xóa</div>
							 <!-- - <a href="{{ url('admin/autoreup/video/delete/'.$rows->pk_reupvideo_id) }}" onclick="return window.confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a> -->
							<!-- <?php //} ?> -->

						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			
		</div>
	</div>
		<div style="margin-left: 20px; margin-top: 20px;">
			<div style="font-style: italic; font-size: 16px; margin-top:7px;">
				<img style="width: 100px" src="public/images/ss.png">
				- Hệ thống chỉ Reup những video ở trạng thái Sẵn sàng Reup
			</div>
			<div style="font-style: italic; font-size: 16px; margin-top:7px;">
				<img style="width: 100px" src="public/images/dasua.png">
				- Đã đổi thumb cho video</div>
			<div style="font-style: italic; font-size: 16px; margin-top:7px;">
				<img style="width: 100px" src="public/images/sua.png">
				- Chưa đổi thumb cho video</div>
			<div style="font-style: italic; font-size: 16px; margin-top:7px;">
				<img style="width: 100px" src="public/images/ba.png">
				- Video đang ở trạng thái Public và chuẩn bị chuyển sang Private
			</div>
			<div style="font-style: italic; font-size: 16px; margin-top:7px; font-weight: bold;">- Trường hợp muốn chỉnh sửa thumb, hoặc private, public mà video đó chưa có trong tool thì bạn phải <span style="color: red; font-weight: bold;">Thêm video Reup</span> rồi <span style="color: green; font-weight: bold;">Sửa</span> link cho chính nó</div>
		</div>
		
</div>
<script type="text/javascript">
	function checkall(){
		$('.box').attr("checked",true);
	}
	function uncheckall(){
		$('.box').attr("checked",false);
	}
	function update(){
		numItems = $('.box').length;
		for(i=1;i<=numItems;i++){
			if ($('.link'+i).html() == '') {
				if ($('.box'+i).is(':checked')){
					$('.status'+i).html('Sẵn sàng Reup');
					$('.status'+i).attr("style","background-color:yellow;vertical-align: middle;width: 100px;padding: 0;");
					pk_reupvideo_id = $('.box'+i).attr('id');
					$.ajax({
			          //async: false,
			          type:'post',
			          url:'admin/public/update',
			          data:{
			          	pk_reupvideo_id
			          },
			          success: function(data){
			            console.log(data);
			          }
			        });
				} else {
					
				}
				if(i==numItems)
					alert('Cập nhật xong!');
			}
		}
	}
	function updatehuy(){
		numItems = $('.box').length;
		for(i=1;i<=numItems;i++){
			if ($('.link'+i).html() == '') {
				if ($('.box'+i).is(':checked')){
					$('.status'+i).html('Chưa sẵn sàng Reup');
					$('.status'+i).attr("style","background-color:none;vertical-align: middle;width: 100px;padding: 0;");
					pk_reupvideo_id = $('.box'+i).attr('id');
					$.ajax({
			          //async: false,
			          type:'post',
			          url:'admin/public/updatehuy',
			          data:{
			          	pk_reupvideo_id
			          },
			          success: function(data){
			            console.log(i);
			          }
			        });
				} else {
					
				}
				if(i==numItems)
					alert('Cập nhật xong!');
			}
		}
	}

	function xoaca(){
		var r=confirm("Bạn chắc chắn muốn xóa video!");
		if(r==true){
			numItems = $('.box').length;
			for(i=1;i<=numItems;i++){
				
				if ($('.box'+i).is(':checked')){
					pk_reupvideo_id=$('.box'+i).attr('id');
			        $('.'+pk_reupvideo_id).remove();
					$.ajax({
					 async: false,
					 type:'post',
			         url:'admin/public/xoa',
			          data:{
			          	pk_reupvideo_id
			          },
			         success: function(data){
			            // alert(data);
		          	 }
			        });
				}
				if(i==numItems)
					alert('Cập nhật xong!');
				
			}
		}
	}

	function publicca(){
		numItems = $('.box').length;
		for(i=1;i<=numItems;i++){
			if ($('.link'+i).html() != '') {
				if ($('.box'+i).is(':checked')){
					pk_reupvideo_id = $('.box'+i).attr('id');
					time=$('#time').val();
			        $('.public'+pk_reupvideo_id).attr('style','width: 50px; cursor:pointer; height: 50px;background-color:yellow; color:black;');
					$.ajax({
					  async: false,
			          type:'post',
			          url:'admin/public/update_public',
			          data:{
			          	pk_reupvideo_id,time
			          },
			          success: function(data){
			            // console.log(data);
			        	// alert(data);
			          }
			        });	
			    }
			}
				if(i==numItems)
					alert('Vui lòng đợi hệ thống cập nhật video của bạn!');
		}
	}

	function privateca(){
		numItems = $('.box').length;
		for(i=1;i<=numItems;i++){
			if ($('.link'+i).html() != '') {
				if ($('.box'+i).is(':checked')){
					pk_reupvideo_id = $('.box'+i).attr('id');
					time=$('#time').val();
			        $('.private'+pk_reupvideo_id).attr('style','width: 50px; cursor:pointer; height: 50px;background-color:yellow; color:black;');
					$.ajax({
					  async: false,
			          type:'post',
			          url:'admin/public/update_private',
			          data:{
			          	pk_reupvideo_id,time
			          },
			          success: function(data){
			            // console.log(data);
			        	// alert(data);
			          }
			        });	
			    }
			}
				if(i==numItems)
					alert('Vui lòng đợi hệ thống cập nhật video của bạn!');
		}
	}
	
	function public(id){
		$('.public'+id).attr('style','width: 50px; cursor:pointer; height: 50px;background-color:yellow; color:black;');
		pk_reupvideo_id=id;
		time=0;
		$.ajax({
          type:'post',
          url:'admin/public/update_public',
          data:{
          	pk_reupvideo_id,time
          },
          success: function(data){
            // console.log(data);
        	alert('Vui lòng đợi hệ thống cập nhật video của bạn!');
          }
        });	
	}
	function private(id){
		$('.private'+id).attr('style','width: 50px; cursor:pointer; height: 50px;background-color:yellow; color:black;');
		pk_reupvideo_id=id;
		time=0;
		$.ajax({
		 type:'post',
          	url:'admin/public/update_private',
	          data:{
	          	pk_reupvideo_id,time
	          },
	        success: function(data){
	            alert(data);
          	}
        });	
	}
	function xoa(id){
		var r=confirm("Bạn chắc chắn muốn xóa video!");
		if(r==true){
			pk_reupvideo_id=id;
			$.ajax({
			 type:'post',
	          	url:'admin/public/xoa',
		          data:{
		          	pk_reupvideo_id
		          },
		        success: function(data){
		            // alert(data);
	          	}
	        });
	        $('.'+id).remove();
	    }
	}

</script>
@endsection
