<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>访问记录-思途CMS3.0</title>
 {template 'stourtravel/public/public_js'}
 {php echo Common::getCss('style.css,base.css,base2.css,plist.css'); }
 {php echo Common::getScript("DatePicker/WdatePicker.js"); }

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
              &gt; 优化应用
              &gt; <span>智能链接</span>

   </div>

        <div class="add_menu-btn" style="border: none">
            <a href="javascript:;" id="addbtn" class="add-btn-class ml-10" style="margin-top: 50px;">添加</a>
            <a href="javascipt:;" id="genbtn" class="set-btn-class ml-10" style="margin-top: 50px;">生成</a>
        </div>

        <div class="filter">
            <span class="tit ml-10">筛选</span>


              <div id="agent_choose">

                  <select name="keywordtype" id="keywordtype" class="bd_style wid_100" onchange="goSearch(this.value,'keywordtype')">
                     <option value="0">全部</option>
                     <option value="1">主目标词</option>
                     <option value="2">目标性长尾词</option>
                     <option value="3">营销性长尾词</option>
                  </select>
              </div>
            <div class="pro-search" style="float: left;margin-top: 4px;">
                <input type="text" id="searchkey" value="关键字" datadef="关键字" class="searchkey sty-txt1 set-text-xh wid_200 ml10" />
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
   window.keytypemenu =[
       {"id":"1","name":"主目标词"},
       {"id":"2","name":"目标性长尾词"},
       {"id":"3","name":"营销性长尾词"}
     ];


   Ext.onReady(
    function() 
    {
		 Ext.tip.QuickTipManager.init();
         $(".searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            var url=SITEURL+"toollink/add/";
            ST.Util.showBox('添加关键词',url,500,'',function(){window.product_store.load()});
        });
        //生成按钮
        $("#genbtn").click(function(){
            var url=SITEURL+'toollink/gen/';
            ST.Util.showBox('生成链接',url,500,160,function(){});
        })

		//产品store
        window.product_store=Ext.create('Ext.data.Store',{

		 fields:[
             'id',
             'title',
             'type',
             'linkurl',
             'linelink',
             'hotellink',
             'carlink',
             'articlelink',
             'spotlink',
             'photolink',
             'visalink',
             'tuanlink'
         ],

         proxy:{
		   type:'ajax',
		   api: {
              read: SITEURL+'toollink/index/action/read',  //读取数据的URL
			  update:SITEURL+'toollink/index/action/save',
			  destroy:SITEURL+'toollink/index/action/delete'
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
				   text:'关键词',
				   width:'25%',
				   dataIndex:'title',
				   align:'left',
				   border:0,
                   editor:'textfield',
				   sortable:false,
				   renderer : function(value, metadata,record) {
                          return value;
			                       
						}
				  
			   },
               {
                   text:'关键词类型',
                   width:'10%',
                   dataIndex:'type',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       var id=record.get('id');
                       if(!isNaN(id))
                       {
                           var html="<select onchange=\"updateField(this,"+id+",'type',0,'select')\"><option>请选择</option>";
                           Ext.Array.each(window.keytypemenu, function(row, index, itelf) {
                               var is_selected=row.id==value?"selected='selected'":'';
                               html+="<option value='"+row.id+"' "+is_selected+">"+row.name+"</option>";
                           });
                           html+="</select>";
                           return html;

                       }

                   }

               },
               {
                   text:'链接URL',
                   width:'20%',
                   dataIndex:'linkurl',
                   align:'left',
                   border:0,
                   sortable:false,
                   editor:'textfield',
                   renderer : function(value, metadata,record) {
                       return value;
                   }

               },
               {
                   text:'线路',
                   width:'5%',
                   dataIndex:'linelink',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return "<span style='color:red'>"+value+"</span>";

                   }

               },
               {
                   text:'酒店',
                   width:'5%',
                   dataIndex:'hotellink',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return "<span style='color:red'>"+value+"</span>";

                   }

               },
               {
                   text:'租车',
                   width:'5%',
                   dataIndex:'carlink',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return "<span style='color:red'>"+value+"</span>";

                   }

               },
               {
                   text:'文章',
                   width:'5%',
                   dataIndex:'articlelink',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return "<span style='color:red'>"+value+"</span>";

                   }

               },

               {
                   text:'景点',
                   width:'5%',
                   dataIndex:'spotlink',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return "<span style='color:red'>"+value+"</span>";

                   }

               },
               {
                   text:'相册',
                   width:'5%',
                   dataIndex:'photolink',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return "<span style='color:red'>"+value+"</span>";

                   }

               },
               {
                   text:'签证',
                   width:'5%',
                   dataIndex:'visalink',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return "<span style='color:red'>"+value+"</span>";

                   }

               },
               {
                   text:'团购',
                   width:'5%',
                   dataIndex:'tuanlink',
                   align:'left',
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return "<span style='color:red'>"+value+"</span>";

                   }

               }


	           ],
			 listeners:{
		            boxready:function()
		            {
					
				
					   var height=Ext.dom.Element.getViewportHeight();
					   this.maxHeight=height-70;
					   this.doLayout();
		            },
					afterlayout:function(grid)
					{
						
			

/*
					   var data_height=0;
					   try{
					     data_height=grid.getView().getEl().down('.x-grid-table').getHeight();
					   }catch(e)
					   {
					   }
					  var height=Ext.dom.Element.getViewportHeight();

					  if(data_height>height-90)
					  {
						  window.has_biged=true;
						  grid.height=height-90;
					  }
					  else if(data_height<height-90)
					  {
						  if(window.has_biged)
						  {
							//delete window.grid.height;
							window.has_biged=false;  
							grid.doLayout();
						  }
					  }*/
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
	     window.product_grid.height=(height-90);
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

       var sttime = $.trim($("#starttime").val());
       var sttimedef = $("#starttime").attr('datadef');
       sttime = sttime==sttimedef ? '' : sttime;

       var ettime = $.trim($("#endtime").val());
       var ettimedef = $("#endtime").attr('datadef');
       ettime = ettime==ettimedef ? '' : ettime;

       window.product_store.getProxy().setExtraParam('sttime',sttime);
       window.product_store.getProxy().setExtraParam('ettime',ettime);
       window.product_store.getProxy().setExtraParam('keyword',keyword);
       window.product_store.load();
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
						 url   :  SITEURL+"toollink/index/action/update",
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
						 }});

  }
  

  



</script>

</body>
</html>
