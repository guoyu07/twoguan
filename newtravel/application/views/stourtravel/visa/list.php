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
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">

            <div class="crumbs" id="dest_crumbs">
                <label>位置：</label>
                首页
                &gt;产品中心
                &gt;签证管理
                &gt;<span>签证列表</span>
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
                    <span class="change-btn-xz btnbox" id="visatype" data-url="box/index/type/visatype" data-result="result_visatype" >签证类型&nbsp;&gt;&nbsp;<span id="result_visatype">全部</span></span>
                </div>
                <div class="change-btn-list mt-5 ml-10">
                    <span class="change-btn-xz btnbox" id="visacity" data-url="box/index/type/visacity" data-result="result_visacity" >签发城市&nbsp;&gt;&nbsp;<span id="result_visacity">全部</span></span>
                </div>

                <div class="pro-search ml-10" style=" float:left; margin-top:5px">
                    <input type="text" id="searchkey" value="签证名称/签证编号" datadef="签证名称/签证编号" class="sty-txt1 set-text-xh wid_200">
                    <input type="button" value="搜索" class="sty-btn1 default-btn wid_60" onclick="CHOOSE.searchKeyword()" >
                </div>

     <span class="display-mod">
       <span class="list-1 fl"><a href="javascript:void(0);" title="基本信息" class="on" onClick="CHOOSE.togMod(this,1)">基本信息</a></span>
       <span class="list-3 fl"><a href="javascript:void(0);" title="供应商" onClick="CHOOSE.togMod(this,3)">供应商</a></span>
     </span>
            </div>
            <div id="product_grid_panel" class="content-nrt">

            </div>
        </td>
    </tr>
</table>
<script>

