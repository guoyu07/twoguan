
<!--酒店开关-->
<dd>
    <form id="hotelfrm">
    <ul>
        <li class="li_1">订单未处理</li>
        <li class="li_2">
            <span class="fl mr-10">开关:</span>
            <label><input type="radio" name="isopen1" class="fl mt-8 mr-3" value="1" {if $hotel_order_msg1_open==1}checked="checked"{/if} ><span class="fl mr-20">开启</span></label>
            <label><input type="radio" name="isopen1" class="fl mt-8 mr-3" value="0" {if $hotel_order_msg1_open==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_3">
            <span class="fl">内容:</span>
            <textarea name="msg1" cols="" rows="">{$hotel_order_msg1}</textarea>
            <p>短信内容里可配置{#WEBNAME#}代表网站名称,<br />{#PHONE#}代表网站联系电话,<br />{#PRODUCTNAME#}代表产品名称,<br />{#PRICE#}表示产品单价,{#Number}表示预订数量,<br />{#TOTALPRICE#}表示支付订单的总价</p>
        </li>
    </ul>
    <ul>
        <li class="li_1">订单处理中</li>
        <li class="li_2">
            <span class="fl mr-10">开关:</span>
            <label><input type="radio" name="isopen2" class="fl mt-8 mr-3" value="1" {if $hotel_order_msg2_open==1}checked="checked"{/if} ><span class="fl mr-20">开启</span></label>
            <label><input type="radio" name="isopen2" class="fl mt-8 mr-3" value="0" {if $hotel_order_msg2_open==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_3">
            <span class="fl">内容:</span>
            <textarea name="msg2" cols="" rows="">{$hotel_order_msg2}</textarea>
            <p>短信内容里可配置{#WEBNAME#}代表网站名称,<br />{#PHONE#}代表网站联系电话,<br />{#PRODUCTNAME#}代表产品名称,<br />{#PRICE#}表示产品单价,{#Number}表示预订数量,<br />{#TOTALPRICE#}表示支付订单的总价</p>
        </li>
    </ul>
    <ul>
        <li class="li_1">订单处理成功</li>
        <li class="li_2">
            <span class="fl mr-10">开关:</span>
            <label><input type="radio" name="isopen3" class="fl mt-8 mr-3" value="1" {if $hotel_order_msg3_open==1}checked="checked"{/if} ><span class="fl mr-20">开启</span></label>
            <label><input type="radio" name="isopen3" class="fl mt-8 mr-3" value="0" {if $hotel_order_msg3_open==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_3">
            <span class="fl">内容:</span>
            <textarea name="msg3" cols="" rows="">{$hotel_order_msg3}</textarea>
            <p>短信内容里可配置{#WEBNAME#}代表网站名称,<br />{#PHONE#}代表网站联系电话,<br />{#PRODUCTNAME#}代表产品名称,<br />{#PRICE#}表示产品单价,{#Number}表示预订数量,<br />{#TOTALPRICE#}表示支付订单的总价</p>
        </li>
    </ul>
    <ul>
        <li class="li_1">订单取消</li>
        <li class="li_2">
            <span class="fl mr-10">开关:</span>
            <label><input type="radio" name="isopen4" class="fl mt-8 mr-3" value="1" {if $hotel_order_msg4_open==1}checked="checked"{/if} ><span class="fl mr-20">开启</span></label>
            <label><input type="radio" name="isopen4" class="fl mt-8 mr-3" value="0" {if $hotel_order_msg4_open==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_3">
            <span class="fl">内容:</span>
            <textarea name="msg4" cols="" rows="">{$hotel_order_msg4}</textarea>
            <p>短信内容里可配置{#WEBNAME#}代表网站名称,<br />{#PHONE#}代表网站联系电话,<br />{#PRODUCTNAME#}代表产品名称,<br />{#PRICE#}表示产品单价,{#Number}表示预订数量,<br />{#TOTALPRICE#}表示支付订单的总价</p>
        </li>
    </ul>
        <div class="opn-btn">
            <a class="save" href="javascript:;" id="hotel_btn_saveg">保存</a>
            <input type="hidden" name="msgtype" value="hotel_order_msg">

        </div>
    </form>
    <script language="javascript">
        $(function(){
            $("#hotel_btn_saveg").click(function(){
                $.ajax({
                    url:SITEURL+'sms/savemsg',
                    data: $('#hotelfrm').serialize(),
                    type: "POST",
                    dataType:'json',
                    success:function(data){
                        if(data.status){
                            ST.Util.showMsg('保存成功',4);
                        }
                    }
                })
                return false;
            })
        })
    </script>

</dd>