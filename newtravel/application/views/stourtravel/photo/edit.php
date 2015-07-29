<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>思途CMS3.0</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,jqtransform.css'); }
    {php echo Common::getCss('ext-theme-neptune-all-debug.css','js/extjs/resources/ext-theme-neptune/'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,product_add.js,st_validate.js,jquery.colorpicker.js,jquery.jqtransform.js,imageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>
<script>
$(function(){
		//$('form').jqTransform({imgPath:'<?php echo $GLOBALS['cfg_public_url']; ?>images/img/'});
	});
	</script>
<body>
<!--顶部-->
{php Common::getEditor('jseditor','',700,300,'Sline','','print',true);}
<table class="content-tab">
<tr>
    <td width="119px" class="content-lt-td" valign="top">
        {template 'stourtravel/public/leftnav'}
        <!--右侧内容区-->
    </td>
    <td valign="top" class="content-rt-td" style="overflow:auto;">
        <div class="crumbs">
            <label>位置：</label>首页
            &gt; 文章系统
            &gt; 相册管理
            &gt;<span>{$position}</span>

        </div>
        <div class="content-nr">
            <div class="manage-nr">
                <div class="w-set-tit bom-arrow">
                    <span class="on" id="column_basic" onclick="Product.switchTab(this,'basic')"><s></s>基础信息</span>
                    <span id="column_image" onclick="Product.switchTab(this,'image')"><s></s>相册图片</span>
                    <span id="column_image" onclick="Product.switchTab(this,'seo')"><s></s>优化信息</span>
                    <span id="column_extend" onclick="Product.switchTab(this,'extend')"><s></s>扩展配置</span>
                </div>
                <form id="product_fm">
                <div class="product-add-div" id="content_basic">
                        <div class="add-class">
                            <dl>
                                <dt>相册名称：</dt>
                                <dd>
                                    <input type="text" name="photoname" data-required="true" value="{$info['photoname']}" class="set-text-xh text_700 mt-2">
                                    <input type="hidden" id="photoid" name="photoid" value="{$info['id']}">
                                </dd>
                            </dl>
                            <dl>
                                <dt>站点：</dt>
                                <dd>
                                    <select name="webid">
                                       {loop $weblist $web}
                                            <option value="{$web['webid']}" {if $web['webid']==$info['webid']}selected="selected"{/if}>{$web['webname']}</option>
                                       {/loop}
                                    </select>
                                </dd>
                            </dl>
                            <dl>
                                <dt>目的地选择：</dt>
                                <dd>
                                    <input type="button" onclick="Product.getDest(this,'.dest-sel',6)" class="btn-sum-xz mt-4" value="选择"/>
                                    <div class="save-value-div mt-2 ml-10 dest-sel">
                                        {loop $info['kindlist_arr'] $k $v}
                                        <span><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" name="kindlist[]" value="{$v['id']}"></span>
                                        {/loop}
                                    </div>
                                </dd>
                            </dl>
                            <dl>
                                <dt>相册分类：</dt>
                                <dd>
                                    <input type="button" class="btn-sum-xz mt-4" onclick="Product.getAttrid(this,'.attr-sel',6)" value="选择"/>
                                    <div class="save-value-div mt-2 ml-10 attr-sel">
                                        {loop $info['attrlist_arr'] $k $v}
                                        <span><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                                        {/loop}
                                    </div>

                                </dd>
                            </dl>
                            <dl>
                                <dt>相册编辑：</dt>
                                <dd>
                                    <input type="text" class="set-text-xh text_300 mt-2" name="author" value="{$info['author']}">
                                </dd>
                            </dl>
                            <dl>
                              <dt>前台隐藏：</dt>
                              <dd>
                                  <label>
                                    <input class="fl mt-8 mr-3" type="radio" name="ishidden"  {if $info['ishidden']==0}checked="checked"{/if} value="0">
                                    <span class="fl mr-20">显示</span>
                                  </label>
                                  <label>
                                    <input class="fl mt-8 mr-3" type="radio" name="ishidden"  {if $info['ishidden']==1}checked="checked"{/if} value="1">
                                    <span>隐藏</span>
                                  </label>
                              </dd>
                            </dl>
                            <dl>
                                <dt>相册介绍：</dt>
                                <dd style="line-height: 20px">
                                    {php Common::getEditor('imginfo',$info['imginfo'],800,200);}
                                </dd>
                            </dl>
                        </div>
                    </div>
                <div id="content_image" class="product-add-div content-hide">

                        <div class="up-pic">
                            <dl>
                                <dt>相册图片：</dt>
                                <dd>
                                    <div class="up-file-div">
                                        <div id="pic_btn" class="btn-file mt-4">上传图片</div>
                                    </div>
                                    <div class="up-list-div">
                                        <ul class="pic-sel">
                                        </ul>
                                        <input id="litpic" type="hidden" value="{$info['litpic']}"/>
                                        <input type="hidden" class="headimgindex" name="imgheadindex" value="">
                                    </div>
                                </dd>
                            </dl>

                        </div>
                    </div>
                <div id="content_seo" class="product-add-div content-hide" >
                        <div class="add-class">
                            <dl>
                                <dt>优化标题：</dt>
                                <dd>
                                    <input type="text" name="seotitle" id="seotitle" class="set-text-xh text_700 mt-2" value="{$info['seotitle']}">
                                </dd>
                            </dl>
                            <dl>
                                <dt>Tag词：</dt>
                                <dd>
                                    <input type="text" id="tagword" name="tagword" class="set-text-xh text_700 mt-2 " value="{$info['tagword']}">
                                </dd>
                            </dl>
                            <dl>
                                <dt>关键词：</dt>
                                <dd>
                                    <input type="text" name="keyword" id="keyword" class="set-text-xh text_700 mt-2" value="{$info['keyword']}">
                                </dd>
                            </dl>
                            <dl>
                                <dt>页面描述：</dt>
                                <dd style="height:auto">
                                    <textarea class="set-area wid_695" name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                                </dd>
                            </dl>
                        </div>
                    </div>
                <div id="content_extend" class="product-add-div content-hide" >
                    {php Common::genExtendData(6,$extendinfo);}
                </div>
                </form>
                <div class="opn-btn">
                    <a class="save ml-20" id="save_btn" href="javascript:;">保存</a>
                    <!--<a class="save" href="javascript:;" onclick="nextStep()">下一步</a>-->
                </div>
            </div>
        </div>
    </td>
</tr>


<!--左侧导航区-->

<!--右侧内容区-->

<script>
 $(document).ready(function(e) {


     $("#product_fm input").st_readyvalidate();


     $("#save_btn").click(function(e) {
         var validate=$("#product_fm input").st_govalidate({require:function(element,index){
             $(element).css("border","1px solid red");
             if(index==1)
             {
                 var switchDiv=$(element).parents(".product-add-div").first();
                 if(switchDiv.is(":hidden")&&!switchId)
                 {
                     var switchId=switchDiv.attr('id');
                     var columnId=switchId.replace('content','column');
                     $("#"+columnId).trigger('click');
                 }

             }
         }});
         if(validate==true)
         {
             ST.Util.showMsg('保存中',6,10000);
             Ext.Ajax.request({
                 url   :  SITEURL+"photo/ajax_photosave",
                 method  :  "POST",
                 isUpload :  true,
                 form  : "product_fm",
                 datatype  :  "JSON",
                 success  :  function(response, opts)
                 {
                     var text = response.responseText;
                     if(window.isNaN(text))
                     {
                         ZENG.msgbox._hide();
                         ST.Util.showMsg('保存失败',5);
                     }
                     else
                     {
                         $("#photoid").val(text);
                         ST.Util.showMsg('保存成功',4)
                     }
                 }});

         }
         else
         {
             ST.Util.showMsg("请将信息填写完整",1,1200);
         }
     });

     setTimeout(function(){
         $('#pic_btn').uploadify({
             'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
             'uploader': SITEURL + 'uploader/uploadfile',
             'buttonImage' : PUBLICURL+'images/upload-ico.png',  //指定背景图
             'formData':{webid:0,thumb:true,uploadcookie:"<?php echo Cookie::get('username')?>"},
             'auto': true,   //是否自动上传
             'height': 25,
             'width': 80,
             'removeTimeout':0.2,
             'removeCompleted' : true,
             'onUploadSuccess': function (file, data, response) {
                 var imageinfo=$.parseJSON(data);
                 Imageup.genePic(imageinfo.litpic,".up-list-div ul");
             }
         });
     },10)



 });



</script>
<script>
    {if $action=='edit'}
        var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});
        $(".pic-sel").html(piclist);
        var litpic = $("#litpic").val();
        $(".img-li").find('img').each(function(i,item){

            if($(item).attr('src')==litpic){
                var obj = $(item).parent().find('.btn-ste')[0];
                Imageup.setHead(obj,i+1);
            }
        })
        window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量
        {/if}
</script>

</body>
</html>
