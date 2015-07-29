<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>付款-{$webname}</title>
    {php echo Common::getScript('jquery-min.js'); }
    {php echo Common::getCss('m_base.css,style.css'); }
</head>

<body>
    {template 'public/top'}
	<div class="city_top clearfix">
  	<a class="back" href="{$cmsurl}">返回</a>
    <a class="city_tit" href="javascript:;">订单付款</a>
  </div>
  
  <div class="m-main">
	
  	<div class="xz-top-box">
    	<div class="pic"><img class="fl" src="{$info['litpic']}" alt="" width="90" height="64" /></div>
    	<div class="txt">
        <p>{$info['productname']}</p>
        <span>&yen;{$info['totalprice']} </span>
      </div>
    </div>
    
    <ul class="order_msg">
        {if $info['typeid']==1 || $info['typeid']==2 || $info['typeid']==3}
    	 <li><em>价格类型：</em>{$info['suitname']}</li>
    	 <li><em>出发日期：</em>{$info['usedate']}</li>
        {/if}
        {if $info['typeid']==1}
    	  <li><em>预定数量：</em>成人{$info['dingnum']}名，儿童{$info['childnum']}名</li>
        {else}
          <li><em>预定数量：</em>{$info['dingnum']}</li>
        {/if}
    	<li class="li_jg"><em>总额：</em><strong>&yen;{$info['totalprice']}</strong></li>
    </ul>
    
    <div class="show-list-js">
    	<div class="zhifu-box">
      	<h3>选择支付方式：</h3>
        <p>
          <a class="on" data-value="3" href="javascript:;"><em class="hc">微信</em></a>
        	<a data-value="1" href="javascript:;"><em class="zfb">支付宝</em></a>
        	<a data-value="2" href="javascript:;"><em class="kq">快钱</em></a>
        </p>

      </div>
    </div>
    
  </div>
  <form method="post" action="{$cmsurl}page/dopay" id="payfrm">
      <input type="hidden" name="orderid" value="{$info['id']}"/>
      <input type="hidden" name="paytype" id="paytype" value="3">
  </form>
  
  {template 'public/foot'}
  
  <div class="opy"></div>
  <div class="bom_fix_box">
  	<a class="booking" href="javascript:;">确认支付</a>
  </div>
<script>
    $(function(){
        $('.zhifu-box').find('a').click(function(){
                $(this).addClass('on').siblings().removeClass('on');
                $("#paytype").val($(this).attr('data-value'));
        })


        $('.booking').click(function(){

            $("#payfrm").submit();
        })
    })

</script>
 
</body>
</html>
