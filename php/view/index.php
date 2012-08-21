<?$this->inside("layout",array("variable pour le layout"=>"yoooooo"))?>

<div class="left-bar">
    <?=$this->render("nav")?>
</div>




<div class="video-bg full" data-section="now-playing">
    <?=$this->render("player")?>
</div>


<div class="page-content full bgWhite">


    <div class="m-left " style="min-height: 100px;" 
            data-ajax-receiver="moment-details" 
            data-section="now-playing">
        <?if($video):?>
            <?=$this->render("moment/details",array("video"=>$video))?>
        <?endif?>
    </div>


    <div class="m-left"  data-section="moments">
        <div class="row">
            <?=$this->render("moments")?>
        </div>
        
    </div>
    
    <div class="container zero">
        <div class="m-left" data-section="download">
            <?=$this->render("download")?> 
        </div>
    </div>
    <div class="container zero">
        <div class="m-left" data-section="submit">
            <?=$this->render("submit")?> 
        </div>
    </div>
    <div class="container zero">
        <div class="m-left" data-section="about">
            <?=$this->render("about")?> 
        </div>
    </div>
    
    
</div>

    
            

            
            
            
            



           





