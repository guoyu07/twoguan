<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="admin/public/css/common.css"/>
    <meta charset="utf-8">
<title>文章添加/修改</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,imageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>
	<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td ">
    <div class="content-nr">
        <!--面包屑-->
        <div class="crumbs">
            <label>位置：</label>
             首页
             &gt; {$modulename}管理
             &gt; <span>{$position}</span>
        </div>
      <div class="content-nr">
          <form method="post" name="product_frm" id="product_frm">
          <div class="manage-nr">
              <div class="w-set-tit bom-arrow" id="nav">
                  <span class="on"><s></s>基础信息</span>
                  <span data-id="tupian"><s></s>图片设置</span>
                  <span data-id="youhua"><s></s>优化设置</span>
                  <span data-id="extend"><s></s>扩展设置</span>
              </div>

               <!--基础信息开始-->
                  <div class="product-add-div">
                      <div class="add-class">
                          <dl>
                              <dt>站点：</dt>
                              <dd>

                                  <select name="webid">
                                      <option value="0" {if $info['webid']==0}selected="selected"{/if}>主站</option>
                                      {loop $weblist $k}
                                       <option value="{$k['webid']}" {if $info['webid']==$k['webid']}selected="selected"{/if} >{$k['webname']}</option>
                                      {/loop}

                                  </select>

                              </dd>
                          </dl>
                          <dl>
                              <dt>标题：</dt>
                              <dd>
                                  <input type="text" name="title" id="title" class="set-text-xh text_700 mt-2 w300"  value="{$info['title']}" />
                                  <div class="help-ico mt-9 ml-5">{php echo Common::getIco('help',40); }</div>
                              </dd>
                          </dl>
                          <dl>
                              <dt>卖点：</dt>
                              <dd>
                                  <input type="text" name="sellpoint" id="sellpoint" class="set-text-xh text_700 mt-2 w300"  value="{$info['sellpoint']}" />
                                  <div class="help-ico mt-9 ml-5">{php echo Common::getIco('help',40); }</div>
                              </dd>
                          </dl>
                          <dl>
                              <dt>满意度：</dt>
                              <dd>
                                  <input type="text" name="satisfyscore" id="satisfyscore" class="set-text-xh  mt-2 w100"  value="{$info['satisfyscore']}" />
                                  <div class="help-ico mt-9 ml-5">{php echo Common::getIco('help',40); }</div>
                              </dd>
                          </dl>

                          <dl>
                              <dt>显示模版：</dt>
                              <dd>
                                  <div class="temp-chg" id="templet_list">
                                      <a {if $info['templet']==''}class="on"{/if}  href="javascript:void(0)"  data-value="" onclick="setTemplet(this)">标准</a>
                                      {loop $templetlist $r}
                                      <a {if $info['templet']==$r['path']}class="on"{/if}  href="javascript:void(0)" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                                      {/loop}
                                      <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                                  </div>
                              </dd>
                          </dl>

                      </div>



                      <div class="add-class">
                          <dl>
                              <dt>目的地选择：</dt>
                              <dd>

                                  <input type="button" onclick="Product.getDest(this,'.dest-sel',4)" class="btn-sum-xz mt-4" value="选择"/>
                                  <div class="save-value-div mt-2 ml-10 dest-sel">
                                      {loop $info['kindlist_arr'] $k $v}
                                      <span><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" name="kindlist[]" value="{$v['id']}"></span>
                                      {/loop}

                                  </div>
                              </dd>
                          </dl>
                          <dl>
                              <dt>{$modulename}属性：</dt>
                              <dd>
                                  <input type="button" class="btn-sum-xz mt-4" value="选择" onclick="Product.getAttrid(this,'.attr-sel','{$typeid}')" />
                                  <div class="save-value-div mt-2 ml-10 attr-sel">
                                      {loop $info['attrlist_arr'] $k $v}
                                      <span><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                                      {/loop}
                                  </div>
                              </dd>
                          </dl>
                          <dl>
                              <dt>供应商：</dt>
                              <dd>
                                  <input type="button" class="btn-sum-xz mt-4" onclick="Product.getSupplier(this,'.supplier-sel')" value="选择"/>

                                  <div class="save-value-div mt-2 ml-10 supplier-sel">
                                      {if !empty($info['supplier_arr']['suppliername'])}
                                      <span><s onclick="$(this).parent('span').remove()"></s>{$info['supplier_arr']['suppliername']}<input type="hidden" name="supplierlist[]" value="{$info['supplier_arr']['id']}"></span>
                                      {/if}

                                  </div>
                              </dd>
                          </dl>

                          <dl>
                              <dt>{$modulename}内容: </dt>
                              <dd>
                                  {php Common::getEditor('content',$info['content'],700,400);}
                              </dd>

                          </dl>
                          <dl>
                              <dt>价格：</dt>
                              <dd>
                                  <input type="text" name="price" id="price" class="set-text-xh text_250 mt-2" value="{$info['price']}" />
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
                      </div>

                  </div>
              <!--/基础信息结束-->
              <!--图片开始-->
              <div class="product-add-div" data-id="tupian">
                  <div class="up-pic">
                      <dl>
                          <dt>图片：</dt>
                          <dd>
                              <div class="up-file-div">
                                  <div id="pic_btn" class="btn-file mt-4">上传图片</div>
                              </div>
                              <div class="up-list-div">

                                  <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                  <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}"/>
                                  <ul class="pic-sel">

                                  </ul>
                              </div>
                          </dd>
                      </dl>


                  </div>
              </div>
              <!--图片结束-->


              <div class="product-add-div" data-id="youhua">
                      <div class="add-class">
                          <dl>
                              <dt>优化标题：</dt>
                              <dd>
                                  <input type="text" name="seotitle" id="seotitle" class="set-text-xh text_700 mt-2 w500" value="{$info['seotitle']}" >
                              </dd>
                          </dl>

                          <dl>
                              <dt>访问量：</dt>
                              <dd>
                                  <input type="text" name="shownum" id="shownum"  class="set-text-xh text_700 mt-2 w50" value="{$info['shownum']}">
                              </dd>
                          </dl>
                          <dl>
                              <dt>Tag词：</dt>
                              <dd>

                                  <input type="text" id="tagword" name="tagword" class="set-text-xh text_700 mt-2" value="{$info['tagword']}" >
                              </dd>
                          </dl>
                          <dl>
                              <dt>关键词：</dt>
                              <dd>
                                  <input type="text" name="keyword" id="keyword" name="keyword" class="set-text-xh text_700 mt-2 w300" value="{$info['keyword']}">
                              </dd>
                          </dl>
                          <dl>
                              <dt>页面描述：</dt>
                              <dd style="height:auto">
                                  <textarea class="set-area wid_695"  name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                              </dd>
                          </dl>

                      </div>
                  </div>
              <div class="product-add-div" data-id="extend">
                  {php Common::genExtendData($typeid,$extendinfo);}
              </div>

                  <div class="opn-btn">
                      <input type="hidden" name="productid" id="productid" value="{$info['id']}"/>
                      <input type="hidden" name="action" id="action" value="{$action}"/>
                      <input type="hidden" name="typeid" value="{$typeid}"/>
                      <a class="save ml-20" id="btn_save" href="javascript:;">保存</a>
                  </div>

          </div>
        </form>

    </div>
    </div>
    </div>
    </td>
    </tr>
    </table>

	<script>
        //设置模板
        function setTemplet(obj)
        {
            var templet = $(obj).attr('data-value');
            $(obj).addClass('on').siblings().removeClass('on');
            $("#templet").val(templet);

        }
	$(document).ready(function(){

        $("#nav").find('span').click(function(){

            Product.changeTab(this,'.product-add-div');//导航切换

        })
        $("#nav").find('span').first().trigger('click');


        var action = "{$action}";

        $("input[name='allow']:checked").trigger('click');


        //上传图片
        setTimeout(function(){
            $('#pic_btn').uploadify({
                'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
                'uploader': SITEURL + 'uploader/uploadfile',
                'buttonImage' : PUBLICURL+'images/upload-ico.png',  //指定背景图
                'formData':{webid:0,thumb:true,uploadcookie:"<?php echo Cookie::get('username')?>"},
                'fileTypeDesc' : 'Image Files',
                'fileTypeExts' : '*.gif; *.jpg; *.png',
                'auto': true,   //是否自动上传
                'height': 25,
                'width': 80,
                'removeTimeout':0.2,
                'removeCompleted' : true,
                'onUploadSuccess': function (file, data, response) {
                    var imageinfo=$.parseJSON(data);

                    Imageup.genePic(imageinfo.litpic,".up-list-div ul",".cover-div");
                }
            });
        },10)



        //保存
        $("#btn_save").click(function(){

               var title = $("#title").val();

            //验证名称
             if(title==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#title").focus();
                   ST.Util.showMsg('请填写标题',5,2000);
               }
               else
               {
                   Ext.Ajax.request({
                       url   :  SITEURL+"tongyong/ajax_save/typeid/{$typeid}",
                       method  :  "POST",
                       isUpload :  true,
                       form  : "product_frm",
                       datatype  :  "JSON",
                       success  :  function(response, opts)
                       {

                           var data = $.parseJSON(response.responseText);
                           if(data.status)
                           {
                               if(data.productid!=null){
                                   $("#productid").val(data.productid);
                               }
                               ST.Util.showMsg('保存成功!','4',2000);
                           }


                       }});
               }

        })


        //如果是修改页面
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




     });





    </script>

</body>
</html>
