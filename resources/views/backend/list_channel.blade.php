@extends('backend.layout')
@section('controller')
<div class="col-md-12">
	@can('sl',$count)
	<div style="margin-bottom:5px;">
		<a href="{{ url('admin/channel/add/') }}" class="btn btn-primary">Thêm kênh theo dõi</a>
	</div>
	@endcan('sl',$count)
	<h2>Bạn đã dùng <b style="color: red;"><?php echo $count."/".$sl ?></b> kênh!</h2>
	<div class="panel panel-primary">
		<div class="panel-heading">Danh sách kênh theo dõi</div>
		<div class="panel-body" style="">
			<table class="table table-bordered table-hover" style="text-align: center;">
				<tr>
					<th style="width:50px;text-align: center; vertical-align: middle;">STT</th>
					<th style="text-align: center; vertical-align: middle;">Name</th>
					<th style="text-align: center; vertical-align: middle;">Ghi chú</th>
					<th style="text-align: center; vertical-align: middle;">Link</th>
					<th style="text-align: center; vertical-align: middle;">Publish</th>
					<th style="text-align: center; vertical-align: middle;">Tổng video</th>
					<th style="text-align: center; vertical-align: middle;">Sub</th>
					<th style="text-align: center; vertical-align: middle;">View kênh</th>
					<!-- <th style="text-align: center; vertical-align: middle;">Sub tăng</th>
					<th style="color: red;font-weight: bold;text-align: center; vertical-align: middle;">View tăng/giờ</th> -->
					<th style="text-align: center; vertical-align: middle;">Ngày thêm</th>
					<th style="text-align: center; vertical-align: middle;">Nguyên nhân die</th>
					<th style="text-align: center; vertical-align: middle;">Quản lý<br><span style="font-weight: 100; color: red">Nền đen: DIE</span></th>
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
					<td style="text-align: center; vertical-align: middle;"><a href="{{ url('admin/channel/video/'.$rows->pk_channel_id) }}"><?php echo urldecode($rows->c_name); ?></a></td>
					<td style="text-align: center; vertical-align: middle;"><div><?php echo $rows->ghichu ?></div></td>
					<td style="text-align: center; vertical-align: middle;"><input type="text" style="width: 100px" value="<?php echo $rows->c_link ?>" name=""></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo substr( $rows->c_publish,0,10); ?></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo $rows->c_tongvideo ?></td>
					<td style="text-align: center; vertical-align: middle;">
						<?php
							$subtang = $rows->c_subtang-$rows->c_sub;
							if($subtang<=0) $subtang=0;
							if ($subtang!=0) {
								echo $rows->c_sub.'(<span style="color:red">+'.$subtang.'</span>)'; 
							} else{
								echo $rows->c_sub;
							}
						?>
					</td>
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
					<!-- <td style="text-align: center; vertical-align: middle;"><?php $subtang = $rows->c_subtang-$rows->c_sub;if($subtang<=0) $subtang=0;echo $subtang; ?></td>
					<td style="color: red;font-weight: bold;text-align: center; vertical-align: middle;">
						<?php 
							$viewtang = $rows->c_viewtang-$rows->c_view;
							$time=round(($rows->c_time1-$rows->c_time)/3600,2);

							if($viewtang<=0) 
								$viewtang=0;
							if($time<=0) 
								$time=0;
							echo $viewtang." views/".$time."h"; 

						
						?>
					</td> -->
					<td style="text-align: center; vertical-align: middle;"><?php echo $rows->c_date ?></td>
					<td style="text-align: center; vertical-align: middle;"><textarea class="form-control" readonly style="height: 100px" id="" value cols="20" rows="10"><?php echo $rows->die_do=='0'?'':$rows->die_do; ?></textarea></td>
					<td style="text-align: center; vertical-align: middle;
						<?php 
							if($rows->die==1){
								echo "background-color: black;";
							} 
						?>
					">
						<a target="_blank" href="https://www.youtube.com/channel/<?php echo $rows->c_link?>/videos">Xem kênh</a> - <a href="{{ url('admin/channel/delete/'.$rows->pk_channel_id) }}" onclick="return window.confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
			
		</div>
	</div>
</div>

@endsection