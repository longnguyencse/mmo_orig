@extends('backend.layout')
@section('controller')
<div class="col-md-12">
	<div style="font-weight: bold;font-size: 20px; margin-bottom: 20px">Kênh: <a target="_blank" href="https://www.youtube.com/channel/<?php echo $kenh->c_link?>/videos"><?php echo urldecode($kenh->c_name); ?></a></div>
	<?php 
		if ($kenh->die==1) {
	?>
		<div style="font-weight: bold;font-size: 20px; margin-bottom: 20px">Kênh DIE lúc: <?php echo $kenh->date; ?></div>
	<?php } ?>
	<div style="margin-bottom:5px;">
		<a href="{{ url('admin/channel/video/add').'/'.$channel->fk_video_id }}" class="btn btn-primary">Thêm video</a>
		<span onclick="view()" href="" class="btn btn-primary">Copy tất cả link video</span>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">Danh sách video theo dõi</div>
		<div class="panel-body" style="">
			<table class="table table-bordered table-hover" style="text-align: center;">
				<tr>
					<th style="width:50px;text-align: center; vertical-align: middle;">STT</th>
					<th style="text-align: center; vertical-align: middle;">Ảnh</th>
					<th style="text-align: center; vertical-align: middle;">Name</th>
					<th style="text-align: center; vertical-align: middle;">Link</th>
					<th style="text-align: center; vertical-align: middle;">Publish</th>
					<th style="text-align: center; vertical-align: middle;">View</th>
					<!-- <th style="color: red;font-weight: bold;text-align: center; vertical-align: middle;">View tăng/giờ</th>
					<th style="text-align: center; vertical-align: middle;">View hiện tại</th> -->
					<th style="text-align: center; vertical-align: middle;">Chết</th>
					<th style="text-align: center; vertical-align: middle;">Sống</th>
					<!-- <th style="text-align: center; vertical-align: middle;">Nguyên nhân die</th> -->
					<th style="text-align: center; vertical-align: middle;">Quản lý</th>
				</tr>
				<tbody style="overflow-x: hidden;overflow-y: auto;height: 400px;">
					<?php 
						$stt=0;
						foreach ($arr as $rows) 
						{
							$stt++;
					?>
				<tr>
					<td style="text-align: center; vertical-align: middle;"><?php echo $stt; ?></td>
					<td style="width: 50px;text-align: center; vertical-align: middle;" ><img style="width: 100px" src="<?php echo $rows->c_img ?>"></td>
					<td style="width: 200px;text-align: center; vertical-align: middle;"><?php echo urldecode($rows->c_name); ?></td>
					<td style="width: 150px;text-align: center; vertical-align: middle;"><a id="link<?php echo $stt?>" href="https://www.youtube.com/watch?v=<?php echo $rows->c_link ?>" target='_blank'><?php echo $rows->c_link ?></a></td>
					<td style="width: 100px;text-align: center; vertical-align: middle;"><?php echo $rows->c_publish ?></td>
					<td style="text-align: center; vertical-align: middle;">
						<?php 
							 
							$viewtang = $rows->c_viewtang-$rows->c_view;
							if($viewtang<=0) $viewtang=0;
							if ($viewtang!=0) {
								echo $rows->c_view.'(<span style="color:red">+'.$viewtang.'</span>)'; 
							} else{
								echo $rows->c_view;
							}
						?>
					</td>
					<td style="width: 100px;text-align: center; vertical-align: middle;"><?php echo $rows->c_die ?></td>
					<td style="width: 100px;text-align: center; vertical-align: middle;"><?php echo $rows->c_song ?></td>
					<!-- <td style="text-align: center; vertical-align: middle;"><?php echo $rows->die_do==0?'':$rows->die_do; ?></td> -->
					<td style="text-align: center; vertical-align: middle;
						<?php 
							if($rows->c_died==1){
								echo 'background-color: black;';
							} 
						?>
					">
						<a href="{{ url('admin/channel/video/delete/'.$rows->pk_video_id) }}" onclick="return window.confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
					</td>
				</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div id="copy" style="display: none;"></div>
	</div>
</div>
@endsection
<script type="text/javascript">
var stt="<?php echo $stt ?>";
var b=0;
function view(){
    b++;
	var c_link= $("#link"+b).html();

    $('#copy').append(c_link+' ');
    if( b < stt ){
        view();
    } else{
    	xong();
    }
}
function xong(){
	var $temp = $("<textarea>");
	$("body").append($temp);
	$temp.val($('#copy').html().replace(/[^a-zA-Z0-9-_]/g,'\r\n')).select();
	document.execCommand("copy");
	$temp.remove();
	alert("Đã copy xong!");
}

</script>
