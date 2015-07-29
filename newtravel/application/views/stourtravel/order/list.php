<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>问答管理-思途CMS3.0</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,order.css'); }

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
                首页
                &gt; 订单中心
                &gt; <span>{$position}</span>
                <div class="pro-search">
                    <input type="text" id="searchkey" value="订单号/产品名称/联系人" datadef="订单号/产品名称/联系人" class="sty-txt1 set-text-xh wid_200" />
                    <input type="button" id="btn_search" value="搜索" onclick="search()" class="sty-btn1 default-btn wid_60" />
                </div>

            </div>
            <div class="add_menu-btn" style="border: none">
                <!--<a href="javascript:;" id="addbtn" class="add-btn-class ml-10" style="margin-top: 50px;">添加</a>-->
                <div id="list_ot_web" style="float: left;margin-top: 50px;margin-left: 5px;">

                </div>
                <div id="sellinfo" style="float: left;margin-top: 50px;margin-left: 5px;width:90%">
                    <p id="btn" style="float: left"><a href="javascript:;" class="btn_order btn_report" title="查看数据报表">数据报表</a>&nbsp;&nbsp;<a href="javascript:;" class="btn_order btn_excel" title="导出Excel报表">导出Excel</a></p>
                        <div id="sell_info_list">
                        <ul>
                          <li>  &nbsp;&nbsp;今日:<span id="today_price">11111</span> &nbsp;&nbsp;</li>
                          <li>| &nbsp;&nbsp;昨日:<span id="last_price">11111</span> &nbsp;&nbsp;</li>
                          <li>| &nbsp;&nbsp;本周:<span id="thisweek_price">11111</span> &nbsp;&nbsp;</li>
                          <li>| &nbsp;&nbsp;本月:<span id="thismonth_price">11111</span> &nbsp;&nbsp;</li>
                          <li>| &nbsp;&nbsp;总销售额:<span id="total_price">11111</span> &nbsp;&nbsp;</li>
                        </ul>
                    </div>

                </div>
            </div>



            <div id="product_grid_panel" class="content-nrt" >

            </div>
        </td>
    </tr>
</table>
<script>

window.display_mode = 1;	//默认显示模式
window.product_kindid = 0;  //默认目的地ID

window.statusmenu=[
    {"status":"0","name":"未处理"},
    {"status":"1","name":"处理中"},
    {"status":"2","name":"交易成功"},
    {"status":"3","name":"取消订单"}
];


Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        var editico = "{php echo Common::getIco('edit');}";
        var delico = "{php echo Common::getIco('del');}";

        $("#searchkey").focusEffect();

        //站点切换
        var web_menu_items=[];
        Ext.Array.each(window.WEBLIST,function(row,index,itself){
            web_menu_items.push({text:row.webname,webid:row.webid});
        });

        Ext.create('Ext.button.Cycle',{
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

        });


        //产品store
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'typeid',
                'ordersn',
                'productname',
                'addtime',
                'usedate',
                'dingnum',
                'price',
                'childprice',
                'childnum',
                'linkman',
                'status'

            ],

            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'order/index/action/read/typeid/{$typeid}',  //读取数据的URL
                    update: SITEURL+'order/index/action/save/typeid/{$typeid}',
                    destroy: SITEURL+'order/index/action/delete/typeid/{$typeid}'
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
                    text: '订单号',
                    width: '10%',
                    dataIndex: 'ordersn',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },

                {
                    text: '产品名称',
                    width: '25%',
                    dataIndex: 'productname',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '申请日期',
                    width: '10%',
                    dataIndex: 'addtime',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {

                        return value;
                    }

                },
                {
                    text: '使用日期',
                    width: '10%',
                    dataIndex: 'usedate',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                       return value;
                    }

                },
                {
                    text: '预订数量',
                    width: '5%',
                    dataIndex: 'dingnum',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                       return value;

                    }

                },
                {
                    text: '价格(成人)',
                    width: '10%',
                    dataIndex: 'price',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;

                    }

                },
                {
                    text: '订单状态',
                    width: '8%',
                    dataIndex: 'status',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        var id=record.get('id');
                        if(!isNaN(id))
                        {

                            var html="<select onchange=\"updateField(this,"+id+",'status',0,'select')\"><option>所有</option>";
                            Ext.Array.each(window.statusmenu, function(row, index, itelf) {
                                var is_selected=row.status==value?"selected='selected'":'';
                                html+="<option value='"+row.status+"' "+is_selected+">"+row.name+"</option>";
                            });
                            html+="</select>";
                            return html;

                        }

                    }

                },

                {
                    text: '查看',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {

                        var id = record.get('id');
                        var typeid = record.get('typeid');
                        var html = "<a href='javascript:void(0);' onclick=\"view(" + id + ","+typeid+")\">"+editico+"</a>";

                        return html;
                        // return getExpandableImage(value, metadata,record);
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
                        var html = "<a href='javascript:void(0);' onclick=\"delS(" + id + ")\">"+delico+"</a>";
                        return html;
                        // return getExpandableImage(value, metadata,record);
                    }


                }



            ],
            listeners: {
                boxready: function () {


                    var height = Ext.dom.Element.getViewportHeight();
                    //console.log('viewportHeight:'+height);
                    this.maxHeight = height-90 ;
                    this.doLayout();
                },
                afterlayout: function (grid) {






               /*    var data_height = 0;
                    try {
                        data_height = grid.getView().getEl().down('.x-grid-table').getHeight();
                    } catch (e) {
                    }
                    var height = Ext.dom.Element.getViewportHeight();
                    console.log(data_height+'---'+height);
                    if (data_height > height - 106) {
                        window.has_biged = true;
                        grid.height = height - 106;
                    }
                    else if (data_height < height - 106) {
                        if (window.has_biged) {
                            delete window.grid.height;
                            window.has_biged = false;
                            grid.doLayout();
                        }
                    }*/
                }
            },
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 2,
                    listeners: {
                        edit: function (editor, e) {
                            var id = e.record.get('mid');
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
    if (data_height > height - 140)
        window.product_grid.height = (height - 140);
    else
       // delete window.product_grid.height;
    window.product_grid.doLayout();


})



$(function(){


    var typeid = "{$typeid}";
    var channelname = "{$channelname}";
    //查看数据报表
    $(".btn_report").click(function(){
        var url=SITEURL+"order/dataview/typeid/"+typeid;
        ST.Util.showBox(channelname+'订单数据报表查看',url,860,510,function(){});

    })
    //导出excel
    $(".btn_excel").click(function(){
        var url=SITEURL+"order/excel/typeid/"+typeid;
        ST.Util.showBox(channelname+'订单生成excel',url,560,380,function(){});
    })

    //获取当前产品订单常规信息
    $.getJSON(SITEURL+'order/ajax_sell_info/typeid/'+typeid,function(data){
        $("#today_price").html(data.today);
        $("#last_price").html(data.last);
        $("#thisweek_price").html(data.thisweek);
        $("#thismonth_price").html(data.thismonth);
        $("#total_price").html(data.total);

    })





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

    if (type == 'select') {
        value = Ext.get(ele).getValue();
    }
    var view_el = window.product_grid.getView().getEl();


    Ext.Ajax.request({
        url: SITEURL+"order/index/action/update/",
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


//查看订单
function view(id,typeid)
{
    var url=SITEURL+"order/view/id/"+id+"/typeid/"+typeid;
    ST.Util.showBox('查看订单信息',url,450,300,function(){window.product_store.load()});
}

</script>

</body>
</html>
