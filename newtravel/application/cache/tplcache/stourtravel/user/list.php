<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>用户管理-思途CMS3.0</title>
 <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
 <?php echo Common::getCss('style.css,base.css,base2.css,plist.css'); ?>
  <?php echo Common::getScript("jquery.validate.js"); ?>
<style>
   .user-add-tb{
       width:340px;
       table-layout: fixed;
       line-height: 35px;
   }
   .user-add-tb td input{
       height: 24px;
   }
   .user-add-tb td textarea{
       height: 50px;
       width: 240px;
   }
   .error{
       color:red;
       padding-left:5px;
   }
</style>
</head>
<body style="overflow:hidden">
<table class="content-tab">
   <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
    <!--右侧内容区-->
    </td>
    <td valign="top" class="content-rt-td" style="overflow:hidden">
      
  <div class="crumbs" id="dest_crumbs">
            <label>位置：</label>
              首页
              &gt; 增值应用
              &gt; <span>用户管理</span>
       </div>
        <div class="add_menu-btn" style="border: none">
            <a href="javascript:;" id="addbtn" class="add-btn-class ml-10" style="margin-top: 50px;">添加</a>
            &nbsp;&nbsp;
            <a href="javascript:;" class="add-btn-class ml-10" style="margin-top: 50px;" id="right_manage">权限</a>
        </div>
   
 
 <div id="product_grid_panel" class="content-nrt">
    
  </div>
  </td>
  </tr>
 </table> 
 
