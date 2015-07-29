<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if(!empty($row['seotitle'])) { ?><?php echo $row['seotitle'];?><?php } else { ?><?php echo $row['spotname'];?><?php } ?>
-<?php echo $webname;?></title>
<meta name="keywords" content="<?php echo $row['keyword'];?>" />
<meta name="description" content="<?php echo $row['description'];?>" />
 <?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
   <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="javascript:history.go(-1);">返回</a>
    <a class="city_tit"><?php echo $row['spotname'];?></a>
  </div>
  
  <div class="m-main">
  <!--首页滚动图片-->
    <div class="home-device">
      <div class="swiper-main">
        <div class="swiper-container swiper1">
          <div class="swiper-wrapper">
            <?php $n=1; if(is_array($row['pic_arr'])) { foreach($row['pic_arr'] as $v) { ?>
              <div class="swiper-slide"> <img src="<?php echo $v['0'];?>" width="320" height="200" /> </div>
            <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      <div class="pagination pagination1"></div>
    </div>
    
    <div class="show-jc-js">
    
    <div class="bt-box">
        <h1 class="tit"><?php echo $row['spotname'];?></h1>
      </div>
      
      <ul>
      <li class="li_1">
        <p>
          <span><?php if($row['doorprice']>0) { ?><em>&yen;<?php echo $row['doorprice'];?></em> 起<?php } else { ?><em>电询</em><?php } ?>
</span>
            <a href="<?php echo $cmsurl;?>page/pinlun/id/<?php echo $row['id'];?>/typeid/5"><span class="myd"><b class="fl" style=" width:100%">满意度：<em><?php echo $row['satisfyscore'];?></em></b></span></a>
          </p>
        </li>
        <li class="li_2">
        <p>景点类型与星级：<?php echo $row['attrname'];?></p>
          <p>景点位置：<?php echo $row['address'];?></p>
        </li>
        <li class="li_3"><a href="<?php echo $cmsurl;?>spot/create/id/<?php echo $row['id'];?>"><p>选择价格类型 / 填写购买信息</p></a></li>
      </ul>
      
    </div>
    
    <div class="show-list-js">
      <div class="list-con">
      <h3 class="tit">景点介绍</h3>
      <div class="txt">
        <?php echo $row['content'];?>
        </div>
      </div>
        <?php if(!empty($row['booknotice'])) { ?>
        <div class="list-con mt10">
            <h3 class="tit">预订须知</h3>
            <div class="txt">
                <?php echo $row['booknotice'];?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php if(!empty($other)) { ?>
    <div class="xg-box">
    <h3>相关推荐</h3>
      <?php $n=1; if(is_array($other)) { foreach($other as $v) { ?>
      <div class="pdt_list">
        <a href="<?php echo $cmsurl;?>spot/show/id/<?php echo $v['id'];?>">
          <div class="pdt_img"><img src="<?php echo $v['litpic'];?>" width="90" height="64"></div>
          <div class="pdt_txt">
            <div class="pdt_box">
              <p class="p_tit">
                <em><?php echo $v['spotname'];?></em>
                
                <span class="mt5">优惠价：<?php if($v['doorprice']>0) { ?><b>&yen;<?php echo $v['doorprice'];?></b> 起<?php } else { ?><b>电询</b><?php } ?>
</span>
              </p>
            </div>
          </div>
        </a>
      </div>
      <?php $n++;}unset($n); } ?>
    </div>
    <?php } ?>
  </div>
  
 <?php echo  Stourweb_View::template('public/foot');  ?>
<script>
    var mySwiper = new Swiper('.swiper1',{
        pagination: '.pagination',
paginationClickable: true,
slidesPerView: 'auto'
})
     $(function(){
         if($('.list-con img').length>0){
         var wp = $(window).width()-100;
         $('.list-con img').css('width', wp+'px' );
         }
     })
</script>
</body>
</html>
