<div class="item masonry_brick">
			<div class="item_t">
				<div class="img">
					<a href="[field:url/]" target="_blank"><img width="274"
                     src="[field:id function=getDefaultImage()/]" rel="[field:pic/]" class="lazy_load" /></a>

				</div>
				<div class="title"><span>[field:photoname/]</span></div>
			</div>
			<div class="item_b clearfix">
				<div class="items_likes fl">
					<a href="javascript:;" onClick="addFavorate(this,[field:id/])" class="like_btn"></a>
					<em class="bold">[field:favorite runphp='yes'] if(empty(@me)) @me=0;[/field:favorite]</em>
				</div>
				<div class="items_comment fr"><!--<a href="[field:url/]">评论</a><em class="bold">(0)</em>--></div>
			</div>
		</div><!--item end-->