<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $tuan['title'];?>-<?php echo $webname;?></title>
    <?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
    <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
    <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="<?php echo $cmsurl;?>">返回</a>
    <a class="city_tit" href="javascript:;">团购详情</a>
  </div>
  
  <div class="m-main">
  <!--首页滚动图片-->
    <div class="home-device">
      <div class="swiper-main">
        <div class="swiper-container swiper1">
          <div class="swiper-wrapper">
            <?php $n=1; if(is_array($tuan['picturelist'])) { foreach($tuan['picturelist'] as $row) { ?>
              <div class="swiper-slide"> <img src="<?php echo $row['litpic'];?>" width="320" height="200" /> </div>
            <?php $n++;}unset($n); } ?>
          </div>
        </div>
      </div>
      <div class="pagination pagination1"></div>
    </div>
    
    <div class="show-jc-js">
    
    <div class="bt-box">
        <h1 class="tit"><?php echo $tuan['title'];?></h1>
        <p class="txt"><?php echo $tuan['sellpoint'];?></p>
      </div>
      
      <ul>
      <li class="li_1">
        <p>
          <span><em>&yen;<?php echo $tuan['ourprice'];?></em> 起</span>
            <span class="myd"><a href="<?php echo $cmsurl;?>page/pinlun/id/<?php echo $tuan['id'];?>/typeid/13"><b class="fl" style=" width:100%">满意度：<em><?php echo $tuan['score'];?></em></b></span>
          </p>
        </li>
      </ul>
      
    </div>
    
    <div class="show-list-js">
    <div class="list-con">
      <h3 class="tit">团购介绍</h3>
      <div class="txt">
        <p>
                <?php echo $tuan['content'];?>
        </p>
        </div>
      </div>
    </div>
    
  </div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
  
  <div class="opy"></div>
  <div class="bom_fix_box">
  <a class="cell_phone" href="tel:<?php echo $phone;?>"><?php echo $phone;?></a>
    <a class="booking" href="<?php echo $cmsurl;?>tuan/order/orderid/<?php echo $tuan['id'];?>">立即预定</a>
  </div>
<script>
var mySwiper = new Swiper('.swiper1',{
        pagination: '.pagination',
paginationClickable: true,
slidesPerView: 'auto'
})
    $(function(){
        $(".myd").click(function(){
            window.
        })
    })
</script>
</body>
</html>
