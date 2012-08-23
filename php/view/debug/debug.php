<div class="row">
    <div class="span8">
        
        
        
        <h2 class="fs0">File cache logs</h2>

        <? foreach(FileCache::$logs as $log): ?>
        <p <?if($log->hasBeenRefreshed):?>style="color:#f00;" <?endif?>>
                <?foreach($log as $k=>$v):?>
                    <b><?=$k?> : </b><br> 
                    <?=$v?><br/>
                <? endforeach;?>
        </p>
        <? endforeach;?>






    </div>



</div>