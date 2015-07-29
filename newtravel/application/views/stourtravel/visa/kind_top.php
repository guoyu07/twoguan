<?php
$sub = Common::getConfig('menu_sub.visakind');
foreach($sub as $row)
{

    $link = "<span class='kinditem' data-url='".$row['url']."' data-name='".$row['name']."'><s></s>".$row['name']."</span>";
    echo $link;
}

?>
<script>
    $(function(){

        $('.kinditem').click(function(){


            var url = $(this).attr('data-url');
            var urlname = $(this).attr('data-name');
            ST.Util.addTab(urlname,url);
        })
    })


</script>
