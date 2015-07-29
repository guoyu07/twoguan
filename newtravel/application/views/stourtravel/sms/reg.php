<dd>
    <form id="regfrm">
    <ul>
        <li class="li_1">短信注册通知开关</li>
        <li class="li_2">
            <span class="fl mr-10">开关:</span>
            <label><input name="reg_open" type="radio" class="fl mt-8 mr-3" value="1" {if $reg_open==1}checked="checked"{/if} ><span class="fl mr-20">开启</span></label>
            <label><input name="reg_open" type="radio" class="fl mt-8 mr-3" value="0" {if $reg_open==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_3">
            <span class="fl">内容:</span>
            <textarea name="reg_content" id="reg_content"   cols="" rows="">{$reg}</textarea>
            <p>短信内容里可配置{#WEBNAME#}代表网站名称,<br />{#PHONE#}代表网站联系电话,{#LOGINNAME#}代表<br />登陆名称,{#PASSWORD}代表登陆密码.</p>
        </li>
    </ul>
    <ul>
        <li class="li_1">注册短信验证码</li>
        <li class="li_2">
            <span class="fl mr-10">开关:</span>
            <label><input name="reg_msgcode_open" type="radio" class="fl mt-8 mr-3" value="1" {if $reg_msgcode_open==1}checked="checked"{/if}  ><span class="fl mr-20">开启</span></label>
            <label><input name="reg_msgcode_open" type="radio" class="fl mt-8 mr-3" value="0" {if $reg_msgcode_open==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_3">
            <span class="fl">内容:</span>
            <textarea name="reg_msgcode_content" cols="" rows="">{$reg_msgcode}</textarea>
            <p>短信内容里可配置{#WEBNAME#}代表网站名称,<br />{#PHONE#}代表网站联系电话,<br />{#CODE#}代表短信验证码.</p>
        </li>
    </ul>
    <ul>
        <li class="li_1">找回密码验证码</li>
        <li class="li_2">
            <span class="fl mr-10">开关:</span>
            <label><input type="radio" name="reg_findpwd_open" class="fl mt-8 mr-3" value="1" {if $reg_findpwd_open==1}checked="checkd"{/if} ><span class="fl mr-20">开启</span></label>
            <label><input type="radio" name="reg_findpwd_open" class="fl mt-8 mr-3" value="0" {if $reg_findpwd_open==0}checked="checked"{/if} ><span class="fl">关闭</span></label>
        </li>
        <li class="li_3">
            <span class="fl">内容:</span>
            <textarea name="reg_findpwd_content" cols="" rows="">{$reg_findpwd}</textarea>
            <p>短信内容里可配置{#WEBNAME#}代表网站名称,<br />{#PHONE#}代表网站联系电话,<br />{#CODE#}代表短信验证码.</p>
        </li>
    </ul>

        <div class="opn-btn">
            <a class="save" href="javascript:;" id="reg_btn_saveg">保存</a>
            <input type="hidden" name="msgtype" value="reg">

        </div>
        </form>
    <script language="javascript">
        $(function(){
            $("#reg_btn_saveg").click(function(){
                $.ajax({
                    url:SITEURL+'sms/savemsg',
                    data: $('#regfrm').serialize(),
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
