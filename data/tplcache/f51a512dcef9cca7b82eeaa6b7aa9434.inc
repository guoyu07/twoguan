<div class="line_list_con">
        	<div class="list_bt"><s></s><h3>{sline:field.kindname/}旅游线路</h3><a href="/lines/{sline:field.pinyin/}/" target="_blank">更多</a></div>
        	<div class="menu_left">
            <div class="line_menu_txt">
                {sline:getdest flag='mdd_hot' row='30'}
                <a href="[field:url/]" title="[field:title/]" target="_blank">[field:title/]</a>
                {/sline:getdest}
            </div>
            <div class="line_menu_pic">
                {sline:field.leftad/}
            </div>
          </div>
          
          <div class="list_rig">
          	<ul>
                {sline:getlinelist type="mdd" flag="recommend" row="5" }
                    <li>
                    <a class="fl" href="[field:url/]" target="_blank"><img class="fl lazyimg" src="" data-original="[field:lit160/]" width="80" height="60" alt="[field:title/]" title="[field:title/]" /></a>
                    <div class="con_txt">
                      <p class="p1"><a href="[field:url/]" target="_blank"><span style="[field:color/]">[field:title/]</span>[field:iconlist function=Helper_Archive::getIconList(@me)/]</a></p>
                      <p class="p2">推荐理由：[field:sellpoint/]</p>
                      <p class="p3">
                          <label class="wid_1">满意度：<span class="color_f60">[field:satisfyscore/]</span></label>
                          <label class="wid_1">订单：已成交 <span class="color_f60">[field:sellnum/]</span> 单</label>
                          <label class="wid_2">出发班期：<span class="color_f60">[field:startdate/]</span></label>
                      </p>
                    </div>
                    <div class="price">
                        <p class="p1">[field:price2/]</p>
                      <p class="p2">[field:jifentprice/]</p>
                    </div>
                  </li>
               {/sline:getlinelist}

            </ul>
          </div>
          {sline:field.middlead/}

          
        </div>