<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $order['productname'];?>-<?php echo $webname;?></title>
 <?php echo Common::getScript('jquery-min.js,common.js,st_m.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
    <a class="back" href="<?php echo $cmsurl;?>">返回</a>
    <a class="city_tit" href="<?php echo $cmsurl;?>user/index">个人中心</a>
</div>
  
  <div class="m-main">
<div class="xz-top-box">
    <div class="pic"><img class="fl" src="<?php echo $order['litpic'];?>" alt="" width="90" height="64"></div>
    <div class="txt">
        <p><?php echo $order['productname'];?></p>
        <span>&yen;<?php echo $order['totalprice'];?> </span>
      </div>
    </div>
    <ul class="order_msg">
    <li><em>价格类型：</em><?php echo $order['suitname'];?></li>
    <li><em>出发日期：</em><?php echo $order['usedate'];?></li>
    <li class="li_line"><em>预定人数：</em>成人<?php echo $order['dingnum'];?>名，儿童<?php echo $order['childnum'];?>名</li>
    <li><em>订单编号：</em><?php echo $order['ordersn'];?></li>
    <li><em>订单时间：</em><?php echo Common::myDate('Y-m-d H:i:s',$order['addtime']);?></li>
        <?php if($order['ispay']==1) { ?>
     <li><em>付款时间：</em><?php echo Common::myDate('Y-m-d H:i:s',$order['finishtime']);?></li>
        <?php } ?>
    <li class="li_jg"><em>总额：</em><strong>&yen;<?php echo $order['totalprice'];?></strong></li>
    </ul>
      <?php if($order['status'] ==2) { ?>
          <?php if($order['ispinlun'] == 1) { ?>
                  <div class="dp_box">
                      <h3>我的点评</h3>
                      <dl>
                          <dt>
                              <span class="name"><?php echo $user['nickname'];?></span>
                              <span class="myd">满意度：<em><?php echo $order['pinlun']['satisfyscore'];?></em></span>
                          </dt>
                          <dd>
                             <?php echo $order['pinlun']['content'];?>
                          </dd>
                      </dl>
                  </div>
          <?php } else { ?>
                  <div class="bom_fix_box">
                      <a class="booking" href="<?php echo $cmsurl;?>user/pinlun/orderid/<?php echo $order['id'];?>">立即点评</a>
                  </div>
          <?php } ?>
      <?php } else { ?>
          <div class="bom_fix_box">
              <a class="booking" href="<?php echo $cmsurl;?>page/pay/orderid/<?php echo $order['id'];?>">付款</a>
          </div>
      <?php } ?>
</div>
  
   <?php echo  Stourweb_View::template('public/foot');  ?>
</body>
</html>
