<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>线路列表-思途CMS3.0</title>
 {template 'stourtravel/public/public_js'}
   {php echo Common::getCss('style.css,base.css,base2.css,plist.css'); }
   {php echo Common::getCss('ext-theme-neptune-all-debug.css','js/extjs/resources/ext-theme-neptune/'); }
   {php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); }
   {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>
<body style="overflow:hidden">
<table class="content-tab">
   <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
    <td valign="top" class="content-rt-td" style="overflow:hidden">
     
  <div class="crumbs" id="dest_crumbs">
         <label>位置：</label>
         首页
         &gt;产品中心
         &gt;<span>线路管理</span>
  </div>

 
<div class="list-top-set">
   <div class="list-web-pad"></div>
   <div class="list-web-ct">
      <div class="list-web-ct-lt" id="list_ot_set">
          <a href="javascript:;" id="addbtn" class="add-btn-class ml-10">添加</a>
      </div>
   </div>
 </div>

 <div class="search-bar filter" id="search_bar">
     <span class="tit ml-10">筛选</span>
     <div class="change-btn-list mt-5 ml-10">
       <span class="change-btn-xz btnbox" id="website" data-url="box/index/type/weblist" data-result="result_webid">站点切换&nbsp;&gt;&nbsp;<span id="result_webid">全部</span></span>

     </div>
     
     <div class="change-btn-list mt-5 ml-10">
       <span class="change-btn-xz btnbox" id="startcity" data-url="box/index/type/startplace" data-result="result_startcity">出发地&nbsp;&gt;&nbsp;<span id="result_startcity">全部</span></span>

     </div>
     
     <div class="change-btn-list mt-5 ml-10">
       <span class="change-btn-xz btnbox" id="destination" data-url="box/index/type/destlist" data-result="result_dest" >目的地&nbsp;&gt;&nbsp;<span id="result_dest">全部</span></span>

     </div>
     
     <div class="change-btn-list mt-5 ml-10">
       <span class="change-btn-xz btnbox" id="attrlist" data-url="box/index/type/attrlist/typeid/1" data-result="result_attrlist" >属性&nbsp;&gt;&nbsp;<span id="result_attrlist">全部</span></span>

     </div>
   
   	 <div class="pro-search ml-10 fl mt-4">
        <input type="text" id="searchkey" value="线路名称/产品编号" datadef="线路名称/产品编号" class="sty-txt1 set-text-xh wid_150">
        <input type="button" value="搜索" class="sty-btn1 default-btn wid_60 mt-1" onclick="CHOOSE.searchKeyword()" >
     </div>
   
     <span class="display-mod">
       <span class="list-1 fl"><a href="javascript:void(0);" title="基本信息" class="on" onClick="CHOOSE.togMod(this,1)">基本信息</a></span>
       <span class="list-2 fl"><a href="javascript:void(0);" title="套餐" onClick="CHOOSE.togMod(this,2)">套餐</a></span>
       <span class="list-3 fl"><a href="javascript:void(0);" title="供应商" onClick="CHOOSE.togMod(this,3)">供应商</a></span>
     </span>
   </div> 
 <div id="product_grid_panel" class="content-nrt">
    
  </div>
  </td>
  </tr>
 </table> 
<script>

   window.kindmenu = {$kindmenu};//分类设置菜单
   window.display_mode=1;	

  Ext.onReady(
    function() 
    {
		 Ext.tip.QuickTipManager.init();

        $(".btnbox").buttonBox();

        $("#searchkey").focusEffect();

        //添加按钮
        $("#addbtn").click(function(){

            ST.Util.addTab('添加线路','{$cmsurl}line/add/parentkey/product/itemid/1',0);
        });

        var kindsetmenu=[];
        Ext.Object.each(window.kindmenu,function(key,row,itself){
            kindsetmenu.push({text:row.name,handler:function(){

                ST.Util.addTab(row.name,row.url,1);
            }})
        })
        Ext.create('Ext.button.Button',{
            text:'设置',
            renderTo:'list_ot_set',
            cls:'ext-configbutton',
            focusCls:'ext-configbutton',
            componentCls:'',
            menu: {
                items:kindsetmenu
            }

        });



		//线路store
        window.product_store=Ext.create('Ext.data.Store',{

		 fields:[
             'id',
             'aid',
             'webid',
             'linename',
             'lineseries',
		     'kindlist',
             'kindname',
             'starttime',
             'endtime',
             'attrid',
             'attrname',
             'tprice',
             'profit',
             'lineprice',
             'isjian',
             'istejia',
             'addtime',
             'modtime',
             'displayorder',
             'ishidden',
             'suit',
             'jifentprice',
             'jifencomment',
             'jifenbook',
             'propgroup',
             'minprice',
             'minprofit',
             'tr_class',
             'themelist',
             'iconlist',
             'iconname',
             'suppliername',
             'linkman',
             'mobile',
             'qq',
             'address',
             'url'
         ],

         proxy:{
		   type:'ajax',
		   api: {
              read: SITEURL+'line/line/action/read',  //读取数据的URL
			  update:SITEURL+'line/line/action/save',
			  destroy:SITEURL+'line/line/action/delete'
              },
		      reader:{
                type: 'json',   //获取数据的格式 
                root: 'lines',
                totalProperty: 'total'
                }	
	         },

		 remoteSort:true,	 
		 pageSize:30,
         autoLoad:true,
		 listeners:{
			 load:function( store, records, successful, eOpts )
			 {
                if(!successful){
                    ST.Util.showMsg("{__('norightmsg')}",5,1000);
                }

			 }
		 }
		  
       });
	   
	  //线路列表框 
	  window.product_grid=Ext.create('Ext.grid.Panel',{ 
	   store:product_store,
	   padding:'2px',
	   renderTo:'product_grid_panel',
	   border:0,
	   bodyBorder:0,
	   bodyStyle:'border-width:0px',
	   scroll:'vertical',
	   bbar: Ext.create('Ext.toolbar.Paging', {
                    store: product_store,  //这个和grid用的store一样
                    displayInfo: true,
                    emptyMsg: "没有数据了",
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
							  select:CHOOSE.changeNum
						  }
					  }
					
					],
				  listeners: {
						single: true,
						render: function(bar) {
							var items = this.items;
							bar.down('tbfill').hide();

							bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="abtn" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="abtn" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="abtn" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));
							bar.insert(1,Ext.create('Ext.panel.Panel',{border:0,items:[{
								 xtype:'button',
                                 style:'backgroundcolor:#008ed8',
								 text:'批量设置',
								 menu:[
								       {text:'目的地',handler:function(){ CHOOSE.setSome(1)}},
									   {text:'属性',handler:function(){ CHOOSE.setSome(2,1)}},
									   {text:'专题',handler:function(){ CHOOSE.setSome(4)}},
									   {text:'图标',handler:function(){ CHOOSE.setSome(3)}}
									 ]
								
								}]}));
							bar.insert(2,Ext.create('Ext.toolbar.Fill'));
							//items.add(Ext.create('Ext.toolbar.Fill'));
						}
					}	
                 }), 		 			 
	   columns:[
			   {
				   text:'选择',
				   width:'5%',
				  // xtype:'templatecolumn',
				   tdCls:'line-ch',
				   align:'center',
				   dataIndex:'id',
                   sortable:false,
				   border:0,
				   renderer : function(value, metadata,record) {
					    id=record.get('id');
					    if(id.indexOf('suit')==-1)
					    return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='"+value+"'/>"; 
					 
					}


				  
			   },
			   {
				   text:'排序',
				   width:'5%',
				   dataIndex:'displayorder',
                   tdCls:'line-order',
				   id:'column_lineorder',
				   align:'center',
				   border:0,
			       editor: 'textfield',
				   renderer : function(value, metadata,record) {
					              var id=record.get('id'); 
								   if(id.indexOf('suit')!=-1)
								        metadata.tdAttr ="data-qtip='指同一条线路下套餐的显示顺序'"+"data-qclass='dest-tip'";

								  if(value==9999||value==999999)
								      return '';
							      else 
								      return value;		  
					 
					},
                   listeners:{
                       afterrender:function(obj,eopts)
                       {
                           if(window.display_mode==3 )
                               obj.hide();
                           else
                               obj.show();
                       }
                   }

				  
			   },
               {
                   text:'线路编号',
                   width:'5%',
                   dataIndex:'lineseries',
                   align:'left',
                   id:'column_lineseries',

                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return '<span style="color:red">'+value+'</span>';
                   }


               },
			   {
				   text:'线路名称',
				   width:'30%',
				   dataIndex:'linename',
				   align:'left',
				   id:'column_linename',
				   
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
					  //  return  "<input type='checkbox' class='product_check' value='"+value+"'/>"; 
		
			                         var aid=record.get('aid');
									 var id=record.get('id');
                                     var iconname = record.get('iconname');
                                     var url=record.get('url');
									 
									 if(!isNaN(id))
			                           return "<a href='"+url+"' class='line-title' target='_blank'>"+value+iconname+"</a>";
			                         else if(id.indexOf('suit')!=-1)
									 {
									    //metadata.tdAttr ="data-qtip='点击跳转到套餐设置页面'  data-qclass='dest-tip'";
									   return "&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' class='suit-title'>"+value+"</a>";
									 }
					}
				  
			   }
			   ,

			   {
				   text:'积分抵现金',
				   width:'8%',
				   dataIndex:'jifentprice',
				   align:'center',
				   cls:'mod-2',	
				   editor:'textfield',
				   tdCls:'suit-cell',   
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
					                 var id=record.get('id');
			                         if(id.indexOf('suit')!=-1)
									 {
									    metadata.tdAttr ="data-qtip='双击修改积分'  data-qclass='dest-tip'";
									    return value;
									 }
					},
				   listeners:{
					    afterrender:function(obj,eopts)
						{

							if(window.display_mode==2)
							    obj.show();
                            else
                                obj.hide();


					    }
					}
			   }
			   ,
			   {
				   text:'评论送积分',
				   width:'8%',
				   editor:'textfield',
				   dataIndex:'jifencomment',
				   align:'center',
				    cls:'mod-2',
				    tdCls:'suit-cell',   	
				   border:0,
				   sortable:false,
				    renderer : function(value, metadata,record) {
					                 var id=record.get('id');
			                         if(id.indexOf('suit')!=-1)
									 {
									    metadata.tdAttr ="data-qtip='双击修改积分'  data-qclass='dest-tip'";
									    return value;
									 }
					},
				   listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=2)
							    obj.hide();
                            else
                                obj.show();

					    }
					} 
			   }
			   ,
			   {
				   text:'购买送积分',
				   width:'8%',
				   dataIndex:'jifenbook',
				   align:'center',
				   editor:'textfield',
				   border:0,
				    cls:'mod-2',
				    tdCls:'suit-cell',   	
				   sortable:false,
				    renderer : function(value, metadata,record) {
					                 var id=record.get('id');
			                         if(id.indexOf('suit')!=-1)
									 {
									    metadata.tdAttr ="data-qtip='双击修改积分'  data-qclass='dest-tip'";
									    return value;
									 }
					},
				   listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=2)
							    obj.hide();
                            else
                                obj.show();

					    }
					}
			   },
			   {
				   text:'适用人群',
				   width:'10%',
				   dataIndex:'propgroup',
				   align:'center',
				   border:0,
				   cls:'mod-2',
				   tdCls:'suit-cell', 	
				   sortable:false,
				   renderer : function(value, metadata,record) {
						 var id=record.get('id');
						 if(!value)
						   return '';
						 else
						 {
							 var arr=value.split(',');
							 var str='';
							 for(var i in arr)
							 {
								 if(arr[i]==1)
								  str+='小孩'+',';
								 else if(arr[i]==2)
								  str+='成人'+',';
								 else if(arr[i]==3)
								  str+='老人'+',';
								
							 }
							 return str.slice(0,-1);     
							 
						 }
						
						 
						 
						
                    },
				   listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=2)
							    obj.hide();
                            else
                                obj.show();

					    }
					}
			   },
			    {
				   text:'最低价格(元)',
				   width:'5%',
				   align:'center',
				   border:0,
				   cls:'mod-2',
				   dataIndex:'minprice',
				   sortable:false,
				   listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=2)
							    obj.hide();
                            else
                                obj.show();

					    }
					}			  
				},
			    {
				   text:'最低利润(元)',
				   width:'5%',
				   align:'center',
				   dataIndex:'minprofit',
				   border:0,
				   cls:'mod-2',
				   sortable:false,
				   listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=2)
							    obj.hide();
                            else
                                obj.show();

					    }
					}			  
				},
				{
				   text:'管理',
				   width:'12%',
				   align:'center',
				   border:0,
				   cls:'mod-2',
				   sortable:false,
				   renderer : function(value, metadata,record) {
					  //  return  "<input type='checkbox' class='product_check' value='"+value+"'/>"; 
		
			                         var aid=record.get('aid');
									 var id=record.get('id');
                                     var name=record.get('linename');
			                          if(id.indexOf('suit')!=-1)
                                      {
                                         var suitid=id.slice(id.indexOf('_')+1);
									     return "<a href='javascript:;' onclick=\"ST.Util.addTab(\'修改套餐\',\'line/editsuit/parentkey/product/itemid/1/suitid/"+suitid+"\')\">修改</a>&nbsp;&nbsp;<a href='javascript:void(0);' onclick=\"delSuit('"+id+"')\">删除</a>";
                                      }
                                      else
                                      {
                                          return '<a href="javascript:;" onclick="ST.Util.addTab(\'添加套餐\',\'line/addsuit/parentkey/product/itemid/1/lineid/'+id+'\')">添加套餐</a>';
                                      }
					},				 
				   listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=2)
							    obj.hide();
                            else
                                obj.show();
					    }
					}			  
				
				}
			    ,
			   {
				   text:'供应商',
				   width:'20%',
				   align:'center',
				   dataIndex:'suppliername',
				   cls:'mod-3',
				   border:0,
				   sortable:false,
					listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=3)
							    obj.hide();
                            else
                                obj.show();

					    }
					}
				   
			   },
               {
                   text:'联系人',
                   width:'10%',
                   align:'center',
                   dataIndex:'linkman',
                   cls:'mod-3',
                   border:0,
                   sortable:false,
                   listeners:{
                       afterrender:function(obj,eopts)
                       {
                           if(window.display_mode!=3)
                               obj.hide();
                           else
                               obj.show();

                       }
                   }

               },
			   {
				   text:'联系电话',
				   width:'8%',
				   align:'center',
				   dataIndex:'mobile',
				   cls:'mod-3',
				   border:0,
				   sortable:false,
					listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=3)
							    obj.hide();
                            else
                                obj.show();

					    }
					}
				   
			   },
               {
                   text:'地址',
                   width:'15%',
                   align:'center',
                   dataIndex:'address',
                   cls:'mod-3',
                   border:0,
                   sortable:false,
                   listeners:{
                       afterrender:function(obj,eopts)
                       {
                           if(window.display_mode!=3)
                               obj.hide();
                           else
                               obj.show();

                       }
                   }

               },
               {
                   text:'QQ',
                   width:'10%',
                   align:'center',
                   dataIndex:'qq',
                   cls:'mod-3',
                   border:0,
                   sortable:false,
                   listeners:{
                       afterrender:function(obj,eopts)
                       {
                           if(window.display_mode!=3)
                               obj.hide();
                           else
                               obj.show();

                       }
                   }

               },
			   {
				   text:'目的地',
				   width:'10%',
				   dataIndex:'kindlist',
				   align:'center',
				    cls:'mod-1',
				   sortable:false,
				   renderer : function(value, metadata,record) {
					     var kindname=record.get('kindname');	 
						 if(kindname)
						 metadata.tdAttr ="data-qtip='"+kindname+"'"+"data-qclass='dest-tip'";
						 var id=record.get('id');
						 var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						
						 return "<a href='javascript:void(0);' onclick=\"ST.Destination.setDest(this,1,"+id+",'"+value+"',CHOOSE.destSetBack)\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    },
					 listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=1)
							    obj.hide();
                            else
                                obj.show();

					    }
					}

				  
			   },
			   {
				 text:'图标',
				   width:'10%',
				   align:'center',
				   dataIndex:'iconlist',
				   border:0,
				   cls:'mod-1',
				   sortable:false,
				   renderer : function(value, metadata,record) {
					     var id=record.get('id');
						 var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						 return "<a href='javascript:void(0);' onclick=\"ST.Icon.setIcon(this,1,"+id+",'"+value+"',CHOOSE.iconSetBack)\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    },
					 listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=1)
							    obj.hide();
                            else
                                obj.show();

					    }
					}
				 
  
			   },
			   {
				   text:'属性',
				   width:'10%',
				   align:'center',
				   dataIndex:'attrid',
				   border:0,
				   sortable:false,
				   cls:'mod-1',
				   renderer : function(value, metadata,record) {
					     var attrname=record.get('attrname');
						 if(attrname)
						 metadata.tdAttr ="data-qtip='"+attrname+"'data-qclass='dest-tip'";
						 var id=record.get('id');
						 var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						 return "<a href='javascript:void(0);' onclick=\"ST.Attrid.setAttrid(this,1,"+id+",'"+value+"',CHOOSE.attrSetBack)\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    },
					 listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=1)
							    obj.hide();
                            else
                                obj.show();

					    }
					}

			   },
			   {
				   text:'专题',
				   width:'10%',
				   align:'center',
				   sortable:false,
				  dataIndex:'themelist',
				  cls:'mod-1',
				   border:0,
				  renderer : function(value, metadata,record) {
					    
						 var id=record.get('id');
						 var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						 return "<a href='javascript:void(0);' onclick=\"ST.Theme.setTheme(this,1,"+id+",'"+value+"',CHOOSE.themeSetBack)\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    },
					 listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=1)
							    obj.hide();
                            else
                                obj.show();

					    }
					}
				  
			   },

			   {
				   text:'隐藏',
				   width:'5%',
				  // xtype:'templatecolumn',
				   align:'center',
				   border:0,
				   dataIndex:'ishidden',
				   xtype:'actioncolumn',
				    cls:'mod-1',
		           items:[
			       {
			        getClass: function(v, meta, rec) {          // Or return a class from a function
					    if(v==1)
						  return 'dest-status-ok';
						else
						  return 'dest-status-none';  
                    },
				    handler:function(view,index,colindex,itm,e,record)
				    {
					   togStatus(null,record,'ishidden');
					   
				    }
			      }
			      ],
				   listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=1)
							    obj.hide();
                            else
                                obj.show();

					    }
					}
				  
				  
			   },
			    {
				   text:'管理',
				   width:'12%',
				   align:'center',
				   border:0,
				   sortable:false,
				   cls:'mod-1',
				   renderer : function(value, metadata,record) {
                         var linename=record.get('linename');
					     var id=record.get('id');
						 return "<a href='javascript:void(0);' onclick=\"goModify("+id+",'"+linename+"')\">修改";
                                   // return getExpandableImage(value, metadata,record);
                    },
					 listeners:{
					    afterrender:function(obj,eopts)
						{
							if(window.display_mode!=1)
							    obj.hide();
                            else
                                obj.show();

					    }
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
					afterlayout:function()
					{
			
			            if(window.line_kindname)
						{
							 Ext.getCmp('column_lineorder').setText(window.line_kindname+'-排序')
						}
						else
					    {
							Ext.getCmp('column_lineorder').setText('排序')
						}
					
						window.product_store.each(function(record){
				        id=record.get('id');
					    if(id.indexOf('suit')!=-1)
						  {

                              var ele=window.product_grid.getView().getNode(record);
                              var cls=record.get('tr_class');
                              Ext.get(ele).addCls(cls);
                              Ext.get(ele).setVisibilityMode(Ext.Element.DISPLAY);
                              if(window.display_mode!=2)
                              {
                                  Ext.get(ele).hide();
                              }
                              else
                              {
                                  Ext.get(ele).show();
                              }
						  }
						else if(window.display_mode==2)
						 {
							 var ele=window.product_grid.getView().getNode(record);
							 var cls=record.get('tr_class');
							 Ext.get(ele).addCls(cls);
						 }
						
					   });
				  }
			 },
			 plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                  clicksToEdit:2,
                  listeners:{
					 edit:function(editor, e)
					 {
						   var id=e.record.get('id');
						   var view_el=window.product_grid.getView().getEl();
						  view_el.scrollBy(0,this.scroll_top,false);
						  updateField(0,id,e.field,e.value,0);
						  return false;
					 },
					 beforeedit:function(editor,e)
					 {
						 if(e.field=='jifentprice'||e.field=='jifenbook'||e.field=='jifencomment')
						 {
							  var id=e.record.get('id');
							  if(id.indexOf('suit')==-1)
							  {
								  return false;
							  }
						 }
						  var view_el=window.product_grid.getView().getEl()
	                       this.scroll_top=view_el.getScrollTop();		
						 
					 }
				 }
               })
             ]
			
			  
			   
			   
	   });
	   
	  
	  
	})
	
	//实现动态窗口大小
     Ext.EventManager.onWindowResize(function(){

      var height=Ext.dom.Element.getViewportHeight();
	   window.product_grid.maxHeight=(height-106);
	   window.product_grid.doLayout();
	   
	 }) 
	

 	
	//更新某个字段
  function updateField(ele,id,field,value,type)
  {
	  var record=window.product_store.getById(id.toString());
	  if(type=='select')
	  {
		  value=Ext.get(ele).getValue();
	  }
	  Ext.Ajax.request({
						 url   :  "line/action/update",
						 method  :  "POST",
						 datatype  :  "JSON",
						 params:{id:id,field:field,val:value,kindid:window.product_kindid},
						 success  :  function(response, opts) 
						 {
							 if(response.responseText=='ok')
							{
							   var view_el=window.product_grid.getView().getEl()
	                           var scroll_top=view_el.getScrollTop();				   
							   record.set(field,value);
							   record.commit(); 
						       view_el.scrollBy(0,scroll_top,false);
							 }
                             else
                             {
                                ST.Utils.showMsg("{__('norightmsg')}",5,1000);
                             }
						 }});

  }


  //切换显示或隐藏
   function togStatus(obj,record,field)
  {
       var val=record.get(field);
       var id=record.get('id');
	   var newval=val==1?0:1;
	   Ext.Ajax.request({
						 url   :  "line/action/update",
						 method  :  "POST",
						 datatype  :  "JSON",
						 params:{id:id,field:field,val:newval},
						 success  :  function(response, opts) 
						 {
							 if(response.responseText=='ok')
							{
								var view_el=window.product_grid.getView().getEl()
	                            var scroll_top=view_el.getScrollTop();		
							   record.set(field,newval);
							   record.commit();
							    view_el.scrollBy(0,scroll_top,false);
							 }
						 }});
	 
  }
  //删除套餐
  function delSuit(id)
  {
	  Ext.Msg.confirm("提示","确定删除这个套餐？",function(buttonId){
		    if(buttonId=='yes')
	         window.product_store.getById(id).destroy();
		  })
  }
  //修改
  function goModify(lineid,linename)
  {
      parent.window.addTab(linename,SITEURL+'/line/edit/lineid/'+lineid+'/parentkey/product/itemid/1',1);
  }

</script>

</body>
</html>
