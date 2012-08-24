<?php


/**
 * Description of Less
 *
 * @author  david marsalone
 */
class Less {
    
    /**
     * Guess...
     * @var Less 
     */
    private static $current;

    /**
     *
     * @return Less using it will prevent to declare more than one Less instance.
     */
    private static function me() {
        if(self::$current){
            return self::$current;
        }else{
            return new Less();
        }
    }


    /**
     *
     * @var lessc the wonderfull & glorious php less compiler 
     */
    private static $less;
    /**
     * where to put the output files
     */
    public static $outputPath="media/less-css/";


    public function __construct() {
        
        self::$current=$this;
        self::$less=new lessc();
        self::$less->setPreserveComments(true);
    }
    /**
     * 
     * @param String $inputFile the path to the less file you want to compile.
     * @param String $outputFile the path to the css file you want as result.
     * @return String the path to the result css file
     */
    public function compile ($inputFile,$outputFile){
        
        try {
            $output=$outputFile.".css";
            FileTools::mkDirOfFile($output);
            self::$less->checkedCompile($inputFile.".less", $output);
            return $output;
            
        } catch (exception $e) {
            echo "fatal error: " . $e->getMessage();
            die();
        }
    }
    
    public static function getIncludeTag($lessFile){
        $outputFile=  self::$outputPath.$lessFile;
        $path=Site::$root."/".self::me()->compile($lessFile, $outputFile);
        return "<link type=\"text/css\" rel=\"stylesheet\" href=\"".$path."\"/>";
    }
}

