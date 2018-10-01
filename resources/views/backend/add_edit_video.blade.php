@extends('backend.layout')
@section('controller')

<div class="col-md-8 col-xs-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">Thêm video theo dõi</div>
		<div class="panel-body">
			<form method="GET">
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Link video: </div>
			    <div class="col-md-10">
					<input type="search" id="video" name="video" class="form-control" placeholder="https://www.youtube.com/watch?v=g20t_K9dlhU">
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Thêm video vào kênh: </div>
			    <div class="col-md-10">
			  		<select class="form-control" id="kenh" name="kenh">
				        <option value="<?php echo $arr1->c_link; ?>"><?php echo $arr1->c_name; ?></option>
			      	</select>
				</div>
			  </div>
      
			  <div class="row" style="margin-top:5px;">
				<div class="col-md-2"></div>
				<div class="col-md-10">
					<input type="submit" class="btn btn-primary" value="Thêm video">
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>


@endsection