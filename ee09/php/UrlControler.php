<?php

/**
 * Description of UrlControler
 *
 * @author juliette david
 */
class UrlControler {
    
    public $urlArray;
    public $urlString;
    public $context=array();



    public function __construct($url){
        
        $this->urlArray=  explode("/", $url);
        $this->urlString=$url;
    }
    public function getView(){
        
        
        //index
        if($this->urlString=="" || $this->urlString=="/"){
            $view=new View("index");
            return $view;
        }
        
        
        //existing template
        $templateUrl=$this->findExistingView($this->urlString);
        if($templateUrl){

           $context=array();
           
           //custom controler
           $customControler="php/view/".$templateUrl."_c.php";
           if(file_exists($customControler)){
              include($customControler); 
           }
           
           $view=new View($templateUrl);
           $this->context=$context;
           return $view;
        }
        
        $view=new View("index");
        return $view;
        
        
    }
    /**
     * 
     * @param string $url usualy, the url on the navigation browser without domain name
     * @return String return the view path or false if not found
     */
    public function findExistingView($url){
        $parts=explode("/",$url);
        while(count($parts)>0){
            $url="php/view/".implode("/",$parts).".php";
            if(file_exists($url)){
                return implode("/",$parts);
            }
            array_pop($parts);
        }
        return false;
    }
}
