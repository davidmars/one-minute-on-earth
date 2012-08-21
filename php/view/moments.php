<?/*----------------------------videos list-------------------------*/?>
<?
$videos=YTPlayList::getVideos();
?>
<?foreach($videos as $video):?>
    <?=$this->render("moment/thumb",array("video"=>$video))?>
<?endforeach?>