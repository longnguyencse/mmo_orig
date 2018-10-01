@extends('backend.layout')
@section('controller')
<div class="col-md-12">
	<!-- <div style="margin-bottom:5px;">
		<a href="{{ url('admin/user/add') }}" class="btn btn-primary">Add user</a>
	</div> -->
	<div class="panel panel-primary">
		<div class="panel-heading">List User</div>
		<div class="panel-body">
			<table class="table table-bordered table-hover">
				<tr>
					<th>STT</th>
					<th>Name</th>
					<th>Email</th>
					<th>Ngày kích hoạt</th>
					<th>Số ngày còn lại</th>
					<th>Trạng thái</th>
					<th style="width:100px;">Quản lý</th>
				</tr>
			<?php 
				$stt=0;
				foreach($arr as $rows){
					$stt++;
					$info=DB::table('info')->where('fk_users_id','=',$rows->id)->first();
					// echo $info->goi;
					// echo "<pre>";
					// print_r($info->goi);
			?>
				<tr>
					<td style="text-align: center;"><?php echo $stt; ?></td>
					<td>{{ $rows->name }}</td>
					<td>{{ $rows->email }}</td>
					<td style="text-align: center;"><?php echo isset($info->ngaykichhoat)?$info->ngaykichhoat:""; ?></td>
					<td style="text-align: center;">
						<?php
							// if (isset($info->goi)) {
							// 	echo $info->goi;
							// }

							$goi = $info->goi;
							$t = time()-$info->time;
							$sd = $t/86400;
							$conlai = $goi-$sd;
							echo $conlai<0?0:round($conlai,3);
							if ($conlai<=0) {
								DB::update("update users set status=0 where id='$info->fk_users_id' ");
							}	
						?>
					</td>
					<td><?php echo $rows->status==1?"<span style='font-weight: bold;color: red'>Enabled</span>":"Disabled"; ?></td>
					<td style="text-align:center;">
						<a href="{{ url('admin/user/edit/'.$rows->id) }}">Edit</a>&nbsp;
						<a href="{{ url('admin/user/delete/'.$rows->id) }}" onclick="return window.confirm('Are you sure?');">Delete</a>
					</td>
				</tr>
			<?php } ?>
			</table>

		</div>
	</div>
</div>

@endsection