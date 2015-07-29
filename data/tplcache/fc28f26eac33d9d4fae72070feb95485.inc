   <!--客户评论开始-->
    <div class="discuss">
      <h3>客户评论</h3>
      <div class="dis_list">
         {sline:getcommentlist flag='all' row='6'}
              <dl>
                <dt><b>[field:nickname/]</b><strong>满意度：</strong><span class="comment_star" data-score="[field:score/]"></span></dt>
                <dd>[field:content/]</dd>
              </dl>
         {/sline:getcommentlist}
       
      </div>
    </div>
    <!--客户评论结束-->   <!--热门团购产品开始-->                                 
       <div class="hot_pro">
      <h3>热门团购产品</h3>
      <div class="side_plb_list tuan_list">
        {sline:gettuanlist flag="hot" row="2"}
          <dl class="dl_list">
            	<dt><a class="fl" href="[field:url/]" target="_blank"><img class="fl" src="[field:lit240/]" width="218" height="130" alt="[field:litpic/]" /></a></dt>
              <dd class="dd1"><a href="[field:url/]" target="_blank">[field:title/]</a></dd>
              <dd class="dd2">
              	<span class="sp_1">¥[field:ourprice/]</span>
                <span class="sp_2">[field:discount/]折</span>
                <a href="/tuan/book_[field:aid/].html" target="_blank">抢购</a>
              </dd>
            </dl>
        {/sline:gettuanlist}
       
      </div>
      <script language="javascript">
         $(function(){
		     $(".tuan_list").find('.dl_list').last().addClass('bor_bot_0');
		 })
      </script>
    </div>
    <!--热门团购产品结束--> <!--相关线路开始-->
    <div class="l_side_list">
      <h3><s></s>相关线路</h3>
      <div class="l_side_con r_line">
        {sline:getlinelist flag='relative' row='4'}
        <dl>
          <dt><a href="[field:url/]" target="_blank"><img src="[field:lit160/]" width="105" height="80" alt="[field:title/]" /></a></dt>
          <dd class="dd_1"><a href="[field:url/]" target="_blank">[field:title/]</a>[field:sellpoint/]</dd>
          <dd class="dd_2">[field:price/]</dd>
        </dl>
       {/sline:getlinelist}
        <script language="javascript">
				 $(function(){
					 $(".r_line").find('dl').last().addClass('bor_bot_none');
				 })
         </script>
      
      </div>
    </div>
    <!--相关线路结束--> <!--相关酒店开始-->
    <div class="h_side_list">
      <h3><s></s>相关酒店</h3>
      <div class="h_side_con" id="r_h_list">
        {sline:gethotellist flag='relative' row='4'}
          	<dl>
            	<dt><s>[field:global.autoindex/]</s><a href="[field:url/]" target="_blank">[field:title/]</a></dt>
              <dd><p><label class="fl">星级:</label>[field:hotelrank/]</p><span><strong>&yen;[field:hotelprice/]</strong>起</span></dd>
            </dl>
        {/sline:gethotellist}
         <script language="javascript">
				 $(function(){
					 $(".r_h_list").find('dl').last().addClass('bor_bot_none');
				 })
         </script>
      </div>
    </div>
    <!--相关酒店结束-->