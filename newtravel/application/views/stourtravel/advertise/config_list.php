<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>广告位管理-思途CMS3.0</title>
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
                <label>位置：</label>
                <a href="javascript:void(0);">首页</a>
                &gt; <a href="javascript:void(0);">营销策略</a>
                &gt; <a href="javascript:void(0);">广告位管理</a>
                <div class="pro-search">
                    <input type="text" id="searchkey" value="广告位置/调用标识" datadef="广告位置/调用标识" class="sty-txt1 set-text-xh wid_200" />
                    <input type="button" id="btn_search" value="搜索" onclick="search()" class="sty-btn1 default-btn wid_60" />
                </div>

            </div>
            <div class="add_menu-btn" style="border: none">
                <a href="javascript:;" id="addbtn" class="add-btn-class ml-10" style="margin-top: 50px;">添加</a>
            </div>

            <div id="product_grid_panel" class="content-nrt" >

            </div>
        </td>
    </tr>
</table>
<script>

window.display_mode = 1;	//默认显示模式
window.product_kindid = 0;  //默认目的地ID
window.TYPEMENU = [
    {'id':'1','name':'首页广告'},
    {'id':'2','name':'栏目广告'},
    {'id':'3','name':'自定义广告'},
]


Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        var editico = "{php echo Common::getIco('edit');}";
        var delico = "{php echo Common::getIco('del');}";

        $("#searchkey").focusEffect();

        //添加按钮
        $("#addbtn").click(function(){
            var url=SITEURL+"advertise/config_add/parentkey/sale/itemid/3";
            ST.Util.showBox('添加广告位',url,450,260,function(){window.product_store.load()});
        });

        //产品store
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'position',
                'tagname',
                'width',
                'height',
                'type',
                'issystem'
            ],

            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'advertise/config/action/read',  //读取数据的URL
                    update: SITEURL+'advertise/config/action/save',
                    destroy: SITEURL+'advertise/config/action/delete'
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
                    text: '广告位置',
                    width: '15%',
                    dataIndex: 'position',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    editor:'textfield',
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },

                {
                    text: '调用标识',
                    width: '15%',
                    dataIndex: 'tagname',
                    align: 'left',
                    border: 0,
                    sortable: false,

                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '宽度',
                    width: '15%',
                    dataIndex: 'width',
                    align: 'left',
                    border: 0,
                    editor:'textfield',
                    sortable: false,
                    renderer: function (value, metadata, record) {

                        return value;
                    }

                },
                {
                    text: '高度',
                    width: '15%',
                    dataIndex: 'height',
                    align: 'left',
                    border: 0,
                    editor:'textfield',
                    sortable: false,
                    renderer: function (value, metadata, record) {
                       return value;
                    }

                },
                {
                    text: '广告类型',
                    width: '15%',
                    dataIndex: 'type',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        var id=record.get('id');
                        if(!isNaN(id))
                        {

                            var html="<select onchange=\"updateField(this,"+id+",'type',0,'select')\"><option value='0'>选择</option>";

                            Ext.Array.each(window.TYPEMENU, function(row, index, itelf) {
                                var is_selected=row.id==value?"selected='selected'":'';
                                html+="<option value='"+row.id+"' "+is_selected+">"+row.name+"</option>";
                            });
                            html+="</select>";
                            return html;

                        }

                    }

                },

                {
                    text: '修改',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {

                        var id = record.get('id');
                        var issystem = record.get('issystem');
                        var html = "<a href='javascript:void(0);' onclick=\"modify(" + id + ","+issystem+")\">"+editico+"</a>";
                        return html;

                    }


                },
                {
                    text: '删除',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {

                        var id = record.get('id');
                        var issystem = record.get('issystem');
                        var html = "<a href='javascript:void(0);' onclick=\"delS(" + id + ","+issystem+")\">"+delico+"</a>";
                        return html;
                        // return getExpandableImage(value, metadata,record);
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
    if (data_height > height - 106)
        window.product_grid.height = (height - 106);
    else
       // delete window.product_grid.height;
    window.product_grid.doLayout();


})







//按进行搜索
function search() {
    var keyword = $.trim($("#searchkey").val());
    var datadef = $("#searchkey").attr('datadef');
    keyword = keyword==datadef ? '' : keyword;
    window.product_store.getProxy().setExtraParam('keyword',keyword);
    window.product_store.load();


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
    Ext.Msg.confirm("提示", "确定删除", function (buttonId) {
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
    console.log(record);
    if (type == 'select') {
        value = Ext.get(ele).getValue();
    }
    var view_el = window.product_grid.getView().getEl();


    Ext.Ajax.request({
        url: SITEURL+"advertise/config/action/update",
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
function delS(id,issystem) {
    if(issystem){
        ST.Util.showMsg('这是系统广告位,不能删除',5);
        return false;
    }

    Ext.Msg.confirm("提示", "确定删除吗？", function (buttonId) {


        if (buttonId == 'yes')
            window.product_store.getById(id.toString()).destroy();
    })
}








//刷新保存后的结果
function refreshField(id, arr) {
    id = id.toString();
    var id_arr = id.split('_');
    // var view_el=window.product_grid.getView().getEl()
    //var scroll_top=view_el.getScrollTop();
    Ext.Array.each(id_arr, function (num, index) {
        if (num) {
            var record = window.product_store.getById(num.toString());

            for (var key in arr) {
                record.set(key, arr[key]);
                record.commit();
                // view_el.scrollBy(0,scroll_top,false);
                // window.line_grid.getView().refresh();
            }
        }
    })
}


//修改
function modify(id)
{
    var url=SITEURL+"advertise/config_edit/parentkey/sale/itemid/3/id/"+id;
    ST.Util.showBox('修改广告位',url,450,260,function(){window.product_store.load()});
}

</script>

</body>
</html>