window.display_mode = 1;	//默认显示模式
window.product_kindid = 0;  //默认目的地ID
window.kindmenu = {$kindmenu};//分类设置菜单


Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        $(".btnbox").buttonBox();

        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){

            ST.Util.addTab('添加签证','{$cmsurl}visa/add/parentkey/product/itemid/5',0);
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
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'aid',
                'series',
                'title',
                'ishidden',
                'displayorder',
                'iconlist',
                'iconname',
                'themelist',
                'visakind',
                'visacity',
                'price',
                'jifenbook',
                'jifentprice',
                'jifencomment',
                'suppliername',
                'linkman',
                'mobile',
                'qq',
                'address'
            ],

            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'visa/visa/action/read',  //读取数据的URL
                    update: SITEURL+'visa/visa/action/save',
                    destroy: SITEURL+'visa/visa/action/delete'
                },
                reader: {
                    type: 'json',   //获取数据的格式
                    root: 'lists',
                    totalProperty: 'total'
                }
            },

            remoteSort: true,
            pageSize: 30,
            autoLoad: true,
            listeners: {
                load:function( store, records, successful, eOpts )
                {
                    if(!successful){
                        ST.Util.showMsg("{__('norightmsg')}",5,1000);
                    }


                }
            }

        });

        //产品列表
        window.product_grid = Ext.create('Ext.grid.Panel', {
            store: product_store,
            padding: '2px',
            renderTo: 'product_grid_panel',
            border: 0,
            width: "100%",
            bodyBorder: 0,
            bodyStyle: 'border-width:0px',
            scroll:'vertical', //只要垂直滚动条
                bbar: Ext.create('Ext.toolbar.Paging', {
                store: product_store,  //这个和grid用的store一样
                displayInfo: true,
                emptyMsg: "",
                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: '每页显示数量',
                        width: 170,
                        labelAlign: 'right',
                        forceSelection: true,
                        value: 30,
                        store: {fields: ['num'], data: [
                            {num: 30},
                            {num: 60},
                            {num: 100}
                        ]},
                        displayField: 'num',
                        valueField: 'num',
                        listeners: {
                            select: CHOOSE.changeNum
                        }
                    }

                ],

                listeners: {
                    single: true,
                    render: function (bar) {
                        var items = this.items;
                        bar.down('tbfill').hide();

                        bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="abtn" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="abtn" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="abtn" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));

                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                        //items.add(Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns: [
                {
                    text: '选择',
                    width: '5%',
                    // xtype:'templatecolumn',
                    tdCls: 'product-ch',
                    align: 'center',
                    dataIndex: 'id',
                    border: 0,
                    renderer: function (value, metadata, record) {

                        return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='" + value + "'/>";

                    }

                },
                {
                    text: '排序',
                    width: '5%',
                    dataIndex: 'displayorder',
                    tdCls: 'product-order',
                    id: 'column_lineorder',
                    align: 'center',
                    border: 0,
                    editor: 'textfield',
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');

                        if (value == 9999 || value == 999999 || value == 0)
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
                    text: '签证名称',
                    width: '20%',
                    dataIndex: 'title',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        var iconname = record.get('iconname');
                        var aid=record.get('aid');
                        return "<a href='/visa/show_"+aid+".html' class='product-title' target='_blank'>"+value+iconname+"</a>";

                    }

                },
                {
                    text: '签证类型',
                    width: '10%',
                    dataIndex: 'visakind',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {

                        return value;
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
                    text: '签发城市',
                    width: '8%',
                    dataIndex: 'visacity',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;
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
                    text: '图标',
                    width: '5%',
                    align: 'center',
                    dataIndex: 'iconlist',
                    border: 0,
                    cls: 'mod-1',
                    sortable: false,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {

                        var id = record.get('id');
                        var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
                        return "<a href='javascript:void(0);' onclick=\"ST.Icon.setIcon(this,8," + id + ",'" + value + "',CHOOSE.iconSetBack)\">" + d_text + "</a>";
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
                    text: '专题',
                    width: '5%',
                    align: 'center',
                    sortable: false,
                    dataIndex: 'themelist',
                    cls: 'mod-1',
                    border: 0,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {

                        var id = record.get('id');
                        var d_text=value?'<span style="color:green">已设</span>':'<span style="color:red">未设</span>';
                        return "<a href='javascript:void(0);' onclick=\"ST.Theme.setTheme(this,8," + id + ",'" + value + "',CHOOSE.themeSetBack)\">" + d_text + "</a>";
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
                    text: '价格',
                    width: '5%',
                    dataIndex: 'price',
                    align: 'left',
                    border: 0,
                    editor:'textfield',
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;
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
                    text: '预订送积分',
                    width: '5%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    dataIndex: 'jifenbook',
                    editor: 'textfield',
                    cls: 'mod-2',
                    renderer: function (value, metadata, record) {
                        return value;
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
                    text: '积分抵现金',
                    width: '5%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    editor: 'textfield',
                    dataIndex: 'jifentprice',
                    cls: 'mod-2',
                    renderer: function (value, metadata, record) {
                        return value;
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
                    text: '评论送积分',
                    width: '5%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    editor: 'textfield',
                    dataIndex: 'jifencomment',
                    cls: 'mod-2',
                    renderer: function (value, metadata, record) {
                      return value;
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
                    text: '隐藏',
                    width: '5%',
                    // xtype:'templatecolumn',
                    align: 'center',
                    border: 0,
                    dataIndex: 'ishidden',
                    xtype: 'actioncolumn',
                    cls: 'mod-1',
                    items: [
                        {
                            getClass: function (v, meta, rec) {          // Or return a class from a function
                                if (v == 1)
                                    return 'dest-status-ok';
                                else
                                    return 'dest-status-none';
                            },
                            handler: function (view, index, colindex, itm, e, record) {
                                // togStatus(null,record,'ishidden');
                                var val = record.get('ishidden');
                                var id = record.get('id');
                                var newval = val == 1 ? 0 : 1;
                                updateField(null, record.get('id'), 'ishidden', newval)

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
                    text: '管理',
                    width: '13%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {

                        var id = record.get('id');
                        return "<a href='javascript:void(0);' onclick=\"goModify(" + id + ")\">修改";
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
                    width:'13%',
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

                }


            ],
            listeners: {
                boxready: function () {


                    var height = Ext.dom.Element.getViewportHeight();
                    this.maxHeight = height ;
                    this.doLayout();
                },
                afterlayout: function (grid) {


                    if (window.product_kindname) {
                        Ext.getCmp('column_lineorder').setText(window.product_kindname + '-排序')
                    }
                    else {
                        Ext.getCmp('column_lineorder').setText('排序')
                    }

                    window.product_store.each(function (record) {
                        id = record.get('id');

                        if (id.indexOf('suit') != -1) {

                            var ele = window.product_grid.getView().getNode(record);
                            var cls = record.get('tr_class');
                            Ext.get(ele).addCls(cls);
                            Ext.get(ele).setVisibilityMode(Ext.Element.DISPLAY);
                            if (window.display_mode != 2) {
                                Ext.get(ele).hide();
                            }
                            else {
                                Ext.get(ele).show();
                            }

                        }
                        else if (window.display_mode == 2) {
                            var ele = window.product_grid.getView().getNode(record);
                            var cls = record.get('tr_class');
                            Ext.get(ele).addCls(cls);
                        }

                    });

                    var data_height = 0;
                    try {
                        data_height = grid.getView().getEl().down('.x-grid-table').getHeight();
                    } catch (e) {
                    }
                    var height = Ext.dom.Element.getViewportHeight();
                    // console.log(data_height+'---'+height);
                    if (data_height > height - 106) {
                        window.has_biged = true;
                        grid.height = height - 106;
                    }
                    else if (data_height < height - 106) {
                        if (window.has_biged) {
                           // delete window.grid.height;
                            window.has_biged = false;
                            grid.doLayout();
                        }
                    }
                }
            },
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 2,
                    listeners: {
                        edit: function (editor, e) {
                            var id = e.record.get('id');
                            //  var view_el=window.product_grid.getView().getEl();
                            //  view_el.scrollBy(0,this.scroll_top,false);
                            updateField(0, id, e.field, e.value, 0);
                            return false;

                        }

                    }
                })
            ],
            viewConfig: {

            }
        });


    })

//实现动态窗口大小
Ext.EventManager.onWindowResize(function () {
    var height = Ext.dom.Element.getViewportHeight();
    var data_height = window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
    if (data_height > height - 120)
        window.product_grid.height = (height - 120);
    else
       // delete window.product_grid.height;
    window.product_grid.doLayout();


})




//更新某个字段
function updateField(ele, id, field, value, type) {
    var record = window.product_store.getById(id.toString());
    if (type == 'select') {
        value = Ext.get(ele).getValue();
    }
    var view_el = window.product_grid.getView().getEl();


    Ext.Ajax.request({
        url: SITEURL+"visa/visa/action/update",
        method: "POST",
        datatype: "JSON",
        params: {id: id, field: field, val: value, kindid: 0},
        success: function (response, opts) {
            if (response.responseText == 'ok') {


                record.set(field, value);
                record.commit();
                // view_el.scrollBy(0,scroll_top,false);
            }
        }});

}


//删除套餐
function del(id) {
    Ext.Msg.confirm("提示", "确定删除吗？", function (buttonId) {
        if (buttonId == 'yes')
            window.product_store.getById(id).destroy();
    })
}




//修改
function goModify(id)
{
    var url = SITEURL+'visa/edit/parentkey/product/itemid/5/id/'+id;

    parent.window.addTab('修改签证',url,0);
}

</script>

</body>
</html>
