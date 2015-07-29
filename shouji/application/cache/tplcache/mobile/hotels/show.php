<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if(empty($row['seotitle'])) { ?><?php echo $row['hotelname'];?><?php } else { ?><?php echo $row['seotitle'];?><?php } ?>
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
    <a class="city_tit">酒店详情</a>
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
        <h1 class="tit"><?php echo $row['hotelname'];?></h1>
      </div>
      
      <ul>
      <li class="li_1">
        <p>
            <?php if(intval($row['hotelprice'])>0) { ?>
          <span><em>&yen;<?php echo $row['hotelprice'];?></em> 起</span>
            <?php } else { ?>
            <span><em>电询</em></span>
            <?php } ?>
            <a href="<?php echo $cmsurl;?>page/pinlun/id/<?php echo $row['id'];?>/typeid/2"><span class="myd"><b class="fl" style=" width:100%">满意度：<em><?php echo $row['satisfyscore'];?></em></b></span></a>
          </p>
        </li>
        <li class="li_2">
        <p>酒店编号：<?php echo $row['series'];?></p>
        <?php if(!empty($row['randname'])) { ?><p>酒店星级：<?php echo $row['randname'];?></p><?php } ?>
        <?php if(!empty($row['address'])) { ?><p>酒店位置：<?php echo $row['address'];?></p><?php } ?>
        <?php if(!empty($row['telephone'])) { ?><p>联系电话：<?php echo $row['telephone'];?></p><?php } ?>
          <?php if(!empty($row['opentime'])) { ?><p>开业时间：<?php echo $row['opentime'];?></p><?php } ?>
          <?php if(!empty($row['decoratetime'])) { ?><p>装修时间：<?php echo $row['decoratetime'];?></p><?php } ?>
          <?php if(!empty($row['attrname'])) { ?><p>酒店属性：<?php echo $row['attrname'];?></p><?php } ?>
        </li>
        <li class="li_3">
        <p><a href="<?php echo $cmsurl;?>hotels/create/id/<?php echo $row['id'];?>">选择房型、入住如期</a></p>
        </li>
      </ul>
      
    </div>
    
    <div class="show-list-js">
    <div class="list-con">
      <h3 class="tit">酒店介绍</h3>
      <div class="txt">
         <?php echo $row['content'];?>
        </div>
      </div>
      <?php if(!empty($row['fuwu'])) { ?>
      <div class="list-con mt10">
      <h3 class="tit">服务项目</h3>
      <div class="txt">
        <?php echo $row['fuwu'];?>
        </div>
      </div>
      <?php } ?>
      <?php if(!empty($row['jiaotong'])) { ?>
      <div class="list-con mt10">
        <h3 class="tit">交通指南</h3>
        <div class="txt">
          <?php echo $row['jiaotong'];?>
        </div>
      </div>
      <?php } ?>
      <?php if(!empty($row['zhoubian'])) { ?>
      <div class="list-con mt10">
        <h3 class="tit">周边景点</h3>
        <div class="txt">
          <?php echo $row['zhoubian'];?>
        </div>
      </div>
      <?php } ?>
      <?php if(!empty($row['zhuyi'])) { ?>
      <div class="list-con mt10">
        <h3 class="tit">注意事项</h3>
        <div class="txt">
          <?php echo $row['zhuyi'];?>
        </div>
      </div>
      <?php } ?>
      <?php if(!empty($row['fujian'])) { ?>
      <div class="list-con mt10">
        <h3 class="tit">附件设施</h3>
        <div class="txt">
          <?php echo $row['fujian'];?>
        </div>
      </div>
      <?php } ?>
    </div>
  
  </div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
  
 <!-- <div class="opy"></div>
  <div class="bom_fix_box">
  <a class="cell_phone" href="#">4006-5006-40</a>
    <a class="booking" href="#">立即预定</a>
  </div>-->
</body>
<script>
    var mySwiper = new Swiper('.swiper1',{
    pagination: '.pagination',
    paginationClickable: true,
    slidesPerView: 'auto'
  })
</script>
</html>
