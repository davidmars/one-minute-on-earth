<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeoPlace
 *
 * @author juliette
 */
class GeoPlace {
    //put your code here
    
    /**
     * 
     * @var String latitude and longitude separated by space 
     */
    public $latlng;
    /**
     * 
     * @var String 
     */
    public $mapUrl;
    public $city;
    public $sublocality;
    public $country;
    public $route;
    public $state;
    public $neighborhood;
    public $establishment;
    /**
     * google url 
     * @var String
     */
    public $feed;
    /**
     * cached url for the feed
     * @var local url of the location feed 
     */
    public $localFeed;
    
    /**
     * contenu xml
     * @var type 
     */
    public $feedContent;
    /**
     *
     * @var Int status code returned by google location feed (if not 200 the file will not be stored)
     */
    public $status;
    /**
     * the google API server key to retrievemaps and location feeds. 
     */
    const API_KEY="AIzaSyBgoldKfln-fWUY7fT7_rssPtsE_iBCg4A";

    /**
     *
     * @param String $latlng
     * @return  object related to $latlng param
     */
    public static function getPlace($latlng){
        $key=self::API_KEY;
        $url="http://maps.google.com/maps/geo?key=$key&output=xml&language=en&sensor=false&q=".urlencode($latlng);
        //$url="http://maps.googleapis.com/maps/api/geocode/xml?"."key=$key&output=xml&language=en&q=".urlencode($latlng);
        //$url="http://maps.googleapis.com/maps/api/geocode/xml?"."language=en&lat-lng=".urlencode($latlng);
        $url="http://maps.googleapis.com/maps/api/geocode/json?latlng=".str_replace(" ", ",", $latlng)."&sensor=false&language=en";
        $place=new GeoPlace();
        $place->latlng=$latlng;
        $place->mapUrl=  self::getMapUrl($latlng);
        $place->localFeed=FileCache::getFile($url);
        $place->feed=$url;
        
        $json=file_get_contents($place->localFeed);
        $place->feedContent=$json;
        $json=  json_decode($json);
        
        if($json->status!="OK"){
           FileCache::remove($url);
           $place->country="status error ".$json->status;
        }else{
           
           $place->country=count($json->results);
           
           
           
           //search for the best result
           foreach($json->results as $r){
               foreach($r->types as $t){

                       $bestResult=$r;
                       $types[$t]=$r;
                   }
  
           }
           
           if($types["sublocality"]){
               $bestResult=$types["sublocality"];
           }elseif($types["neighborhood"]){
               $bestResult=$types["neighborhood"];
           }else{
               $bestResult=$json->results[0];
           }
           
           $bestResult=$bestResult->address_components;
           
           foreach($types as $r){
           $bestResult=$r->address_components;
           foreach($bestResult as $prop){
              foreach($prop->types as $type){
                  switch ($type){
                      case "country":
                          $place->country=$prop->long_name;
                          break;
                      case "locality":
                          $place->city=$prop->long_name;
                          break;
                      case "route":
                          $place->route=$prop->long_name;
                          break;
                      case "sublocality":
                          $place->sublocality=$prop->long_name;
                          break;
                      case "neighborhood":
                          $place->neighborhood=$prop->long_name;
                          break;
                      case "establishment":
                          $place->establishment=$prop->long_name;
                          break;
                  }
              }
              
           }
           }
           /*
           if($place->establishment){
             $place->city= $place->city.", ".$place->establishment; 
           }elseif($place->neighborhood){
             $place->city= $place->city.", ".$place->neighborhood;  
            //$place->city.="-".$place->establishment.$place->sublocality." - ".$place->neighborhood;
           }
            
            */
           if($place->city==""){
               $place->city=$place->route;
           }
           /*
           if(!$place->city){
              $place->city= $place->sublocality;
           }
           if(!$place->city){
              $place->city= $place->route;
           }
           if($place->neighborhood){
              $place->city= $place->city." ".$place->neighborhood;
           }
           */
        }

        return $place;
    }
    
    public static function getMapUrl($latLng){
        $latLng=  str_replace(" ", ",", $latLng);
        $key=  self::API_KEY;
        return Site::$root."/".FileCache::getFile("https://maps.googleapis.com/maps/api/staticmap?center=".$latLng."&zoom=14&size=480x360&sensor=false&markers=color:black".urlencode("|").$latLng."&key=".$key);
    }
    
}
