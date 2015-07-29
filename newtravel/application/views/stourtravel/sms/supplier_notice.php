<!--团购-->
<dd>
    <form id="supplier_configfrm">
    <ul>
        <li class="li_1">生成订单</li>
        <li class="li_2">
            <span class="fl mr-10">开关:</span>
            <label><input type="radio" name="cfg_supplier_msg_open" class="fl mt-8 mr-3" value="1" {if $config['cfg_supplier_msg_open']==1}checked="checked"{/if} ><span class="fl mr-20">开启</span></label>
            <label><input type="radio" name="cfg_supplier_msg_open" class="fl mt-8 mr-3" value="0" {if $config['cfg_supplier_msg_open']==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_2">
            <span class="fl mr-10">发送给供应商:</span>
            <label><input type="radio" name="cfg_supplier_send_open" class="fl mt-8 mr-3" value="1" {if $config['cfg_supplier_send_open']==1}checked="checked"{/if} ><span class="fl mr-20">开启</span></label>
            <label><input type="radio" name="cfg_supplier_send_open" class="fl mt-8 mr-3" value="0" {if $config['cfg_supplier_send_open']==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_2">
            <span class="fl mr-10">本站管理员手机:</span>
            <label><input type="text" name="cfg_webmaster_phone"  value="{$config['cfg_webmaster_phone']}"></label>
        </li>

        <li class="li_3">
            <span class="fl">内容:</span>
            <textarea name="cfg_supplier_msg" id="" cols="" rows="">{$config['cfg_supplier_msg']}</textarea>
            <p>短信内容里可配置{#LINKNAME#}代表预订人,<br />{#PHONE#}代表预订人联系电话,<br />{#PRODUCTNAME#}代表产品名称,<br />{#PRICE#}表示产品单价,{#Number}表示预订数量,<br />{#TOTALPRICE#}表示支付订单的总价</p>
        </li>
    </ul>

        <div class="opn-btn">
            <a class="save" href="javascript:;" id="supplier_btn_saveg">保存</a>


        </div>
    </form>
    <script language="javascript">
        $(function(){

            //配置信息保存
            $("#supplier_btn_saveg").click(function(){


                var url = SITEURL+"config/ajax_saveconfig";
                var frmdata = $("#supplier_configfrm").serialize();
                var frmdata = frmdata+"&webid=0";
                console.log()
                $.ajax({
                    type:'POST',
                    url:url,
                    dataType:'json',
                    data:frmdata,
                    success:function(data){

                        if(data.status==true)
                        {

                            ST.Util.showMsg('保存成功',4);
                        }




                    }
                })


            });
        })
    </script>
</dd>