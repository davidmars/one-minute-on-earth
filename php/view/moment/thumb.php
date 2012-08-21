<div class="span3 embed-vdo moment-small" data-embed-vdo="true" data-vdo-id="<?=$video->id?>" data-scroll-to-section="now-playing">
    <span class="bg">&nbsp;</span>
    <a href="#" class="thumbnail">
        <img class="thumb" src="<?=$video->thumbUrl?>" alt="">
        <img class="map" src="<?=$video->geoPlace->mapUrl?>" alt="">
    </a>
    <div class="text">
        <h3 class="fs0">
            <a href="<?=$video->url()?>">
                <span class="city"><?=$video->geoPlace->city?>, </span>
                <span class="country"><?=$video->geoPlace->country?></span>
            </a>
        </h3>
        <div class="fs0">
            <span class="date"><?=date("l dS F Y",$video->date)?></span>
        </div>
        <div class="">
            <span class=""><?=$video->id?></span>
        </div>
    </div>
    <div class=""><a class="author" href="<?=$video->authorUrl?>" target="_blank"><?=$video->author?>@<?=$video->embedEngine?></a></div>

</div>