<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if(empty($row['seotitle'])) { ?><?php echo $row['linename'];?><?php } else { ?><?php echo $row['seotitle'];?><?php } ?>
-<?php echo $webname;?></title>
<meta name="keywords" content="<?php echo $row['keyword'];?>" />
<meta name="description" content="<?php echo $row['description'];?>" />
 <?php echo Common::getScript('jquery-min.js,jMonth.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css,jmonth.css'); ?>
 <script type="text/javascript">
  var pricearr=<?php echo json_encode($suit);?>;
</script>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back"  href="javascript:history.go(-1);">返回</a>
    <a class="city_tit">价格类型、出发日期</a>
  </div>
  
  <div class="m-main">

  <div class="xz-top-box">
    <div class="pic"><img class="fl" src="<?php echo $row['linepic'];?>" alt="" width="90" height="64" /></div>
    <div class="txt">
        <p><?php echo $row['linename'];?></p>
        <span><?php if($row['lineprice']>0) { ?>&yen;<?php echo $row['lineprice'];?>起<?php } else { ?>电询<?php } ?>
</span>
      </div>
    </div>
    
    <div class="big_box">
    
      <div class="price-tc">
        <h3>价格类型</h3>
        <ul>
        <?php $n=1; if(is_array($suit)) { foreach($suit as $key => $v1) { ?>
             <li <?php if($key==0) { ?>class="cur fangxing"<?php } else { ?>class="fangxing"<?php } ?>
 dateid="<?php echo $v1['id'];?>"><a href="#"><?php echo $v1['suitname'];?></a></li>
        <?php $n++;}unset($n); } ?>
        </ul>
      </div>
      
      <div class="go-date">
      <h3>出发日期</h3>
        <div class="selectdiv">
        <?php if(!empty($suit['0']['price_arr'])) { ?>
          <select style="font-size: 14px;width:100%;height:30px; color:#2a2a2a; margin-top:10px; margin-left:-5px;" id="tarveldate" name="tarveldate" onchange="settravel();">
            <?php $n=1; if(is_array($suit['0']['price_arr'])) { foreach($suit['0']['price_arr'] as $v2) { ?>
              <option value="<?php echo $v2['day'];?>||<?php echo intval($v2['adultprice']);?>||<?php echo intval($v2['childprice']);?>"><?php echo $v2['day'];?> <?php if($v2['adultprice']>0) { ?>￥<?php echo $v2['adultprice'];?>/大人<?php } ?>
  <?php if($v2['childprice']>0) { ?>￥<?php echo $v2['childprice'];?>/儿童<?php } ?>
  </option>
            <?php $n++;}unset($n); } ?>
          </select>
        <?php } else { ?>
           <select style="font-size: 14px;width:100%;height:30px; color:#2a2a2a; margin-top:10px; margin-left:-5px;" id="tarveldate" name="tarveldate">
              <option>暂无价格信息</option>
          </select>
        <?php } ?>
        </div>
      </div>
      
      <div class="order-m">
      <form action="<?php echo $cmsurl;?>order/create" method="post" name="form1" id="form1">
      <input type="hidden" name="id" id="id" value="<?php echo $row['id'];?>">
      <input type="hidden" id="ordertype" name="ordertype" value="1" />
      <input type="hidden" id="dateid" name="dateid" value="<?php echo Common::myDate('Y-m-d',$suit['0']['price_arr']['0']['dayid']); ?>" />
      <input type="hidden" id="suitid" name="suitid" value="<?php echo $suit['0']['id'];?>" />
      <h3>预定人数</h3>
        <ul>
        <li id="manli">
          <label>成人：</label>
            <span>
            <span class="order-btn minus minus-active" id="plus"></span>
              <input type="text" id="dingnum" min="1" max="100" class="order-txt-n" name="dingnum" value="1" />
              <input type="hidden" id="price" name="price" value="<?php echo intval($suit['0']['price_arr']['0']['adultprice']);?>" />
            <span class="order-btn plus plus-active" id="minus"></span>
            </span>
            <span class="order-jg">成人价<em>&yen;</em><em id="dismanprice"><?php echo intval($suit['0']['price_arr']['0']['adultprice']);?></em></span>
          </li>
          <li id="chiledli">
          <label>儿童：</label>
            <span>
            <span class="order-btn minus minus-active" id="plus"></span>
              <input type="text" id="childnum" min="1" max="100" class="order-txt-n" name="childnum" value="1" />
              <input type="hidden" id="childprice" name="childprice" value="<?php echo intval($suit['0']['price_arr']['0']['childprice']);?>" />
            <span class="order-btn plus plus-active" id="minus"></span>
            </span>
            <span class="order-jg">儿童价<em>&yen;</em><em id="dischildprice"><?php echo intval($suit['0']['price_arr']['0']['childprice']);?></em></span>
          </li>
          <li><label>联系人：</label><input type="text" name="linkman" id="linkman" class="order-lx" placeholder="请填写联系人" value="<?php echo $user['truename'];?>" /></li>
          <li><label>联系电话：</label><input type="text" name="linktel" id="linktel" class="order-lx" placeholder="手机号码或固定电话" value="<?php echo $user['mobile'];?>" />可通过此手机号查询订单(必填)</li>
        </ul>
        </form>
      </div>
      
    </div>
  </div>
  
 <?php echo  Stourweb_View::template('public/foot');  ?>
  
  <div class="opy"></div>
  <div class="bom_fix_box">
  <span>总额：<em>&yen;</em><em id="totle">0</em></span>
  <a class="booking" href="javascript:void(0);" onclick="checkform();">提交订单</a>
  </div>
  