<script>
  var roles=<?php echo $roles;?>;
  Ext.onReady(
    function() 
    {
 Ext.tip.QuickTipManager.init();
 /*顶部按钮，相关设置，站点等*/
     Ext.get('addbtn').on('click',function()
         {
             var addwin=Ext.getCmp('addfrm_win');
             if(addwin)
             {
               addwin.toFront();
               return;
             }
             Ext.create('Ext.window.Window',
                 {
                     title:'添加用户',
                     border:1,
                     y:140,
                     style: {
                         borderStyle: 'solid',
                         borderWidth:'1px'
                     },
                     bodyStyle:'padding:10px',
                     id:'addfrm_win',
                     ghost:false,
                     autoShow:true,
                     listeners:{
                         boxready:function(win)
                         {
                             var select="<select name='roleid'><option value='0'>请选择..</option>"
                             Ext.Array.each(roles,function(row,index){
                                 select+="<option value='"+row.roleid+"'>"+row.rolename+"</option>";
                             })
                             select+="</select>";
                             var html="<form class='frm' id='addfrm'><table class='user-add-tb'>";
                             html+="<tr><td width='70'>用户名:</td><td><input type='text' class='username' name='username' size='15'/></td></tr>";
                             html+="<tr><td>密码:</td><td><input type='text' class='password' name='password' size='15'/></td></tr>";
                             html+="<tr><td>权限:</td><td>"+select+"</td></tr>"
                             html+="<tr><td>备注:</td><td><textarea name='beizu'></textarea></td></tr>";
                             html+="</table></form>";
                             win.update(html);
                         }
                     },
                     buttons:
                     {
                         style:"background:#fff",   //设置背景色，这样就不会有透明 的了.
                         items:[
                             { xtype: 'button', text:'提交',handler:function(button)
                              {
                                   $(".frm").validate({
                                      focusInvalid:false,
                                      rules: {
                                          username:
                                          {
                                              required: true,
                                              remote:{
                                                  type:"POST",
                                                  url: SITEURL+'user/ajax_checkuser',
                                                  data:
                                                  {
                                                      val:function()
                                                      {
                                                          return $(".frm .username").val()
                                                      }
                                                  }
                                              }
                                          },
                                          password: {
                                              required: true,
                                              rangelength: [6, 16]
                                          }
                                      },
                                      messages: {
                                          username:{
                                             required:"请输入用户名",
                                             remote:'用户名重复'
                                          },
                                          password: {
                                              required:"请输入密码",
                                              rangelength:"密码长度为6-16位"
                                          }
                                      },
                                      errUserFunc:function(element){
                                          console.log(element);
                                      },
                                      submitHandler:function(form){
                                          Ext.Ajax.request({
                                              url   :  SITEURL+"user/ajax_addsave",
                                              method  :  "POST",
                                              isUpload :  true,
                                              form  : "addfrm",
                                              success  :  function(response, opts)
                                              {
                                                  var txt= response.responseText;
                                                  if(txt!='no')
                                                  {
                                                     var _arr=Ext.decode(txt);
                                                     window.product_store.add(_arr);
                                                    //  $("#uid").val(data.productid);
                                                      ST.Util.showMsg('添加成功!','4',2000);
                                                      button.up('window').close();
                                                  }
                                              }});
                                          return false;//阻止常规提交
                                      }
                                  });
                                  $(".frm").submit();
                             }},
                             { xtype: 'button', text: '取消' ,handler:function(){
                                 this.up('window').close();
                             }}
                         ]
                     }
                 });
         })
 //产品store
         window.product_store=Ext.create('Ext.data.Store',{
 fields:['id','username','beizu','roleid'],
         proxy:{
   type:'ajax',
   api: {
              read: SITEURL+'user/list/action/read',  //读取数据的URL
  update:SITEURL+'user/list/action/save',
  destroy:SITEURL+'user/list/action/delete'
              },
      reader:{
                type: 'json',   //获取数据的格式 
                root: 'lists',
                totalProperty: 'total'
                }
         },
 remoteSort:true,
         autoLoad:true,
 pageSize:30  
       });
   
  //产品列表 
  window.product_grid=Ext.create('Ext.grid.Panel',{ 
   store:product_store,
   padding:'2px',
   renderTo:'product_grid_panel',
   border:0,
   bodyBorder:0,
   bodyStyle:'border-width:0px',
       scroll:'vertical', //只要垂直滚动条
   bbar: Ext.create('Ext.toolbar.Paging', {
                    store: product_store,  //这个和grid用的store一样
                    displayInfo: true,
                    emptyMsg: "",
items:[
  {
  xtype:'combo',
  fieldLabel:'每页显示数量',
  width:170,
  labelAlign:'right',
  forceSelection:true,
  value:30,  
  store:{fields:['num'],data:[{num:30},{num:60},{num:100}]},
  displayField:'num',
  valueField:'num',
  listeners:{
  select:changeNum
  }
  }

],
  listeners: {
single: true,
render: function(bar) {
var items = this.items;
bar.down('tbfill').hide();
bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="abtn" href="javascript:void(0);" onclick="chooseAll()">全选</a><a class="abtn" href="javascript:void(0);" onclick="chooseDiff()">反选</a><a class="abtn" href="javascript:void(0);" onclick="delLine()">删除</a></div>'}));

bar.insert(1,Ext.create('Ext.toolbar.Fill'));
//items.add(Ext.create('Ext.toolbar.Fill'));
}
}
                 }),   
   columns:[
   {
   text:'选择',
   width:'10%',
  // xtype:'templatecolumn',
   tdCls:'product-ch',
   align:'center',
   dataIndex:'id',
   border:0,
   renderer : function(value, metadata,record) {
    id=record.get('id');
    if(id.indexOf('suit')==-1)
    return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='"+value+"'/>"; 
 
}
   },
   {
   text:'用户名',
   width:'25%',
   dataIndex:'username',
   align:'left',
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
       return value;
}
   },
               {
               text:'权限',
               width:'25%',
               dataIndex:'roleid',
               align:'left',
               border:0,
               sortable:false,
               renderer : function(value, metadata,record) {
                    var id=record.get('id');
                    var roleid = record.get('roleid');
                    var status = roleid==1 ? "disabled=\"disabled\"" : '';
                    var html="<select "+status+" onchange=\"updateField(this,"+id+",'roleid',0,'select')\"><option value='0'>请选择..</option>"
                    Ext.Array.each(roles,function(row,index){
                            var is_selected=value==row.roleid?"selected='selected'":'';
                            html+="<option value='"+row.roleid+"' "+is_selected+">"+row.rolename+"</option>";
                    })
                    html+="</select>";
                   return html;
                  // return value;
               }
              },
              {
               text:'备注',
               width:'30%',
               dataIndex:'beizu',
               align:'left',
               editor:'textfield',
               border:0,
               sortable:false,
               renderer : function(value, metadata,record) {
                   return value;
                  }
               },
   {
   text:'管理',
   width:'10%',
   align:'center',
   border:0,
   sortable:false,
   dataIndex:'id',
   renderer : function(value, metadata,record) {    
         //  title=record.get('ztname');
  // return "<a href='javascript:;' onclick=\"ST.Util.addTab('修改"+title+"','"+SITEURL+"zhuanti/edit/themeid/"+value+"')\">修改</a>";
                                   // return getExpandableImage(value, metadata,record);
return "<a href='javascript:;' onclick=\"goModify("+value+")\">修改</a>"
                    }  
   }
           ],
 listeners:{
            boxready:function()
            {
   var height=Ext.dom.Element.getViewportHeight();
   this.maxHeight=height-106;
   this.doLayout();
            },
afterlayout:function(grid)
{
window.product_store.each(function(record){
        id=record.get('id');
   });
   var data_height=0;
   try{
     data_height=grid.getView().getEl().down('.x-grid-table').getHeight();
   }catch(e)
   {
   }
  var height=Ext.dom.Element.getViewportHeight();
  if(data_height>height-106)
  {
  window.has_biged=true;
  grid.height=height-106;
  }
  else if(data_height<height-106)
  {
  if(window.has_biged)
  {
delete window.product_grid.height;
window.has_biged=false;  
grid.doLayout();
  }
  }
  }
 },
 plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                  clicksToEdit:2,
                  listeners:{
 edit:function(editor, e)
 {
var id=e.record.get('id');
updateField(0,id,e.field,e.value,0);
return false;
  
 },
 beforeedit:function(editor,e)
 {
   
 }
 }
               })
             ],
