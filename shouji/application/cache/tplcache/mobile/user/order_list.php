<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>我的订单列表-<?php echo $webname;?></title>
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
  <div class="bgcolor_f0 clearfix" id="order_list">
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
          <li class="li_2"><span>数量：<?php echo $order['dingnum'];?></span><span>总额：<em>&yen;<?php echo $order['totalprice'];?></em></span></li>
          <?php if($order['status']!=2) { ?>
          <li class="li_3"><a class="qr_zhifu" href="<?php echo $cmsurl;?>page/pay/orderid/<?php echo $order['id'];?>">确认支付</a></li>
          <?php } else { ?>
          <li class="li_3">
              <?php if($order['ispinlun']==1) { ?>
                <span>已经点评</span>
              <?php } else { ?>
               <a class="lj_dp" href="<?php echo $cmsurl;?>user/pinlun/orderid/<?php echo $order['id'];?>">立即点评</a>
              <?php } ?>
              <span>交易成功</span></li>
          <?php } ?>
        </ul>
      </div>
      <?php $n++;}unset($n); } ?>
    </div>
</div>
  <?php echo  Stourweb_View::template('public/foot');  ?>
  <input type="hidden" id="page" value="1"/>
  <script>
      $(function(){
          $(window).scroll(function(){
               var scrollTop = $(this).scrollTop();               //滚动条距离顶部的高度
               var scrollHeight = $(document).height();           //当前页面的总高度
               var windowHeight = $(this).height();               //当前可视的页面高度
               if(scrollTop + windowHeight >= scrollHeight)  { //距离顶部+当前高度 >=文档总高度 即代表滑动到底部
                  var page = parseInt($("#page").val())+1;
                  $.ajax({
                      type:'POST',
                      data:"page="+page,
                      url:SITEURL+'user/ajax_order_more',
                      dataType:'json',
                      success:function(data){
                            if(data.status=='success'){
                                var html = '';
                                $.each(data.orderlist,function(i,row){
                                     html+='<div class="order-list-zt">';
                                     html+='<ul>';
                                     html+='<a href="'+SITEURL+'user/order_detail/orderid/'+row.id+'>';
                                     html+='<li class="li_1">';
                                     html+='<img src="'+row.litpic+'" width="90" height="64" />';
                                     html+='<p>';
                                     html+='<span class="tit">'+row.productname+'</span>';
                                     html+='<span class="txt">'+row.suitname+'</span>';
                                     html+='</p>';
                                     html+='</li>';
                                     html+='</a>';
                                     html+='<li class="li_2"><span>数量：'+row.dingnum+'</span>';
                                     html+='<span>总额：<em>&yen;'+row.totalprice+'</em></span></li>';
                                     if(row.status!=2){
                                         html+='<li class="li_3"><a class="qr_zhifu" href="'+SITEURL+'user/pay/orderid/'+row.id+'">确认支付</a></li>';
                                     }
                                     else{
                                            html+='<li class="li_3">';
                                            if(row.ispinlun == 1){
                                                html+='<span>已经点评</span>';
                                            }
                                            else{
                                                //html+='<span><a href="'+SITEURL+'user/pinlun/orderid/'+row.orderid+'">我要点评</a></span>';
                                                html+='<a class="lj_dp" href="'+SITEURL+'user/pinlun/orderid/'+row.id+'">立即点评</a>';
                                            }
                                            html+=' <span>交易成功</span></li>';
                                     }
                                     html+='</ul>';
                                     html+='</div>';
                                })
                                $("#page").val(page);
                                $("#order_list").append(html);
                            }
                      }
                  })
              }
          })
      })
  </script>
</body>
</html>
