<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('base.css,order.css,jqtransform.css'); }
    {php echo Common::getScript('jquery.jqtransform.js,hdate/hdate.js');}
    {php echo Common::getCss('hdate.css','js/hdate'); }

    <script language="javascript">
        $(function(){
            $('form').jqTransform({imgPath:'../images/img/'});
        });
    </script>
</head>

<body style="background-color: #fff">
<div class="derive_box">
    <div class="derive_tit">选择导出时间</div>
    <div class="derive_con">
        <form>
            <p class="pd">
                <input type="radio"  name="time" value="1" checked="checked">
                <label>今日</label>
            </p>
            <p class="pd">
                <input type="radio"  name="time" value="2">
                <label>昨日</label>
            </p>
            <p class="pd">
                <input type="radio"  name="time" value="3">
                <label>最近7天</label>
            </p>
            <p class="pd">
                <input type="radio"  name="time" value="5">
                <label>最近30天</label>
            </p>
            <p class="pd">
                <input type="radio"  name="time" value="6" >
                <label>自定义时间段</label>
                <input type="text" value="" id="starttime" onclick="calendar.show({ id: this })" />
                <span class="derive_arrow_rig"></span>
                <input type="text" id="endtime" onclick="calendar.show({ id: this })" />
            </p>
            <div class="now_derive_box"><a class="derive_btn btn_excel" href="javascript:;">立即导出</a></div>
        </form>
    </div>
</div>
</body>
<script>
    var typeid = '{$typeid}';
    $(function(){
       $(".btn_excel").click(function(){
           var timetype = $("input[name='time']:checked").val();

           var starttime = endtime = 0;
           if(timetype==6){
               var starttime = $('#starttime').val();
               var endtime = $("#endtime").val();
               if(starttime==''||endtime==''){
                   ST.Util.showMsg('请选择时间段',5,1000);
                   return false;
               }

           }
           var url = SITEURL+'order/genexcel/typeid/'+typeid+'/timetype/'+timetype+'?starttime='+starttime+'&endtime='+endtime;

           window.open(url);
       })

    })
</script>
</html>