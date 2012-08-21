<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmbedVdo
 *
 * @author juliette david
 */
class EmbedVdo {
    /**
     * location object for the video
     * @var GeoPlace 
     */
    public $geoPlace;
    
    /**
     * url image of the video
     * @var String
     */
    public $thumbUrl;
    
    /**
     * The date of the video
     * @var Date 
     */
    public $date;
    
    /**
     * can be YT or VIMEO
     * @var String 
     */
    public $embedEngine;
    /**
     * the id from YT or Vimeo
     */
    public $id;
    /**
     *
     * @var String the author user name in YT or Video 
     */
    public $author;
    /**
     *
     * @var type the author page on YT or Vimeo 
     */
    public $authorUrl;
    
    
    public $feedContent;
    
    public function externalUrl(){
        return "http://www.youtube.com/watch?v=".$this->id;
    }
    
    /**
     *
     * @return String the relative url to the moment 
     */
    public function url(){
        return "moment/".$this->geoPlace->country."/".$this->geoPlace->city."-w-".$this->id;
    }
    
    public static function getByUrl($url){
        //YTPlayList::
        $splited=explode("-w-",$url);
        $id=$splited[count($splited)-1];
        return self::getById($id);
    }
    
    public static function getById($id){
        $playlist=YTPlayList::getVideos($YTPlaylistId);
        foreach($playlist as $vdo){
            if($vdo->id==$id){
                return $vdo;
            }
        }
    }
    
    
}

?>
