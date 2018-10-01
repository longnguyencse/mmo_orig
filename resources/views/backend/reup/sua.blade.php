@extends('backend.layout')
@section('controller')

<div class="col-md-8 col-xs-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">Chỉnh sửa video sau khi Upload</div>
		<div class="panel-body">
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<?php if($arr->link==''){ ?>
				  <div class="row" style="margin-top:5px;">
				  	<div class="col-md-2">ID video: </div>
				    <div class="col-md-10">
						<input type="text" class="form-control" name="link" placeholder="iui3ghND-aa" value="<?php echo $arr->link==''?'':$arr->link; ?>">
						<div><i style="color: red;">Cập nhật link này để có thể chỉnh sửa thumb, public, private cho video!</i></div>
				  		<div><i style="color: red;">Bạn phải cập nhật chính xác ID video của kênh!</i></div>
					</div>
				  </div>
				<?php } else{ ?>
				<div class="row" style="margin-top:5px;">
				  	<div class="col-md-2">ID video: </div>
				    <div class="col-md-10">
						<input type="text" class="form-control" name="link" placeholder="iui3ghND-aa" readonly="" value="<?php echo $arr->link==''?'':$arr->link; ?>">
					</div>
				 </div>
				 <div class="row" style="margin-top:5px;">
				  	<div class="col-md-2">Tiêu đề: </div>
				    <div class="col-md-10">
						<input type="text" class="form-control" readonly="" value="<?php echo $arr->name==''?'':urldecode($arr->name); ?>">
					</div>
				 </div>
			  <!-- <div class="row" style="margin-top:5px;">
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
			  </div> -->
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Ảnh: </div>
			    <div class="col-md-10">
					<input type="file" name="img">
					<?php 
						if ($arr->sua == 1) 
						{
					?>
						<img style="width: 200px" src="{{ $arr->img }}">
					<?php
						} else{
					?>
					<?php 
						if ($arr->img != '') 
						{
					?>
						<img style="width: 200px" src="<?php echo $arr->link==''?$arr->img:'https://i.ytimg.com/vi/'.$arr->link.'/default.jpg' ?>">
					<?php
						}}
					?>
				</div>
			  </div>
			  <div class="row" style="margin-top:15px;">
			  	<div class="col-md-2">Trạng thái: </div>
			    <div class="col-md-10">
						Public <input type="radio" name="status" value="0" <?php echo $arr->trangthai==0?'checked':''; ?> value="1">
						 HOẶC Private <input type="radio" name="status" value="1" <?php echo $arr->trangthai==1?'checked':''; ?> value="0">
						SAU <input type="number" style="width:75px" value="1" name="time" required min="0"> Phút
				</div>
				<div class="col-md-2"></div>
			    <div class="col-md-10">
						Xóa video <input type="radio" name="status" value="2" <?php echo $arr->trangthai==2?'checked':''; ?> value="1"> <i style="color: red;">Chú ý xóa video sẽ không khôi phục lại được!</i>
				</div>
			  </div>
			  
			  <div class="row" style="margin-top:15px;">
			  	<div class="col-md-2">Sửa: </div>
			    <div class="col-md-10">
					<input type="checkbox" name="run" <?php echo $arr->sua==1?'checked':''; ?>> <i style="color: red">Video của bạn đã được Upload. Nếu muốn sửa toàn bộ thông tin ở trên thì tích vào đây</i>
				</div>
			  </div>
      			<?php } ?>
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