@extends('frontend/layout')
@section('controller')
<?php 
             	$category = DB::table("tbl_category_news")->orderBy("pk_category_news_id","desc")->get();
              ?>
              @foreach($category as $rows_category)
              <?php 
              	//kiem tra, neu danh muc co bai tin thi moi hien thi cac tin moi nhat
              $news = DB::table("tbl_news")->where("fk_category_news_id","=",$rows_category->pk_category_news_id)->orderBy("pk_news_id","desc")->first();
               ?>
               @if(isset($news->c_name))
                    <!-- list category tin tuc -->
                    <div class="row-fluid">
                        <div class="marked-title">
                            <h3><a href="#" style="color:white">{{ $rows_category->c_name }}</a></h3>
                        </div>
                    </div>                    
                    <div class="row-fluid">
                        <div class="span2">
                           <!-- first news -->
                            <article>
                             <div class="post-thumb">
   <a href="{{ url('news/detail/'.$news->pk_news_id) }}"><img src="{{ asset('upload/news/'.$news->c_img) }}" alt=""></a>
                                </div>
          <div class="cat-post-desc">
   <h3><a href="{{ url('news/detail/'.$news->pk_news_id) }}">{{ $news->c_name }}</a></h3>
             <p>{!! $news->c_description !!}</p>
                                </div>
                            </article>
                            <!-- end first news -->
                        </div>
                        <div class="span2">
 <?php 
 	$news1 = DB::select("select * from tbl_news where pk_news_id<".$news->pk_news_id." order by pk_news_id desc limit 0,3");
 	/*
	insert: DB::insert("insert into table(col1,col2) values(vl1,vl2)");
	update: DB::update("update table_name set col=value...")
	delete: DB::delete("delete from tbl_name where...");
 	*/
  ?>
                      @foreach($news1 as $rows_news1)
                           <!-- list news -->
                            <article class="twoboxes">
                                <div class="right-desc">
   <h3><a href="{{ url('news/detail/'.$rows_news1->pk_news_id) }}"><img src="{{ asset('upload/news/'.$rows_news1->c_img) }}" alt=""></a><a href="{{ url('news/detail/'.$rows_news1->pk_news_id) }}">{!! $rows_news1->c_name !!}</a></h3>  
                                    <div class="clear"></div>    
                                </div>
                                <div class="clear"></div>
                            </article>
                            <!-- end list news -->
                        @endforeach
                        </div>
                    </div>
                    <div class="clear"></div>
                    <!-- end list category tin tuc -->
                    @endif
                 @endforeach  
@endsection