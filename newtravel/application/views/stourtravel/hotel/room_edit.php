<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>酒店房型添加/修改</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,product_add.js,imageup.js,jquery.validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>
<style>

    .day_cs td{
        width:40px;
        padding:5px 3px;
        text-align:center;
        cursor:pointer;
    }
    .day_cs td.active{
        background:#096;
        color:white;
    }
</style>
	<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td">
    <div class="content-nr">
        <!--面包屑-->
        <div class="crumbs">
            <label>位置：</label>
             <a href="javascript:;">首页</a>
             &gt; <a href="javascript:;">产品管理</a>
             &gt; <a href="javascript:;">酒店管理</a>
             &gt; <a href="javascript:;">{$hotelname}</a>
             &gt;  <span>{$position}</span>
        </div>
      <div class="content-nr">
          <form method="post" name="product_frm" id="product_frm">
          <div class="manage-nr">
              <div class="w-set-tit bom-arrow" id="nav">
                  <span class="on"><s></s>{$position}</span>

              </div>

               <!--基础信息开始-->
              <div class="product-add-div">
              <div class="add-class">
                  <dl>
                      <dt>当前酒店：</dt>
                      <dd>
                          {$hotelname}
                      </dd>
                  </dl>
                  <dl>
                      <dt>房型名称：</dt>
                      <dd>
                          <input type="text" name="roomname" id="roomname" class="set-text-xh text_700 mt-2" value="{$info['roomname']}" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>门市价：</dt>
                      <dd>
                          <input type="text" name="sellprice" id="sellprice" class="set-text-xh text_100 mt-2" value="{$info['sellprice']}" />
                          <span class="fl ml-5">元</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>优惠价：</dt>
                      <dd>
                          <input type="text" name="price" id="price" class="set-text-xh text_100 mt-2" value="{$info['price']}" />
                          <span class="fl ml-5">元</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>房间面积：</dt>
                      <dd>
                          <input type="text" name="roomarea" id="roomarea" class="set-text-xh text_100 mt-2" value="{$info['roomarea']}" />
                          <span class="fl ml-5">㎡</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>房间楼层：</dt>
                      <dd>
                          <input type="text" name="roomfloor" id="roomfloor" class="set-text-xh text_100 mt-2" value="{$info['roomfloor']}" />
                          <span class="fl ml-5">层</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>房间数：</dt>
                      <dd>
                          <input type="text" name="roomnum" id="roomnum" class="set-text-xh text_100 mt-2" value="{$info['roomnum']}" />
                          <span class="fl ml-5">间</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>床型：</dt>
                      <dd>
                          <form class="fl">
                              <div class="on-off">
                                  {loop $roomtype $room}
                                   <input id="R_BedCategory_{$n}" type="radio" name="roomstyle" value="{$room}" {if $info['roomstyle']==$room}checked="checked"{/if}/>
                                   <label for="R_BedCategory_{$n}">{$room}</label>
                                  {/loop}

                                  <input  type="radio" name="roomstyle" id="user_room_v" value="{if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])}{$info['roomstyle']}{/if}"  {if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])} checked="checked"{/if}/>
                                  <label for="user_room_v"><input type="text" class="uservalue" data-value="user_room_v" style="width:70px;border-left:none;border-right:none;border-top:none"  value="{if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])}{$info['roomstyle']}{/if}"></label>



<script>
    $(function(){

            $('.uservalue').bind('input propertychange', function() {
                       var datacontain = $(this).attr('data-value');
                       $('#'+datacontain).val($(this).val());
            });

    })
