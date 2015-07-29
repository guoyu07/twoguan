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
             首页
             &gt; 产品管理
             &gt; 线路管理
             &gt; 套餐管理
             &gt;<span>{$position}</span>


        </div>
      <div class="content-nr">
          <form method="post" name="product_frm" id="product_frm">
          <div class="manage-nr">
              <div class="w-set-tit bom-arrow" id="nav">
                  <span class="on"><s></s>线路套餐</span>

              </div>

               <!--基础信息开始-->
              <div class="product-add-div">
              <div class="add-class">
                  <dl>
                      <dt>当前线路：</dt>
                      <dd>
                          {$lineinfo['linename']}
                          <input type="hidden" name="lineid" id="lineid" value="{$lineinfo['id']}"/>
                          <input type="hidden" name="suitid" id="suitid" value="{$info['id']}">
                      </dd>
                  </dl>
                  <dl>
                      <dt>套餐名称：</dt>
                      <dd>
                          <input type="text" name="suitname" id="suitname"  class="set-text-xh text_700 mt-2" value="{$info['suitname']}" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>套餐说明：</dt>
                      <dd style="height: 200px;line-height: 20px">

                          {php Common::getEditor('description',$info['description'],700,120,'Line');}
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
                          <input type="text" name="jifentprice" id="jifentprice" value="{$info['jifentprice']}" class="set-text-xh text_100 mt-2 " />
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
                      <dt>适用人群：</dt>
                      <dd class="prop-group">
                          <input type="checkbox" name="propgroup[]" value="2" id="adultgroup" checked="checked">成人
                          &nbsp;
                          <input type="checkbox" name="propgroup[]" value="1" id="childgroup">儿童
                          &nbsp;
                          <input type="checkbox" name="propgroup[]" value="3" id="oldgroup">老人
                          &nbsp;

                      </dd>
                  </dl>
                  <dl>
                      <dt>套餐价格：</dt>
                      <dd>
                        <table class="group-tb">
                         <tr class="group_2">
                          <td width="80">成人价格:</td>
                          <td>
                          <span class="fl">成本</span>
                          <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="adultbasicprice" onkeyup="calPrice(this)" value="" />
                          <span class="fl ml-10">+利润</span>
                          <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="adultprofit" onkeyup="calPrice(this)" value="" />
                          <span class="fl ml-10">售价：<b style=" color:#f60" class="tprice"></b></span>
                          </td>
                         </tr>
                         <tr class="group_1" style="display:none">
                            <td width="80">儿童价格:</td>
                            <td>
                                <span class="fl">成本</span>
                                <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="childbasicprice" onkeyup="calPrice(this)" value="{$info['childbasicprice']}" />
                                <span class="fl ml-10">+利润</span>
                                <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="childprofit" onkeyup="calPrice(this)" value="{$info['childprofit']}" />
                                <span class="fl ml-10">售价：<b style=" color:#f60" class="tprice"></b></span>
                            </td>
                           </tr>
                         <tr class="group_3" style="display:none">
                            <td width="80">老人价格:</td>
                            <td>
                                <span class="fl">成本</span>
                                <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="oldbasicprice" onkeyup="calPrice(this)" value="{$info['oldbasicprice']}" />
                                <span class="fl ml-10">+利润</span>
                                <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="oldprofit" onkeyup="calPrice(this)" value="{$info['oldprofit']}" />
                                <span class="fl ml-10">售价：<b style=" color:#f60" class="tprice"></b></span>
                            </td>
                           </tr>
                        </table>
                      </dd>
                  </dl>
                  <dl>
                      <dt>价格描述：</dt>
                      <dd>
                          <input type="text" class="set-text-xh text_700 mt-2" style="width: 300px"  name="description" />
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
                      <input type="hidden" name="suitid" id="suitid" value="{$info['id']}"/>
                      <input type="hidden" name="action" id="action" value="{$action}"/>
                      <input type="hidden" name="lineid" id="lineid" value="{$lineinfo['id']}">
                      <a class="save" id="btn_save" href="javascript:;">保存</a>
                      <a class="save" id="btn_view_more" style="{if $action=='add'}display:none{/if}"   href="javascript:;" onclick="showMore()">查看报价</a>

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
        var group = "{$info['propgroup']}";
        var groupArr = group.split(',');

        if($.inArray('1',groupArr)!=-1){
            $('.group_1').show();
            $('#childgroup').attr('checked','checked');
        }
        if($.inArray('3',groupArr)!=-1){
            $('.group_3').show();
            $('#oldgroup').attr('checked','checked');
        }



        //保存
        $("#btn_save").click(function(){
                var suitname = $("#suitname").val();
                if(suitname==''){
                    ST.Util.showMsg('请输入套餐名称',5,1000);
                    return false;
                }
                Ext.Ajax.request({
                       url   :  SITEURL+"line/ajax_suitsave",
                       method  :  "POST",
                       isUpload :  true,
                       form  : "product_frm",
                       success  :  function(response, opts)
                       {
                           //console.log(response);
                           var data = response.responseText;
                           if(data!='no')
                           {
                               $("#suitid").val(data);
                               ST.Util.showMsg('保存成功!','4',2000);
                               $("#btn_view_more").show();

                           }
                       }});
        })

        //如果是修改页面


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


        $(".prop-group input:checkbox").click(
            function(e)
            {
				$(".group-tb tr").hide();
                $(".prop-group input:checked").each(function(index, element) {
                      var gp=$(element).val();
					  $(".group_"+gp).show();
                });
            }
        );


     });

    //查看日历报价
    function showMore()
    {
        var suitid = $("#suitid").val();
        var productid = $("#lineid").val();

        var width = $(window).width()-100;
        var height = $(window).height()-100
       // var url = "calendar.php?suitid="+suitid+"&carid="+carid;
        var url = SITEURL+'calendar/index/suitid/'+suitid+'/typeid/1/productid/'+productid;
        ST.Util.showBox('查看报价',url,width,height);
       // parent.window.showJbox('查看报价',url,width,height);

    }
    //计算价格
    function calPrice(obj)
    {
        var dd=$(obj).parents('td:first');

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
