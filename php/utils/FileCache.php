<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileCache
 *
 * @author juliette
 */
class FileCache {
    
    /**
     * Return a local url for the specified url
     * @param String $url
     * @return String 
     */
    private static function getLocalUrl($url){
        return "media/FileCache/".md5($url);
    }
    /**
     * Return a local file url for the specified url. If the file is not in cache, it will first download the file to store it for the further calls.
     * @param String $url the remote url
     * @param Int $refreshSeconds the maximum time cache for the file
     * @return String
     */
    public static function getFile($url,$refreshSeconds=0){

        $localUrl=self::getLocalUrl($url);
        
        $needToDownload=false;
        
        if(!file_exists($localUrl)){
           $needToDownload=true; 
        }else if($refreshSeconds!=0){
            if(time()-date("U",filemtime($localUrl))>$refreshSeconds){
                $needToDownload=true;
            }
        }
        
        
        
        if($needToDownload){
            $content=file_get_contents($url);
            self::save($content, $localUrl);
        }

        return $localUrl;
    }

    public static function remove($url){
       $localUrl=self::getLocalUrl($url);
       unlink($localUrl);
    }

    private static function save($content,$fileName){
        self::mkDirOfFile($fileName);
        file_put_contents($fileName, $content);
        chmod($fileName, 0777);
    }

    /**
     * Crée les répertoires et sous répertoire contenant $fileUrl
     * @param String $fileUrl url complete du fichier dont il faut éventuellement créer les répertoires conteneurs
     */
    static function mkDirOfFile($fileUrl){
            $splitted=explode("/",$fileUrl);
            $dir="";
            while(count($splitted)>1){
                    $newFolder=array_shift($splitted);
                    $dir=$dir.$newFolder;
                    if(!is_dir($dir)){
                            mkdir( $dir , 0777 , true );
                            chmod($dir, 0777);
                    }
                    $dir.="/";
            }
    }


}
?>
