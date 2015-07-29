<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>{$seoinfo['seotitle']}-{$webname}</title>
<meta name="keywords" content="{$seoinfo['keyword']}" />
<meta name="description" content="{$seoinfo['description']}" />
 {php echo Common::getCss('m_base.css,style.css'); }
 {php echo Common::getScript('jquery-min.js,st_m.js'); }
</head>

<body>
  {template 'public/top'}
  
  <div class="m-main" id="mainindex">
  
		<div class="c_search_top">
      <input type="hidden" name="kindid" id="kindid" value="0" />
      <input type="hidden" name="kind" id="kind" value="0" />
      <input type="hidden" name="city" id="city" value="0" />
    	<ul>
      	<li class="li_1"><p><em>车型分类</em><span id="kind_val">不限</span></p></li>
      	<li class="li_2"><p><em>租车类型</em><span id="kindid_val">不限</span></p></li>
      <!--	<li class="li_3"><p><em>租车价格</em><span id="city_val">不限</span></p></li>-->
      </ul>
      <a class="jd_cx" href="#">租车查询</a>
    </div>
    
    <div class="car_list">
    	<h3 class="car_list_tit">推荐租车</h3>
      <div class="car_con">
      	<p>
        	{loop $list $key $v}
          {if $key%2==0}
          </p>
          <p>
          {/if}
          <a href="{$cmsurl}cars/show/id/{$v['id']}">
            {if $v['carprice']>0}
            <em>&yen; {$v['carprice']} 起</em>
            {else}
            <em>电询</em>
            {/if}
            <img src="{$v['litpic']}" alt="" width="145" height="100" />
            <span>{$v['carname']}</span>
          </a>
        {/loop}
        </p>
      </div>
      <div class="list_more">
      	<a href="{$cmsurl}cars/list/">点击查看更多&gt;&gt;</a>
      </div>
    </div>
    
	</div>
  
  <!-- 租车的属性选项-->
  <div class="m-main" id="arealist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">租车类别</a>
    </div>
    <div>
      <p class="hotel-city-header"><span class="selectli" mainname="kindid" keyid="0" keyword="不限" style="width: 100%; display: block;">不限</span></p>
      <ul>
      {loop $carattr $v1}
        <li>
          <p class="hotel-city-header">{$v1['attrname']}<i class="icon-arrow-up"></i></p>
          <ul class="hotel-city-list">
          {loop $v1['nextlist'] $v2}
            <li class="selectli" mainname="kindid" keyid="{$v2['id']}" keyword="{$v2['attrname']}">{$v2['attrname']}</li>
          {/loop}
          </ul>
        </li>
      {/loop}
      </ul>
    </div>
  </div>

  <!-- 租车的类型选项-->
  <div class="m-main" id="kindlist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">车辆类型</a>
    </div>
    <div>
      <ul class="hotel-city-list">
        <li class="selectli" mainname="kind" keyid="0" keyword="不限">不限</li>
      {loop $cartype $v}
        <li class="selectli" mainname="kind" keyid="{$v['id']}" keyword="{$v['kindname']}">{$v['kindname']}</li>
      {/loop}
      </ul>
    </div>
  </div>

  <!-- 租车的价格类型
  <div class="m-main" id="citylist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">价格区间</a>
    </div>
    <div>
      <ul class="hotel-city-list">
         <li class="selectli" mainname="city" keyid="0" keyword="不限">不限</li>
       {loop $carpricelist $v}
         <li class="selectli" mainname="city" keyid="{$v['id']}" keyword="{intval($v['min'])}-{intval($v['max'])}">{intval($v['min'])}-{intval($v['max'])}</li>
      {/loop}
      </ul>
    </div>
  </div>-->

  {template 'public/foot'}
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
    $('#arealist').css('display','block');
    
    
});
$('.li_3').click(function(){
    $('.m-main').css('display','none');
    $('#citylist').css('display','block');
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
  location.href = '{$cmsurl}cars/list/kind/'+kind+'/attr/'+kindid;
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
