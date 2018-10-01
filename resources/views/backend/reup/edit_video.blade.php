@extends('backend.layout')
@section('controller')

<div class="col-md-8 col-xs-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">Cấu hình Auto Reup video</div>
		<div class="panel-body">
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">ID video: </div>
			    <div class="col-md-10">
					<input type="text" class="form-control" readonly="" value="{{ $arr->linkreup }}">
				</div>
			  </div>

			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Tên video: </div>
			    <div class="col-md-10">
					<input type="text" class="form-control" name="name" value="<?php echo isset($arr->name)?urldecode($arr->name):''; ?>">
				</div>
			  </div>

			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Mô tả: </div>
			    <div class="col-md-10">
			    	<textarea name="desc" class="form-control" style="height: 100px" id="" value cols="30" rows="10"><?php echo isset($arr->description)?urldecode($arr->description):''; ?></textarea>
				</div>
			  </div>

			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Tag: </div>
			    <div class="col-md-10">
			    	<textarea name="tag" class="form-control" style="height: 100px" id="" cols="30" rows="10"><?php echo isset($arr->tag)?$arr->tag:''; ?></textarea>
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Ảnh: </div>
			    <div class="col-md-10">
					<input type="file" name="img">
					<?php 
						if ($arr->img != '') {

					?>
						<img style="width: 200px" src="<?php echo $arr->link==''?$arr->img:'https://i.ytimg.com/vi/'.$arr->link.'/default.jpg' ?>">
					<?php
						}
					?>
				</div>
			  </div>
			  <div class="row" style="margin-top:15px;">
			  	<div class="col-md-2">Trạng thái: </div>
			    <div class="col-md-10">
						Public <input type="radio" name="status" <?php echo $arr->status==1?'checked':''; ?> value="1">
						 <!-- ======== Private <input type="radio" name="status" <?php echo $arr->status!=1?'checked':''; ?> value="0">
						Publish at <input type="text" name="publishat" value="<?php echo date('Y-m-d').'T'.date('H:i:s').'.000Z'; ?>"> -->
				</div>
			  </div>
			  
			  <div class="row" style="margin-top:15px;">
			  	<div class="col-md-2">RUN: </div>
			    <div class="col-md-10">
					<input type="checkbox" name="run" <?php echo $arr->run==1?'checked':''; ?>>
				</div>
			  </div>
      			
			  <div class="row" style="margin-top:15px;">
				<div class="col-md-2"></div>
				<div class="col-md-10">
					<input type="submit" class="btn btn-primary" value="Cập nhật">
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>


@endsection