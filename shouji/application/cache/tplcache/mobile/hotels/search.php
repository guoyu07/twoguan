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
<div class="city_top clearfix">
  <a class="back" href="<?php echo $cmsurl;?>hotels/index">返回</a>
    <a class="city_tit"><?php echo $idname;?>-酒店</a>
  </div>
  
  <div class="m-main">
<section class="main-xl">
<div class="change-type">
  <div class="posfex">
        <ul id="des_w">
<li id="des"><a href="javascript:;" ><?php echo $cityname;?></a></li>
<li id="des-day"><a href="javascript:;"><?php echo $typename;?></a></li>
<li class="no-line" id="des-by"><a href="javascript:;"><?php echo $pricename;?></a></li>
</ul>
        </div>
<!--下拉列表-->
        <div id="des_con">
          <div class="change-type-c" id="des-c">
             <input type="hidden" name="city" id="city" value="<?php echo intval($city);?>" />
              <p><a href="<?php echo $cmsurl;?>hotels/list/?city=0&star=<?php echo intval($star);?>&price=<?php echo intval($price);?>&key=<?php echo $key;?>&order=<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($kindlist)) { foreach($kindlist as $v1) { ?>
              <?php if($v1['id']==$city) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo $v1['id'];?>&star=<?php echo intval($star);?>&price=<?php echo intval($price);?>&key=<?php echo $key;?>&order=<?php echo $order;?>"><?php echo $v1['kindname'];?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo $v1['id'];?>&star=<?php echo intval($star);?>&price=<?php echo intval($price);?>&key=<?php echo $key;?>&order=<?php echo $order;?>"><?php echo $v1['kindname'];?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
          <div class="change-type-c" id="des-day-c">
             <input type="hidden" name="star" id="star" value="<?php echo intval($star);?>" />
              <p><a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo intval($city);?>&star=0&price=<?php echo intval($price);?>&key=<?php echo $key;?>&order=<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($typelist)) { foreach($typelist as $v1) { ?>
              <?php if($v1['id']==$star) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo intval($city);?>&star=<?php echo $v1['id'];?>&price=<?php echo intval($price);?>&key=<?php echo $key;?>&order=<?php echo $order;?>"><?php echo $v1['hotelrank'];?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo intval($city);?>&star=<?php echo $v1['id'];?>&price=<?php echo intval($price);?>&key=<?php echo $key;?>&order=<?php echo $order;?>"><?php echo $v1['hotelrank'];?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
<div class="change-type-c" id="des-by-c">
             <input type="hidden" name="price" id="price" value="<?php echo intval($price);?>" />
              <p><a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo intval($city);?>&star=<?php echo intval($star);?>&price=0&key=<?php echo $key;?>&order=<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($pricelist)) { foreach($pricelist as $v1) { ?>
              <?php if($v1['id']==$price) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo intval($city);?>&star=<?php echo intval($star);?>&price=<?php echo $v1['id'];?>&key=<?php echo $key;?>&order=<?php echo $order;?>"><?php echo intval($v1['min']);?>-<?php echo intval($v1['max']);?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>hotels/list/?city=<?php echo intval($city);?>&star=<?php echo intval($star);?>&price=<?php echo $v1['id'];?>&key=<?php echo $key;?>&order=<?php echo $order;?>"><?php echo intval($v1['min']);?>-<?php echo intval($v1['max']);?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
</div>
        </div>
        
        <div class="df_px">
        <span class="sp_1">默认排序</span>
          <input type="hidden" name="order" id="order" value="<?php echo $order;?>" />
          <span class="sp_2">
            <em>价格</em>
            <a class="up" href="<?php echo $cmsurl;?>hotels/list/city/<?php echo intval($city);?>&star=<?php echo intval($star);?>&price=<?php echo intval($price);?>&key=<?php echo $key;?>&order=asc"></a>
            <a class="down" href="<?php echo $cmsurl;?>hotels/list/city/<?php echo intval($city);?>&star=<?php echo intval($star);?>&price=<?php echo intval($price);?>&key=<?php echo $key;?>&order=desc"></a>
          </span>
        </div>
        
        <div class="fex">
        <!--list开始-->
          <?php $n=1; if(is_array($list)) { foreach($list as $v) { ?>
<div class="pdt_list">
            <a href="<?php echo $cmsurl;?>hotels/show/id/<?php echo $v['id'];?>">
              <div class="pdt_img"><img src="<?php echo $v['litpic'];?>" width="90" height="64"></div>
              <div class="pdt_txt">
                <div class="pdt_box">
                  <p class="p_tit">
                  <em><?php echo $v['hotelname'];?></em>
                    <span class="star"><?php echo $v['randname'];?></span>
                    <span class="mt5">优惠价：<?php if(intval($v['hotelprice'])>0) { ?><b>&yen;<?php echo $v['hotelprice'];?></b>起<?php } else { ?><b>电询</b><?php } ?>
</span>
                  </p>
                </div>
              </div>
            </a>
          </div>
          <?php $n++;}unset($n); } ?>
          
          <!--list结束-->

</div>
          <div class="load_more"><img src="../images/loading.gif" />正在载入中</div>
          <input type="hidden" value="<?php echo $key;?>" id="key"/>
          <a href="javascript:void();" class="load-more"  page="1"/>点击载入更多<a>
</div>
</section>
</div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
</body>
<script type="text/javascript">
$('.load-more').click(function(){
        var docRec = $(this);
        var page = parseInt(docRec.attr('page'))+1;
        var city = $('#city').val();
        var star = $('#star').val();
        var price = $('#price').val();
        var order = $('#order').val();
        var key = $('#key').val();
        var url='/shouji/hotels/list/?city='+city;
         $.get(url+'&star='+star+'&price='+price+'&key='+encodeURIComponent(key)+'&action=ajaxline&page='+page+'&order='+order,function(results){
            eval('results='+results);
            var str = '';
            var listnum = 0;
            for(a in results){
                var temprice = '<b>电询</b>';
                if(results[a]['hotelprice']>0){
                  temprice = '<b>&yen;'+results[a]['hotelprice']+'</b> 起';
                }
               str +=  '<div class="pdt_list"><a href="<?php echo $cmsurl;?>hotels/show/id/'+results[a]['id']+'"><div class="pdt_img"><img src="'+results[a]['litpic']+'" width="90" height="64"></div><div class="pdt_txt"><div class="pdt_box"><p class="p_tit"><em>'+results[a]['hotelname']+'</em><span class="star">'+results[a]['randname']+'</span><span class="mt5">优惠价：'+temprice+'</span></p></div></div></a></div>';
               
                listnum++;
            }
            docRec.attr('page',page);
            if(listnum==0){
              docRec.html('已无更多文章攻略信息');
            }
            $('.fex').append(str);
        });
    });
</script>
</html>
