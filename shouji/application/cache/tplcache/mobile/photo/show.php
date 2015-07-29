<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $info['photoname'];?>-<?php echo $webname;?></title>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
 <?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="<?php echo $cmsurl;?>">返回</a>
    <a class="city_tit" href="javascript:;"><?php echo $info['photoname'];?></a>
  </div>
  
  <div class="m-main">
<!--首页滚动图片-->
    <div class="home-device">
      <div class="swiper-main">
        <div class="swiper-container swiper1">
          <div class="swiper-wrapper">
            <?php $n=1; if(is_array($picturelist)) { foreach($picturelist as $row) { ?>
             <div class="swiper-slide"><img src="<?php echo $row['litpic'];?>" width="320" height="200" /></div>
            <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="ph_box_con">
    <h3><em><?php echo $info['photoname'];?></em><span>(<b style="font-weight: normal" id="cindex">1</b>/<?php echo count($picturelist);?>)</span></h3>
    <p><?php echo $info['imginfo'];?></p>
    </div>
</div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
  
<script>
var mySwiper = new Swiper('.swiper1',{
paginationClickable: true,
slidesPerView: 'auto',
            onSlideChangeEnd: function(swiper){
             $("#cindex").html(swiper.activeIndex+1);
            }
})
  </script>
</body>
</html>
