<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>属性配置</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>
  <style>
   .list_title{
       line-height: 30px;
       color:#006498;
       float: left;
   }
   .lh30{line-height: 30px;}
   .red{color: red}
   .mt5{margin-top: 5px}
   .w300{width: 300px;}
  </style>

	<div class="middle-con" style="background-color: #fff">
       <form name="frm" id="frm">
        <div class="w-set-con">

           <div class="nr-list">
               <span class="list_title">属性名称：</span>

               <span class="lh30 red">{$info['attrname']}</span>

            </div>
            <div class="nr-list">
                <span class="list_title">属性描述：</span>

                <span class="lh30" ><input type="text" name="description" class="set-text-xh w300" value="{$info['description']}"></span>

            </div>
            
            <div class="nr-list">
                <span class="list_title">属性图片：</span>

                  <div class="up-file-div lh30 mt5 fl">
                      <div id="file_upload" class="btn-file mt-4">上传图片</div>
                      {if !empty($info['litpic'])}
                       <div id="img"><img id="litimg" src="{$info['litpic']}" width="100" height="80"   /></div>
                      {else}
                      <div id="img"><img id="litimg" src="{php echo Common::getDefaultImage();}" width="100" height="80" /></div>
                      {/if}
                  </div>

            </div>
            
            <div class="opn-btn">
            	<a class="save" href="javascript:;">保存</a>

            </div>

            <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}">
            <input type="hidden" name="attrid" id="attrid" value="{$info['id']}"/>
            <input type="hidden" name="typeid" value="{$typeid}"/>
       </div>
           </form>
    </div>

  
  
	<script>
        $(function(){

            //上传图片
            setTimeout(function(){
                $('#file_upload').uploadify({
                    'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
                    'uploader': SITEURL + 'uploader/uploadfile',
                    'buttonImage' : PUBLICURL+'images/upload-ico.png',  //指定背景图
                    'formData':{webid:0,thumb:true,uploadcookie:"<?php echo Cookie::get('username')?>" },
                    'fileTypeDesc' : 'Image Files',
                    'fileTypeExts' : '*.gif; *.jpg; *.png',
                    'auto': true,   //是否自动上传
                    'height': 25,
                    'width': 80,
                    'removeTimeout':0.2,
                    'removeCompleted' : true,
                    'wmode ':'transparent',
                    'multi' : false,
                    'onUploadSuccess': function (file, data, response) {

                        var obj = $.parseJSON(data);
                        if(obj.bigpic!=''){
                            $('#litimg')[0].src=obj.bigpic;
                            $("#litpic").val(obj.bigpic);


                        }
                    }
                });
            },10)


            $(".save").click(function(){

                var ajaxurl = SITEURL + 'attrid/ajax_config_save';

                Ext.Ajax.request({
                    url: ajaxurl,
                    method: 'POST',
                    form : 'frm',
                    success: function (response, options) {

                        var data = $.parseJSON(response.responseText);
                        if(data.status)
                        {

                            ST.Util.showMsg('保存成功',4);
                            //ST.Util.closeBox();//关闭当前窗口
                            //parent.window.getNav();

                        }
                        else
                        {
                            ST.Util.showMsg('保存失败',5);
                        }

                    }

                });


            })
        })

	</script>
</body>
</html>
