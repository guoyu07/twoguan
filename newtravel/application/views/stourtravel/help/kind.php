<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>思途CMS3.0</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,jqtransform.css'); }
    {php echo Common::getCss('ext-theme-neptune-all-debug.css','js/extjs/resources/ext-theme-neptune/'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,st_validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }

</head>
<body>

<table class="content-tab">
<tr>
    <td width="119px" class="content-lt-td" valign="top">
        {template 'stourtravel/public/leftnav'}
        <!--右侧内容区-->
    </td>
    <td valign="top" class="content-rt-td" style="overflow:auto;">


        <div class="content-nr" style="height: 351px;">
            <div class="crumbs">
                <label>位置：</label>
                首页
                &gt; 文章系统
                &gt; 帮助管理
                &gt; <span>帮助分类</span>
            </div>

            <div class="w-set-con">

                <div class="w-set-nr">

                    <div class="add_menu-btn">
                        <a href="javascript:;" class="add-btn-class ml-10" onclick="addRow()">添加</a>
                    </div>

                    <div class="nor-attr-list">
                     <form id="day_fm">
                       <table width="95%" border="0" cellspacing="0" cellpadding="0" id="day_tab">
                       <tr>
                                <th scope="col" align="center" width="12%">排序</th>
                                <th scope="col" align="center" width="30%">分类名称</th>

                                 <th scope="col" align="center" width="25%">是否启用</th>
                                 <th scope="col" align="center" width="25%">删除</th>
                                 <th></th>
                               </tr>
                           <?php
						     foreach($list as $k=>$v)
						      {
								   $is_checked=$v['isopen']==1?'checked="checked"':'';
								  ?>
                               <tr>
                                <td align="center"><input class="p2" name="displayorder[{$v['id']}]" value="{$v['displayorder']}"  size="6"></td>
                                <td align="center"><input class="p2" name="kindname[{$v['id']}]" value="{$v['kindname']}" size="20"> </td>
                                <td align="center"><input class="p2" type="checkbox" name="isopen[{$v['id']}]" {$is_checked} value="1" /></td>
                                <td align="center"><img src="{$GLOBALS['cfg_public_url']}images/del-ico.gif" onclick="delRow(this,{$v['id']})"></td>
                               </tr>
							  <?php
							    }
							  ?>
                       </table>
                     </form>
                    </div>

                    <div class="opn-btn">
                        <a class="save ml-10" href="javascript:;" onclick="rowSave()">保存</a>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
</table>

<script>
   $(".w-set-tit").find('#tb_lineday').addClass('on');


  function rowSave()
  {
      ST.Util.showMsg('保存中',6,10000);
      Ext.Ajax.request({
          url   :  SITEURL+"help/kind/action/save",
          method  :  "POST",
          isUpload :  true,
          form  : "day_fm",
          datatype  :  "JSON",
          success  :  function(response, opts)
          {
              var text = response.responseText;
              if(text=='ok')
              {
                  ZENG.msgbox._hide();
                  ST.Util.showMsg("保存成功",4,1000);
              }
              else
              {
                  ST.Util.showMsg("{__('norightmsg')}",5,1000);
              }


          }});

  }
  function addRow()
  {
	  
	   Ext.Ajax.request({
                  url   :  SITEURL+"help/kind/action/add",
                  method  :  "POST",
                  datatype  :  "JSON",
                  success  :  function(response, opts)
                  {
                      var id = response.responseText;

                      if(Number(id)>0)
                      {
                        var html='<tr><td align="center"><input class="p2" name="displayorder['+id+']" value="" size="6"></td>';
	  html+='<td align="center"><input class="p2" name="kindname['+id+']" value="" size="20"> </td>';
      html+='<td align="center"><input class="p2" type="checkbox" name="isopen['+id+']" checked="checked" value="1"></td>';
	  html+='<td align="center"><img src="{$GLOBALS['cfg_public_url']}images/del-ico.gif" onclick="delRow(this,'+id+')"></td></tr>';
                         $("#day_tab").append(html);
						
						  
                      }
                      else{
                          ST.Util.showMsg("{__('norightmsg')}",5,1000);
                      }
                     
                  }});
	/*			  
      var html='<tr><td align="center"><input name="newdisplayorder[]" value="" size="6"></td>';
	  html+='<td align="center"><input name="newkindname[]" value="" size="20"> </td>'; 
      html+='<td align="center"><input type="checkbox" name="newisopen[]" checked="checked" value="1"></td>';
	  html+='<td align="center"><img src="/admin/public/images/del-ico.gif" onclick="delRow(this,0)"></td></tr>';
      $("#day_tab").append(html);
	  */

  }
  function delRow(dom,id)
  {
      ST.Util.confirmBox('删除分类','确定删除吗?',function(){
          if(id==0)
              $(dom).parents('tr').first().remove();
          else
          {
              Ext.Ajax.request({
                  url   :  SITEURL+"help/kind/action/del",
                  method  :  "POST",
                  params:{id:id},
                  datatype  :  "JSON",
                  success  :  function(response, opts)
                  {
                      var text = response.responseText;
                      if(text='ok')
                      {
                          $(dom).parents('tr').first().remove();
                      }
                      else
                      {

                      }
                  }});

          }


      });

  }


</script>

</body>
</html>
