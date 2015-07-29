<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>相册列表-<?php echo $webname;?></title>
  <?php echo Common::getCss('m_base.css,style.css'); ?>
  <?php echo Common::getScript('jquery-min.js,st_m.js'); ?>
</head>
<body>
<?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
    <a class="back" href="<?php echo $cmsurl;?>">返回</a>
    <a class="city_tit" href="javascript:;"><?php echo $kindname;?>-相册</a>
</div>
  
  <div class="m-main">
  <div class="change-type">
      <div class="posfex">
        <ul id="des_w">
            <li id="des"><a href="javascript:;" ><?php echo $kindname;?></a></li>
            <li class="no-line" id="des-by"><a href="javascript:;"><?php echo $attrname;?></a></li>
        </ul>
      </div>
      
      <div id="des_con">
        <div class="change-type-c" id="des-c">
          <p><a href="<?php echo $cmsurl;?>photo/list/kindid/0/attrid/<?php echo $attrid;?>">不限</a></p>
            <?php $n=1; if(is_array($kindlist)) { foreach($kindlist as $row) { ?>
            <p <?php if($row['id']==$kindid) { ?>class="on"<?php } ?>
><a href="<?php echo $cmsurl;?>photo/list/kindid/<?php echo $row['id'];?>/attrid/<?php echo $attrid;?>"><?php echo $row['kindname'];?></a></p>
            <?php $n++;}unset($n); } ?>
        </div>
        <div class="change-type-c" id="des-by-c">
          <p class="on"><a href="<?php echo $cmsurl;?>photo/list/kindid/<?php echo $kindid;?>/attrid/0">不限</a></p>
            <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $row) { ?>
            <p <?php if($row['id']==$attrid) { ?>class="on"<?php } ?>
><a href="<?php echo $cmsurl;?>photo/list/kindid/<?php echo $kindid;?>/attrid/<?php echo $row['id'];?>/order/<?php echo $order;?>"><?php echo $row['attrname'];?></a></p>
            <?php $n++;}unset($n); } ?>
        </div>
      </div>
    </div>
<div class="photo-box" id="photo_list" >
            <ul class="case-list">
               <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?>
                 <li>
                     <a href="<?php echo $cmsurl;?>photo/show/id/<?php echo $row['id'];?>">
                         <img src="<?php echo $row['litpic'];?>" />
                         <p><?php echo $row['photoname'];?></p>
                     </a>
                 </li>
               <?php $n++;}unset($n); } ?>
              </ul>
    </div>
</div>
<a href="javascript:;" class="load-more" data-page="1">点击载入更多</a>
  <?php echo  Stourweb_View::template('public/foot');  ?>
    <input type="hidden" id="kindid" value="<?php echo $kindid;?>">
    <input type="hidden" id="attrid" value="<?php echo $attrid;?>">
</body>
<script type="text/javascript">
   
    $(function(){
        $('.load-more').click(function(){
            var page = parseInt($(this).attr('data-page'))+1;
            var kindid = $('#kindid').val();
            var attrid = $('#attrid').val();
            var url=SITEURL+'photo/list/kindid/'+kindid+"/attrid/"+attrid+"/page/"+page+"/action/ajax";
            $.ajax({
                type:'POST',
                data:"page="+page,
                url:url,
                dataType:'json',
                success:function(data){
                    var html = '';
                    var listnum = 0;
                    $.each(data,function(index,row){
                        html+='   <li class="case-list">';
                        html+='    <a href="'+SITEURL+'photo/show/id/'+row.id+'">';
                        html+='    <img src="'+row.litpic+'" alt="" />';
                        html+='    <p>'+row.photoname+'</p>';
                        html+='    </a>';
                        html+='</li>';
                        listnum++;
                    })
                    if(listnum>0){
                        $(".load-more").attr('data-page',page);
                        $(".case-list").append(html);
                    }
                }
            })
         });
        });

</script>
</html>