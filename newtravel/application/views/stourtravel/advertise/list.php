<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>广告管理-思途CMS3.0</title>
 {template 'stourtravel/public/public_js'}
 {php echo Common::getCss('style.css,base.css,base2.css,plist.css'); }

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
              &gt;营销策略
              &gt;广告管理
              &gt; <span>广告列表</span>
   </div>
        <div class="add_menu-btn" style="border: none">
            <a href="javascript:;" id="addbtn" class="add-btn-class ml-10" style="margin-top: 50px;">添加</a>
            <a href="javascipt:;" id="configbtn" class="set-btn-class ml-10" style="margin-top: 50px;">设置</a>
        </div>
        <div class="filter">
            <span class="tit ml-10">筛选</span>

                <select name="weblist" id="weblist" class="bd_style wid_100" onchange="goSearch(this.value,'webid')">
                    <option value="0">所属站点</option>


                </select>
                <select name="adtype" id="adtype" class="bd_style wid_100" onchange="goSearch(this.value,'adtype')">
                    <option value="0">全部广告</option>
                    <option value="1">首页广告</option>
                    <option value="2">栏目广告</option>
                    <option value="3">自定义广告</option>
                </select>
            <div class="pro-search" style="float: left;margin-top: 4px;">
                <input type="text" id="searchkey" value="广告位置/调用标识" datadef="广告位置/调用标识" class="sty-txt1 set-text-xh wid_200 ml10" />
                <input type="button" id="btn_search" value="搜索" onclick="search()" class="sty-btn1 default-btn wid_60" />
            </div>

        </div>

 <div id="product_grid_panel" class="content-nrt">
    
  </div>
  </td>
  </tr>
 </table> 
