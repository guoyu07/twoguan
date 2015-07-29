<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $info['servername'];?>-<?php echo $webname;?></title>
    <?php echo Common::getCss('m_base.css,aboutus.css'); ?>
    <?php echo Common::getScript('jquery-min.js,st_m.js'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
  
  <div class="m-main">
<div class="about">
    <div class="about_tit"><em><?php echo $info['servername'];?></em></div>
      <div class="about_show">
      <?php echo $info['content'];?>
      </div>
    </div>

</div>
<?php echo  Stourweb_View::template('public/foot');  ?>
</body>
</html>