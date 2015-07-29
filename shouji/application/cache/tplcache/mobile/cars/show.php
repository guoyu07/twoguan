<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if(empty($row['seotitle'])) { ?><?php echo $row['carname'];?><?php } else { ?><?php echo $row['seotitle'];?><?php } ?>
-<?php echo $webname;?></title>
<meta name="keyword" content="<?php echo $row['keyword'];?>">
<meta name="description" content="<?php echo $row['description'];?>">
<?php echo Common::getCss('m_base.css,style.css'); ?>
<?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="javascript:history.go(-1);">返回</a>
    <a class="city_tit">车辆详情</a>
  </div>
  
  <div class="m-main">
  <!--首页滚动图片-->
    <?php if(!empty($row['pic_arr'])) { ?>
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
    <?php } ?>
    <div class="show-jc-js">
    
    <div class="bt-box">
        <h1 class="tit"><?php echo $row['carname'];?></h1>
      </div>
      
      <ul>
      <li class="li_1">
        <p>
          <?php if(intval($row['carprice'])>0) { ?>
          <span><em>&yen;<?php echo $row['carprice'];?></em> 起</span>
          <?php } else { ?>
            <span><em>电询</em> </span>
          <?php } ?>
            <a href="<?php echo $cmsurl;?>page/pinlun/id/<?php echo $row['id'];?>/typeid/3"><span class="myd"><b class="fl" style=" width:100%">满意度：<em><?php echo $row['satisfyscore'];?></em></b></span></a>
          </p>
        </li>
        <li class="li_2">
        <p>车辆编号：<?php echo $row['lineseries'];?></p>
        </li>
        <li class="li_3">
        <a href="<?php echo $cmsurl;?>cars/create/id/<?php echo $row['id'];?>"><p>选择行程路线</p></a>
        </li>
      </ul>
      
    </div>
    <?php if(!empty($row['content'])) { ?>
    <div class="show-list-js">
    <div class="list-con">
      <h3 class="tit">车辆信息</h3>
      <div class="txt">
        <?php echo $row['content'];?>
        </div>
      </div>
    <?php } ?>
    <?php if(!empty($row['notice'])) { ?>
      <div class="list-con mt10">
      <h3 class="tit">温馨提示</h3>
      <div class="txt">
        <?php echo $row['notice'];?>
        </div>
      </div>
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
</script>
</body>
</html>
