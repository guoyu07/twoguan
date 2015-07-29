<!--推荐团购产品开始-->                                 
        <div class="hot_pro">
      <h3>推荐团购产品</h3>
      <div class="side_plb_list tuan_list">
        {sline:gettuanlist flag="recommend" row="2"}
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
    <!--推荐团购产品结束--><!--热卖线路产品开始-->
    <div class="hot_pro">
      <h3>热卖产品</h3>
      <div class="side_plb_list line_hot_list">
         {sline:getlinelist type="top" flag="hot" row="2"}
            <dl class="dl_list">
            	<dt><a class="fl" href="[field:url/]" target="_blank"><img class="fl" src="[field:lit240/]" width="218" height="130" alt="[field:title/]" /></a></dt>
              <dd class="dd1"><a href="[field:url/]" target="_blank">[field:title/]</a></dd>
            </dl>
          {/sline:getlinelist} 
      </div>
        <script language="javascript">
         $(function(){
		     $(".line_hot_list").find('.dl_list').last().addClass('bor_bot_0');
		 })
      </script>
    </div>
    <!--热卖线路产品结束--> <!--签证新闻动态开始-->
    <div class="car_atc">
      <h3>签证办理流程</h3>
      <div class="atc_list">
        <ul>
          {sline:getarclist flag='byattr' attrid='9'}
           <li><a href="[field:url/]">[field:title/]</a></li>
          {/sline:getarclist}
         
        </ul>
      </div>
    </div>
    <!--签证输程开始--> <!--相关酒店开始-->
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