</script>


                              </div>
                          </form>
                      </dd>
                  </dl>
                  <dl>
                      <dt>窗户：</dt>
                      <dd>

                              <div class="on-off">
                                  {loop $windowtype $window}
                                  <input id="roomwindow_{$n}" type="radio" name="roomwindow" value="有窗"  {if $info['roomwindow']==$window}checked="checked"{/if}/>
                                  <label for="roomwindow_{$n}">{$window}</label>
                                  {/loop}
                                  <input  type="radio" name="roomwindow" id="user_window_v" value="{if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])}{$info['roomwindow']}{/if}"  {if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])} checked="checked"{/if}/>
                                  <label for="user_roomwindow_v"><input type="text" class="uservalue" data-value="user_window_v" style="width:70px;border-left:none;border-right:none;border-top:none"  value="{if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])} {$info['roomwindow']}{/if}"></label>




                                 </div>

                      </dd>
                  </dl>
                  <dl>
                      <dt>餐标：</dt>
                      <dd>

                              <div class="on-off">
                                  {loop $repasttype $repast}
                                  <input type="radio" name="breakfirst" id="b{$n}"  value="{$repast}" {if $info['breakfirst']==$repast}checked="checked"{/if}/>
                                  <label for="b{$n}">{$repast}</label>
                                  {/loop}
                                  <input  type="radio" name="breakfirst" id="user_repast_v" value="{if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])}{$info['breakfirst']}{/if}"  {if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])} checked="checked"{/if}/>
                                  <label for="user_repast_v"><input type="text" class="uservalue" data-value="user_repast_v" style="width:70px;border-left:none;border-right:none;border-top:none"  value="{if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])} {$info['breakfirst']}{/if}"></label>




                              </div>

                      </dd>
                  </dl>
                  <dl>
                      <dt>宽带：</dt>
                      <dd>

                              <div class="on-off">
                                  {loop $computertype $computer}
                                   <input name="computer" type="radio" value="{$computer}" id="c{$n}" {if $info['computer']==$computer}checked="checked"{/if}/>
                                   <label for="c{$n}">{$computer}</label>
                                  {/loop}
                                  <input  type="radio" name="computer" id="user_computer_v" value="{if !in_array($info['computer'],$computertype) && !empty($info['computer'])}{$info['computer']}{/if}"  {if !in_array($info['computer'],$computertype) && !empty($info['computer'])} checked="checked"{/if}/>
                                  <label for="user_computer_v"><input type="text" class="uservalue" data-value="user_computer_v" style="width:70px;border-left:none;border-right:none;border-top:none"  value="{if !in_array($info['computer'],$computertype) && !empty($info['computer'])} {$info['computer']}{/if}"></label>


                              </div>

                      </dd>
                  </dl>
                  <dl>
                      <dt>房型图片：</dt>
                      <dd style="height: auto">
                          <div class="">
                              <div class="" style="height:auto">
                                  <div id="pic_btn" class="btn-file mt-4">上传图片</div>
                              </div>
                              <div class="up-list-div" >

                                  <ul class="pic-sel">

                                  </ul>
                              </div>
                          </div>
                      </dd>
                  </dl>
              </div>

              <div class="add-class">
                  <dl>
                      <dt>预订送积分：</dt>
                      <dd>
                          <input type="text" name="jifenbook" id="jifenbook" class="set-text-xh text_100 mt-2" value="{$info['jifenbook']}" />
                          <span class="fl ml-5">分</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>积分抵现金：</dt>
                      <dd>
                          <input type="text" name="jifentprice" id="jifentprice" value="{$info['jifentprice']}" class="set-text-xh text_100 mt-2" />
                          <span class="fl ml-5">元</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>评论送积分：</dt>
                      <dd>
                          <input type="text" name="jifencomment" id="jifencomment" class="set-text-xh text_100 mt-2" value="{$info['jifencomment']}" />
                          <span class="fl ml-5">分</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>支付方式：</dt>
                      <dd>

                              <div class="on-off">
                                  <input type="radio" name="paytype" value="1" {if $info['paytype']=='1'}checked="checked"{/if} />全款支付 &nbsp;
                                  <input type="radio" name="paytype" value="2" {if $info['paytype']=='2'}checked="checked"{/if} />定金支付 &nbsp;
                                  <span id="dingjin" style="{if $info['paytype'] == '2'}display:inline-block{else}display: none{/if}"><input type="text"  name="dingjin" id="dingjintxt" value="{$info['dingjin']}" size="8" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;元</span>
                                  <input type="radio" name="paytype" value="3"  {if $info['paytype']=='3'}checked="checked"{/if} />二次确认支付 &nbsp;


                                  <script>
                                      $("input[name='paytype']").click(function(){
                                          if($(this).val() == 2)
                                          {
                                              $("#dingjin").show();
                                          }
                                          else
                                          {

                                              $("#dingjin").hide()
                                          }
                                      })

                                  </script>

                              </div>

                      </dd>
                  </dl>

              </div>

              <div class="add-class">
                  <dl>
                      <dt>日期范围：</dt>
                      <dd>
                          <input type="text" class="set-text-xh text_100 mt-2 choosetime" name="starttime" />
                          <span class="fl ml-5">~</span>
                          <input type="text" class="set-text-xh text_100 mt-2 ml-5 choosetime" name="endtime" />
                      </dd>
                  </dl>

                  <dl>
                      <dt>房型价格：</dt>
                      <dd>
                          <span class="fl">成本</span>
                          <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="basicprice" onkeyup="calPrice(this)" value="{$info['basicprice']}" />
                          <span class="fl ml-10">+利润</span>
                          <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="profit" onkeyup="calPrice(this)" value="{$info['profit']}" />
                          <span class="fl ml-10">售价：<b style=" color:#f60" class="tprice"></b></span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>价格描述：</dt>
                      <dd>
                          <input type="text" class="set-text-xh text_700 mt-2" name="description" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>库存：</dt>
                      <dd>
                          <input type="text" class="set-text-xh text_100 mt-2" name="number" value="-1" /> <span style="color:gray;padding-left:10px">-1表示不限</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>报价规则：</dt>
                      <dd>
                          <input type="radio" name="pricerule" class="pricerule" checked="checked" value="all"/>全部&nbsp;&nbsp;
                          <input type="radio" name="pricerule" class="pricerule" value="week"/>按星期&nbsp;&nbsp;
                          <input type="radio" name="pricerule" class="pricerule" value="month"/>按号数


                      </dd>
                  </dl>
                  <dl>
                      <dt></dt>
                      <dd style="height: auto;">
                          <table class="day_cs" id="week_cs">
                              <tr height="30px"><td val='1'>周一</td><td val='2'>周二</td><td val='3'>周三</td><td val='4'>周四</td><td val='5'>周五</td><td val='6'>周六</td><td val='7'>周日</td></tr>
                          </table>

                          <table class="day_cs" id="month_cs">
                              <tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td></tr>
                              <tr><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td></tr>
                              <tr><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td></tr>
                              <tr><td>31</td><td colspan="9"></td></tr>
                          </table>
                      </dd>
                  </dl>


              </div>

              </div>
              <!--/基础信息结束-->



                  <div class="opn-btn" style="padding-left: 10px; " id="hidevalue">
                      <input type="hidden" name="roomid" id="roomid" value="{$info['id']}"/>
                      <input type="hidden" name="action" id="action" value="{$action}"/>
                      <input type="hidden" name="hotelid" id="hotelid" value="{$hotelid}">
                      <a class="save" id="btn_save" href="javascript:;">保存</a>
                      <a class="save showbtn" id="btn_view_more" style="{if $action=='add'}display:none{/if}"  href="javascript:;" onclick="showMore()">查看报价</a>

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

	$(document).ready(function(){



        var action = "{$action}";
        setTimeout(function(){
            //上传图片
            $('#pic_btn').uploadify({
                'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
                'uploader': SITEURL + 'uploader/uploadfile',
                'buttonImage' : PUBLICURL+'images/upload-ico.png',  //指定背景图
                'formData':{webid:0,thumb:true,uploadcookie:"<?php echo Cookie::get('username')?>"},
                'fileTypeDesc' : 'Image Files',
                'fileTypeExts' : '*.gif; *.jpg; *.png',
                'auto': true,   //是否自动上传
                'height': 25,
                'width': 120,
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
                var roomname = $("#roomname").val();
                if(roomname==''){
                    ST.Util.showMsg('请输入房间名称',5,1000);
                    return false;
                }

                   Ext.Ajax.request({
                       url   :  SITEURL+"hotel/ajax_room_save",
                       method  :  "POST",
                       isUpload :  true,
                       form  : "product_frm",
                       success  :  function(response, opts)
                       {
                           //console.log(response);
                           var data = $.parseJSON(response.responseText);
                           if(data.status)
                           {
                               if(data.roomid!=null){
                                   $("#roomid").val(data.roomid);

                               }
                               ST.Util.showMsg('保存成功!','4',2000);
                               $("#btn_view_more").show();
                           }


                       }});


        })


        //如果是修改页面
        if(action=='edit')
        {

            {if $action=='edit'}
                var piclist = ST.Modify.getUploadFile({$info['piclist_arr']},0);


                $(".pic-sel").html(piclist);

                window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量


            {/if}


        }



        //日历选择
        $(".choosetime").click(function(){
            WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'})
        })

        //隐藏报价方式
        $("#week_cs").hide();
        $(".day_cs").hide();

        $("#week_cs td").click(function(e) {
            var v=$(this).attr('val');
            if($(this).hasClass('active'))
            {
                $("#weekval_"+v).remove();
            }
            else
            {
                $("#hidevalue").append("<input type='hidden' id='weekval_"+v+"' name='weekval[]' value='"+v+"'/>");
            }
            $(this).toggleClass('active');



        });

        $("#month_cs td").click(function(e) {

            var v=$(this).text();
            v=$.trim(v);
            v=window.parseInt(v);

            if($(this).hasClass('active'))
            {
                $("#monthval_"+v).remove();
            }
            else
            {
                $("#hidevalue").append("<input type='hidden' id='monthval_"+v+"' name='monthval[]' value='"+v+"'/>");
            }
            $(this).toggleClass('active');
        });


        $(".pricerule").click(function(e) {
            if($(this).val()=='week')
            {
                $(".day_cs").hide();
                $("#week_cs").show();
            }
            else if($(this).val()=='month')
            {
                $(".day_cs").hide();
                $("#month_cs").show();
            }
            else
            {
                $("#week_cs").hide();
                $(".day_cs").hide();
            }


        });


     });

    //查看日历报价
    function showMore()
    {
        var suitid = $("#roomid").val();
        var productid = $("#hotelid").val();

        var width = $(window).width()-100;
        var height = $(window).height()-100
       // var url = "calendar.php?suitid="+suitid+"&carid="+carid;
        var url = SITEURL+'calendar/index/suitid/'+suitid+'/typeid/2/productid/'+productid;
        ST.Util.showBox('查看报价',url,width,height);
       // parent.window.showJbox('查看报价',url,width,height);

    }
    //计算价格
    function calPrice(obj)
    {
        var dd=$(obj).parents('dd:first');


        var tprice=0;
        dd.find('input:text').each(function(index, element) {
            var price=parseInt($(element).val());
            if(!isNaN(price))
                tprice+=price;
        });
        dd.find(".tprice").html("¥"+tprice);
    }



    </script>


</body>
</html>
