<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>扩展属性-思途CMS3.0</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css'); }

</head>
<style>
    /*搜索*/

</style>
<body style="overflow:hidden">
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">

            <div class="crumbs" id="dest_crumbs">
                <label>位置：</label>首页 &gt; 设置中心 &gt; {$channelname}设置 &gt; <span>扩展字段设置</span>

            </div>

            <div class="list-top-set">
                <div class="list-web-pad"></div>
                <div class="list-web-ct">
                    <div class="list-web-ct-lt" id="list_ot_set">
                        <a href="javascript:;" id="addbtn" class="add-btn-class ml-10">添加</a>
                    </div>
                </div>
            </div>

            <div id="product_grid_panel" class="content-nrt">

            </div>
        </td>
    </tr>
</table>
<script>

window.display_mode = 1;	//默认显示模式
window.product_kindid = 0;  //默认目的地ID



Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();

        //添加按钮
        $("#addbtn").click(function(){
            var url=SITEURL+"attrid/extendlist/action/add/typeid/{$typeid}";
            ST.Util.showBox('添加{$channelname}扩展字段',url,'350','200',function(){window.product_store.load()});
        });

        //产品store
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'fieldname',
                'fieldtype',
                'isopen',
                'description'
            ],

            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'attrid/extendlist/action/read/typeid/{$typeid}',  //读取数据的URL
                    destroy:  SITEURL+'attrid/extendlist/action/delete/typeid/{$typeid}'

                },
                reader: {
                    type: 'json',   //获取数据的格式
                    root: 'lists',
                    totalProperty: 'total'
                }
            },

            remoteSort: true,
            pageSize: 50,
            autoLoad: true,
            listeners: {
                load: function (store, records, successful, eOpts) {

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
                            select: changeNum
                        }
                    }

                ],

                listeners: {
                    single: true,
                    render: function (bar) {
                        var items = this.items;
                        bar.down('tbfill').hide();

                        bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="abtn" href="javascript:void(0);" onclick="chooseAll()">全选</a><a class="abtn" href="javascript:void(0);" onclick="chooseDiff()">反选</a><a class="abtn" href="javascript:void(0);" onclick="del()">删除</a></div>'}));

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
                    text: '字段名称',
                    width: '15%',
                    dataIndex: 'fieldname',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {

                            return value;
                    }

                },
                {
                    text: '描述',
                    width: '35%',
                    dataIndex: 'description',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {

                        return value;
                    }

                },

                {
                    text: '字段类型',
                    width: '30%',
                    dataIndex: 'fieldtype',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text:'可用状态',
                    width:'20%',
                    align:'center',
                    border:0,
                    dataIndex:'isopen',
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
                                togStatus(null,record,'isopen');

                            }
                        }
                    ]



                }








            ],
            listeners: {
                boxready: function () {


                    var height = Ext.dom.Element.getViewportHeight();
                    this.maxHeight = height ;
                    this.doLayout();
                },
                afterlayout: function (grid) {


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

            ],
            viewConfig: {

            }
        });


    })

//实现动态窗口大小
Ext.EventManager.onWindowResize(function () {
    var height = Ext.dom.Element.getViewportHeight();
    var data_height = window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
    if (data_height > height - 106)
        window.product_grid.height = (height - 106);
    else
       // delete window.product_grid.height;
    window.product_grid.doLayout();


})



function togStatus(obj, record, field) {
    var val = record.get(field);
    var id = record.get('id');
    id = id.substr(id.indexOf('_') + 1);
    var newval = val == 1 ? 0 : 1;
    Ext.Ajax.request({
        url: SITEURL+"attrid/extendlist/action/update",
        method: "POST",
        datatype: "JSON",
        params: {id: id, field: field, val: newval},
        success: function (response, opts) {
            if (response.responseText == 'ok') {
                record.set(field, newval);
                record.commit();
            }
        }});

}





//切换每页显示数量
function changeNum(combo, records) {

    var pagesize = records[0].get('num');
    window.product_store.pageSize = pagesize;
    window.product_grid.down('pagingtoolbar').moveFirst();
    //window.product_store.load({start:0});
}
//选择全部
function chooseAll() {
    var check_cmp = Ext.query('.product_check');
    for (var i in check_cmp) {
        if (!Ext.get(check_cmp[i]).getAttribute('checked'))
            check_cmp[i].checked = 'checked';
    }

    //  window.sel_model.selectAll();
}
//反选
function chooseDiff() {
    var check_cmp = Ext.query('.product_check');
    for (var i in check_cmp)
        check_cmp[i].click();

}
function del() {
    //window.product_grid.down('gridcolumn').hide();

    var check_cmp = Ext.select('.product_check:checked');

    if (check_cmp.getCount() == 0) {
        return;
    }
    Ext.Msg.confirm("提示", "删除操作会删除已有的数据,确定删除吗?", function (buttonId) {
        if (buttonId != 'yes')
            return;
        check_cmp.each(
            function (el, c, index) {
                window.product_store.getById(el.getValue()).destroy();
            }
        );
    })
}


//更新某个字段
function updateField(ele, id, field, value, type) {
    var record = window.product_store.getById(id.toString());

    if (type == 'select') {
        value = Ext.get(ele).getValue();
    }
    var view_el = window.product_grid.getView().getEl();


    Ext.Ajax.request({
        url: SITEURL+"hotsearch/index/action/update",
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
function delS(id) {
    Ext.Msg.confirm("提示", "确定删除吗？", function (buttonId) {
        if (buttonId == 'yes')
            window.product_store.getById(id.toString()).destroy();
    })
}




//修改
function modify(id)
{
    var url=SITEURL+"hotsearch/edit/parentkey/supplier/itemid/2/id/"+id;
    ST.Util.showBox('修改供应商信息',url,600,400,function(){window.product_store.load()});
}

</script>

</body>
</html>
