<?php
/**
 * include the files to do the job later 
 */
require_once("ee09/php/Site.php");
require_once("ee09/php/View.php");
require_once("ee09/php/UrlControler.php");

$includesPaths=array(
    /**
     * php from other peoples 
     */
    "ee09/php/lib",
    /**
     * utils classes 
     */
    "ee09/php/utils",
    /**
     * the custom php models 
     */
    "php/models"
);
foreach($includesPaths as $path){
    if ($handle = opendir($path)) {
        while (false !== ($entry = readdir($handle))) {
            $abs=$path."/".$entry;
            if ($entry != "." && $entry != ".." && file_exists($abs)) {
                require_once($abs);
            }
        }
        closedir($handle);
    }
}
