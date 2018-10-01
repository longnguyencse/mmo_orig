@extends('backend.layout')
@section('controller')
	<div class="panel panel-primary">
		<div class="panel-heading">Danh sách kênh REUP</div>
		<div class="panel-body">
			<table class="table table-bordered table-hover" style="text-align: center;">
				<tr>
					<th style="width:50px">STT</th>
					<th style="text-align: center;">Name</th>
					<th style="text-align: center;">Link</th>
					<th style="text-align: center;">Ngày thêm</th>
					<th style="text-align: center;">ClientID</th>
					<th style="text-align: center;">ClientSecret</th>
					<th style="text-align: center;">Tình trạng kênh</th>
					<th style="text-align: center;">Tình trạng Api</th>
				</tr>

				<?php 
					$stt=0;
					$fk_user_id = Auth::user()->id;
					$info = DB::table('info')->where('fk_users_id','=',$fk_user_id)->first();
					foreach ($arr as $rows)
					{
						$stt++;
				?>
				<tr>
					<td><?php echo $stt; ?></td>
					<td><?php echo urldecode($rows->name); ?></td>
					<td><a target="_blank" href="https://www.youtube.com/channel/<?php echo $rows->link?>/videos"><?php echo $rows->link ?></a></td>
					<td><?php echo $rows->publish ?></td>
					<td><input type="" value="<?php echo $rows->clientID ?>" name=""></td>
					<td><?php echo $rows->clientSecret ?></td>
					<td style="
						<?php 
							if ($rows->die==1) {
								echo "background-color: black; color: white;";
							}
						?>
					">
						<?php 
							if ($rows->die==1) {
								echo "Kênh die hoặc API limit";
							}
						?>
					</td>
					<td style="
						<?php 
							if ($info->clientID != $rows->clientID || $info->clientSecret != $rows->clientSecret) {
								echo "background-color: yellow;";
							}
						?>
					">
						<?php
							if ($info->clientID != $rows->clientID || $info->clientSecret != $rows->clientSecret) {
								echo "Kênh chưa được cập nhật Client mới!";
							}
						?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
@endsection