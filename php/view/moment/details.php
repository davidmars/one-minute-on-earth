<div class="row mt2">

            <div class="span1">1</div>
            <div class="span1">2</div>
            <div class="span1">3</div>
            <div class="span1">4</div>
            <div class="span1">5</div>
            <div class="span1">6</div>
            <div class="span1">7</div>
            <div class="span1">8</div>
            <div class="span1">9</div>
            <div class="span1">10</div>
            <div class="span1">11</div>
            <div class="span1 mb1">12</div>


    <div class="clear"></div>
        
   <div class="span4 mb1">
        <div href="#" class="thumbnail">
            <img class="map" src="<?=$video->geoPlace->mapUrl?>" alt="">
        </div>
   </div>
    
    <div class="span9"><div class="row">
        
        <div class="span5 mb1">
            <div class="text">
                <h3 class="fs0">
                        <span class="city"><?=$video->geoPlace->city?>,
                        </span> <span class="country"><?=$video->geoPlace->country?></span></h3>
                <div class="fs0"><span class="date"><?=date("l dS F Y",$video->date)?></span></div>
                
            </div>     
        </div>
    
       
    
    <div class="span5 mb1">        
        <div class="properties row">
            <label class="span1">YouTube</label>
            <div class="span4"><a href="<?=$video->externalUrl()?>" target="_blank"><?=$video->externalUrl()?></a></div>
            <div class="clear"></div>

            <label class="span1">Uploaded</label>
            <div class="span4"><?=$video->date?></a></div>
            <div class="clear"></div>
            
            <label class="span1">By</label>
            <div class="span4"><a href="<?=$video->authorUrl?>" target="_blank"><?=$video->author?></a></div>
            <div class="clear"></div>
            
        </div>
    </div>
    
    </div></div>
    
    


    


</div>

<h3 class="fs1">Video details</h3>
<pre class="prettyprint lang-xml linenums">
    <?=  htmlentities($video->feedContent)?>
</pre>

<h3 class="fs1">Geocode details</h3>
<pre class="prettyprint lang-json linenums">
    <?=  htmlentities($video->geoPlace->feedContent)?>
</pre>