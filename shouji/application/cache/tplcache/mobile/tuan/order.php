<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $info['title'];?>-<?php echo $webname;?></title>
 <?php echo Common::getScript('jquery-min.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
    <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="<?php echo $cmsurl;?>">返回</a>
    <a class="city_tit" href="javascript:;">预订团购产品</a>
  </div>
  <form method="post" action="<?php echo $cmsurl;?>order/create"  id="bookfrm" onsubmit="return check();">
  <div class="m-main">

  <div class="xz-top-box">
    <div class="pic"><img class="fl" src="<?php echo $info['litpic'];?>" alt="" width="90" height="64" /></div>
    <div class="txt">
        <p><?php echo $info['title'];?></p>
        <span>&yen;<?php echo $info['ourprice'];?> </span>
      </div>
    </div>
    
    <div class="big_box">
      
      <div class="order-m">
      <h3>预定产品数</h3>
        <ul>
        <li>
          <label>产品数量：</label>
            <span>
            <span class="order-btn minus minus-active"></span>
              <input type="number" id="dingnum" min="1" max="100" class="order-txt-n" name="dingnum" value="1" />
            <span class="order-btn plus plus-active"></span>
            </span>
            <span class="order-jg"></span>
          </li>
          <li><label>联系人：</label><input type="text" name="linkman" id="linkman" class="order-lx" placeholder="请填写联系人" value="<?php echo $user['truename'];?>" /></li>
          <li><label>联系电话：</label><input type="text" name="linktel" id="linktel" class="order-lx" placeholder="手机号码或固定电话" value="<?php echo $user['mobile'];?>" />可通过此手机号查询订单(必填)</li>
        </ul>
      </div>
      
    </div>
  </div>
  
 <?php echo  Stourweb_View::template('public/foot');  ?>
  <div class="opy"></div>
  <div class="bom_fix_box">
  <span>总额：<em id="totalprice">&yen;<?php echo $info['ourprice'];?></em></span>
  <a class="booking" href="javascript:;">提交订单</a>
    <input type="hidden" id="price"  value="<?php echo $info['ourprice'];?>"/>
      <input type="hidden" id="tuanid" name="tuanid" value="<?php echo $info['id'];?>"/>
      <input type="hidden" name="id" id="id" value="<?php echo $info['id'];?>">
      <input type="hidden" id="ordertype" name="ordertype" value="13" />
      <input type="hidden" id="suitid" name="suitid" value="0" />
      <input type="hidden" id="dateid" name="dateid" value="0" />
  </div>
  </form>
</body>
<script language="JavaScript">
    var price = $("#price").val();
    $(function(){
        $(".minus").click(function(){
            var num = parseInt($("#dingnum").val())-1;
            num = num<=0 ? 1 : num;
            $("#dingnum").val(num);
            var totalprice = num * price;
            $("#totalprice").html('&yen;'+totalprice);
        })
        $(".plus").click(function(){
            var num = parseInt($("#dingnum").val())+1;
            $("#dingnum").val(num);
            var totalprice = num * price;
            $("#totalprice").html('&yen;'+totalprice);
        })
        //提交表单
        $(".booking").click(function(){
            $("#bookfrm").submit();
        })
    })
    function check()
    {
        var linkman = $("#linkman").val();
        var linktel = $("#linktel").val();
        if(linkman==''){
            alert('请填写联系人');
            return false;
        }
        if(linktel == ''){
            alert('请填写联系方式');
            return false;
        }
        return true;
    }
</script>
</html>
