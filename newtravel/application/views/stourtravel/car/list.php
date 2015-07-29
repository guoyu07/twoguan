<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>思途CMS3.0</title>
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
              &gt; 产品中心
              &gt; 车务管理
              &gt; <span>车辆列表</span>
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
                <span class="change-btn-xz btnbox" id="carkind" data-url="box/index/type/carkind" data-result="result_kind" >车辆类型&nbsp;&gt;&nbsp;<span id="result_kind">全部</span></span>

            </div>
          <!--  <div class="change-btn-list mt-5 ml-10">
                <span class="change-btn-xz btnbox" id="carbrand" data-url="box/index/type/carkind" data-result="result_brand" >车辆品牌&nbsp;&gt;&nbsp;<span id="result_brand">全部</span></span>

            </div>-->

            <div class="change-btn-list mt-5 ml-10">
                <span class="change-btn-xz btnbox" id="attrlist" data-url="box/index/type/attrlist/typeid/3" data-result="result_attrlist" >属性&nbsp;&gt;&nbsp;<span id="result_attrlist">全部</span></span>

            </div>

            <div class="pro-search ml-10" style=" float:left; margin-top:5px">
                <input type="text" id="searchkey" value="车辆名称/车辆编号" datadef="车辆名称/车辆编号" class="sty-txt1 set-text-xh wid_150">
                <input type="button" value="搜索" class="sty-btn1 default-btn wid_60" onclick="CHOOSE.searchKeyword()" >
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


    window.display_mode=1;	//默认显示模式
    window.product_kindid=0;  //默认目的地ID
    window.kindmenu = {$kindmenu};//分类设置菜单

  Ext.onReady(
    function() 
    {
		 Ext.tip.QuickTipManager.init();

        $(".btnbox").buttonBox();

        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            var url=SITEURL+"car/add/parentkey/member/itemid/1";
            ST.Util.addTab('添加车辆',SITEURL+'car/add/parentkey/product/itemid/3',0);
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
		
		
		//产品store
        window.product_store=Ext.create('Ext.data.Store',{

		 fields:[
             'id',
             'aid',
             'series',
             'carname',
             'seatnum',
             'carkindid',
             'kindlist',
             'attrid',
             'isjian',
             'isding',
             'istejia',
             'displayorder',
             'brandname',
             'carkindname',
             'kindname',
             'attrname',
             'iconlist',
             'themelist',
             'ishidden',
             'unit',
             'jifenbook',
             'jifentprice',
             'jifencomment',
             'paytype',
             'dingjin',
             'suittypeid',
             'tr_class',
             'paytype',
             'suittypes',
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
              read: 'car/action/read',  //读取数据的URL
			  update:'car/action/save',
			  destroy:'car/action/delete'
              },
		      reader:{
                type: 'json',   //获取数据的格式 
                root: 'lists',
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
	   
	  //产品列表 
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
								 text:'批量设置',
								 menu:[
								       {text:'目的地',handler:function(){ CHOOSE.setSome(1,3)}},
									   {text:'属性',handler:function(){ CHOOSE.setSome(2,3)}},
									   {text:'专题',handler:function(){ CHOOSE.setSome(4,3)}},
									   {text:'图标',handler:function(){ CHOOSE.setSome(3,3)}}
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
				   text:'排序',
				   width:'5%',
				   dataIndex:'displayorder',
                   tdCls:'product-order',
				   id:'column_lineorder',
				   align:'center',
				   border:0,
			       editor: 'textfield',
				   renderer : function(value, metadata,record) {
					              var id=record.get('id'); 
								   if(id.indexOf('suit')!=-1)
								        metadata.tdAttr ="data-qtip='指同一酒店下房型的显示顺序'"+"data-qclass='dest-tip'";

								  if(value==9999||value==999999||value==0)
								      return '';
							      else 
								      return value;		  
					 
					}

				  
			   },
               {
                   text:'编号',
                   width:'5%',
                   dataIndex:'series',
                   align:'left',
                   id:'column_series',

                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return '<span style="color:red">'+value+'</span>';
                   }


               },
			   {
				   text:'车辆名称',
				   width:'18%',
				   dataIndex:'carname',
				   align:'left',
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
					            var aid=record.get('aid');
							    var id=record.get('id');
                                var url=record.get('url');
									 
									 if(!isNaN(id))
			                           return "<a href='"+url+"' class='product-title' target='_blank'>"+value+"</a>";
			                         else if(id.indexOf('suit')!=-1)
									 {
									    metadata.tdAttr ="data-qtip='点击跳转到房型设置页面'  data-qclass='dest-tip'";
									   return "&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' class='suit-title'>"+value+"</a>";
									 }
						}
				  
			   },
			   {
				  text:'座位数',
				  width:'12%',
				  dataIndex:'seatnum',
				  align:'center',
				  cls:'mod-1',
				  sortable:false,
				  editor:'textfield',
				  renderer : function(value, metadata,record,rowIndex,colIndex) {
					   metadata.tdAttr ="data-qtip='双击修改座位数'  data-qclass='dest-tip'";
					  var id=record.get('id');
                      if(!isNaN(id))
					  {
						 return value;
					  }
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
				  text:'车型',
				  width:'12%',
				  dataIndex:'carkindname',
				  align:'center',
				  cls:'mod-1',
				  sortable:false,
				  renderer : function(value, metadata,record,rowIndex,colIndex) {
					   
					  var id=record.get('id');
                      if(!isNaN(id))
					  {
						 return value;
					  }
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
                   width:'20%',
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
				   width:'7%',
				   dataIndex:'kindlist',
				   align:'center',
				    cls:'mod-1',
				   sortable:false,
				   renderer : function(value, metadata,record,rowIndex,colIndex) {
					   
					     var kindname=record.get('kindname');
						 if(kindname)
						 metadata.tdAttr ="data-qtip='"+kindname+"'"+"data-qclass='dest-tip'";
						 var id=record.get('id');
                         var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						 return "<a href='javascript:void(0);' onclick=\"ST.Destination.setDest(this,3,"+id+",'"+value+"',CHOOSE.destSetBack)\">"+d_text+"</a>";
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
				   width:'7%',
				   align:'center',
				   dataIndex:'iconlist',
				   border:0,
				   cls:'mod-1',
				   sortable:false,
				   renderer : function(value, metadata,record,rowIndex,colIndex) {
					  
					     var id=record.get('id');
                         var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						 return "<a href='javascript:void(0);' onclick=\"ST.Icon.setIcon(this,3,"+id+",'"+value+"',CHOOSE.iconSetBack)\">"+d_text+"</a>";
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
				   width:'7%',
				   align:'center',
				   dataIndex:'attrid',
				   border:0,
				   sortable:false,
				   cls:'mod-1',
				   renderer : function(value, metadata,record,rowIndex,colIndex) {
					  
					     var attrname=record.get('attrname');
						 if(attrname)
						    metadata.tdAttr ="data-qtip='"+attrname+"'data-qclass='dest-tip'";
						 
						 var id=record.get('id');
						 var d_text=value!=0?'已设':'未设';
						 return "<a href='javascript:void(0);' onclick=\"ST.Attrid.setAttrid(this,3,"+id+",'"+value+"',CHOOSE.attrSetBack)\">"+d_text+"</a>";
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
				   width:'7%',
				   align:'center',
				   sortable:false,
				  dataIndex:'themelist',
				  cls:'mod-1',
				   border:0,
				  renderer : function(value, metadata,record,rowIndex,colIndex) {
					
						 var id=record.get('id');
                         var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						 return "<a href='javascript:void(0);' onclick=\"ST.Theme.setTheme(this,3,"+id+",'"+value+"',CHOOSE.themeSetBack)\">"+d_text+"</a>";
                                  
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
				   width:'7%',
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
					  // togStatus(null,record,'ishidden');
					   var val=record.get('ishidden');
                       var id=record.get('id');
	                    var newval=val==1?0:1;
					  updateField(null,record.get('id'),'ishidden',newval)
					   
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
				   width:'9%',
				   align:'center',
				   border:0,
				   sortable:false,
				   cls:'mod-1',
				   renderer : function(value, metadata,record) {

                         var name=record.get('carname');
					     var id=record.get('id');
						 return "<a href='javascript:void(0);' onclick=\"goModify("+id+")\">修改";
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
				   text:'套餐类型',
				   width:'10%',
				   align:'center',
				   border:0,
				   sortable:false,
				   dataIndex:'suittypeid',
				   cls:'mod-2',
				   renderer : function(value, metadata,record,rowindex,colindex) {
					     var id=record.get('id');
						 if(id.indexOf('suit')!=-1)
                         {
                             var suittypes=record.get('suittypes');
                             var select_tag="<select onchange=\"updateField(this,'"+id+"','suittypeid',0,'select')\"><option value='0'>请选择..</option>";
                             Ext.Array.each(suittypes, function(row, index) {
                                 var is_selected=row.id==value?"selected='selected'":'';
                                 select_tag+="<option value='"+row.id+"' "+is_selected+">"+row.kindname+"</option>";
                             });
                             select_tag+="</select>";
                             return select_tag;



                         }
					     else
						    return '';		
                                   // return getExpandableImage(value, metadata,record);
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
				   text:'单位',
				   width:'8%',
				   align:'center',
				   border:0,
				   sortable:false,
				   dataIndex:'unit',
				   cls:'mod-2',
				   editor:'textfield',
				   renderer : function(value, metadata,record) {
					   
					     var id=record.get('id');
						 if(id.indexOf('suit')!=-1)
						    return value;
					     else
						    return '';		
                                   // return getExpandableImage(value, metadata,record);
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
				   text:'积分',
				   width:'9%',
				   align:'center',
				   border:0,
				   sortable:false,
				   dataIndex:'jifenbook',
				   editor:'textfield',
				   cls:'mod-2',
				   renderer : function(value, metadata,record) {
					     var id=record.get('id'); 
						 if(id.indexOf('suit')!=-1)
						   {
							  return value;
							
						   }
					     else
						    return '';		
                                   // return getExpandableImage(value, metadata,record);
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
				   text:'积分抵现金',
				   width:'8%',
				   align:'center',
				   border:0,
				   sortable:false,
				   dataIndex:'jifentprice',
				   cls:'mod-2',
				   editor:'textfield',
				   renderer : function(value, metadata,record) {
					     var id=record.get('id'); 
						 if(id.indexOf('suit')!=-1)
						   {
							  return value;
							
						   }
					     else
						    return '';		
                                   // return getExpandableImage(value, metadata,record);
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
				   text:'评论送积分',
				   width:'10%',
				   align:'center',
				   border:0,
				   sortable:false,
				   dataIndex:'jifencomment',
				   cls:'mod-2',
				   editor:'textfield',
				   renderer : function(value, metadata,record) {
					     var id=record.get('id'); 
						 if(id.indexOf('suit')!=-1)
						   {
							  return value;
						   }
					     else
						    return '';		
                                   // return getExpandableImage(value, metadata,record);
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
				   text:'支付方式',
				   width:'12%',
				   align:'center',
				   border:0,
				   sortable:false,
				   dataIndex:'paytype',
				   cls:'mod-2',
				  renderer : function(value, metadata,record) {
					     var id=record.get('id'); 
						 if(id.indexOf('suit')!=-1)
						   {
							   var dingjin=record.get('dingjin');
							   dingjin=dingjin?dingjin:0;
							   
							   var paytype_arr=[{id:1,name:'全额付款'},{id:2,name:'订金支付'},{id:3,name:'二次确认'}];
							   
							   var select_tag="<select onchange=\"updateMixField(this,'"+id+"','paytype',0,'select')\">";
							   Ext.Array.each(paytype_arr, function(row, index) {
								    var is_selected=row.id==value?"selected='selected'":'';
								    select_tag+="<option value='"+row.id+"' "+is_selected+">"+row.name+"</option>"; 	
                                    });
							   select_tag+="</select>";
							   
							   var is_hidden=value==2?'':'display:none';
							   return  "<table style='margin:auto'><tr><td>"+select_tag+"</td><td>&nbsp;<input size='4' type='text' value='"+dingjin+"' onblur=\"updateField(this,'"+id+"','dingjin',0,'input')\" style='"+is_hidden+"' /></td></tr></table>";
														
						   }
					     else
						    return '';		
                                   // return getExpandableImage(value, metadata,record);
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
				   text:'管理',
				   width:'11%',
				   align:'center',
				   border:0,
				   sortable:false,
				   cls:'mod-2',
				   renderer : function(value, metadata,record) {
					     var id=record.get('id');
                         var name=record.get('carname');
						 if(id.indexOf('suit')!=-1)
						   {
                               var suitid=id.slice(id.indexOf('_')+1);
                               var suitname=record.get('carname');
						        return "<a href='javascript:;' onclick=\"ST.Util.addTab('修改"+suitname+"','car/editsuit/suitid/"+suitid+"')\">修改</a>&nbsp;&nbsp;<a href='javascript:;' onclick=\"delSuit('"+id+"')\">删除</a>";
						   }
					     else
						    return '<a href="javascript:;" onclick="ST.Util.addTab(\''+name+'-套餐类型\',\'car/suittype/parentkey/product/itemid/3/carid/'+id+'\')">套餐类型<a>&nbsp;&nbsp;<a href="javascript:;" onclick="ST.Util.addTab(\'添加套餐\',\'car/addsuit/parentkey/product/itemid/3/carid/'+id+'\')">添加套餐</a>';
                                   // return getExpandableImage(value, metadata,record);
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
						
			
			            if(window.product_kindname)
						{
							 Ext.getCmp('column_lineorder').setText(window.product_kindname+'-排序')
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
					   
					   var data_height=0;
					   try{
					     data_height=grid.getView().getEl().down('.x-grid-table').getHeight();
					   }catch(e)
					   {
					   }
					  var height=Ext.dom.Element.getViewportHeight();
					// console.log(data_height+'---'+height);
					  if(data_height>height-106)
					  {
						  window.has_biged=true;
						  grid.height=height-106;
					  }
					  else if(data_height<height-106)
					  {
						  if(window.has_biged)
						  {
							//delete window.product_grid.height;
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
						 //  var view_el=window.product_grid.getView().getEl();
						 // view_el.scrollBy(0,this.scroll_top,false);
						updateField(0,id,e.field,e.value,0);
						return false;
						  
					 },
					 beforeedit:function(editor,e)
					 {
						 if(e.field=='jifentprice'||e.field=='jifenbook'||e.field=='jifencomment'||e.field=='dingjin'||e.field=='unit')
						 {
							  var id=e.record.get('id');
							  if(id.indexOf('suit')==-1)
							  {
								  return false;
							  }
						 }
						// var view_el=window.product_grid.getView().getEl();
	                     //this.scroll_top=view_el.getScrollTop();				   
	 
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
	

  

 
  //更新套餐的字段，并显示相应的text框，仅用于租车的支付方式
  function updateMixField(ele,id,field,value,type)
  {
	  if(type=='select')
	  {
		  var val=Ext.get(ele).getValue();
		 if(val==2)
		  Ext.get(ele).parent('table').down('input').show();
		 else
		  Ext.get(ele).parent('table').down('input').hide();  
	  }
	  updateField(ele,id,field,value,type);
  }
  
  //更新某个字段
  function updateField(ele,id,field,value,type)
  {
	  var record=window.product_store.getById(id.toString());
	  if(type=='select'||type=='input')
	  {
		  value=Ext.get(ele).getValue();
	  }
	  var view_el=window.product_grid.getView().getEl();
	
	 
	  Ext.Ajax.request({
						 url   :  "car/action/update",
						 method  :  "POST",
						 datatype  :  "JSON",
						 params:{id:id,field:field,val:value,kindid:window.product_kindid},
						 success  :  function(response, opts) 
						 {
							 if(response.responseText=='ok')
							 {
							//  var view_el=window.product_grid.getView().getEl()
	                          //   var scroll_top=view_el.getScrollTop();				   
					   
							   record.set(field,value);
							   record.commit(); 
						      // view_el.scrollBy(0,scroll_top,false);
							 }
                             else
                             {
                                 ST.Utils.showMsg("{__('norightmsg')}",5,1000);
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
    function goModify(id)
    {
        var url = SITEURL+'car/edit/parentkey/product/itemid/3/carid/'+id;

        parent.window.addTab('修改车辆',url,0);
    }

  
  
  
 
</script>

</body>
</html>
