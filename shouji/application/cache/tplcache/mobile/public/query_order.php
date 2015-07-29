<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>订单查询-<?php echo $webname;?></title>
    <?php echo Common::getScript('jquery-min.js'); ?>
    <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
    <a class="back" href="<?php echo $cmsurl;?>">返回</a>
    <a class="city_tit" href="javascript:;">订单查询</a>
</div>
  
  <div class="m-main">
  <div class="bgcolor_f0 clearfix">
        <form method="post" action="<?php echo $cmsurl;?>page/queryorder">
     <div class="order-cx">
      <input type="text" class="text-cx" name="mobile" placeholder="输入手机号码查询订单" />
        <input type="submit" class="btn-cx" value="&nbsp;" />
      </div>
        </form>
         <?php $n=1; if(is_array($orderlist)) { foreach($orderlist as $order) { ?>
         <div class="order-list-zt">
             <ul>
                 <a href="<?php echo $cmsurl;?>user/order_detail/orderid/<?php echo $order['id'];?>">
                     <li class="li_1">
                         <img src="<?php echo $order['litpic'];?>" width="90" height="64" />
                         <p>
                             <span class="tit"><?php echo $order['productname'];?></span>
                             <span class="txt"><?php echo $order['suitname'];?></span>
                         </p>
                     </li>
                 </a>
                 <li class="li_2"><em class="fl"><?php echo $order['typename'];?></em><span>数量：<?php echo $order['dingnum'];?></span><span>总额：<em>&yen;<?php echo $order['totalprice'];?></em></span></li>
                 <?php if($order['status']!=2) { ?>
                 <li class="li_3"><a class="qr_zhifu" href="<?php echo $cmsurl;?>page/pay/orderid/<?php echo $order['id'];?>">马上支付</a></li>
                 <?php } else { ?>
                 <li class="li_3">
                     <span>交易成功</span>
                 </li>
                 <?php } ?>
             </ul>
         </div>
         <?php $n++;}unset($n); } ?>
    </div>
</div>
<?php echo  Stourweb_View::template('public/foot');  ?>
</body>
</html>
