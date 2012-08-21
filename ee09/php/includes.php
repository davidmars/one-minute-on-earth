<?php

//core fwk
require_once("ee09/php/Site.php");
require_once("ee09/php/View.php");
require_once("ee09/php/UrlControler.php");

//utils
require_once("php/utils/FileCache.php");


//custom models
$customModelsPath="php/models";
if ($handle = opendir($customModelsPath)) {
    while (false !== ($entry = readdir($handle))) {
        $abs=$customModelsPath."/".$entry;
        if ($entry != "." && $entry != ".." && file_exists($abs)) {
            require_once($abs);
        }
    }
    closedir($handle);
}

?>
