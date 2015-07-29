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
    <a class="back" href="<?php echo $cmsurl;?>cars/index">返回</a>
    <a class="city_tit"><?php if($cartypename=='车辆类型') { ?>租车信息<?php } else { ?><?php echo $cartypename;?>-租车<?php } ?>
</a>
  </div>
  
  <div class="m-main">
<section class="main-xl">
<div class="change-type">
  <div class="posfex">
        <ul id="des_w">
<li id="des"><a href="javascript:;" ><?php echo $cartypename;?></a></li>
<li id="des-day"><a href="javascript:;"><?php echo $attrname;?></a></li>
<li class="no-line" id="des-by"><a href="javascript:;"><?php echo $pricename;?></a></li>
</ul>
        </div>
<!--下拉列表-->
        <div id="des_con">
          <div class="change-type-c" id="des-c">
           <input type="hidden" name="kind" id="kind" value="<?php echo intval($kind);?>" />
              <p><a href="<?php echo $cmsurl;?>cars/list/kind/0/attr/<?php echo intval($attr);?>/price/<?php echo intval($price);?>/order/<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($cartype)) { foreach($cartype as $v1) { ?>
              <?php if($v1['id']==$kind) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>cars/list/kind/<?php echo $v1['id'];?>/attr/<?php echo intval($attr);?>/price/<?php echo intval($price);?>/order/<?php echo $order;?>"><?php echo $v1['kindname'];?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>cars/list/kind/<?php echo $v1['id'];?>/attr/<?php echo intval($attr);?>/price/<?php echo intval($price);?>/order/<?php echo $order;?>"><?php echo $v1['kindname'];?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
          <div class="change-type-c" id="des-day-c">
            <input type="hidden" name="attr" id="attr" value="<?php echo intval($attr);?>" />
              <p><a href="<?php echo $cmsurl;?>cars/list/kind/<?php echo intval($kind);?>/attr/0/price/<?php echo intval($price);?>/order/<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $v1) { ?>
              <?php if($v1['id']==$attr) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>cars/list/kind/<?php echo intval($kind);?>/attr/<?php echo $v1['id'];?>/price/<?php echo intval($price);?>/order/<?php echo $order;?>"><?php echo $v1['attrname'];?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>cars/list/kind/<?php echo intval($kind);?>/attr/<?php echo $v1['id'];?>/price/<?php echo intval($price);?>/order/<?php echo $order;?>"><?php echo $v1['attrname'];?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
          <div class="change-type-c" id="des-type-c">
            <input type="hidden" name="price" id="price" value="<?php echo intval($price);?>" />
              <p><a href="<?php echo $cmsurl;?>cars/list/kind/<?php echo intval($kind);?>/attr/<?php echo intval($attr);?>/price/0/order/<?php echo $order;?>">不限</a></p>
            <?php $n=1; if(is_array($pricelist)) { foreach($pricelist as $v1) { ?>
              <?php if($v1['id']==$price) { ?>
                <p class="on"><a href="<?php echo $cmsurl;?>cars/list/kind/<?php echo intval($kind);?>/attr/<?php echo intval($attr);?>/price/<?php echo $v1['id'];?>/order/<?php echo $order;?>"><?php echo intval($v1['min']);?>-<?php echo intval($v1['max']);?></a></p>
              <?php } else { ?>
                <p ><a href="<?php echo $cmsurl;?>cars/list/kind/<?php echo intval($kind);?>/attr/<?php echo intval($attr);?>/price/<?php echo $v1['id'];?>/order/<?php echo $order;?>"><?php echo intval($v1['min']);?>-<?php echo intval($v1['max']);?></a></p>
              <?php } ?>
            <?php $n++;}unset($n); } ?>
          </div>
        </div>
        
        <div class="df_px">
        <span class="sp_1">默认排序</span>
         <input type="hidden" name="order" id="order" value="<?php echo $order;?>" />
          <span class="sp_2">
            <em>价格</em>
            <a class="up" href="<?php echo $cmsurl;?>cars/list/kind/<?php echo intval($kind);?>/attr/<?php echo intval($attr);?>/price/<?php echo intval($price);?>/order/asc"></a>
            <a class="down" href="<?php echo $cmsurl;?>cars/list/kind/<?php echo intval($kind);?>/attr/<?php echo intval($attr);?>/price/<?php echo intval($price);?>/order/desc"></a>
          </span>
        </div>
        
        <div class="fex">
        <!--list开始-->
          <?php $n=1; if(is_array($list)) { foreach($list as $v) { ?>
  <div class="pdt_list">
              <a href="<?php echo $cmsurl;?>cars/show/id/<?php echo $v['id'];?>">
                <div class="pdt_img"><img src="<?php echo $v['litpic'];?>" width="90" height="64"></div>
                <div class="pdt_txt">
                  <div class="pdt_box">
                    <p class="p_tit">
                    <em><?php echo $v['carname'];?></em>
                      <span><?php echo $v['content'];?></span>
                      <span class="mt5">优惠价：<?php if(intval($v['carprice'])>0) { ?><b>&yen;<?php echo $v['carprice'];?></b>起<?php } else { ?><b>电询</b><?php } ?>
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
        var kind = $('#kind').val();
        var attrid = $('#attr').val();
        var price = $('#price').val();
        var order = $('#order').val();
         $.get('/shouji/cars/list/kind/'+kind+'/attr/'+attrid+'/price/'+price+'/action/ajaxline/page/'+page+'/order/'+order,function(results){
            eval('results='+results);
            var str = '';
            var listnum = 0;
            for(a in results){
                var temprice = '<b>电询</b>';
                if(results[a]['carprice']>0){
                  temprice = '<b>&yen;'+results[a]['carprice']+'</b>起';
                }
                str += '<div class="pdt_list"><a href="<?php echo $cmsurl;?>cars/show/id/'+results[a]['id']+'"><div class="pdt_img"><img src="'+results[a]['litpic']+'" width="90" height="64"></div><div class="pdt_txt"><div class="pdt_box"><p class="p_tit"><em>'+results[a]['carname']+'</em><span>'+results[a]['content']+'</span><span class="mt5">优惠价：'+temprice+'</span></p></div></div></a></div>';
                listnum++;
            }
            docRec.attr('page',page);
            if(listnum==0){
              docRec.html('已无更多车辆信息');
            }
            $('.fex').append(str);
        });
    });
</script>
</html>
