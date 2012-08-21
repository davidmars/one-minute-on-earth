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
    public $country;
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
        $url="http://maps.google.com/maps/geo?key=$key&output=xml&q=".urlencode($latlng);
        
        $place=new GeoPlace();
        
        $place->localFeed=FileCache::getFile($url);
        $xml=file_get_contents($place->localFeed);
        $place->feedContent=$xml;
        $xml=simplexml_load_string($xml);
        
        
        $place->feed=$url;
        $place->status=$xml->Response->Status->code;
        if($place->status!="200"){
            FileCache::remove($url);
        }
        
        $place->latlng=$latlng;
        $place->country=$xml->Response->Placemark->AddressDetails->Country->CountryName;
        

        
        $place->city=$xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->Locality->LocalityName;
        if(!$place->city){
            $place->city=$xml->Response->Placemark->AddressDetails->Country->Locality->LocalityName;    
        }
        if(!$place->city){
            $place->city=$xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->SubAdministrativeArea->Locality->LocalityName;    
        }
        if(!$place->city){
            $place->city=$xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->DependentLocality->DependentLocalityName;    
        }
        if(!$place->city){
            $place->city=$xml->Response->Placemark->AddressDetails->Locality->LocalityName;
        }
        if(!$place->country){
           $c=$xml->Response->Placemark->address;
           if($c){
               $c=explode(",",$c);
               if(count($c)>0){
                    $place->country=$c[count($c)-1];  
               }
           }
        }
        
        $place->mapUrl=  self::getMapUrl($latlng);
        
        return $place;
    }
    
    public static function getMapUrl($latLng){
        $latLng=  str_replace(" ", ",", $latLng);
        $key=  self::API_KEY;
        return Site::$root."/".FileCache::getFile("https://maps.googleapis.com/maps/api/staticmap?center=".$latLng."&zoom=14&size=480x360&sensor=false&markers=color:black".urlencode("|").$latLng."&key=".$key);
    }
    
}
?>
