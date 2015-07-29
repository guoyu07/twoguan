<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>关于我们-<?php echo $webname;?></title>
    <?php echo Common::getCss('m_base.css,aboutus.css'); ?>
    <?php echo Common::getScript('jquery-min.js,st_m.js'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
  
  <div class="m-main">
<div class="about">
    <ul>
         <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?>
         <li><a href="<?php echo $cmsurl;?>corp/show/id/<?php echo $row['id'];?>"><?php echo $row['servername'];?></a></li>
         <?php $n++;}unset($n); } ?>
      </ul>
    </div>

</div>
<?php echo  Stourweb_View::template('public/foot');  ?>
</body>
</html>