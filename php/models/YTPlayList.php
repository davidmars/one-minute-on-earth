<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of YTPlayList
 *
 * @author juliette
 */
class YTPlayList {

    public $total;
    private $current;
    /**
     * the time cache for realy download an xml from youtube...
     * well in fact, there is a random function also to prevent complete refresh.
     */
    const REFRESH_SECONDS=60;
    /**
     * the playlist to load by default 
     */
    const PLAYLIST="01BCB0E07A3C606D";

    public static function getVideos($YTPlaylistId=null) {
        if(!$YTPlaylistId){
            $YTPlaylistId=  self::PLAYLIST;
        }
        $start = 1;
        $total = 100;
        $entries = array();
        $count=1;
        $perpage=0;
        while ($total > $start) {
            $start = ($start) + ($perPage);
            $playlistUrl = "http://gdata.youtube.com/feeds/api/playlists/$YTPlaylistId?v=2&start-index=$start";
            //echo "<h1>".$playlistUrl."</h1>";
            $xml = file_get_contents(FileCache::getFile($playlistUrl, rand(self::REFRESH_SECONDS, self::REFRESH_SECONDS*4)));
            $xml = simplexml_load_string($xml);
            
            //for the next iterator
            $total = $xml->xpath("openSearch:totalResults");
            $total = $total[0];
            $perPage = $xml->xpath("openSearch:itemsPerPage");
            $perPage = $perPage[0];
            

            //echo $start."///".$perPage."///".$total;

            foreach ($xml->entry as $e) {
                
                
                
                
                //echo "<h3>entry ".$count++ . $e->id . "</h3>";
                //thumb
                foreach ($e->xpath("media:group") as $m) {
                    //echo "media<br>";
                    foreach ($m->xpath("media:thumbnail[@yt:name='hqdefault']") as $t) {
                        //print_r($t);
                        $thumb = $t->attributes()->url;
                        //echo "<img src='$thumb'>";
                       
                    }
                }
                

                
                
                $geo = $e->xpath("georss:where/gml:Point/gml:pos");
                $geo = $geo[0];
                
                $id=$e->xpath("media:group/yt:videoid");
                $id=$id[0];
                
                $author=$e->author->name;
                $authorUrl=$e->author->uri;
                
                $date=$e->xpath("yt:recorded");
                $date=  strtotime($date[0]);
                
                $place = GeoPlace::getPlace($geo);
                //echo "<img src='".$place->mapUrl."'>";
                //echo $place->country . " <br> " . $place->city." <br> ".$place->feed." <br> ".$place->status."<br>".$place->localFeed;
                
                //clean object
                $embedVdo=new EmbedVdo();
                $embedVdo->embedEngine="YT";
                $embedVdo->thumbUrl=$thumb;
                $embedVdo->geoPlace=$place;
                $embedVdo->id=$id;
                $embedVdo->author=$author;
                $embedVdo->authorUrl=$authorUrl;
                $embedVdo->date=$date;
                $embedVdo->feedContent=$e->asXML();
                $entries[]=$embedVdo;
                
                
            }
        }
        $entries=self::sortByDate($entries,false);
        return $entries;
        
    }
    /**
     * order the $playlist by date
     * @param Array $playlistArray
     * @return Array 
     */
    public static function sortByDate($playlistArray,$asc=true){
        
        if(!function_exists("compareAsc")){
            function compareAsc($a,$b){
                $aa=date("U",$a->date);
                $bb=date("U",$b->date);
                if ($aa == $bb) {
                    return 0;
                }
                return ($aa < $bb) ? -1 : 1; 
            }
            function compareDesc($a,$b){
                $aa=date("U",$a->date);
                $bb=date("U",$b->date);
                if ($aa == $bb) {
                    return 0;
                }
                return ($aa > $bb) ? -1 : 1; 
            }
        }
        if($asc){
            usort($playlistArray, "compareAsc");
        }else{
            usort($playlistArray, "compareDesc");
        }
        return $playlistArray;
    }


}

?>
