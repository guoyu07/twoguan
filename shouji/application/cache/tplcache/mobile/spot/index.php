<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
 <?php echo Common::getCss('m_base.css,style.css'); ?>
 <?php echo Common::getScript('jquery-min.js'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
  
  <div class="m-main">
<div class="line_search">
  <input type="text" class="s_text" name="key" id="key" placeholder="搜索景点" />
    <a href="javascript:void();" class="s_btn">搜索</a>
    </div>
    </form>
    <?php $n=1; if(is_array($list)) { foreach($list as $v1) { ?>
    <div class="spot_list">
    <h3><?php echo $v1['kindname'];?></h3>
      <div class="spot_con">
      <p>
        <?php $n=1; if(is_array($v1['list_arr'])) { foreach($v1['list_arr'] as $key => $v2) { ?>
          <?php if($key%2==0) { ?>
          </p>
         <p>
          <?php } ?>
        <a href="<?php echo $cmsurl;?>spot/show/id/<?php echo $v2['id'];?>">
          <img src="<?php echo $v2['litpic'];?>" alt="" width="145" height="100" />
            <span><?php echo $v2['spotname'];?></span>
          </a>
          <?php $n++;}unset($n); } ?>
        </p>
      </div>
      <div class="list_more">
      <a href="<?php echo $cmsurl;?>spot/list/kindid/<?php echo $v1['id'];?>">点击查看更多&gt;&gt;</a>
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
    var url = '<?php echo $cmsurl;?>spot/list/?key=';
    location.href = url+key;
  });
</script>
</html>
