<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>系统升级-思途CMS3.0</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,upgrade.css'); }

</head>

<body>
<!--顶部-->
<table class="content-tab">
<tr>
    <td width="119px" class="content-lt-td" valign="top">
        {template 'stourtravel/public/leftnav'}
        <!--右侧内容区-->
    </td>
    <td valign="top" class="content-rt-td" style="overflow:auto;">
        <div class="crumbs">
            <label>位置：</label>
            首页
            &gt; 增值应用
            &gt; <span>系统升级</span>
        </div>
        <div class="content-nr">
            <div class="manage-nr">

                <div class="version_sj">

                    <div class="now_version">
                        <p>当前版本：<span id="currentversion">{$version}</span></p>
                        <a class="nowgx_btn" href="javascript:;">立即更新</a>
                    </div>

                    <div class="version_list" style="overflow-y: hidden;" >
                        <table width="100%" border="0" id="versionlist" style="position:relative" >
                            <tr>
                                <th height="30" scope="col">状态</th>
                                <th scope="col">升级包版本</th>
                                <th scope="col">发布时间</th>
                                <th scope="col">大小</th>
                                <th scope="col">升级说明</th>
                                <th scope="col">升级状态</th>
                            </tr>

                        </table>
                    </div>

                </div>
        </div>
    </td>
</tr>


<!--左侧导航区-->

<!--右侧内容区-->

