<?php

//core fwk
require_once("ee09/php/Site.php");
require_once("ee09/php/View.php");
require_once("ee09/php/UrlControler.php");

//utils

$utilsPath="ee09/php/utils";
if ($handle = opendir($utilsPath)) {
    while (false !== ($entry = readdir($handle))) {
        $abs=$utilsPath."/".$entry;
        if ($entry != "." && $entry != ".." && file_exists($abs)) {
            require_once($abs);
        }
    }
    closedir($handle);
}

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
