<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>评论列表-<?php echo $webname;?></title>
    <?php echo Common::getScript('jquery-min.js'); ?>
    <?php echo Common::getCss('m_base.css,style.css'); ?>
</head>
<body class="bg_f0f">
  <?php echo  Stourweb_View::template('public/top');  ?>
<div class="city_top clearfix">
  <a class="back" href="javascript:window.history.back(-1)">返回</a>
    <a class="city_tit" href="javascript:;">点评记录</a>
  </div>
  
  <div class="m-main">
  <div class="kh_dp">
    <ul>
      <li><img src="<?php echo $publicurl;?>images/kh-dp-bg.png" width="50" /></li>
        <li>
        <span><?php echo $tuan['score'];?></span><em>满意度</em>
        </li>
        <li>
        <span><?php echo $tuan['commentnum'];?></span><em>人点评</em>
        </li>
      </ul>
    </div>
    <div class="dp_box">
    <h3>客户点评</h3>
        <div id="pl_list">
       <?php $n=1; if(is_array($pinlunlist)) { foreach($pinlunlist as $row) { ?>
        <dl>
      <dt>
        <span class="name"><img class="fl" src="<?php echo $row['memberico'];?>" width="30" height="30" /><em class="fl"><?php echo $row['membername'];?></em></span>
          <span class="myd">满意度：<em><?php echo $row['membercore'];?></em></span>
        </dt>
        <dd>
        <?php echo $row['content'];?>
        </dd>
       </dl>
       <?php $n++;}unset($n); } ?>
        </div>
        <input class="load-more" type="button" value="点击载入更多"  data-page="1" />
        <input type="hidden" id="articleid" value="<?php echo $info['id'];?>" />
        <input type="hidden" id="typeid" value="<?php echo $typeid;?>" />
    </div>
</div>
  
  <?php echo  Stourweb_View::template('public/foot');  ?>
    <script type="text/javascript">
        $('.load-more').click(function(){
            var docRec = $(this);
            var page = parseInt(docRec.attr('data-page'))+1;
            var typeid = $('#typeid').val();
            var id = $('#articleid').val();
            var url=SITEURL+'page/pinlun/id/'+id+"/page/"+page+"/action/ajax/typeid/"+typeid;
            $.ajax({
                type:'POST',
                url:url,
                dataType:'json',
                success:function(data){
                    var str = '';
                    var listnum = 0;
                    $.each(data,function(index,a){
                        str+='<dl>';
                        str+='  <dt>';
                        str+='<span class="name"><img class="fl" src="'+ a.memberico+'" width="30" height="30" /><em class="fl">'+ a.membername+'</em></span>';
                        str+='<span class="myd">满意度：<em>'+ a.membercore+'</em></span>';
                        str+='</dt>';
                        str+='    <dd>';
                        str+=a.content;
                        str+='</dd>';
                        str+='</dl>';
                        listnum++;
                    })
                    docRec.attr('data-page',page);
                    if(listnum==0){
                        docRec.attr('value','已无更多评论信息');
                    }
                    $('#pl_list').append(str);
                }
            })
        });
    </script>
</body>
</html>
