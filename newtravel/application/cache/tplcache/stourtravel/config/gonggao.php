<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>公告设置</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css'); ?>
    <?php echo Common::getScript('config.js');?>
</head>
<body>
<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td">
    <div class="content-nr">
        <!--面包屑-->
        <div class="crumbs">
            <label>位置：</label>
             首页
            &gt; 设置中心
            &gt; 系统设置
            &gt; <span>公告设置</span>
        </div>
      <div class="content-nr">
      <div class="web-set">
        <dl>
          <dt>站点：</dt>
            <dd>
                 <a href="javascript:;" class="on" data-webid="0">主站</a>
                <?php $n=1; if(is_array($weblist)) { foreach($weblist as $k => $v) { ?>
              <a href="javascript:;" data-webid="<?php echo $v['webid'];?>"><?php echo $v['webname'];?></a>
                <?php $n++;}unset($n); } ?>
            </dd>
          </dl>
        </div>
        <form id="configfrm">
         <div class="w-set-con">
        <div class="w-set-tit bom-arrow"><span class="on"><s></s>公告</span></div>
          <div class="w-set-nr">
            <div class="nr-list">
            <h4 class="tit"><span class="fl">公告：</span><div class="help-ico"><?php echo Common::getIco('help',5); ?></div></h4>
              <div class="txt">
                  <?php Common::getEditor('cfg_gonggao',$configinfo['cfg_gonggao'],700,300);?>
              </div>
            </div>
            <div class="opn-btn">
            <a class="save ml-10" href="javascript:;" id="btn_save">保存</a>
             <!-- <a class="cancel" href="#">取消</a>-->
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  </td>
  </tr>
  </table>
    <input type="hidden" id="webid" value="0">
  
  
<script>
$(document).ready(function(){
          //子站切换点击
        $(".web-set").find('a').click(function(){
            var webid = $(this).attr('data-webid');
            $("#webid").val($(this).attr('data-webid'));
            $("#webname").html($(this).html());
            $(this).addClass('on').siblings().removeClass('on');
            getConfig(webid);//重新读取配置
        })
        //配置信息保存
        $("#btn_save").click(function(){
            var webid= $("#webid").val();
            Config.saveConfig(webid);
        })
        getConfig(0); //主站配置
        //默认读取配置
});
       //获取配置
        function getConfig(webid)
        {
            Config.getConfig(webid,function(data){
                cfg_gonggaoEditor.setContent(data.cfg_gonggao);
            })
        }
</script>
</body>
</html>
