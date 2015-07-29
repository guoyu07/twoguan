<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $seotitle;?>-<?php echo $webname;?></title>
    <meta name="keywords" content="<?php echo $keyword;?>" />
    <meta name="author" content="<?php echo $webname;?>" />
    <meta name="description" content="<?php echo $description;?>" />
 <?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
 <?php echo Common::getCss('m_base.css,index.css'); ?>
 
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
  <div class="main_page clearfix">
  
  <!--首页滚动图片-->
    <div class="home-device">
      <div class="swiper-main">
        <div class="swiper-container swiper1">
          <div class="swiper-wrapper">
           <?php $ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getrollad')) {$data = $ad_tag->getrollad(array('action'=>'getrollad','name'=>'MobileIndexRollAd',));}?>
              <?php $n=1; if(is_array($data)) { foreach($data as $v) { ?>
                 <div class="swiper-slide"> <a href="<?php echo $v['linkurl'];?>"><img src="<?php echo $v['picurl'];?>" width="320" height="200" /></a> </div>
              <?php $n++;}unset($n); } ?>
           
          </div>
        </div>
      </div>
      <div class="pagination pagination1"></div>
    </div>
    
    <div class="search_home clearfix">
       <form method="post" action="<?php echo $cmsurl;?>mdd/search" onsubmit="return check();">
    <input type="text" class="h_txt" id="keyword" name="keyword" value="" placeholder="搜索目的地" />
    <input type="submit" class="h_btn" value="&nbsp;" />
       </form>
    </div>
    
    <div class="home_menu">
    <p>
      <a class="mdd_ico" href="<?php echo $cmsurl;?>mdd/index"><em></em>目的地</a>
        <a class="xl_ico" href="<?php echo $cmsurl;?>lines/index"><em></em>线路</a>
        <a class="mp_ico" href="<?php echo $cmsurl;?>spot/index"><em></em>景点门票</a>
      </p>
      <p>
      <a class="jd_ico" href="<?php echo $cmsurl;?>hotels/index"><em></em>酒店</a>
        <a class="zc_ico" href="<?php echo $cmsurl;?>cars/index"><em></em>租车</a>
        <a class="qz_ico" href="<?php echo $cmsurl;?>visa/index"><em></em>签证</a>
      </p>
      <p>
      <a class="tg_ico" href="<?php echo $cmsurl;?>tuan/index"><em></em>团购</a>
        <a class="xc_ico" href="<?php echo $cmsurl;?>photo/index"><em></em>相册</a>
        <a class="gl_ico" href="<?php echo $cmsurl;?>raider/index"><em></em>攻略</a>
      </p>
    </div>
    
    <div class="pdt_con">
    <div class="xl_tit clearfix"><h3>本季热推 /</h3> Tour</div>
        <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'getline')) {$data = $line_tag->getline(array('action'=>'getline','row'=>'10','flag'=>'byorder',));}?>
            <?php $n=1; if(is_array($data)) { foreach($data as $k => $v) { ?>
                    <div class="pdt_list">
                        <a href="<?php echo $v['url'];?>">
                            <div class="pdt_img"><img src="<?php echo $v['litpic'];?>" width="90" height="64"></div>
                            <div class="pdt_txt">
                                <div class="pdt_box">
                                    <p class="p_tit"><?php echo $v['title'];?>...</p>
                                    <p class="p_pir"> <?php if(empty($v['lineprice'])) { ?>
                                        <strong>电询</strong>
                                        <?php } else { ?>
                                        <strong>&yen;<?php echo $v['lineprice'];?></strong>
                                        <?php } ?>
<span>满意度<?php echo $v['satisfyscore'];?></span></p>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php $n++;}unset($n); } ?>
        
      <div class="ck_more">
      <a href="<?php echo $cmsurl;?>lines/list/kindid/0">点击查看更多&gt;&gt;</a>
      </div>
    </div>
    
  </div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
<script>
var mySwiper = new Swiper('.swiper1',{
        pagination: '.pagination',
paginationClickable: true,
slidesPerView: 'auto'
})
    function check()
    {
        var keyword = $("#keyword").val();
        if(keyword==''){
            alert("请输入目的地");
            return false;
        }
        return true;
    }
</script>
</body>
</html>
