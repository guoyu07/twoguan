<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if(empty($row['seotitle'])) { ?><?php echo $row['title'];?><?php } else { ?><?php echo $row['seotitle'];?><?php } ?>
-<?php echo $webname;?></title>
<meta name="keyword" content="<?php echo $row['keyword'];?>">
<meta name="description" content="<?php echo $row['description'];?>">
<?php echo Common::getCss('m_base.css,style.css'); ?>
<?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
<script>
$(function(){
  $(".ul_con_list").find(".p_con").first().show();
  $(".ul_con_list").find("i").first().addClass("icon-arrow-down");
$("li span.s_tit").click(function(){
$(this).next(".p_con").show();
$(this).parents("li").siblings().children(".p_con").hide();
$(this).parents("li").siblings().children().children("i").removeClass("icon-arrow-down")
$(this).children("i").addClass("icon-arrow-down");
})
})
</script>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="javascript:history.go(-1);">返回</a>
    <a class="city_tit">签证详情</a>
  </div>
  
  <div class="m-main">
  <!--首页滚动图片-->
    <?php if(!empty($row['litpic'])) { ?>
    <div class="home-device">
      <div class="swiper-main">
        <div class="swiper-container swiper1">
          <div class="swiper-wrapper">
            <div class="swiper-slide"> <img src="<?php echo $row['litpic'];?>" width="320" height="200" /> </div>
          </div>
        </div>
      </div>
      <div class="pagination pagination1"></div>
    </div>
    <?php } ?>
    <div class="show-jc-js">
    
    <div class="bt-box">
        <h1 class="tit"><?php echo $row['title'];?></h1>
      </div>
      
      <ul>
      <li class="li_1">
        <p>
          <span><em>&yen;<?php echo $row['price'];?></em> 起</span>
            <a href="<?php echo $cmsurl;?>page/pinlun/id/<?php echo $row['id'];?>/typeid/8"><span class="myd"><b class="fl" style=" width:100%">满意度：<em><?php echo $row['satisfyscore'];?></em></b></span></a>
          </p>
        </li>
        <li class="li_2">
        <?php if(!empty($row['kindname'])) { ?><p>签证类型：<?php echo $row['kindname'];?></p><?php } ?>
          <?php if(!empty($row['country'])) { ?><p>签证地区：<?php echo $row['country'];?></p><?php } ?>
          <?php if(!empty($row['cityname'])) { ?><p>签发城市：<?php echo $row['cityname'];?></p><?php } ?>
          <?php if(!empty($row['handleday'])) { ?><p>办理时间：<?php echo $row['handleday'];?></p><?php } ?>
          <?php if(!empty($row['validday'])) { ?><p>有&nbsp;&nbsp;效&nbsp;&nbsp;期：<?php echo $row['validday'];?></p><?php } ?>
          <p>面试需要：<?php if($row['needinterview']==1) { ?>需要<?php } else { ?>不需要<?php } ?>
</p>
          <p>邀&nbsp;&nbsp;请&nbsp;&nbsp;函：<?php if($row['needletter']==1) { ?>需要<?php } else { ?>不需要<?php } ?>
</p>
          <?php if(!empty($row['handlerange'])) { ?><p>受理范围：<?php echo $row['handlerange'];?></p><?php } ?>
          <?php if(!empty($row['partday'])) { ?><p>停留时间：<?php echo $row['partday'];?></p><?php } ?>
          <?php if(!empty($row['acceptday'])) { ?><p>受理时间：<?php echo $row['acceptday'];?></p><?php } ?>
          <?php if(!empty($row['handlepeople'])) { ?><p>受理人群：<?php echo $row['handlepeople'];?></p><?php } ?>
          <?php if(!empty($row['belongconsulate'])) { ?><p>所属领管：<?php echo $row['belongconsulate'];?></p><?php } ?>
        </li>
      </ul>
      
    </div>
    
    <div class="show-list-js">
    <div class="list-con">
      <h3 class="tit">签证介绍</h3>
      <div class="txt">
        <?php echo $row['title'];?>
        </div>
      </div>
      <?php if(!empty($row['material'])) { ?>
      <div class="list-con mt10">
      <h3 class="tit">所需资料</h3>
      <div class="txt">
        <ul class="ul_con_list">
            <?php if(!empty($row['material'])) { ?>
             <li>
                <span class="s_tit">在职人员<i></i></span>
                <p class="p_con">
                <?php echo $row['material'];?>
                </p>
              </li>
            <?php } ?>
            
            <?php if(!empty($row['material2'])) { ?>
             <li>
                <span class="s_tit">自由职业者<i></i></span>
                <p class="p_con">
                <?php echo $row['material2'];?>
                </p>
              </li>
            <?php } ?>
          <?php if(!empty($row['material3'])) { ?>
             <li>
                <span class="s_tit">退休人员<i></i></span>
                <p class="p_con">
                <?php echo $row['material3'];?>
                </p>
              </li>
            <?php } ?>
          <?php if(!empty($row['material4'])) { ?>
             <li>
                <span class="s_tit">在校学生<i></i></span>
                <p class="p_con">
                <?php echo $row['material4'];?>
                </p>
              </li>
            <?php } ?>
          <?php if(!empty($row['material5'])) { ?>
             <li>
                <span class="s_tit">学龄前儿童<i></i></span>
                <p class="p_con">
                <?php echo $row['material5'];?>
                </p>
              </li>
            <?php } ?>
        </div>
      </div>
      <?php } ?>
      <div class="list-con mt10">
      <h3 class="tit">预订须知</h3>
      <div class="txt">
        <?php echo $row['booknotice'];?>
        </div>
      </div>
      <?php if(!empty($row['circuit'])) { ?>
      <div class="list-con mt10">
        <h3 class="tit">办理流程</h3>
        <div class="txt">
          <?php echo $row['circuit'];?>
        </div>
      </div>
      <?php } ?>
      <?php if(!empty($row['friendtip'])) { ?>
      <div class="list-con mt10">
        <h3 class="tit">温馨提示</h3>
        <div class="txt">
          <?php echo $row['friendtip'];?>
        </div>
      </div>
      <?php } ?>
    </div>
    
  </div>
<?php echo  Stourweb_View::template('public/foot');  ?>
<div class="opy"></div>
  <div class="bom_fix_box">
    <a class="cell_phone" href="tel:<?php echo $phone;?>"><?php echo $phone;?></a>
    <a class="booking" href="<?php echo $cmsurl;?>visa/order/id/<?php echo $row['id'];?>">立即预定</a>
  </div>
</body>
<script>
    var mySwiper = new Swiper('.swiper1',{
    pagination: '.pagination',
    paginationClickable: true,
    slidesPerView: 'auto'
  })
</script>
</html>
