<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
 <?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
  
  <div class="m-main">
    
    <?php if(!empty($rows1)||!empty($rows2)) { ?>
    <div class="m_gl_list">
    <h3>攻略-游记</h3>
      <?php if(!empty($rows1)) { ?>
      <div class="swiper-container gl-container">
        <div class="swiper-wrapper">
          <?php $n=1; if(is_array($rows1)) { foreach($rows1 as $v) { ?>
          <div class="swiper-slide gl-slide">
            <img src="<?php echo $v['litpic'];?>" width="250" height="100%" />
            <span><?php echo $v['articlename'];?></span>
          </div>
          <?php $n++;}unset($n); } ?>
        </div> 
      </div>
      <?php } ?>
      <?php if(!empty($rows2)) { ?>
      <!--攻略列表开始-->
      <ul class="mdd_gl_list">
      <?php $n=1; if(is_array($rows2)) { foreach($rows2 as $v) { ?>
        <li>
        <a href="<?php echo $cmsurl;?>raider/show/id/<?php echo $v['id'];?>">
          <h4><?php echo $v['articlename'];?></h4>
          <p><?php echo $v['content'];?></p>
        </a>
        </li>
        <?php $n++;}unset($n); } ?>
        <li><a href="/shouji/raider/list/" class="load-more"  page="1" />点击查看更多</a></li>
      </ul>
      <?php } ?>
    </div>
    <?php } ?>
    <?php $n=1; if(is_array($citylist)) { foreach($citylist as $v) { ?>
    <div class="gl_list">
    <h3><?php echo $v['kindname'];?>-攻略<a href="<?php echo $cmsurl;?>raider/list/id/<?php echo $v['id'];?>">更多</a></h3>
      <?php $n=1; if(is_array($v['list'])) { foreach($v['list'] as $v2) { ?>
      <div class="pdt_list">
        <a href="<?php echo $cmsurl;?>raider/show/id/<?php echo $v2['id'];?>">
          <div class="pdt_img"><img src="<?php echo $v2['litpic'];?>" width="90" height="64"></div>
          <div class="pdt_txt">
            <div class="pdt_box">
              <p class="p_tit">
                <em><?php echo $v2['articlename'];?></em>
                <span><?php echo $v2['content'];?>...</span>
              </p>
            </div>
          </div>
        </a>
      </div>
      <?php $n++;}unset($n); } ?>
    </div>
    <?php $n++;}unset($n); } ?>
   
   <?php if(!empty($hotlist)) { ?> 
    <div class="hot-city">
    <h3>热门城市攻略</h3>
      <p>
      <?php $n=1; if(is_array($hotlist)) { foreach($hotlist as $key => $v) { ?>
        <?php if($key%4==0) { ?>
        </p>
        <p>
        <?php } ?>
      <a href="<?php echo $cmsurl;?>raider/list/id/<?php echo $v['id'];?>"><?php echo $v['kindname'];?></a>
      <?php $n++;}unset($n); } ?>
      
      </p>
    </div>
    <?php } ?>
  </div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
<script>
var mySwiper1 = new Swiper('.gl-container',{
paginationClickable: true,
slidesPerView: 'auto'
})
  </script>
</body>
</html>
