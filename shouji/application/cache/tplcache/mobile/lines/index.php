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
  
<div class="line_search">
    <input type="text" id="key" name="key" class="s_text" placeholder="搜索线路" />
    <a href="#" class="s_btn">搜索</a>
    </div>
    <?php $n=1; if(is_array($data)) { foreach($data as $vd) { ?>
<div class="hotel_list">
<h3 class="hotel_list_tit"><?php echo $vd['kindname'];?></h3>
  <div class="hotel_con">
<p>
  <?php $n=1; if(is_array($vd['list'])) { foreach($vd['list'] as $key => $v) { ?>
  <?php if($key%2==0) { ?>
  </p>
  <p>
  <?php } ?>
<a href="<?php echo $cmsurl;?>lines/show/id/<?php echo $v['id'];?>">
<?php if(intval($v['lineprice'])>0) { ?>
<em>&yen; <?php echo $v['lineprice'];?> 起</em>
<?php } else { ?>
<em>电询</em>
<?php } ?>
<img src="<?php echo $v['linepic'];?>" alt="" width="145" height="100" />
<span><?php echo $v['linename'];?></span>
  </a>
  <?php $n++;}unset($n); } ?>
</p>
  </div>
  <div class="list_more">
<a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $vd['id'];?>">点击查看更多&gt;&gt;</a>
  </div>
</div>
    <?php $n++;}unset($n); } ?>
    
</div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
</body>
<script type="text/javascript">
  $('.s_btn').click(function(){
    var key = $('#key').val();
    if(key==''){
      key=0;
    }
    key = encodeURIComponent(key);
    var url = '<?php echo $cmsurl;?>lines/list/?key=';
    location.href = url+key;
  });
</script>
</html>
