<dl>
        	<dt>{sline:field.groupname/}：</dt>
          <dd>
          	<span class="sp_1"><a class="{sline:field.attrid function=getPhotoUrlCls('active','attrid',null,@me)/}" href="{sline:field.attrid function=getPhotoUrl(null,null,@me)/}">全部</a></span>
            <span class="sp_2"> 
           {sline:getattrbygroup typeid="6"}                
            	  <a href="[field:id function=getPhotoUrl(@me,'attrid')/]" class="[field:id function=getPhotoUrlCls('active','attrid',@me)/]">[field:title/]</a>
          {/sline:getattrbygroup}
            </span>
          </dd>
        </dl>