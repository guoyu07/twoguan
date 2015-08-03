<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>思途旅游CMS</title>
    <?php echo Common::getScript('jquery-1.8.3.min.js,common.js,jquery.hotkeys.js,msgbox/msgbox.js,slideTabs.js,hdate/hdate.js,echarts.js,echart-data.js'); ?>
    <?php echo Common::getCss('hdate.css','js/hdate'); ?>
    <?php echo Common::getCss('msgbox.css','js/msgbox'); ?>
    <?php echo Common::getCss('base.css,home.css'); ?>
<script>
$(function(){
$(".gx-help-fk").switchTab({trigger: "mouseover"});
$(window).resize(function(){
setDivAttr()
})
$(document).ready(function(){
              setDivAttr()
         });
function setDivAttr(){
//var cmsMainHeight = $(window).height()-89;
    var cmsMainWidth  = $(window).width()-450;
//$(".cms-main-box").height(cmsMainHeight);
$(".cms-content-box").width(cmsMainWidth);
}
$('.top-list-con table').find('tr:even').css('background','#effaff')
})
</script>
</head>
<body>
  <!--CMS主体内容-->
  <div class="cms-main-box">
  <!--左侧内容-->
  <div class="cms-content-box">
    
      <div class="cms-msg-box">
      <div class="admin_msg">
        <img class="fl" src="<?php echo $GLOBALS['cfg_public_url'];?>images/admin-img.png" alt="管理员" width="50" height="50" />
          <p class="name"><?php echo $username;?></p>
          <p class="time"><?php echo $rolename;?></p>
        </div>
        <div class="txt-msg">
        <div class="contact-btn">
          <a class="fk-btn" href="javascript:;">工单反馈</a>
          <a class="kf-btn" href="javascript:;">专属客服</a>
          </div>
        <p class="affiche">
            <span id="info1" style="display: none">欢迎使用思途CMS！您已获正版授权，受法律保护</span>
            <span id="info2" style="display: none">您未获得正版授权，会面临法律处罚，请<a href="http://www.stourweb.com/cms/accredit" target="_blank">联系我们</a></p>
        </span>
          <p class="version">我的版本： <span id="myversion"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="newversion" style="display: none">发现新版本<a href="javascript:;" onclick="ST.Util.addTab('系统升级','<?php echo $cmsurl;?>upgrade/index/parentkey/application/itemid/1')">立即升级</a></span></p>
        </div>
      </div>
      
      <!--产品管理-->
      <div class="product-manage">
      <div class="pro-mge-tit"><s></s>产品管理</div>
        <div class="pro-mge-con">
        <ul>
           <?php $n=1; if(is_array($menu['newproduct'])) { foreach($menu['newproduct'] as $v) { ?>
                <li>
                    <span><a href="javascript:;" data-url="<?php echo $v['url'];?>" data-name="<?php echo $v['name'];?>"><?php echo $v['name'];?></a></span>
                    <p>
                        <a href="javascript:;" data-url="<?php echo $v['order'];?>" data-name="<?php echo $v['name'];?>订单">
                            <em>订单</em>
                            <em id="<?php echo $v['flag'];?>_order_num"></em>
                        </a>
                    </p>
                </li>
           <?php $n++;}unset($n); } ?>
                <?php $n=1; if(is_array($addmodule)) { foreach($addmodule as $v) { ?>
                <li>
                    <span><a href="javascript:;" data-url="tongyong/index/typeid/<?php echo $v['id'];?>/parentkey/product/itemid/<?php echo $v['id'];?>" data-name="<?php echo $v['modulename'];?>"><?php echo $v['modulename'];?></a></span>
                    <p>
                        <a href="javascript:;" data-url="order/index/parentkey/order/itemid/<?php echo $v['id'];?>/typeid/<?php echo $v['id'];?>" data-name="<?php echo $v['modulename'];?>订单">
                            <em>订单</em>
                            <em id="<?php echo $v['pinyin'];?>_order_num"></em>
                        </a>
                    </p>
                </li>
                <?php $n++;}unset($n); } ?>
                <li>
                    <span><a href="javascript:;" data-url="order/index/parentkey/order/itemid/3/typeid/3" data-name="私人定制">私人定制</a></span>
                    <p>
                        <a href="javascript:;"  data-url="order/index/parentkey/order/itemid/3/typeid/3" data-name="私人定制">
                            <em>订单</em>
                            <em id="custom_order_num"></em>
                        </a>
                    </p>
                </li>
                <li>
                    <span><a href="javascript:;" data-url="order/xy/parentkey/order/itemid/15" data-name="自定义订单">自定义订单</a></span>
                    <p>
                        <a href="javascript:;"   data-url="order/xy/parentkey/order/itemid/15" data-name="自定义订单">
                            <em>订单</em>
                            <em id="zdy_order_num"></em>
                        </a>
                    </p>
                </li>
          </ul>
        </div>
      </div>
      
      <!--软文系统-->
      <div class="article-manage">
      <div class="atc-mge-tit"><s></s>软文系统</div>
        <div class="atc-mge-con article_item">
        <ul>
             <?php $n=1; if(is_array($menu['article'])) { foreach($menu['article'] as $v) { ?>
                <li>
                    <a href="javascript:;" data-url="<?php echo $v['url'];?>" data-name="<?php echo $v['name'];?>" >
                        <s></s>
                        <span><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/<?php echo $v['ico'];?>" alt="<?php echo $v['name'];?>" /></span>
                        <em><?php echo $v['name'];?></em>
                    </a>
                </li>
             <?php $n++;}unset($n); } ?>
          </ul>
        </div>
      </div>
      
      <!--数据统计-->
      <div class="data-count">
      <div class="data-count-tit">
        <s></s>
          <span>数据统计</span>
          <div class="time-interval">
          <em>时间范围</em>
            <input type="text" class="time-begin" id="starttime" onclick="calendar.show({ id: this })" value="<?php echo $starttime;?>" placeholder="<?php echo $starttime;?>" />
            <b></b>
            <input type="text" class="time-over" id="endtime" onclick="calendar.show({ id: this })" value="<?php echo $endtime;?>" placeholder="<?php echo $endtime;?>" />
            <input type="button" class="inquiry-btn query_btn" value="查询" />
          </div>
        </div>
        <div class="data-count-con">
        <div class="list-count-tit"><s></S>订单统计</div>
    <div id="order-count-box" style="height:400px; margin-bottom:50px">
          </div>
          <div class="list-count-tit"><s></S>访问量统计</div>
          <div id="pv-count-box" style="height:400px; margin-bottom:50px">
      </div>
          <div class="list-count-tit"><s></S>会员统计</div>
          <div id="member-count-box" style="height:400px; margin-bottom:50px">
      </div>
          <div class="list-count-tit"><s></S>TOP10 被访问页面</div>
          <div class="top-ten-page">
          <div class="top-nav topvisit">
            <span class="on" data-type="1">今日</span>
            <span data-type="2">昨日</span>
            <span data-type="3">本周</span>
            <span data-type="5">本月</span>
            <span data-type="6">上月</span>
            </div>
            <div class="top-list-con">
            <table width="100%" border="1" id="visit_list">
                <tr>
                  <th width="40%" height="40" align="left" scope="col">URL地址</th>
                  <th width="40%" align="left" scope="col">标题</th>
                  <th width="20%" align="center" scope="col">访问量</th>
                </tr>
              </table>
            </div>
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    
    <!--右侧内容-->
    <div class="cms-sidle-box">
    
    <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs1"></s>营销策略</div>
        <div class="sidle-con">
        <div class="sidle-menu-a">
                <?php $n=1; if(is_array($menu['sale'])) { foreach($menu['sale'] as $v) { ?>
                  <span><a href="javascript:;" data-url="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></span>
                <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      
      <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs2"></s>分类设置</div>
        <div class="sidle-con">
        <div class="sidle-menu-a">
                <?php $n=1; if(is_array($menu['kind'])) { foreach($menu['kind'] as $v) { ?>
                <span><a href="javascript:;" data-url="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></span>
                <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      
      <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs3"></s>站点设置</div>
        <div class="sidle-con">
        <div class="sidle-menu-a">
                <?php $n=1; if(is_array($menu['basic'])) { foreach($menu['basic'] as $v) { ?>
                <span><a href="javascript:;" data-url="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></span>
                <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      
      <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs4"></s>系统配置</div>
        <div class="sidle-con">
        <div class="sidle-menu-a">
                <?php $n=1; if(is_array($menu['system'])) { foreach($menu['system'] as $v) { ?>
                <span><a href="javascript:;" data-url="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></span>
                <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      
      <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs5"></s>优化应用</div>
        <div class="sidle-con">
        <div class="sidle-menu-a">
                <?php $n=1; if(is_array($menu['tool'])) { foreach($menu['tool'] as $v) { ?>
                <span><a href="javascript:;" data-url="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></span>
                <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      
      <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs6"></s>增值应用</div>
        <div class="sidle-con">
        <div class="sidle-menu-a">
                <?php $n=1; if(is_array($menu['application'])) { foreach($menu['application'] as $v) { ?>
                <span><a href="javascript:;" data-url="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></span>
                <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      
      <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs7"></s>模板管理</div>
        <div class="sidle-con">
        <div class="sidle-menu-a">
                <?php $n=1; if(is_array($menu['templet'])) { foreach($menu['templet'] as $v) { ?>
                <span><a href="javascript:;" data-url="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></span>
                <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      
      <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs8"></s>会员管理</div>
        <div class="sidle-con">
        <div class="sidle-menu-a">
                <?php $n=1; if(is_array($menu['member'])) { foreach($menu['member'] as $v) { ?>
                <span><a href="javascript:;" data-url="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></span>
                <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      
      <div class="sidle-module">
      <div class="sidle-tit"><s class="bgs9"></s>思途支持</div>
        <div class="sidle-con">
        <div class="sidle-atc">
          <div class="gx-help-fk">
            <div class="tabnav">
              <span><a href="javascript:;">系统更新</a></span>
              <span><a href="javascript:;">营销文章</a></span>
              <!--<span><a href="#">用户反馈</a></span>-->
              </div>
              <div class="tabcon">
              <ul id="newversion_list">
                </ul>
              </div>
              <div class="tabcon">
              <ul id="yx_article_list">
                </ul>
              </div>
<!--              <div class="tabcon">
              <ul>
                </ul>
              </div>-->
            </div>
          </div>
        </div>
      </div>
      
      <div class="copyright">Powered by Stourweb  V4.1   ©2007-2015</div>
        <div class="copyright">建议使用google浏览器访问后台</div>
      
    </div>
    
  </div>
    <!--客服专员-->
    <div class="kefu-box" style="display: none"><!--要清除内联样式-->
        <div class="kf-tit">
            <em>客服专员</em>
            <span id="kf_close"></span>
        </div>
        <div class="kf-con-list">
            <div class="con-list-tit">尊敬的客户您好，以下是您的专属客服，有任何疑问可以联系对应客服！<span>投诉电话：4006-0999-27</span></div>
            <ul class="list-kf-name">
                <li>
                    <p class="kf-name">售后客服</p>
                    <p class="kf-pic"><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/hongli.jpg" width="100" height="100" /></p>
                    <p class="txt">姓名：宋红丽</p>
                    <p class="txt">编号：ST0206</p>
                    <p class="txt">职位：售后客服</p>
                    <p class="txt">手机：13981917970</p>
                    <p class="txt">QQ ：1516944134</p>
                    <p class="txt">邮箱：shl@stourweb.cn</p>
                    <p class="kf-qq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1516944134&site=qq&menu=yes"><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/kfqq-ico.png" /></a></p>
                </li>
                <li>
                    <p class="kf-name">售后客服</p>
                    <p class="kf-pic"><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/shumei.jpg" width="100" height="100" /></p>
                    <p class="txt">姓名：王淑梅</p>
                    <p class="txt">编号：ST0207</p>
                    <p class="txt">职位：售后客服</p>
                    <p class="txt">手机：18284554129</p>
                    <p class="txt">QQ ：2360829845</p>
                    <p class="txt">邮箱：wsm@stourweb.cn</p>
                    <p class="kf-qq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2360829845&site=qq&menu=yes"><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/kfqq-ico.png" /></a></p>
                </li>
                <li>
                    <p class="kf-name">定制客服</p>
                    <p class="kf-pic"><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/jiawei.jpg" width="100" height="100" /></p>
                    <p class="txt">姓名：邓嘉伟</p>
                    <p class="txt">编号：ST0208</p>
                    <p class="txt">职位：高级UI设计</p>
                    <p class="txt">手机：13032893930</p>
                    <p class="txt">QQ ：2262918618</p>
                    <p class="txt">邮箱：djw@stourweb.cn</p>
                    <p class="kf-qq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2262918618&site=qq&menu=yes"><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/kfqq-ico.png" /></a></p>
                </li>
                <li class="mr_0">
                    <p class="kf-name">技术支持</p>
                    <p class="kf-pic"><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/fanfan.jpg" width="100" height="100" /></p>
                    <p class="txt">姓名：范治华</p>
                    <p class="txt">编号：ST0209</p>
                    <p class="txt">职位：PHP工程师</p>
                    <p class="txt">手机：18942820406</p>
                    <p class="txt">QQ ：1919218803</p>
                    <p class="txt">邮箱：fzh@stourweb.cn</p>
                    <p class="kf-qq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1919218803&site=qq&menu=yes"><img src="<?php echo $GLOBALS['cfg_public_url'];?>images/kfqq-ico.png" /></a></p>
                </li>
            </ul>
        </div>
    </div>
<script>
    var URL = '<?php echo URL::site();?>';
    $(function(){
        //打开项目页面
        $('.pro-mge-con').find('a').click(function(){
            var title = $(this).attr('data-name');
            var url = $(this).attr('data-url');
            ST.Util.addTab(title,url);
        })
        $('.sidle-menu-a').find('a').click(function(){
            var title = $(this).html();
            var url = $(this).attr('data-url');
            ST.Util.addTab(title,url);
        })
        //专属客服
        $(".kf-btn").click(function(){
            $('.kefu-box').show();
        })
       //专属客服关闭
        $('#kf_close').click(function(){
            $('.kefu-box').hide();
        })
        //top 10访问页面
        $(".topvisit").find('span').click(function(){
            var type = $(this).attr('data-type');
            $(this).addClass('on').siblings().removeClass('on');
            var url = URL+'index/ajax_visit_list';
            $.getJSON(url,"type="+type,function(data){
                $("#visit_list tr:not(:eq(0))").remove();//先清除内容
                var trlist = data.trlist;
                $("#visit_list tr:last").after(trlist);
            });
        })
        $(".topvisit").find('span').first().trigger('click');
        //文章管理
        $(".article_item").find('a').click(function(){
            var url = $(this).attr('data-url');
            var title = $(this).attr('data-name');
            ST.Util.addTab(title,url);
        })
        //获取订单数量
        $.ajax({
            type:'POST',
            url:URL+'index/ajax_order_num',
            dataType:'json',
            success:function(data){
                $.each(data,function(i,row){
                    $("#"+row.md+'_order_num').html(row.num);
                })
            }
        })
        //新版检测
        $.ajax({
            url: URL+"upgrade/ajax_check_update",
            dataType: 'json',
            success: function(data){
                $("#myversion").html(data.myversion);
                if(data.newinfo.desc){
                    $("#newversion").show();                }
                else
                {
                }
                checkRightV();
            }});
        getLastArticle();
        getNewVersionInfo();
        //查询日期
        $(".query_btn").click(function(){
            var starttime = $("#starttime").val();
            var endtime = $("#endtime").val();
            var arr = starttime.split("-");
            var starttime = new Date(arr[0], arr[1], arr[2]);
            var starttimes = starttime.getTime();
            var arrs =endtime.split("-");
            var lktime = new Date(arrs[0], arrs[1], arrs[2]);
            var lktimes = lktime.getTime();
            if (starttimes >= lktimes) {
                ST.Util.showMsg("结束日期不能小于开始日期",5,1000);
                return false;
            }
            initChart();
        })
    })
    //检测正版授权
    function checkRightV()
    {
        $.ajax({
            url: URL+"upgrade/ajax_check_right",
            dataType: 'json',
            success: function(data){
                if(data.status==1){
                    $('#info1').show();
                }
                else{
                    $('#info2').show();
                }
            }});
    }
    //异步获取文章
    function getLastArticle()
    {
        $.ajax({
            type:'POST',
            url:URL+'index/ajax_get_last_article',
            dataType:'json',
            success:function(data){
                var list = '';
                $.each(data,function(i,row){
                    list+='<li><a href="http://www.stourweb.com'+row.url+'" target="_blank">'+row.title+'</a></li>';
                });
                $("#yx_article_list").html(list)
            }
        })
    }
    //按星期获取订单数量(图表)
    function getOrderNumber(typeid)
    {
        var arr=[];
        $.ajax({
            type:'POST',
            data:{typeid:2},
            async : false,
            url:URL+'index/ajax_order_num_graph',
            dataType:'json',
            success:function(data){
                if (data) {
                    $.each(data,function(i,row){
                        arr.push(row.num);
                    })
                }
            }
        })
        return arr;
    }
    function getNewVersionInfo()
    {
        $.ajax({
            type:'POST',
            url:URL+'upgrade/ajax_version',
            dataType:'json',
            beforeSend:function(){
            },
            success:function(data){
                var out='';
                var k=1;
                $.each(data,function(i,row){
                    if(k<=5){
                        var desc = row.desc;
                        desc = desc.replace(/<[^>]+>/g,"");
                        out+="<li>";
                        out+='<a href="http://www.stourweb.com/cms/banben" target="_blank">'+row.pubdate+' 发布 '+row.version +'升级包</a>';
                        out+='<p>'+desc+'</p>';
                        out+='</li>';
                    }
                    k++;
                })
                $('#newversion_list').append(out);
            }
        })
    }
</script>
</body>
</html>
