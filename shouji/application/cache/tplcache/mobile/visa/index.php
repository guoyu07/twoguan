<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
 <?php echo Common::getCss('m_base.css,style.css'); ?>
 <?php echo Common::getScript('jquery-min.js,st_m.js'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
  
  <div class="m-main" id="mainindex">
  
<div class="v_search_top">
    <input type="hidden" name="kindid" id="kindid" value="0" />
    <input type="hidden" name="kind" id="kind" value="0" />
    <input type="hidden" name="city" id="city" value="0" />
    <ul>
      <li class="li_1"><p><em>签证类型</em><span id="kind_val">不限</span></p></li>
      <li class="li_2"><p><em>签发城市</em><span id="city_val">不限</span></p></li>
      <li class="li_3"><p><em>签证国家</em><span id="kindid_val">不限</span></p></li>
      </ul>
      <a class="jd_cx" href="#">签证查询</a>
    </div>
    
    <div class="hotel_list">
    <h3 class="visa_list_tit">热门签证</h3>
      <div class="hotel_con">
      <p>
        <?php $n=1; if(is_array($list)) { foreach($list as $key => $v) { ?>
          <?php if($key%2==0) { ?>
          </p>
          <p>
          <?php } ?>
        <a href="<?php echo $cmsurl;?>visa/show/id/<?php echo $v['id'];?>">
            <?php if($v['price']>0) { ?>
          <em>&yen; <?php echo $v['price'];?> 起</em>
            <?php } else { ?>
            <em>电询</em>
            <?php } ?>
          <img src="<?php echo $v['litpic'];?>" alt="" width="145" height="100" />
            <span><?php echo $v['title'];?></span>
          </a>
        <?php $n++;}unset($n); } ?>
        </p>
      </div>
      <div class="list_more">
      <a href="<?php echo $cmsurl;?>visa/list/">点击查看更多&gt;&gt;</a>
      </div>
    </div>
    
</div>
  <!-- 签证的目的地选项-->
  <div class="m-main" id="arealist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">签证地区</a>
    </div>
    <div>
      <p class="hotel-city-header"><span class="selectli" mainname="kindid" keyid="0" keyword="不限" style="width: 100%; display: block;">不限</span></p>
      <ul>
      <?php $n=1; if(is_array($area)) { foreach($area as $v1) { ?>
        <li>
          <p class="hotel-city-header"><?php echo $v1['kindname'];?><i class="icon-arrow-up"></i></p>
          <ul class="hotel-city-list">
          <?php $n=1; if(is_array($v1['netslist'])) { foreach($v1['netslist'] as $v2) { ?>
            <li class="selectli" mainname="kindid" keyid="<?php echo $v2['id'];?>" keyword="<?php echo $v2['kindname'];?>"><?php echo $v2['kindname'];?></li>
          <?php $n++;}unset($n); } ?>
          </ul>
        </li>
      <?php $n++;}unset($n); } ?>
      </ul>
    </div>
  </div>
  <!-- 签证的类型选项-->
  <div class="m-main" id="kindlist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">签证类型</a>
    </div>
    <div>
      <ul class="hotel-city-list">
        <li class="selectli" mainname="kind" keyid="0" keyword="不限">不限</li>
      <?php $n=1; if(is_array($visatype)) { foreach($visatype as $v) { ?>
        <li class="selectli" mainname="kind" keyid="<?php echo $v['id'];?>" keyword="<?php echo $v['kindname'];?>"><?php echo $v['kindname'];?></li>
      <?php $n++;}unset($n); } ?>
      </ul>
    </div>
  </div>
  <!-- 签证的类型选项-->
  <div class="m-main" id="citylist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">签发城市</a>
    </div>
    <div>
      <ul class="hotel-city-list">
         <li class="selectli" mainname="city" keyid="0" keyword="不限">不限</li>
       <?php $n=1; if(is_array($visacity)) { foreach($visacity as $v) { ?>
         <li class="selectli" mainname="city" keyid="<?php echo $v['id'];?>" keyword="<?php echo $v['kindname'];?>"><?php echo $v['kindname'];?></li>
      <?php $n++;}unset($n); } ?>
      </ul>
    </div>
  </div>
 <?php echo  Stourweb_View::template('public/foot');  ?>
</body>
<script type="text/javascript">
  $(function(){
  $("li p.hotel-city-header").toggle(function(){
        $(this).next(".hotel-city-list").hide();
        $(this).children("i").removeClass("icon-arrow-up").addClass("icon-arrow-down");
    },function(){
        $(this).next(".hotel-city-list").show();
        $(this).children("i").removeClass("icon-arrow-down").addClass("icon-arrow-up");
      });
  });
$('.li_1').click(function(){
    $('.m-main').css('display','none');
    $('#kindlist').css('display','block');
    
});
$('.li_2').click(function(){
    $('.m-main').css('display','none');
    $('#citylist').css('display','block');
    
});
$('.li_3').click(function(){
    $('.m-main').css('display','none');
    $('#arealist').css('display','block');
});
function backtype(){
    $('.m-main').css('display','none');
    $('#mainindex').css('display','block');    
}
//提交参数查询
$('.jd_cx').click(function(){
  var kindid = $('#kindid').val();
  var city = $('#city').val();
  var kind = $('#kind').val();
  location.href = '<?php echo $cmsurl;?>visa/list/id/'+kindid+'/kind/'+kind+'/city/'+city;
});
//设置选中结果
$('.selectli').click(function(){
   var docRec = $(this);
   var selectmain = docRec.attr('mainname');//选择的类型
   var selectid = docRec.attr('keyid');//选定的值
   var selectkey = docRec.attr('keyword');//选定的显示字符串
   $('#'+selectmain).val(selectid);
   $('#'+selectmain+'_val').html(selectkey);
   backtype();
});
</script>
</html>
