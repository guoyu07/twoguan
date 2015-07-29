<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if(empty($row['seotitle'])) { ?><?php echo $row['linename'];?><?php } else { ?><?php echo $row['seotitle'];?><?php } ?>
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
    <a class="city_tit">产品详情</a>
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
        <h1 class="tit"><?php echo $row['linename'];?></h1>
        <p class="txt"><?php echo $row['sellpoint'];?></p>
      </div>
      
      <ul>
      <li class="li_1">
        <p>
          <span><em><?php if($row['lineprice']>0) { ?>&yen;<?php echo $row['lineprice'];?><?php } else { ?>电询<?php } ?>
</em> 起</span>
            <a href="<?php echo $cmsurl;?>page/pinlun/id/<?php echo $row['id'];?>/typeid/1"><span class="myd"><b class="fl" style=" width:100%">满意度：<em><?php echo $row['satisfyscore'];?></em></b></span></a>
          </p>
        </li>
        <li class="li_2">
        <p>线路编号：<?php echo $row['lineseries'];?></p>
          <p>往返交通：<?php echo $row['transport'];?></p>
          <p>旅游团期：<?php echo $row['lineday'];?>天</p>
          <p>提前报名：<?php echo $row['linebefore'];?>天</p>
        </li>
        <li class="li_3">
        <a href="<?php echo $cmsurl;?>lines/create/id/<?php echo $row['id'];?>"><p>选择价格类型、出发日期</p></a>
        </li>
      </ul>
      
    </div>
    <div class="show-list-js">
      <?php $n=1; if(is_array($linedisc)) { foreach($linedisc as $v) { ?>
        <?php if($v['columnname']=='jieshao') { ?>
          <?php if($row['isstyle']=='1') { ?>
            <?php if((!empty($row[$v['columnname']]))) { ?>
          <div class="list-con mt10">
            <h3 class="tit"><?php echo $v['chinesename'];?></h3>
            <div class="txt">
              <?php echo $row[$v['columnname']];?>
              </div>
            </div>
            <?php } ?>
          <?php } else { ?>
            <div class="list-con mt10">
              <h3 class="tit"><?php echo $v['chinesename'];?></h3>
                <?php $n=1; if(is_array($row['linejieshao_arr'])) { foreach($row['linejieshao_arr'] as $v2) { ?>
                  <div class="day_con">
                    <div class="day_bg_num"><?php echo $v2['day'];?></div>
                    <dl>
                      <dt>
                        <span>第<?php echo $v2['day'];?>天</span><em><?php echo $v2['title'];?></em>
                      </dt>
                      <dd>
                        <span class="line_item">用餐</span>
                        <div class="line_item_p">
                          <em>早餐：<?php if($v2['breakfirsthas'] =='1') { ?>含<?php } else { ?>不含<?php } ?>
</em>
                          <em>中餐：<?php if($v2['lunchhas'] =='1') { ?>含<?php } else { ?>不含<?php } ?>
</em>
                          <em>晚餐：<?php if($v2['supperhas'] =='1') { ?>含<?php } else { ?>不含<?php } ?>
</em>
                        </div>
                      </dd>
                      <dd><span class="line_item">住宿</span><em><?php echo $v2['hotel'];?></em></dd>
                      <dd>
                        <span class="line_item">安排</span>
                        <div class="line_item_p"><?php echo $v2['jieshao'];?></div>
                      </dd>
                    </dl>
                  </div>
              <?php $n++;}unset($n); } ?>
              
            </div>
          <?php } ?>
        <?php } else { ?>
          <?php if((!empty($row[$v['columnname']]))) { ?>
            <div class="list-con mt10">
              <h3 class="tit"><?php echo $v['chinesename'];?></h3>
              <div class="txt">
              <?php echo $row[$v['columnname']];?>
              </div>
            </div>
            <?php } ?>
        <?php } ?>
      <?php $n++;}unset($n); } ?>
     
    </div>
    
  </div>
  
<?php echo  Stourweb_View::template('public/foot');  ?>
<div class="opy"></div>
  <div class="bom_fix_box">
    <a class="cell_phone" href="tel:<?php echo $phone;?>"><?php echo $phone;?></a>
    <a class="booking" href="<?php echo $cmsurl;?>lines/create/id/<?php echo $row['id'];?>">立即预定</a>
  </div>
</body>
<script>
    var mySwiper = new Swiper('.swiper1',{
    pagination: '.pagination',
    paginationClickable: true,
    slidesPerView: 'auto'
  })
/*  $(function(){
       if($('.list-con img').length>0){
           var wp = $(window).width()-100;
           $('.list-con img').css('width', wp+'px' );
       }
   })*/
</script>
</html>
