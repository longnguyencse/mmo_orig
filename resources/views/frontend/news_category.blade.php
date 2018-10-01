@extends('frontend/layout')
@section('controller')
<?php 
	$category = DB::table("tbl_category_news")->where("pk_category_news_id","=",$id)->first();
 ?>
<div class="marked-title">
                        <h3><?php echo isset($category->c_name)?$category->c_name:"" ?></h3>
                    </div>
                    <div class="row">  
                <?php 
                	//$news = DB::select("select * from tbl_news where fk_category_news_id=$id order by pk_news_id desc");
                	$news = DB::table("tbl_news")->where("fk_category_news_id","=",$id)->orderBy("pk_news_id","desc")->paginate(3);
                 ?>      
                 @foreach($news as $rows)       
                        <!-- list news -->
                        <article>
							<div class="cat-post-desc">
								<h3><a href="{{ url('news/detail/'.$rows->pk_news_id) }}">{{ $rows->c_name }}</a></h3>
								<p><a href="{{ url('news/detail/'.$rows->pk_news_id) }}"><img class="img_category" src="{{ asset('upload/news/'.$rows->c_img) }}" alt=""></a>{!! $rows->c_description !!}</p>
							</div>
							<div class="clear"></div>
							<div class="line_category"></div>
						</article>                       
                        <!-- end list news -->
                   @endforeach                                                             
                                                
                    </div>
                    <div class="clear"></div>
                    {{ $news->links() }}
@endsection