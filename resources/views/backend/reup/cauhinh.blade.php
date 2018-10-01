@extends('backend.layout')
@section('controller')
<div class="col-md-8 col-xs-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">Cấu hình cho kênh</div>
		<div class="panel-body">
			<form method="post" enctype="multipart/form-data">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">

			  	<div class="row" style="margin-top:5px;">
				  	<div class="col-md-3">Ghi chú: </div>
				    <div class="col-md-9">
						<input type="search" id="ghichu" name="ghichu" value="<?php echo $arr->ghichu!=''?$arr->ghichu:''; ?>" class="form-control">
						
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
				  	<div class="col-md-3">Mặc định cắt video: </div>
				    <div class="col-md-9">
						Cắt đầu: <input type="number" id="catdau" min="0" name="catdau" value="<?php echo $arr->catdau!=''?$arr->catdau:5; ?>"  > giây - 
						Cắt cuối: <input type="number" id="catduoi" name="catduoi" value="<?php echo $arr->catduoi!=''?$arr->catduoi:5; ?>" min="0"> giây
					</div>
				</div>

			  <!-- chinh sua tieu de -->
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3">Thời gian giãn Public: </div>
			    <div class="col-md-9">
					<input type="number" style="width: 75px" value="<?php echo $arr->gian; ?>" id="gian" name="gian" required > Phút
					
				</div>
			  </div>

			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3">Lặp tiêu đề trong mô tả: </div>
			    <div class="col-md-9">
					<input type="number" style="width: 75px" min="0" value="<?php echo $arr->lap; ?>" id="lap" name="lap" required > Lần
					
				</div>
			  </div>

			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3">Chỉnh sửa tiêu đề: </div>
			    <div class="col-md-9">
					<input type="search" id="tieude" name="tieude" value="<?php $tieude=$arr->tieude; if($arr->tieude_type==2){$var=explode('thaybang',$tieude); $tieude=$var[0]; $tieude=trim($tieude);} echo $tieude!=''?$tieude:''; ?>" placeholder="Nhập từ khóa muốn thay" class="form-control">
					
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3"></div>
			    <div class="col-md-9">
					<input type="radio" value="1" id="them" <?php if ($arr->tieude_type==1) {echo "checked";} ?> checked name="edittieude" > <i style="color:red;">Thêm</i>
					<input type="radio" value="2" id="thay" <?php if ($arr->tieude_type==2) {echo "checked";} ?> name="edittieude" > <i style="color:red;">Thay thế</i>
					<input type="radio" value="3" id="thaytb" <?php if ($arr->tieude_type==3) {echo "checked";} ?> name="edittieude" > <i style="color:red;">Thay toàn bộ</i>
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3"></div>
			    <div class="col-md-9">
					<input type="search" id="thaybang" name="thaybang" value="<?php $tieude=$arr->tieude; if($arr->tieude_type==2){$var=explode('thaybang',$tieude); $tieude=$var[1]; $tieude=trim($tieude); echo $tieude!=''?$tieude:'';} ?>" placeholder="Nhập từ khóa cần thay thế" class="form-control">
				</div>
			  </div>
			  <!-- end chinh sua tieu de -->
			  <!-- chinh sua mo ta -->
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3">Chỉnh sửa mô tả: </div>
			    <div class="col-md-9">
					<textarea id="mota" name="mota" placeholder="Nhập từ khóa muốn thay" class="form-control" style="height: 100px" id="" cols="30" rows="10"><?php $mota=$arr->mota; if($arr->mota_type==2){$var=explode('thaybang',$mota); $mota=$var[0]; $mota=trim($mota);} echo $mota!=''?$mota:''; ?></textarea>
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3"></div>
			    <div class="col-md-9">
					<input type="radio" value="1" <?php if ($arr->mota_type==1) {echo "checked";} ?> id="themmmt" checked name="editmota" > <i style="color:red;">Thêm</i>
					<input type="radio" value="2" <?php if ($arr->mota_type==2) {echo "checked";} ?> id="thaymt" name="editmota" > <i style="color:red;">Thay thế</i>
					<input type="radio" value="3" <?php if ($arr->mota_type==3) {echo "checked";} ?> id="thaytbmt" name="editmota" > <i style="color:red;">Thay toàn bộ</i>
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3"></div>
			    <div class="col-md-9">
					<textarea id="thaybangmt" placeholder="Nhập từ khóa cần thay thế" name="thaybangmt" class="form-control" style="height: 100px" id="" cols="30" rows="10"><?php $mota=$arr->mota; if($arr->mota_type==2){$var=explode('thaybang',$mota); $mota=$var[1]; $mota=trim($mota); echo $mota!=''?$mota:'';} ?></textarea>
				</div>
			  </div>
			  <!-- end chinh sua mo ta -->
			  <!-- chinh sua tag -->
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3">Chỉnh sửa tag: </div>
			    <div class="col-md-9">
					<input type="search" id="tag" name="tag" value="<?php $tag=$arr->tag; if($arr->tag_type==2){$var=explode('thaybang',$tag); $tag=$var[0]; $tag=trim($tag);} echo $tag!=''?$tag:''; ?>" placeholder="Nhập từ khóa muốn thay" class="form-control">
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3"></div>
			    <div class="col-md-9">
					<input type="radio" value="1" <?php if ($arr->tag_type==1) {echo "checked";} ?> id="themt" checked name="edittag" > <i style="color:red;">Thêm</i>
					<input type="radio" value="2" <?php if ($arr->tag_type==2) {echo "checked";} ?> id="thayt" name="edittag" > <i style="color:red;">Thay thế</i>
					<input type="radio" value="3" <?php if ($arr->tag_type==3) {echo "checked";} ?> id="thaytbt" name="edittag" > <i style="color:red;">Thay toàn bộ</i>
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3"></div>
			    <div class="col-md-9">
					<input type="search" id="thaybangt" name="thaybangt" value="<?php $tag=$arr->tag; if($arr->tag_type==2){$var=explode('thaybang',$tag); $tag=$var[1]; $tag=trim($tag); echo $tag!=''?$tag:'';} ?>" placeholder="Nhập từ khóa cần thay thế" class="form-control">
				</div>
			  </div>
			  <!-- end chinh sua tag -->

			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-3">Logo thumb (200x200)</div>
			    <div class="col-md-9">
					<input type="file" name="img">
					<?php 
						if ($arr->img != '0') {
					?>
						<img style="width: 200px" src="<?php echo $arr->img=='0'?'':$arr->img; ?>">
					<?php
						}
					?>
					<div>Xóa video intro: <input type="checkbox" name="xoa"></div>
				</div>
			  </div>
			  
			  <div class="row" style="margin-top:5px;">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<input type="submit" value="Cập nhật" class="btn btn-primary">
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
// tieu de
	if(!$('#thay').is(":checked"))
		$('#thaybang').hide();
	$('#thay').click(function(){
		$('#thaybang').fadeIn();
		$('#thaybang').attr("required","");
	});
	$('#them').click(function(){
		$('#thaybang').hide();
		$('#thaybang').removeAttr("required");
	});
	$('#thaytb').click(function(){
		$('#thaybang').hide();
		$('#thaybang').removeAttr("required");
	});
// end tieu de



// tieu de
	if(!$('#thaymt').is(':checked'))
		$('#thaybangmt').hide();
	$('#thaymt').click(function(){
		$('#thaybangmt').fadeIn();
		$('#thaybangmt').attr("required","");
	});
	$('#themmmt').click(function(){
		$('#thaybangmt').hide();
		$('#thaybangmt').removeAttr("required");
	});
	$('#thaytbmt').click(function(){
		$('#thaybangmt').hide();
		$('#thaybangmt').removeAttr("required");
	});
// end tieu de



// tieu de
	if(!$('#thayt').is(':checked'))
		$('#thaybangt').hide();
	$('#thayt').click(function(){
		$('#thaybangt').fadeIn();
		$('#thaybangt').attr("required","");
	});
	$('#themt').click(function(){
		$('#thaybangt').hide();
		$('#thaybangt').removeAttr("required");
	});
	$('#thaytbt').click(function(){
		$('#thaybangt').hide();
		$('#thaybangt').removeAttr("required");
	});
// end tieu de
	
</script>


@endsection