<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>支付成功-<?php echo $webname;?></title>
    <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
  
  <div class="m-main">
  <div class="ts_con_page">
    <img src="<?php echo $publicurl;?>/images/success.png" width="200" />
    <p>恭喜，购买成功</p>
      <a href="<?php echo $cmsurl;?>">回到主页</a>
    </div>
</div>
  
 <?php echo  Stourweb_View::template('public/foot');  ?>
</body>
</html>
