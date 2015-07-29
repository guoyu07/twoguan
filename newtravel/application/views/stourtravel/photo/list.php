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
            &gt; 文章系统
            &gt; 相册管理
            &gt; <span>相册列表</span>
         </div>
 <div class="list-top-set">
   <div class="list-web-pad"></div>
   <div class="list-web-ct">
      <div class="list-web-ct-lt" id="list_ot_set">
          <a href="javascript:;" id="addbtn" class="add-btn-class ml-10">添加</a>
      </div>
      <div class="list-web-ct-rt" id="list_ot_web"></div>
   </div>
 </div>

        <div class="search-bar filter" id="search_bar">
            <span class="tit ml-10">筛选</span>
            <div class="change-btn-list mt-5 ml-10">
                <span class="change-btn-xz btnbox" id="website" data-url="box/index/type/weblist" data-result="result_webid">站点切换&nbsp;&gt;&nbsp;<span id="result_webid">全部</span></span>

            </div>

            <div class="change-btn-list mt-5 ml-10">
                <span class="change-btn-xz btnbox" id="destination" data-url="box/index/type/destlist" data-result="result_dest" >目的地&nbsp;&gt;&nbsp;<span id="result_dest">全部</span></span>

            </div>

            <div class="change-btn-list mt-5 ml-10">
                <span class="change-btn-xz btnbox" id="attrlist" data-url="box/index/type/attrlist/typeid/6" data-result="result_attrlist" >属性&nbsp;&gt;&nbsp;<span id="result_attrlist">全部</span></span>

            </div>

            <div class="pro-search ml-10" style=" float:left; margin-top:5px">
                <input type="text" id="searchkey" value="相册名称" datadef="相册名称" class="sty-txt1 set-text-xh wid_200">
                <input type="button" value="搜索" class="sty-btn1 default-btn wid_60" onclick="CHOOSE.searchKeyword()" >
            </div>

     <span class="display-mod">

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

            ST.Util.addTab('添加相册','{$cmsurl}photo/add/parentkey/article/itemid/3',0);
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
             'webid',
             'photoname',
             'kindlist',
             'attrid',
             'ishidden',
             'displayorder',
             'kindname',
             'attrname',
             'themelist',
             'modtime',
             'litpic'
         ],

         proxy:{
		   type:'ajax',
		   api: {
              read: SITEURL+'photo/photo/action/read',  //读取数据的URL
			  update:SITEURL+'photo/photo/action/save',
			  destroy:SITEURL+'photo/photo/action/delete'
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
	   width:"100%",
	   bodyBorder:0,
	   bodyStyle:'border-width:0px',
	   scroll:'vertical',
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
								       {text:'目的地',handler:function(){ CHOOSE.setSome(1,6)}},
									   {text:'属性',handler:function(){ CHOOSE.setSome(2,6)}},
									   {text:'专题',handler:function(){ CHOOSE.setSome(4,6)}},
									   {text:'图标',handler:function(){ CHOOSE.setSome(3,6)}}
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
				   width:'8%',
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
								
								  if(value==9999||value==999999||value==0)
								      return '';
							      else 
								      return value;		  
					 
					}

				  
			   },
			   {
				   text:'相册名称',
				   width:'18%',
				   dataIndex:'photoname',
				   align:'left',
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
					            var aid=record.get('aid');
							 var id=record.get('id');
									 
									 if(!isNaN(id))
			                           return "<a href='/photos/show_"+aid+".html' class='product-title' target='_blank'>"+value+"</a>";
						}
				  
			   },
			   {
				   text:'封面',
				   width:'18%',
				   dataIndex:'litpic',
				   align:'left',
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
					            var aid=record.get('aid');
							 var id=record.get('id');
									 
							if(!isNaN(id))
			                           return "<img height='80px' src='"+value+"'/>";           
						}
				  
			   },
			   {
				   text:'目的地',
				   width:'8%',
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
						 return "<a href='javascript:void(0);' onclick=\"ST.Destination.setDest(this,6,"+id+",'"+value+"',CHOOSE.destSetBack)\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    }
			   },  
			   {
				   text:'属性',
				   width:'8%',
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
                         var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						 return "<a href='javascript:void(0);' onclick=\"ST.Attrid.setAttrid(this,6,"+id+",'"+value+"',CHOOSE.attrSetBack)\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    }
			   },
			   {
				   text:'专题',
				   width:'8%',
				   align:'center',
				   sortable:false,
				  dataIndex:'themelist',
				  cls:'mod-1',
				   border:0,
				  renderer : function(value, metadata,record,rowIndex,colIndex) {
					
						 var id=record.get('id');
                         var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
						 return "<a href='javascript:void(0);' onclick=\"ST.Theme.setTheme(this,6,"+id+",'"+value+"',CHOOSE.themeSetBack)\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    }
				  
			   },
			   {
				   text:'隐藏',
				   width:'8%',
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
			      ]
				  
				  
			   },
			   {
				   text:'更新时间',
				   width:'9%',
				   align:'center',
				   border:0,
				   dataIndex:'modtime',
				   renderer : function(value, metadata,record) {
					     return value;

                    }
				  
			   },
			   {
				   text:'管理',
				   width:'11%',
				   align:'center',
				   border:0,
				   sortable:false,
				  renderer : function(value, metadata,record) {
					     var id=record.get('id');
                         var photoname=record.get('photoname');
						 return "<a href='javascript:void(0);' onclick=\"goModify('"+id+"')\">修改</a>";
						 	

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
						
			
			            if(window.product_kindname)
						{
							 Ext.getCmp('column_lineorder').setText(window.product_kindname+'-排序')
						}
						else
					    {
							Ext.getCmp('column_lineorder').setText('排序')
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
						  //var view_el=window.product_grid.getView().getEl();
						 // view_el.scrollBy(0,this.scroll_top,false);
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
	  var view_el=window.product_grid.getView().getEl();
	
	 
	  Ext.Ajax.request({
						 url   :  "photo/action/update",
						 method  :  "POST",
						 datatype  :  "JSON",
						 params:{id:id,field:field,val:value,kindid:window.product_kindid},
						 success  :  function(response, opts) 
						 {
							 if(response.responseText=='ok')
							 {
							  //var view_el=window.product_grid.getView().getEl()
	                            // var scroll_top=view_el.getScrollTop();				   
					   
							   record.set(field,value);
							   record.commit(); 
						      // view_el.scrollBy(0,scroll_top,false);
							 }
						 }});

  }


   //修改
   function goModify(id)
   {
       var url = SITEURL+'photo/edit/parentkey/article/itemid/3/photoid/'+id;

       parent.window.addTab('修改相册',url,1);
   }
</script>

</body>
</html>