</body>
<script type="text/javascript">
//提交订单
function checkform(){
    if(($('#dingnum').val()==0)&&($('#childnum').val()==0)){
      alert('请选择预订数量!');
      return false;
    }
    if(($('#price').val()==0)&&($('#childprice').val()==0)){
      alert('当前产品不能预订!');
      return false;
    }
    if($('#suitid').val()==0){
      alert('请选择套餐类型!');
      return false;
    }
    if($('#dateid').val()==0){
      alert('请选择出行日期!');
      return false;
    }
    if($('#linkman').val()==''){
      alert('请填写联系人!');
      return false;
    }
    $('#form1').submit();
}
$('.plus').click(function(){
    var dingnum = $(this).parent().find('.order-txt-n');
    dingnum.val(parseInt(dingnum.val())+1);
    checkPNum();
});
$('.minus').click(function(){
    var dingnum = $(this).parent().find('.order-txt-n');
    var peopelnum = dingnum.val();
    if(peopelnum>=1){
       dingnum.val(parseInt(dingnum.val())-1);
    }
    checkPNum();
});
//重新计算价格
function checkPNum(){
    var manNum = $('#dingnum').val();
    var childNum = $('#childnum').val();
    var manprice = $('#price').val();
    var childprice = $('#childprice').val();
    var totle = parseInt(manNum)*parseInt(manprice)+parseInt(childNum)*parseInt(childprice);
    $('#totle').html(totle);
}
//选中日期后重置大人小孩价格计算
function  settravel(){
  var selectdate = $('#tarveldate').val();
  var selectarr = selectdate.split('||');
  $('#dismanprice').html(selectarr[1]);
  $('#price').val(selectarr[1]);
  $('#dateid').val(selectarr[0]);
  if(selectarr[1]==0){
    $('#manli').css('display','none');
    $('#dingnum').val('0');
  }else{
    $('#manli').css('display','block');;
  }
  $('#childprice').val(selectarr[2]);
  $('#dischildprice').html(selectarr[2]);
  if(selectarr[2]==0){
    $('#childnum').val('0');
    $('#chiledli').css('display','none'); 
  }else{
    $('#chiledli').css('display','block');
  }
  checkPNum();
}
$(document).ready(function(){
  checkPNum();
});
//房型切换
$('.fangxing').click(function(){
  $('.fangxing').removeClass('cur');
  $(this).addClass('cur');
  var roomid=$(this).attr('dateid');
     $('#suitid').val(roomid);
   for(a in pricearr){
      if(pricearr[a]['id']==roomid){
        var str='';
        if(pricearr[a]['price_arr'].length == 0){
          //重置价格选择框
          str += '<select style="font-size: 14px;width:100%;height:30px; color:#2a2a2a; margin-top:10px; margin-left:-5px;" id="tarveldate" name="tarveldate"><option>暂无价格信息</option></select>';
          $('.selectdiv').html(str);
          //价格清空
          $('#dismanprice').html('0');
          $('#price').val('0');
          $('#childprice').val('0');
          $('#dischildprice').html('0');
          checkPNum();
        }else{
          //重置价格选择框
          str +='<select style="font-size: 14px;width:100%;height:30px; color:#2a2a2a; margin-top:10px; margin-left:-5px;" id="tarveldate" name="tarveldate" onchange="settravel();">';
          for (b in pricearr[a]['price_arr']) {
            var disstr = pricearr[a]['price_arr'][b]['day'];
            var dayid =  pricearr[a]['price_arr'][b]['dayid'];
            var price1 = parseInt(pricearr[a]['price_arr'][b]['adultprice']);
            var price2 = parseInt(pricearr[a]['price_arr'][b]['childprice']);
            if(price1>0){
                disstr += ' ￥'+pricearr[a]['price_arr'][b]['adultprice']+'/大人';
            }
            if(price2>0){
                disstr += ' ￥'+pricearr[a]['price_arr'][b]['childprice']+'/儿童';
            }
            str +='<option value="'+dayid+'||'+price1+'||'+price2+'">'+disstr+'</option>';
          }
          str +='</select>';
          $('.selectdiv').html(str);
          //重新计算价格
          settravel();
        }
      }
   }
});
</script>
</html>
