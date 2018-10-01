@extends('backend.layout')
@section('controller')
<div class="col-md-8 col-xs-offset-2">	
	<div class="panel panel-primary">
		<div class="panel-heading">Add edit user</div>
		<div class="panel-body">
		<form method="post" action="">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<!-- rows -->
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2">Name</div>
				<div class="col-md-10">
					<input type="text" value="{{ isset($arr->name)?$arr->name:'' }}" name="name" class="form-control" required>
				</div>
			</div>
			<!-- end rows -->
			<!-- rows -->
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2">Email</div>
				<div class="col-md-10">
					<input type="email" value="{{ isset($arr->email)?$arr->email:'' }}" name="email" class="form-control" required>
				</div>
			</div>
			<!-- end rows -->
			
			<!-- rows -->
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2">Gói</div>
				<div class="col-md-10">
					<input type="number"  name="number" min="0" max="1000" value="{{ isset($info->goi)?$info->goi:'' }}" required> Ngày
				</div>
			</div>
			<!-- end rows -->
			<!-- rows -->
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2">Kênh Reup và Theo dõi</div>
				<div class="col-md-10">
					<input type="number" value="{{ isset($arr->sl)?$arr->sl:'' }}" name="sl" min="0" required>  Kênh
				</div>
			</div>
			<!-- end rows -->
			<!-- rows -->
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2" style="color: red; font-weight: bold;">REUP</div>
				<div class="col-md-10">
					<input style="margin-right: 20px;" <?php echo $arr->reup==1?'checked':''; ?> type="checkbox" name="reup">
					Lượng kênh Reup <input type="number" required min="0" value="<?php echo $arr->kenhreup; ?>" name="kenhreup" style="width: 100px;">
				</div>
			</div>
			<!-- end rows -->
			<!-- rows -->
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2" style="color: red; font-weight: bold;">Kích hoạt</div>
				<div class="col-md-4">
					<input type="checkbox" name="checkbox">
				</div>
				<div class="col-md-2" style="color: red; font-weight: bold;">Hủy</div>
				<div class="col-md-4">
					<input type="checkbox" name="checkbox1">
				</div>
			</div>
			<!-- end rows -->
			<!-- rows -->
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2">Password</div>
				<div class="col-md-10">
					<input type="password" name="password" class="form-control" @if(isset($arr->email)) placeholder="Không đổi password thì không nhập thông tin vào ô textbox này" @endif>
				</div>
			</div>
			<!-- end rows -->
			<!-- rows -->
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2"></div>
				<div class="col-md-10">
					<input type="submit" value="Process" class="btn btn-primary">
				</div>
			</div>
			<!-- end rows -->
		</form>
		</div>
	</div>
</div>
@endsection