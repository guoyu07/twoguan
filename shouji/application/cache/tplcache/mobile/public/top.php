<div class="home_top clearfix">
  <div class="logo">
    <a href="<?php echo $cmsurl;?>">
      <img src="<?php echo $logo;?>" alt="<?php echo $webname;?>" />
      </a>
    </div>
    <div class="user_login">
       <?php if(empty($user)) { ?>
     <a class="" href="<?php echo $cmsurl;?>user/login">登录/</a>
       <a class="" href="<?php echo $cmsurl;?>user/register?forwardurl=<?php echo $forwardurl;?>">注册</a>
       <?php } else { ?>
        <a class="" href="<?php echo $cmsurl;?>user/index"><?php echo $user['nickname'];?>/</a>
        <a class="" href="<?php echo $cmsurl;?>user/loginout">退出</a>
       <?php } ?>
        /<a class="" href="<?php echo $cmsurl;?>page/query">订单查询</a>
    </div>
  </div>
  <script language="JavaScript">
      var SITEURL = "<?php echo $cmsurl;?>";
  </script>
