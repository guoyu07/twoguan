<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $seotitle;?>-<?php echo $webname;?></title>
  <meta name="keywords" content="<?php echo $keyword;?>" />
  <meta name="description" content="<?php echo $description;?>" />
 <?php echo Common::getScript('jquery-min.js,idangerous.swiper.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
  
  <div class="m-main">
      <form method="post" action="<?php echo $cmsurl;?>mdd/search" id="searchfrm">
          <div class="line_search">
              <input type="text" class="s_text" placeholder="搜索目的地" name="keyword" id="keyword" value="<?php echo $keyword;?>" />
              <a href="javascript:;" class="s_btn" >搜索</a>
          </div>
      </form>
    <?php $n=1; if(is_array($list)) { foreach($list as $v1) { ?>
    <div class="line-lei">
      <h2><a  href="<?php echo $cmsurl;?>mdd/city/id/<?php echo $v1['id'];?>"><?php echo $v1['kindname'];?></a></h2>
      <?php $n=1; if(is_array($v1['nextlist'])) { foreach($v1['nextlist'] as $v2) { ?>
      <dl>
        <dt><a href="<?php echo $cmsurl;?>mdd/city/id/<?php echo $v2['id'];?>"><?php echo $v2['kindname'];?></a></dt>
        <dd>
        <?php $n=1; if(is_array($v2['nextlist'])) { foreach($v2['nextlist'] as $key => $v3) { ?>
          <?php if($key%4==0) { ?>
          </dd>
          <dd>
          <?php } ?>
          <a href="<?php echo $cmsurl;?>mdd/city/id/<?php echo $v3['id'];?>"><?php echo $v3['kindname'];?></a>
        <?php $n++;}unset($n); } ?>
        </dd>
      </dl>
      <?php $n++;}unset($n); } ?>
    </div>
    <?php $n++;}unset($n); } ?>
    
  </div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
</body>
<script language="JavaScript">
    $(function(){
        $(".s_btn").click(function(){
            if($('#keyword').val()==''){
                alert('请输入要搜索的目的地');
                return false;
            }else{
                $("#searchfrm").submit()
            }
        })
    })
</script>
</html>