<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if(empty($row['seotitle'])) { ?><?php echo $row['carname'];?><?php } else { ?><?php echo $row['seotitle'];?><?php } ?>
-<?php echo $webname;?></title>
<meta name="keyword" content="<?php echo $row['keyword'];?>">
<meta name="description" content="<?php echo $row['description'];?>">
<?php echo Common::getCss('m_base.css,style.css'); ?>
<?php echo Common::getScript('jquery-min.js'); ?>
<script type="text/javascript">
  var pricearr=<?php echo json_encode($room);?>;
</script>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="javascript:history.go(-1);">返回</a>
    <a class="city_tit">车辆套餐选择</a>
  </div>
  
  <div class="m-main">

  <div class="xz-top-box">
    <div class="pic"><img class="fl" src="<?php echo $row['litpic'];?>" alt="" width="90" height="64" /></div>
    <div class="txt">
        <p><?php echo $row['carname'];?></p>
        <?php if(intval($row['carprice'])>0) { ?>
        <span>&yen;<?php echo $row['carprice'];?>起</span>
        <?php } else { ?>
        <span><电询</span>
        <?php } ?>
      </div>
    </div>
    
    <div class="big_box">
    
      <div class="price-tc">
        <h3>套餐类型</h3>
        <ul>
        <?php $n=1; if(is_array($room)) { foreach($room as $key => $v1) { ?>
             <li <?php if($key==0) { ?>class="cur fangxing"<?php } else { ?>class="fangxing"<?php } ?>
 dateid="<?php echo $v1['id'];?>"><?php echo $v1['suitname'];?> <?php if(intval($v1['price'])>0) { ?>&yen;<?php echo $v1['price'];?>起<?php } else { ?>电询<?php } ?>
</li>
        <?php $n++;}unset($n); } ?>
        </ul>
      </div>
      
      <div class="go-date">
      <h3>出行日期</h3>
        <div class="selectdiv">
        <?php if(!empty($room['0']['price_arr'])) { ?>
          <select style="font-size: 14px;width:100%;height:30px; color:#2a2a2a; margin-top:10px; margin-left:-5px;" id="tarveldate" name="tarveldate" onchange="settravel();">
            <?php $n=1; if(is_array($room['0']['price_arr'])) { foreach($room['0']['price_arr'] as $v2) { ?>
              <option value="<?php echo $v2['dayid'];?>||<?php echo $v2['adultprice'];?>"><?php echo $v2['day'];?> ￥<?php echo $v2['adultprice'];?>/<?php echo $room['0']['unit'];?></option>
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
      <input type="hidden" id="ordertype" name="ordertype" value="3" />
      <input type="hidden" id="dateid" name="dateid" value="<?php echo $room['0']['price_arr']['0']['dayid'];?>" />
      <input type="hidden" id="suitid" name="suitid" value="<?php echo intval($room['0']['id']);?>" />
      <input type="hidden" id="price" name="price" value="<?php echo $room['0']['price_arr']['0']['adultprice'];?>" />
      <h3>预定人数</h3>
        <ul>
        <li>
          <label>预定数量：</label>
            <span>
            <span class="order-btn minus minus-active"></span>
              <input type="text" id="dingnum" min="1" max="100" class="order-txt-n" name="dingnum" value="1" />
            <span class="order-btn plus plus-active"></span>
            </span>
            <span class="order-jg"></span>
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
  <span>总额：<em>&yen;</em><em id='totle'>0</em></span>
  <a class="booking" href="javascript:void(0);" onclick="checkform();">提交订单</a>
  </div>
  
</body>
<script type="text/javascript">
//提交订单
function checkform(){
    if($('#dingnum').val()==0){
      alert('请选择预订数量!');
      return false;
    }
    if($('#price').val()==0){
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
    var manprice = $('#price').val();
    var totle = parseInt(manNum)*parseInt(manprice);
    $('#totle').html(totle);
}
//选中日期后重置大人小孩价格计算
function  settravel(){
  var selectdate = $('#tarveldate').val();
  var selectarr = selectdate.split('||');
  $('#price').val(selectarr[1]);
  $('#dateid').val(selectarr[0]);
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
          $('#price').val('0');
          checkPNum();
        }else{
          //重置价格选择框
          str +='<select style="font-size: 14px;width:100%;height:30px; color:#2a2a2a; margin-top:10px; margin-left:-5px;" id="tarveldate" name="tarveldate" onchange="settravel();">';
          for (b in pricearr[a]['price_arr']) {
            str +='<option value="'+pricearr[a]['price_arr'][b]['dayid']+'||'+pricearr[a]['price_arr'][b]['adultprice']+'">'+pricearr[a]['price_arr'][b]['day']+' ￥'+pricearr[a]['price_arr'][b]['adultprice']+'/'+pricearr[a]['unit']+'</option>';
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
