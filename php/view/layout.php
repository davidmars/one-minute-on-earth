<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="en">
<!--<![endif]-->

    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

            <title></title>
            <meta name="description" content="">
            <meta name="author" content="">
            <meta name="viewport" content="width=device-width">

            <?=$this->render("layout/css-files")?>
            
            <script src="assets/lib/modernizr-2.5.3-respond-1.1.0.min.js"></script>
            <script type="text/javascript" src="<?=Site::$root?>/assets/lib/jquery-1.7.2.js"></script>
    </head>
    
    <body>
        <?=$_content?>
    </body>
    
    <?=$this->render("layout/js-files")?>

</html>