viewConfig:{
//enableTextSelection:true
}   
   });
   
  
  
})



//实现动态窗口大小
  Ext.EventManager.onWindowResize(function(){ 
      var height=Ext.dom.Element.getViewportHeight(); 
  var data_height=window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
  if(data_height>height-106)
     window.product_grid.height=(height-106);
  else
      delete window.product_grid.height;
  window.product_grid.doLayout();
 }) 
  Ext.get('right_manage').on('click',function(dom){
      ST.Util.addTab("权限管理",SITEURL+"user/right/parentkey/application/itemid/7");
  })
  //进行搜索
  function goSearch(ele,val,field)
  {
 
  if(field=='kindid')
  {
     Ext.select('.kind-search-cs a').removeCls('active');
    Ext.get(ele).addCls('active'); 
  }
  window.product_store.getProxy().setExtraParam(field,val);
  window.product_store.load();
  
  }
  
    
  function searchDest(ele)
  {
   var keyword=Ext.get(ele).prev().getValue();
   keyword=Ext.String.trim(keyword);
   goSearch(0,keyword,'keyword');
  }

//切换每页显示数量
  function changeNum(combo,records)
  {

var pagesize=records[0].get('num');
window.product_store.pageSize=pagesize;
window.product_grid.down('pagingtoolbar').moveFirst();
}
//选择全部 
  function chooseAll()
  {
 var check_cmp=Ext.query('.product_check');
 for(var i in check_cmp)
 {
if(!Ext.get(check_cmp[i]).getAttribute('checked'))
    check_cmp[i].checked='checked';
 } 
 
//  window.sel_model.selectAll();
  }
  //反选
  function chooseDiff()
  {
  var check_cmp=Ext.query('.product_check');
for(var i in check_cmp)
  check_cmp[i].click();
  }
  function delLine()
  {
  var check_cmp=Ext.select('.product_check:checked');
  if(check_cmp.getCount()==0)
  {
  return;
  }
  
  var system_managers=window.product_store.query('roleid',1);
  
  var managers_num=system_managers.getCount();
 
  
   ST.Util.confirmBox("提示","确定删除",function(buttonId){
    
      check_cmp.each(
  function(el,c,index)
{
var record=window.product_store.getById(el.getValue());
if(record.get('roleid')==1)
{
if(managers_num==1)
{
ST.Util.showMsg('至少要保留一个系统管理员',5);
return;
}
else
{
managers_num--;
record.destroy();
}

}
else
  record.destroy();
}
 );
   })
  }
 
  
  //更新某个字段
  function updateField(ele,id,field,value,type)
  {
  var record=window.product_store.getById(id.toString());
  if(type=='select')
  {
  value=Ext.get(ele).getValue();
  }
  var view_el=window.product_grid.getView().getEl();

 
  Ext.Ajax.request({
 url   :  "list/action/update",
 method  :  "POST",
 datatype  :  "JSON",
 params:{id:id,field:field,val:value},
 success  :  function(response, opts) 
 {
 if(response.responseText=='ok')
 {
 
   record.set(field,value);
   record.commit(); 
      
 }
 }});
  }
  
  
  //设置帮助的显示位置
  function setPosition(dom,types,id)
  {
  Ext.create('Ext.window.Window',
           { 
     title:'设置显示位置',
 border:1,
 style: {
                     borderStyle: 'solid',
 borderWidth:'1px'
                  },
 bodyStyle:'padding:10px', 
 ghost:false,
 autoShow:true,
 listeners:{
  boxready:function(win)
  {
  var html="<div><span style=\"margin-left:10px\"><input onclick=\"choosePos(this,9,0)\" type=\"checkbox\"  value=\"0\" style=\"vertical-align:middle\">全选</span>";
  var  choosed=types.split(',');
  Ext.Object.each(typearr, function(key, value, myself)
  {
   var tid=key.slice(4);
   
   var is_checked='';
   if(Ext.Array.contains(choosed,tid))
       is_checked="checked='checked'" 
   
   html+="<span style='margin-left:10px'><input onclick=\"choosePos(this,"+id+","+tid+")\" type='checkbox' "+is_checked+" value='"+tid+"' style='vertical-align:middle'/>"+value+"</span>"
  });
  html+="</div>";
  win.update(html);
  }
}
   });
  
  
  }
  
  //修改
  function goModify(id)
  {
 Ext.create('Ext.window.Window',
                 {
                     title:'修改用户',
                     border:1,
                     y:140,
                     style: {
                         borderStyle: 'solid',
                         borderWidth:'1px'
                     },
                     bodyStyle:'padding:10px',
                     id:'addfrm_win',
                     ghost:false,
                     autoShow:true,
                     listeners:{
                         boxready:function(win)
                         {
 var record=window.product_store.getById(id.toString());
                             win.setTitle("修改用户-"+record.get('username'));
                             var username=record.get('username');
                             var roleid=record.get('roleid');
                             var beizu=record.get('beizu');
                             var select="<select name='roleid'><option value='0'>请选择..</option>"
                             Ext.Array.each(roles,function(row,index){
                                 var is_selected=row.roleid==roleid?"selected='selected'":'';
                                 select+="<option value='"+row.roleid+"' "+is_selected+">"+row.rolename+"</option>";
                             })
                             select+="</select>";
                             var html="<form class='frm' id='addfrm'><table class='user-add-tb'>";
                             html+="<tr><td width='60'>密码:</td><td><input type='password' class='password' name='password' size='15'/><input type='hidden' name='id' value='"+id+"'/><input type='hidden' name='username' value='"+username+"'/></td></tr>";
                             //html+="<tr><td>权限:</td><td>"+select+"</td></tr>"
                             html+="<tr><td>备注:</td><td><textarea name='beizu'>"+beizu+"</textarea></td></tr>";
                             html+="</table></form>";
                             win.update(html);
                         }
                     },
                     buttons:
                     {
                         style:"background:#fff",   //设置背景色，这样就不会有透明 的了.
                         items:[
                             { xtype: 'button', text:'提交',handler:function(button)
                              {
                                   $(".frm").validate({
                                      focusInvalid:false,
                                      rules: {
                                          username:
                                          {
                                              required: true,
                                              remote:{
                                                  type:"POST",
                                                  url: SITEURL+'user/ajax_checkuser',
                                                  data:
                                                  {
                                                      val:function()
                                                      {
                                                          return $(".frm .username").val()
                                                      }
                                                  }
                                              }
                                          },
                                          password: {
                                              required: true,
                                              rangelength: [6, 16]
                                          }
                                      },
                                      messages: {
                                          username:{
                                             required:"请输入用户名",
                                             remote:'用户名重复'
                                          },
                                          password: {
                                              required:"请输入密码",
                                              rangelength:"密码长度为6-16位"
                                          }
                                      },
                                      errUserFunc:function(element){
                                          console.log(element);
                                      },
                                      submitHandler:function(form){
                                          Ext.Ajax.request({
                                              url   :  SITEURL+"user/ajax_addsave",
                                              method  :  "POST",
                                              isUpload :  true,
                                              form  : "addfrm",
                                              success  :  function(response, opts)
                                              {
                                                  var txt= response.responseText;
                                                  if(txt!='no')
                                                  {
                                                    var _arr=Ext.decode(txt);
                                                    var record=window.product_store.getById(id.toString());
                                                    // window.product_store.add(_arr);
                                                    //  $("#uid").val(data.productid);
                                                     for(var i in _arr)
                                                     {
                                                        record.set(i,_arr[i]);
                                                     }
                                                      ST.Util.showMsg('修改成功!','4',2000);
                                                     button.up('window').close();
                                                  }
                                              }});
                                          return false;//阻止常规提交
                                      }
                                  });
                                  $(".frm").submit();
                             }},
                             { xtype: 'button', text: '取消' ,handler:function(){
                                 this.up('window').close();
                             }}
                         ]
                     }
                 });
  }
  
  
  
</script>
</body>
</html>
