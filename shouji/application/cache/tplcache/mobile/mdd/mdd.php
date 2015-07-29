<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if(empty($row['seotitle'])) { ?><?php echo $row['kindname'];?><?php } else { ?><?php echo $row['seotitle'];?><?php } ?>
-<?php echo $webname;?></title>
 <meta name="keywords" content="<?php echo $row['keyword'];?>" />
 <meta name="description" content="<?php echo $row['description'];?>" />
 <?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
  <div class="city_top clearfix">
    <a class="back" href="<?php echo $cmsurl;?>mdd/index">返回</a>
    <a class="city_tit"><?php echo $row['kindname'];?></a>
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
    <div class="mdd_jh">
      <p>
      <?php if($tj['article']>0) { ?>
        <a class="gl-ico" href="<?php echo $cmsurl;?>raider/list/id/<?php echo $row['id'];?>"><em></em>攻略<span>(<?php echo $tj['article'];?>)</span></a>
      <?php } ?>
      <?php if($tj['lines']>0) { ?>
        <a class="xl-ico" href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $row['id'];?>"><em></em>线路<span>(<?php echo $tj['lines'];?>)</span></a>
      <?php } ?>
      <?php if($tj['hotel']>0) { ?>
        <a class="jd-ico" href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo $row['id'];?>"><em></em>酒店<span>(<?php echo $tj['hotel'];?>)</span></a>
      <?php } ?>
      </p>
      <p>
      <?php if($tj['car']>0) { ?>
        <a class="zc-ico" href="<?php echo $cmsurl;?>cars/list/kindid/<?php echo $row['id'];?>"><em></em>租车<span>(<?php echo $tj['car'];?>)</span></a>
      <?php } ?>
      <?php if($tj['spot']>0) { ?>
        <a class="mp-ico" href="<?php echo $cmsurl;?>spot/list/?kindid=<?php echo $row['id'];?>"><em></em>门票<span>(<?php echo $tj['spot'];?>)</span></a>
      <?php } ?>
      <?php if($tj['photo']>0) { ?>
        <a class="xc-ico" href="<?php echo $cmsurl;?>photo/list/kindid/<?php echo $row['id'];?>"><em></em>相册<span>(<?php echo $tj['photo'];?>)</span></a>
      <?php } ?>
      </p>
    </div>
    
    <?php if(!empty($articlarr1)||!empty($articlarr2)) { ?>
    <div class="m_gl_list">
      <h3><?php echo $row['kindname'];?>-攻略-游记</h3>
       <?php if(!empty($articlarr1)) { ?>
      <div class="swiper-container gl-container">
        <div class="swiper-wrapper">
          <?php $n=1; if(is_array($articlarr1)) { foreach($articlarr1 as $v) { ?>
          <div class="swiper-slide gl-slide">
            <img src="<?php echo $v['litpic'];?>" width="250" height="100%" />
            <span><?php echo $v['articlename'];?></span>
          </div>
          <?php $n++;}unset($n); } ?>
         
        </div> 
      </div>
      <?php } ?>
      <?php if(!empty($articlarr2)) { ?>
      <!--攻略列表开始-->
      <ul class="mdd_gl_list">
        <?php $n=1; if(is_array($articlarr2)) { foreach($articlarr2 as $v) { ?>
        <li>
          <h4><?php echo $v['articlename'];?></h4>
          <p><?php echo $v['content'];?></p>
        </li>
        <?php $n++;}unset($n); } ?>
      </ul>
      <?php } ?>
      <div class="list_more mt10">
        <a href="<?php echo $cmsurl;?>raider/list/id/<?php echo $row['id'];?>">点击查看更多&gt;&gt;</a>
      </div>
    </div>
    <?php } ?>
    <div class="mdd_cp_list">
      <div class="tabs">
      <?php if(!empty($lineslist)) { ?>
        <a href="#" <?php if($sts==1) { ?> class="active"<?php } ?>
>旅游路线</a>
      <?php } ?>
      <?php if(!empty($carlist)) { ?>
        <a href="#" <?php if($sts==2) { ?> class="active"<?php } ?>
>旅游租车</a>
      <?php } ?>
      <?php if(!empty($hotellist)) { ?>
        <a href="#" <?php if($sts==3) { ?> class="active"<?php } ?>
>优惠酒店</a>
      <?php } ?>
      <?php if(!empty($spotlist)) { ?>
        <a href="#" <?php if($sts==4) { ?> class="active"<?php } ?>
>景区门票</a>
      <?php } ?>
      </div>
      <div class="swiper-container mdd-all">
        <div class="swiper-wrapper">
         <?php if(!empty($lineslist)) { ?>
          <div class="swiper-slide">
            <div class="mdd_con">
              <p>
              <?php $n=1; if(is_array($lineslist)) { foreach($lineslist as $key => $v) { ?>
              <?php if($key%2==0) { ?>
              </p>
              <p>
              <?php } ?>
                <a href="<?php echo $cmsurl;?>lines/show/id/<?php echo $v['id'];?>">
                  <em><?php if($v['lineprice']==0) { ?>电询<?php } else { ?>&yen;<?php echo $v['lineprice'];?><?php } ?>
</em>
                  <img src="<?php echo $v['linepic'];?>" alt="" width="140" height="100">
                  <span><?php echo $v['linename'];?></span>
                </a>
              <?php $n++;}unset($n); } ?>
              </p>
            </div>
            <div class="list_more mt10">
              <a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $row['id'];?>">点击查看更多&gt;&gt;</a>
            </div>
          </div>
        <?php } ?>
        <?php if(!empty($carlist)) { ?>
          <div class="swiper-slide">
            <div class="mdd_con">
              <p>
                <?php $n=1; if(is_array($carlist)) { foreach($carlist as $key => $v) { ?>
                <?php if($key%2==0) { ?>
                </p>
                <p>
                <?php } ?>
                  <a href="<?php echo $cmsurl;?>cars/show/id/<?php echo $v['id'];?>">
                    <em><?php if($v['carprice']==0) { ?>电询<?php } else { ?>&yen;<?php echo $v['carprice'];?><?php } ?>
</em>
                    <img src="<?php echo $v['litpic'];?>" alt="" width="140" height="100">
                    <span><?php echo $v['carname'];?></span>
                  </a>
                <?php $n++;}unset($n); } ?>
              </p>
            </div>
            <div class="list_more mt10">
              <a href="<?php echo $cmsurl;?>cars/list/kindid/<?php echo $row['id'];?>">点击查看更多&gt;&gt;</a>
            </div>
          </div>
        <?php } ?>
        <?php if(!empty($hotellist)) { ?>
          <div class="swiper-slide">
            <div class="mdd_con">
              <p>
               <?php $n=1; if(is_array($hotellist)) { foreach($hotellist as $key => $v) { ?>
               <?php if($key%2==0) { ?>
                </p>
                <p>
                <?php } ?>
                  <a href="<?php echo $cmsurl;?>hotels/show/id/<?php echo $v['id'];?>">
                    <em><?php if($v['hotelprice']==0) { ?>电询<?php } else { ?>&yen;<?php echo $v['hotelprice'];?><?php } ?>
</em>
                    <img src="<?php echo $v['litpic'];?>" alt="" width="140" height="100">
                    <span><?php echo $v['hotelname'];?></span>
                  </a>
                <?php $n++;}unset($n); } ?>
              </p>
            </div>
            <div class="list_more mt10">
              <a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo $row['id'];?>">点击查看更多&gt;&gt;</a>
            </div>
          </div>
        <?php } ?>
        <?php if(!empty($spotlist)) { ?>
          <div class="swiper-slide">
            <div class="mdd_con">
              <p>
                <?php $n=1; if(is_array($spotlist)) { foreach($spotlist as $key => $v) { ?>
               <?php if($key%2==0) { ?>
                </p>
                <p>
                <?php } ?>
                  <a href="<?php echo $cmsurl;?>spot/show/id/<?php echo $v['id'];?>">
                    <em><?php if($v['doorprice']==0) { ?>电询<?php } else { ?>&yen;<?php echo $v['doorprice'];?><?php } ?>
</em>
                    <img src="<?php echo $v['litpic'];?>" alt="" width="140" height="100">
                    <span><?php echo $v['spotname'];?></span>
                  </a>
                <?php $n++;}unset($n); } ?>
              </p>
            </div>
            <div class="list_more mt10">
              <a href="<?php echo $cmsurl;?>spot/list/?kindid=<?php echo $row['id'];?>">点击查看更多&gt;&gt;</a>
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
    </div>
    
    <?php if(!empty($photolist)) { ?>
    <div class="m_xc_list">
      <h3>风景相册</h3>
      <div class="xc_con">
        <p>
        <?php $n=1; if(is_array($photolist)) { foreach($photolist as $key => $v) { ?>
           <?php if($key%2==0) { ?>
            </p>
            <p>
            <?php } ?>
          <a href="<?php echo $cmsurl;?>spot/show/id/<?php echo $v['id'];?>">
            <img src="<?php echo $v['litpic'];?>" alt="" width="145" height="100">
            <span><?php echo $v['photoname'];?></span>
          </a>
          <?php $n++;}unset($n); } ?>
         
        </p>
      </div>
      <div class="list_more mt10">
        <a href="<?php echo $cmsurl;?>photo/list/kindid/<?php echo $row['id'];?>">点击查看更多&gt;&gt;</a>
      </div>
    </div>
  </div>
  <?php } ?>
  
 <?php echo  Stourweb_View::template('public/foot');  ?>
<script>
    var mySwiper = new Swiper('.swiper1',{
    pagination: '.pagination',
    paginationClickable: true,
    slidesPerView: 'auto'
  })
    var mySwiper1 = new Swiper('.gl-container',{
    paginationClickable: true,
    slidesPerView: 'auto'
  })
  var tabsSwiper = new Swiper('.mdd-all',{
    speed:500,
    onSlideChangeStart: function(){
      $(".tabs .active").removeClass('active')
      $(".tabs a").eq(tabsSwiper.activeIndex).addClass('active')  
    }
  })
  $(".tabs a").on('touchstart mousedown',function(e){
    e.preventDefault()
    $(".tabs .active").removeClass('active')
    $(this).addClass('active')
    tabsSwiper.swipeTo( $(this).index() )
  })
  $(".tabs a").click(function(e){
    e.preventDefault()
  })
  </script>
</body>
</html>
