<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
 <?php echo Common::getScript('jquery-min.js,st_m.js'); ?>
 <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body>
  <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="<?php echo $cmsurl;?>lines/index">返回</a>
    <a class="city_tit"><?php echo $kindname;?>-线路</a>
  </div>
  <div class="m-main">
<section class="main-xl">
<div class="change-type">
  <div class="posfex">
        <ul id="des_w">
<li id="des"><a href="javascript:;" ><?php echo $kindname;?></a></li>
<li id="des-day"><a href="javascript:;"><?php echo $daysname;?></a></li>
<li id="des-type"><a href="javascript:;"><?php echo $travelname;?></a></li>
<li class="no-line" id="des-by"><a href="javascript:;"><?php echo $pricename;?></a></li>
</ul>
        </div>
<!--下拉列表-->
        <div id="des_con">
          <div class="change-type-c" id="des-c">
          <input type="hidden" name="kindid" id="kindid" value="<?php echo intval($kindid);?>" />
              <p><a href="<?php echo $cmsurl;?>lines/list/?kindid=0&days=<?php echo intval($days);?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($kindlist)) { foreach($kindlist as $v1) { ?>
              <?php if($v1['id']==$kindid) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $v1['id'];?>&days=<?php echo intval($days);?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>"><?php echo $v1['kindname'];?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $v1['id'];?>&days=<?php echo intval($days);?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>"><?php echo $v1['kindname'];?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
          <div class="change-type-c" id="des-day-c">
          <input type="hidden" name="days" id="days" value="<?php echo intval($days);?>" />
             <p><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=0&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($dayslist)) { foreach($dayslist as $v2) { ?>
              <?php if($v2['word']==$days) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo $v2['word'];?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>"><?php echo $v2['word'];?>日游</a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo $v2['word'];?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>"><?php echo $v2['word'];?>日游</a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
          <div class="change-type-c" id="des-type-c">
          <input type="hidden" name="attrid" id="attrid" value="<?php echo intval($attrid);?>" />
           <p><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo intval($days);?>&attrid=0&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $v3) { ?>
              <?php if($v3['id']==$attrid) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo intval($days);?>&attrid={$v3['id'])}&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>"><?php echo $v3['attrname'];?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo intval($days);?>&attrid=<?php echo $v3['id'];?>&pricetyle=<?php echo intval($pricetyle);?>&order=<?php echo $order;?>"><?php echo $v3['attrname'];?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
            <div class="change-type-c" id="des-by-c">
            <input type="hidden" name="pricetyle" id="pricetyle" value="<?php echo intval($pricetyle);?>" />
             <p><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo intval($days);?>&attrid=<?php echo intval($attrid);?>&pricetyle=0&order=<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($pricelist)) { foreach($pricelist as $v4) { ?>
              <?php if($v4['id']==$pricetyle) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo intval($days);?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo $v4['id'];?>&order=<?php echo $order;?>"><?php echo intval($v4['lowerprice']);?>-<?php echo intval($v4['highprice']);?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo intval($days);?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo $v4['id'];?>&order=<?php echo $order;?>"><?php echo intval($v4['lowerprice']);?>-<?php echo intval($v4['highprice']);?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
</div>
        </div>
        <div class="df_px">
        <span class="sp_1">默认排序</span>
        <input type="hidden" name="order" id="order" value="<?php echo $order;?>" />
          <span class="sp_2">
          <em>价格</em>
            <a class="<?php if($order=='asc') { ?>upon<?php } else { ?>up<?php } ?>
 <?php echo $order;?>" href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo intval($days);?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo intval($pricetyle);?>&order=asc"></a>
            <a class="<?php if($order=='desc') { ?>downon<?php } else { ?>down<?php } ?>
 <?php echo $order;?>" href="<?php echo $cmsurl;?>lines/list/?kindid=<?php echo $kindid;?>&days=<?php echo intval($days);?>&attrid=<?php echo intval($attrid);?>&pricetyle=<?php echo intval($pricetyle);?>&order=desc"></a>
          </span>
        </div>
        <div class="fex">
        <?php $n=1; if(is_array($list)) { foreach($list as $v) { ?>
        <!--list开始-->
<div class="pdt_list">
            <a href="<?php echo $cmsurl;?>lines/show/id/<?php echo $v['id'];?>">
              <div class="pdt_img"><img src="<?php echo $v['linepic'];?>" width="90" height="64"></div>
              <div class="pdt_txt">
                <div class="pdt_box">
                  <p class="p_tit"><?php echo $v['linename'];?>...</p>
                  <p class="p_pir">
                  <?php if($v['lineprice']==0) { ?>
                  <strong>电询</strong>
                  <?php } else { ?>
                  <strong>&yen;<?php echo $v['lineprice'];?></strong>
                  <?php } ?>
                  <span>满意度<?php echo $v['satisfyscore'];?></span></p>
                </div>
              </div>
            </a>
          </div>
          <?php $n++;}unset($n); } ?>
          
          <!--list结束-->

</div>
        <div class="load_more"><img src="../images/loading.gif" />正在载入中</div>
          <input type="hidden" name="key" id="key" value="<?php if(empty($key)) { ?>0<?php } else { ?><?php echo $key;?><?php } ?>
" />
          <a href="javascript:;" class="load-more"  page="1" />点击载入更多<a>
</div>
</section>
</div>
  
<?php echo  Stourweb_View::template('public/foot');  ?>
</body>
<script type="text/javascript">
$('.load-more').click(function(){
        var docRec = $(this);
        var page = parseInt(docRec.attr('page'))+1;
        var kindid = $('#kindid').val();
        var days = $('#days').val();
        var key = $('#key').val();
        var attrid = $('#attrid').val();
        var pricetyle = $('#pricetyle').val();
        var order = $('#order').val();
        var url='/shouji/lines/list/?kindid='+kindid+'&days='+days+'&attrid='+attrid+'&pricetyle='+pricetyle+'&key='+key+'&action=ajaxline&page='+page+'&order='+order;
         $.get(url,function(results){
            eval('results='+results);
            var str = '';
            var listnum = 0;
            for(a in results){
                var temprice = '电询';
                if(results[a]['lineprice']>0){
                  temprice = '&yen;'+results[a]['lineprice'];
                }
                str += '<div class="pdt_list"><a href="<?php echo $cmsurl;?>lines/show/id/'+results[a]['id']+'"><div class="pdt_img"><img src="'+results[a]['linepic']+'" width="90" height="64"></div><div class="pdt_txt"><div class="pdt_box"><p class="p_tit">'+results[a]['linename']+'...</p><p class="p_pir"><strong>'+temprice+'</strong><span>满意度'+results[a]['satisfyscore']+'</span></p></div></div></a></div>';
                listnum++;
            }
            docRec.attr('page',page);
            if(listnum==0){
              docRec.html('已无更多线路');
            }
            $('.fex').append(str);
        });
    });
</script>
</html>
