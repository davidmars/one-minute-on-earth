<?php
/**
 * Here are publics statics to manage globals stuffs....
 * it is recommended to set this variables on a config file 
 *
 * @author david marsalone
 */
class Site {
    /**
     *
     * @var String the root path of your website starting with slash.
     * Usefull to display hrefs or img src, etc... 
     */
    public static $root="/omoe";
    /**
     *
     * @param String $url the local url you need to display
     * @param Bool $absolute if true the host will be added
     * @return String return a coorect href to $url 
     */
    public static function url($url,$absolute=false){
        if($absolute){
            return self::$host.self::$root."/".$url;
        }else{
            return self::$root."/".$url;
        }
    }
     /**
     * @var String the host of your website.
     * Usefull to display hrefs or img src, etc... 
     */
    public static $host="http://david.de.shic.cc";
    /**
     * 
     * @var Bool is the website in debug mode or not? 
     */
    public static $debug=false;
}

?>
