<?php
require_once("php/includes.php");
$videos=YTPlayList::getVideos("01BCB0E07A3C606D");
?>





<?foreach ($videos as $v):?>
<img src="<?=$v->thumbUrl?>"
<? endforeach; ?>
 
