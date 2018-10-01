@extends('backend.layout')
@section('controller')
<!-- <script type="text/javascript">
	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});
</script> -->
<div class="col-md-8 col-xs-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">Edit</div>
		<div class="panel-body">
			<form method="GET">
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">ID Channel: </div>
			    <div class="col-md-10">
					<input type="search" id="q" name="q" class="form-control" required placeholder="ID Channel...">
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
		          <div class="col-md-2">Ghi chú: </div>
		          <div class="col-md-10">
		            <input type="search" id="ghichu" name="ghichu" class="form-control">
		          </div>
		        </div>
			  <div class="row" style="margin-top:5px;">
			  	<div class="col-md-2">Số lượng video: </div>
			    <div class="col-md-10">
					<input type="number" value="10" min="1" max="50" id="sl" name="sl" >
				</div>
			  </div>
			  <div class="row" style="margin-top:5px;">
				<div class="col-md-2"></div>
				<div class="col-md-10">
					<input type="submit" class="btn btn-primary" value="Thêm Channel">
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>

<!-- <div class="col-md-12">
	<div class="panel panel-primary">
		<div id="channel" class="panel-heading">
			List channel
		</div>
		<div class="panel-body">
			<table class="table table-bordered table-hover" id="bang_video" style="text-align: center;">
				<tr>
					<th style="width:50px">STT</th>
					<th>Img</th>
					<th>Name</th>
					<th style="width: 100px;">Link</th>
					<th>View</th>
					<th>Publish</th>
					<th>Manager</th>
				</tr>
			</table>
		</div>
	</div>
</div> -->
<!-- <script type="text/javascript">
var video_id,video_view,video_img,video_name,video_pub;

function send(a){
	var video_name = $('#name'+a).html();
	var video_id = $('#id'+a).html();
	var video_view = $('#view'+a).html();
	var video_img = $('#img'+a).attr("src");
	var video_pub = $('#publish'+a).html();
	var pk_channel_id  = $('#pk').html();

	$('#button'+a).attr("style","background-color:red");
		$.ajax({
          type:'post',
          url:'video',
          data:{
          	video_name,video_img,video_id,video_pub,video_view,pk_channel_id
          },
          success: function(data){
            console.log(data);
          }
        });
}

function channel(){
	$('.tr').remove();
	var a=1;
	var c_link = $('#c_link').val();
	var c_name,c_view,c_sub,c_publish,c_tongvideo,playlist;
	var arr=[];
	var request2 = gapi.client.youtube.channels.list({
      part: 'snippet,contentDetails,statistics',
      id:c_link,
    });
    request2.execute(function(responsechannel) {
    	c_name=responsechannel.items[0].snippet.title;
    	c_view=responsechannel.items[0].statistics.viewCount;
    	c_sub=responsechannel.items[0].statistics.subscriberCount;
    	c_publish=responsechannel.items[0].snippet.publishedAt;
    	c_tongvideo=responsechannel.items[0].statistics.videoCount;
    	playlist=responsechannel.items[0].contentDetails.relatedPlaylists.uploads;
    	
	    $.ajax({
          type:'post',
          url:'add',
          data:{
          	c_link,c_name,c_view,c_sub,c_publish,c_tongvideo
          },
          success: function(data){
            // console.log(data);
            $('#pk').html(data);
          }
        });
	    var request3 = gapi.client.youtube.playlistItems.list({
		    'maxResults': '50',
	        'part': 'snippet,contentDetails',
	        'playlistId': playlist
	    });
	    
	    request3.execute(function(responsepll) {
	    	
	    	for(i=0;i<responsepll.items.length;i++){
	    		var request4 = gapi.client.youtube.videos.list({
			        part: 'snippet,contentDetails,statistics',
			        id:responsepll.items[i].contentDetails.videoId,
			    });
			    request4.execute(function(response) { //video
	    			// arr.push(response);
	    			// console.log(response);
	    			$('#bang_video').append("<tr class='tr'><th>"+a+"</th><th><img id='img"+a+"' style='width:200px' src='"+response.items[0].snippet.thumbnails.standard.url+"'></th><th id='name"+a+"'>"+response.items[0].snippet.title+"</th><th id='id"+a+"'>"+response.items[0].id+"</th><th id='view"+a+"'>"+response.items[0].statistics.viewCount+"</th><th id='publish"+a+"'>"+response.items[0].snippet.publishedAt+"</th><th><input id='button"+a+"' onclick='send("+a+")' class='btn btn-primary' value='Add'></th></tr>");
	    			a++;

			  	});
			}
			// setTimeout(f,2000);
	    });

	 //    function video(){
	 //    	console.log(arr);
	 //    	for(var b=0;b<arr.length;b++){
	 //    		var a=b;
	 //    		setTimeout( function timer(){
		// 	        // alert("hello world");
		// 	        video_id=arr[a].items[0].id;
		// 			console.log(video_id);
		// 			console.log(a);
		// 	    	video_name=arr[a].items[0].snippet.title;
		// 	    	video_img=arr[a].items[0].snippet.thumbnails.standard.url;
		// 	    	video_view=arr[a].items[0].statistics.viewCount;
		// 	    	video_pub=arr[a].items[0].snippet.publishedAt;		
		// 			$.post('controller/post_video.php',{postid:video_id,postname:video_name,postimg:video_img,postview:video_view,postpub:video_pub},
		// 		      function(data){
		// 		        $('#result1').html(data);
		// 		      }
		// 		    );
		// 	    }, b*3000 );
	 //    	}
		// }
		// var b = 0;
		// function f() {
		// 	var howManyTimes = arr.length;
		// 	video_id=arr[b].items[0].id;
		// 	// console.log(video_id);
		// 	console.log(arr);
	 //    	video_name=arr[b].items[0].snippet.title;
	 //    	video_img=arr[b].items[0].snippet.thumbnails.standard.url;
	 //    	video_view=arr[b].items[0].statistics.viewCount;
	 //    	video_pub=arr[b].items[0].snippet.publishedAt;		
		// 	// $.post('controller/post_video.php',{postid:video_id,postname:video_name,postimg:video_img,postview:video_view,postpub:video_pub},
		//  //      function(data){
		//  //        $('#result1').html(data);
		//  //      }
		//  //    );
		//     b++;
		//     if( b < howManyTimes ){
		//         setTimeout( f, 200 );
		//     }
		// }
    });
}
</script> -->

@endsection