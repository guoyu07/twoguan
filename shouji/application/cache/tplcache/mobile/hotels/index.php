<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
 <?php echo Common::getCss('m_base.css,style.css,jmonth.css'); ?>
 <?php echo Common::getScript('jquery-min.js,st_m.js,jMonth.js'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
  
  <div class="m-main" id="mainindex">
  
<div class="h_search_top">
      <input type="hidden" name="star" id="star" value="0" />
      <input type="hidden" name="price" id="price" value="0" />
      <input type="hidden" name="city" id="city" value="0" />
    <ul>
      <li class="li_1"><p><em>入住城市</em><span id="city_val">不限</span></p></li>
      <li class="li_2"><p><em>入住日期</em><span id="date_val"><?php echo date('m/d/Y');?></span></p></li>
      <li class="li_3"><p><em>房价范围</em><span id="price_val">不限</span></p></li>
      <li class="li_4"><p><em>酒店星级</em><span id="star_val">不限</span></p></li>
      <li class="li_5"><p><em>酒店名称</em><span><input type="text" id="key" placeholder="输入酒店名称" /></span></p></li>
      </ul>
      <a class="jd_cx" href="#">酒店查询</a>
    </div>
    
    <div class="hotel_list">
    <h3 class="hotel_list_tit">推荐酒店</h3>
      <div class="hotel_con">
      <p>
          <?php $n=1; if(is_array($list)) { foreach($list as $key => $v) { ?>
          <?php if($key%2==0) { ?>
          </p>
          <p>
          <?php } ?>
        <a href="<?php echo $cmsurl;?>hotels/show/id/<?php echo $v['id'];?>">
            <?php if(intval($v['hotelprice'])>0) { ?>
          <em>&yen; <?php echo $v['hotelprice'];?> 起</em>
            <?php } else { ?>
            <em>电询</em>
            <?php } ?>
          <img src="<?php echo $v['litpic'];?>" alt="" width="145" height="100" />
            <span><?php echo $v['hotelname'];?></span>
          </a>
          <?php $n++;}unset($n); } ?>
        </p>
      </div>
      <div class="list_more">
      <a href="<?php echo $cmsurl;?>hotels/list/city/0">点击查看更多&gt;&gt;</a>
      </div>
    </div>
    
</div>
  
  <!--酒店目的地-->
  <div class="m-main" id="cityindex" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">酒店目的地</a>
    </div>
    <div>
      <p class="hotel-city-header"><span class="selectli" mainname="city" keyid="0" keyword="不限" style="width: 100%; display: block;">不限</span></p>
    </div>
    <?php $n=1; if(is_array($citylist)) { foreach($citylist as $v1) { ?>
    <div>
      <p class="hotel-city-header"><span class="selectli" mainname="city" keyid="<?php echo $v1['id'];?>" keyword="<?php echo $v1['kindname'];?>" style="width: 100%; display: block;"><?php echo $v1['kindname'];?></span></p>
      <ul>
        <?php $n=1; if(is_array($v1['nextlist'])) { foreach($v1['nextlist'] as $v2) { ?>
        <li>
          <p class="hotel-city-header"><span class="selectli" mainname="city" keyid="<?php echo $v2['id'];?>" keyword="<?php echo $v2['kindname'];?>" style="width: 100%; display: block;"><?php echo $v2['kindname'];?></span><i class="icon-arrow-up"></i></p>
          <ul class="hotel-city-list">
            <?php $n=1; if(is_array($v2['nextlist'])) { foreach($v2['nextlist'] as $v3) { ?>
              <li class="selectli" mainname="city" keyid="<?php echo $v3['id'];?>" keyword="<?php echo $v3['kindname'];?>"><?php echo $v3['kindname'];?></li>
            <?php $n++;}unset($n); } ?>
          </ul>
        </li>
        <?php $n++;}unset($n); } ?>
      </ul>
    </div>
    <?php $n++;}unset($n); } ?>
  </div>
  <!-- 酒店的星级选项-->
  <div class="m-main" id="starlist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">酒店星级</a>
    </div>
    <div>
      <ul class="hotel-city-list">
        <li class="selectli" mainname="star" keyid="0" keyword="不限">不限</li>
      <?php $n=1; if(is_array($typelist)) { foreach($typelist as $v) { ?>
        <li class="selectli" mainname="star" keyid="<?php echo $v['aid'];?>" keyword="<?php echo $v['hotelrank'];?>"><?php echo $v['hotelrank'];?></li>
      <?php $n++;}unset($n); } ?>
      </ul>
    </div>
  </div>
  <!-- 酒店的价格选项-->
  <div class="m-main" id="pricelist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">价格区间</a>
    </div>
    <div>
      <ul class="hotel-city-list">
         <li class="selectli" mainname="price" keyid="0" keyword="不限">不限</li>
       <?php $n=1; if(is_array($pricelist)) { foreach($pricelist as $v) { ?>
         <li class="selectli" mainname="price" keyid="<?php echo $v['id'];?>" keyword="<?php echo intval($v['min']);?>-<?php echo intval($v['max']);?>"><?php echo intval($v['min']);?>-<?php echo intval($v['max']);?></li>
      <?php $n++;}unset($n); } ?>
      </ul>
    </div>
  </div>
<!--日期选择-->
<div class="m-main" id="datelist" style="display:none">
    <div class="city_top clearfix">
      <a class="back" href="javascript:void(0);" onclick="backtype();">返回</a>
      <a class="city_tit">选择入住日期</a>
    </div>
    <dl class="kz_select">
    <dt class="hotel-city-header">日期选择</dt>
    <dd>
      <div id="jMonthCalendar">
        <script>
            $(document).ready(function() {
            var options = {
            height: 'auto',
            width: '100%',
            navHeight: 30,
            labelHeight: 28,
            onMonthChanging: function(dateIn) {
              return true;
            },
            onEventLinkClick: function(event) { 
              alert('aa');
              return true; 
            },
            onEventBlockClick: function(event) { 
              return true; 
            },
            onEventBlockOver: function(event) {
              return true;
            },
            onEventBlockOut: function(event) {
              return true;
            }
          };
          var d = new Date();
          var str = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
          var data=[{"EventID": "25", "StartDateTime": str, "Title": "", "URL": "#", "Description": "", "CssClass": "Meeting"}];
          var events=eval(data);
          $.jMonthCalendar.Initialize(options, events);
          
            })
        </script>
      </div>
    </dd>
    </dl>
  </div>
 <?php echo  Stourweb_View::template('public/foot');  ?>
</body>
<script type="text/javascript">
 
$('.li_1').click(function(){
    $('.m-main').css('display','none');
    $('#cityindex').css('display','block');
    
});
$('.li_2').click(function(){
    $('.m-main').css('display','none');
    $('#datelist').css('display','block');
    
});
$('.li_3').click(function(){
    $('.m-main').css('display','none');
    $('#pricelist').css('display','block');
});
$('.li_4').click(function(){
    $('.m-main').css('display','none');
    $('#starlist').css('display','block');
});
function backtype(){
    $('.m-main').css('display','none');
    $('#mainindex').css('display','block');    
}
//日历点中效果
function hotelselectdate(seobj){
   var selectdate = $(seobj).attr('date');
   $('#date_val').html(selectdate);
   backtype();
}
//提交参数查询
$('.jd_cx').click(function(){
  var star = $('#star').val();
  var city = $('#city').val();
  var price = $('#price').val();
  var key = $('#key').val();
  if(key==''){
    key=0;
  }else{
    key = encodeURIComponent(key);
  }
  location.href = '<?php echo $cmsurl;?>hotels/list/city/'+city+'/star/'+star+'/price/'+price+'/key/'+key;
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