<script language="JavaScript">
    var public_url = "{$GLOBALS['cfg_public_url']}";
    var clicknum = 0;
    $(function(){
        getVersionList();
        //点击更新
        $(".nowgx_btn").click(function(){

            var noupgradenum = $("#versionlist").find("tr[class='noupgrade']").length;
            if(noupgradenum==0){
                ST.Util.showMsg('当前版本已经是最新版本',4,1000);
            }else{
                $(this).removeClass('nowgx_btn').addClass('nowgx_btn_click');
                if(clicknum==0){
                    clicknum++;
                    $.ajax({
                        type:'POST',
                        url:SITEURL+'upgrade/ajax_backup_database',
                        dataType:'json',
                        beforeSend:function(){
                            ST.Util.showMsg('正在备份数据库...',6,1000000);
                        },
                        success:function(data){
                            ST.Util.hideMsgBox();
                            if(data.status){ //备份数据库成功
                                upgrade();

                            }else{
                                ST.Util.showMsg('备份数据库失败,请检查',5,2000);
                            }

                        }

                    })

                }
            }




        })
    })

    //升级
    function upgrade()
    {
        $.ajax({
            type:'POST',
            url:SITEURL+'upgrade/ajax_upgrade',
            dataType:'json',
            beforeSend:function(){
                var lastv = $("#versionlist").find("tr[class='noupgrade']").last();
                var scrolltop =lastv.offset().top-30;
                lastv.find('.jdimg').attr('src',public_url+'images/jingdu.gif');
                scrollToBottom(scrolltop);
            },
            success:function(data){
                if(data.status==1){
                    var lastv = $("#versionlist").find("tr[class='noupgrade']").last();
                    $("#currentversion").html(data.currentversion);
                    lastv.find('.gxstatus').html('已更新');
                    lastv.find('.progress').html('已完成');
                    lastv.find('.noupgrade').removeClass('noupgrade').addClass('hasupgrade');

                    lastv.addClass('hasupgrade').removeClass('noupgrade');
                    if($("#versionlist").find("tr[class='noupgrade']").length>=1){//如果还有更新包则继续更新
                        upgrade();
                    }else{
                        clearCache();

                    }



                }else{
                    var lastv = $("#versionlist").find('tr').find('.noupgrade').last();
                    lastv.find('.errmsg').html(data.msg);
                    lastv.find('.errmsg').show();
                    //如果是序列号验证失败,则弹出填写序列号窗口
                    if(data.type=='license_err'){
                        showBindBox();
                    }
                }
            }
        })
    }


  //检测更新包
    function getVersionList()
    {

        $.ajax({
            type:'POST',
            url:SITEURL+'upgrade/ajax_version',
            dataType:'json',
            beforeSend:function(){
                ST.Util.showMsg('正在获取更新列表...',6,1000000);
            },
            success:function(data){
                ST.Util.hideMsgBox();
                var tr='';
                $.each(data,function(i,row){


                    var status = row.status=='已更新' ? '已完成' : '<img class="jdimg" src="'+public_url+'images/nojingdu.png" /><span class="tck_con errmsg" style="display:none"></span>';
                    var mclass = row.status=='已更新' ? 'hasupgrade' : 'noupgrade';
                    tr+='<tr class="'+mclass+'">';
                    tr+='<td height="50" align="center"><span  class="gxstatus '+mclass+'">'+row.status+'<span></td>';
                    tr+='<td align="center">'+row.version+'</td>';
                    tr+='<td align="center">'+row.pubdate+'</td>';
                    tr+='<td align="center">'+row.filesize+'</td>';
                    tr+='<td align="center"><img class="showdetail" data-version="'+row.version+'" data-pubdate="'+row.pubdate+'" src="'+public_url+'images/sjsm.png" title="查看版本更新内容"/><div class="ver_desc">'+row.desc+'</div></td>'
                    tr+='<td align="center" class="'+mclass+' progress">'+status+'</td>'
                    tr+='</tr>';
                })
                $('#versionlist').append(tr);
                addEvent();


            }
        })
    }

    function addEvent()
    {
        $('.showdetail').click(function(){
            var content = $(this).parent().find('.ver_desc').html();
            var version = $(this).attr('data-version');
            var pubdate = $(this).attr('data-pubdate');
            var html="<style>.version_num_con{color:#565656;float:left;}.version_num_con dl{ float:left;width:100%;border-bottom:1px solid #dcdcdc}.version_num_con dl dt{float:left;width:11%;height:40px;line-height:40px}.version_num_con dl dd{width:89%;float:left;line-height:40px;}.ver_desc{display: none}</style>";

                html+='<div class="version_num_con">';
                html+='<dl>';
                html+='<dt>版本号：</dt>';
                html+='<dd>'+version+'</dd>';
                html+='</dl>';
                html+='<dl>';
                html+='<dt>发布时间：</dt>';
                html+='<dd>'+pubdate+'</dd>';
                html+='</dl>';
                html+='<dl>';
                html+='<dt>升级内容：</dt>';
                html+='<dd>';
                html+=content;
                html+='</dd>';
                html+='</dl>';
                html+='</div>';

            ST.Util.messagBox('查看版本详细信息',html);
        })
    }

    function makeHtml()
    {
        $.ajax(
            {
                type: "post",
                url: SITEURL+'index/ajax_makehtml',
                beforeSend: function(){
                    ST.Util.showMsg('正在生成HTML,请稍后...',6,20000);
                },
                success: function(data)
                {
                    if(data=='ok')
                    {
                        ST.Util.showMsg('生成HTML成功',4,1000);
                        ST.Util.showMsg('站点已升级至最新版!',4,1000);
                    }
                }

            }
        );
    }
    function clearCache()
    {
        $.ajax(
            {
                type: "post",
                url: SITEURL+'index/ajax_clearcache',
                beforeSend: function(){
                    ST.Util.showMsg('正在清除缓存,请稍后...',6,20000);
                },
                success: function(data)
                {
                    if(data=='ok')
                    {
                        ST.Util.showMsg('缓存清除成功',4,1000);
                        makeHtml();
                    }
                }

            }
        );
    }



    //显示绑定页面
   function showBindBox()
   {
       var url=SITEURL+"upgrade/bind";
       ST.Util.showBox('绑定授权ID',url,560,166,function(){
           clicknum=0;
           var lastv = $("#versionlist").find("tr[class='noupgrade']").last();
           lastv.find('.jdimg').attr('src',public_url+'images/jingdu.gif');
           $('.nowgx_btn_click').removeClass('nowgx_btn_click').addClass('nowgx_btn');

       });

   }



    //滚动到底部
    function scrollToBottom(num)
    {
        $("html,body").animate({scrollTop:num},1000);
    }


</script>
</body>
</html>
