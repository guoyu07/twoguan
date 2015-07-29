<dl>
         	<dt>{sline:field.groupname/}：</dt>
            <dd>
            	<span class="sp_1"><a class="{sline:field.attrid function=getTuanAttrUrlCls('on',null,@me)/}" href="{sline:field.attrid function=getTuanUrl(null,null,@me)/}">全部</a></span>
              <span class="sp_2">                              
                {sline:getattrbygroup typeid="13"}
                 <a href="[field:attrid function=getTuanUrl(@me,'attrid')/]" class="[field:attrid function=getTuanAttrUrlCls('on',@me)/]" >[field:title/]</a>
               {/sline:getattrbygroup}
              </span>
               
            </dd>
          </dl>