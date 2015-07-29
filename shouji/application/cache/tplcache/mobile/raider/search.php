<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
 <?php echo Common::getScript('jquery-min.js,st_m.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="<?php echo $cmsurl;?>raider/index">返回</a>
    <a class="city_tit"><?php echo $kindname;?>-攻略</a>
  </div>
  
  <div class="m-main">
<section class="main-xl">
<div class="change-type">
  <div class="posfex">
        <ul id="des_w">
<li id="des"><a href="javascript:;" ><?php echo $kindname;?></a></li>
<li id="des-day"><a href="javascript:;"><?php echo $attrname;?></a></li>
</ul>
        </div>
<!--下拉列表-->
        <div id="des_con">
          <div class="change-type-c" id="des-c">
           <input type="hidden" name="kindid" id="kindid" value="<?php echo intval($kindid);?>" />
              <p><a href="<?php echo $cmsurl;?>raider/list/id/0/attrid/<?php echo intval($attrid);?>/order/<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($kindlist)) { foreach($kindlist as $v1) { ?>
              <?php if($v1['id']==$kindid) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>raider/list/id/<?php echo $v1['id'];?>/attrid/<?php echo intval($attrid);?>/order/<?php echo $order;?>"><?php echo $v1['kindname'];?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>raider/list/id/<?php echo $v1['id'];?>/attrid/<?php echo intval($attrid);?>/order/<?php echo $order;?>"><?php echo $v1['kindname'];?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
          <div class="change-type-c" id="des-day-c">
            <input type="hidden" name="attrid" id="attrid" value="<?php echo intval($attrid);?>" />
             <p><a href="<?php echo $cmsurl;?>raider/list/id/<?php echo $kindid;?>/attrid/0/order/<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $v3) { ?>
              <?php if($v3['id']==$attrid) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>raider/list/id/<?php echo $kindid;?>/attrid/{$v3['id'])}/order/<?php echo $order;?>"><?php echo $v3['attrname'];?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>raider/list/id/<?php echo $kindid;?>/attrid/<?php echo $v3['id'];?>/order/<?php echo $order;?>"><?php echo $v3['attrname'];?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
        </div>
        
        <div class="df_px">
        <span class="sp_1">默认排序</span>
          <input type="hidden" name="order" id="order" value="<?php echo $order;?>" />
          <span class="sp_2">
            <em>时间</em>
            <a class="up" href="<?php echo $cmsurl;?>raider/list/id/<?php echo $kindid;?>/attrid/<?php echo intval($attrid);?>/order/asc"></a>
            <a class="down" href="<?php echo $cmsurl;?>raider/list/id/<?php echo $kindid;?>/attrid/<?php echo intval($attrid);?>/order/desc"></a>
          </span>
        </div>
        
        <div class="fex">
        <!--list开始-->
          <?php $n=1; if(is_array($list)) { foreach($list as $v) { ?>
<div class="pdt_list">
            <a href="<?php echo $cmsurl;?>raider/show/id/<?php echo $v['id'];?>">
              <div class="pdt_img"><img src="<?php echo $v['litpic'];?>" width="90" height="64"></div>
              <div class="pdt_txt">
                <div class="pdt_box">
                  <p class="p_tit">
                  <em><?php echo $v['articlename'];?></em>
                    <span><?php echo $v['content'];?></span>
                  </p>
                </div>
              </div>
            </a>
          </div>
          <?php $n++;}unset($n); } ?>
          <!--list结束-->

</div>
        <div class="load_more"><img src="<?php echo $tpl;?>/images/loading.gif" />正在载入中</div>
        <input type="hidden" value="<?php echo $key;?>" id="key"/>
        <a href="javascript:void();" class="load-more"  page="1"/>点击载入更多<a>
</div>
</section>
</div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
</body>
<script type="text/javascript">
$('.load-more').click(function(){
        var docRec = $(this);
        var page = parseInt(docRec.attr('page'))+1;
        var kindid = $('#kindid').val();
        var attrid = $('#attrid').val();
        var order = $('#order').val();
        var key = $('#key').val();
        var url='/shouji/raider/list/kindid/'+kindid;
         $.get(url+'/attrid/'+attrid+'/action/ajaxline/page/'+page+'/order/'+order,function(results){
            eval('results='+results);
            var str = '';
            var listnum = 0;
            for(a in results){
               str += '<div class="pdt_list"><a href="<?php echo $cmsurl;?>raider/show/id/'+results[a]['id']+'"><div class="pdt_img"><img src="'+results[a]['litpic']+'" width="90" height="64"></div><div class="pdt_txt"><div class="pdt_box"><p class="p_tit"><em>'+results[a]['articlename']+'</em><span>'+results[a]['content']+'...</span></p></div></div></a></div>';
                listnum++;
            }
            docRec.attr('page',page);
            if(listnum==0){
              docRec.html('已无更多文章攻略信息');
            }
            $('.fex').append(str);
        });
    });
</script>
</html>
