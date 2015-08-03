<div class="web-set">
    <dl>
        <dt>站点：</dt>
        <dd>
            <a href="javascript:;" class="on" data-webid="0">主站</a>
            <?php $n=1; if(is_array($weblist)) { foreach($weblist as $k => $v) { ?>
            <a href="javascript:;" data-webid="<?php echo $v['webid'];?>"><?php echo $v['webname'];?></a>
            <?php $n++;}unset($n); } ?>
        </dd>
    </dl>
</div>