<script>


   window.display_mode=1;	//默认显示模式
   window.product_kindid=0;  //默认目的地ID
   var editico = "{php echo Common::getIco('edit');}";
   var delico = "{php echo Common::getIco('del');}";
   var previewico = "{php echo Common::getIco('preview');}";


  Ext.onReady(
    function() 
    {
		 Ext.tip.QuickTipManager.init();
         $("#searchkey").focusEffect();
        //添加广告
         $("#addbtn").click(function(){

             var url = SITEURL+"advertise/add/parentkey/sale/itemid/1";
             ST.Util.addTab('添加广告',url);

         })
        //广告位设置
        $("#configbtn").click(function(){

            var url = SITEURL+"advertise/config/parentkey/sale/itemid/1";
            ST.Util.addTab('广告位配置',url);

        })
		 
		 var web_menu_items=[];
		 Ext.Array.each(window.WEBLIST,function(row,index,itself){
              var option = "<option value="+row.webid+">"+row.webname+"</option>";
              $("#weblist").append(option);
							    // web_menu_items.push({text:row.webname,webid:row.webid});
		 });

		
		/* Ext.create('Ext.button.Cycle',{
			   renderTo:'list_ot_web',
			   text:'主站',
			   showText:true,
			   style:"background:#07C3D9",
			   menu:{
				   items:web_menu_items
			   },
			   changeHandler: function(cycleBtn, activeItem) {
                       if(!window.web_togfirst)
					   {
						   window.web_togfirst=1;
					       return;
					   }
					  window.product_store.getProxy().setExtraParam('webid',activeItem.webid);
					  window.product_store.load({start:0});
					   
                   }
			 
			 });*/

		//产品store
        window.product_store=Ext.create('Ext.data.Store',{

		 fields:[
             'id',
             'displayorder',
             'tagname',
             'adposition',
             'linktext',
             'linkurl',
             'picurl'
         ],

         proxy:{
		   type:'ajax',
		   api: {
              read: SITEURL+'advertise/index/action/read',  //读取数据的URL
			  update:SITEURL+'advertise/index/action/save',
			  destroy:SITEURL+'advertise/index/action/delete'
              },
		      reader:{
                type: 'json',   //获取数据的格式 
                root: 'lists',
                totalProperty: 'total'
                }	
	         },
		 remoteSort:true,
         autoLoad:true,
		 pageSize:30,
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
								
								  if(value==9999||value==999999||value==0)
								      return '';
							      else 
								      return value;		  
					 
					}

				  
			   },
			   {
				   text:'广告位置',
				   width:'10%',
				   dataIndex:'adposition',
				   align:'left',
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
					         return value;
			                       
						}
				  
			   },
               {
                   text:'广告标识',
                   width:'10%',
                   dataIndex:'tagname',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return value;

                   }

               },
               {
                   text:'预览',
                   width:'8%',
                   align:'center',
                   dataIndex:'id',
                   border:0,
                   sortable:false,
                   cls:'mod-1',
                   renderer : function(value, metadata,record,rowIndex,colIndex) {
                       var litpic = record.get('picurl');
                       var html = "<a href='javascript:void(0);' onclick=\"preview('" + litpic + "',this)\">"+previewico+"</a>";

                       return html;
                   }


               },
			   {
				   text:'广告主题',
				   width:'25%',
				   dataIndex:'linktext',
				   align:'center',
				   cls:'mod-1',
                   editor:'textfield',
				   sortable:false,
				   renderer : function(value, metadata,record,rowIndex,colIndex) {
					   return value;
                    }


				  
			   },
			   {
				 text:'链接url',
				   width:'20%',
				   align:'center',
				   dataIndex:'linkurl',
				   border:0,
                   editor:'textfield',
				   cls:'mod-1',
				   sortable:false,
				   renderer : function(value, metadata,record,rowIndex,colIndex) {
					  
					   return value;
                    }
				 
  
			   },


			   {
				   text:'修改',
				   width:'9%',
				   align:'center',
				   border:0,
				   sortable:false,
				  renderer : function(value, metadata,record) {
                      var id = record.get('id');
                      var html = "<a href='javascript:void(0);' onclick=\"modify(" + id + ")\">"+editico+"</a>";

                      return html;
						 	
                                   // return getExpandableImage(value, metadata,record);
                    }
				  
			   },

               {
                   text:'删除',
                   width:'9%',
                   align:'center',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       var id = record.get('id');
                       var html = "<a href='javascript:void(0);' onclick=\"delS(" + id + ")\">"+delico+"</a>";

                       return html;

                       // return getExpandableImage(value, metadata,record);
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
							//delete window.grid.height;
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
	
	
	 
	 	
	

	


  
  
  
  //进行搜索
  function goSearch(val,field)
  {

	  window.product_store.getProxy().setExtraParam(field,val);
	  window.product_store.load();
	  
  }

   //按进行搜索
   function search() {
       var keyword = $.trim($("#searchkey").val());
       var datadef = $("#searchkey").attr('datadef');
       keyword = keyword==datadef ? '' : keyword;
       goSearch(keyword,'keyword');

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
	  //window.product_grid.down('gridcolumn').hide();
	  
	  var check_cmp=Ext.select('.product_check:checked');
	  
	  if(check_cmp.getCount()==0)
	  {
		  return;
	  }
	   Ext.Msg.confirm("提示","确定删除",function(buttonId){
		    if(buttonId!='yes')
		       return;
	 check_cmp.each(
		  function(el,c,index)
				{
						window.product_store.getById(el.getValue()).destroy();	 
				}
			 );
	   })
  }
   //删除套餐
   function delS(id) {
       Ext.Msg.confirm("提示", "确定删除吗？", function (buttonId) {
           if (buttonId == 'yes')
               window.product_store.getById(id.toString()).destroy();
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
						 url   :  SITEURL+"advertise/index/action/update",
						 method  :  "POST",
						 datatype  :  "JSON",
						 params:{id:id,field:field,val:value,kindid:window.product_kindid},
						 success  :  function(response, opts) 
						 {
							 if(response.responseText=='ok')
							 {
							 
							   record.set(field,value);
							   record.commit(); 
						      
							 }
                             else{
                                 ST.Util.showMsg("{__('norightmsg')}",5,1000);
                             }
						 }
      });

  }
  

  
  //刷新保存后的结果
  function refreshField(id,arr)
  {
	  id=id.toString();
	  var id_arr=id.split('_');
	//  var view_el=window.product_grid.getView().getEl()
	 // var scroll_top=view_el.getScrollTop();				   			      
	  Ext.Array.each(id_arr,function(num,index)
	  {
		   if(num)
		   {
		     var record=window.product_store.getById(num.toString());
			 
			 for(var key in arr)
			 {
				 record.set(key,arr[key]);
				 record.commit();
				
			 }
		   }
	  })
  }

  //修改
    function modify(id)
    {
        var url = SITEURL+'advertise/edit/parentkey/sale/itemid/1/id/'+id;

        parent.window.addTab('修改广告',url,1);
    }
//预览
   function preview(litpic,obj)
   {
       var d = parent.window.dialog({
           content: '<img src="'+litpic+'">',
           title: '',
           quickClose: true,
           align: 'bottom'
       });

       d.show(obj);
   }
</script>

</body>
</html>
