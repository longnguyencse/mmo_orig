@extends('backend.layout')
@section('controller')

<div class="col-md-8 col-xs-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">Thêm video REUP</div>
		<div class="panel-body">
			<form method="GET">
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Link của video: </div>
			    <div class="col-md-10">
					<input type="search" id="autoreupvideo" class="form-control" name="autoreupvideo" placeholder="https://www.youtube.com/watch?v=jlf26LJdM43">
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Thêm video vào kênh: </div>
			    <div class="col-md-10">
			  		<select class="form-control" id="kenh" name="kenh">
				        <option value="<?php echo $arr->pk_reupchannel_id; ?>"><?php echo urldecode($arr->name); ?></option>
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