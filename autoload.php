<?php
define('ROOT',str_replace('\\','/',dirname(__FILE__)) . '/');
error_reporting(0);
class autoload{
    public static function load($className){
        $file_name=sprintf("%s.php",str_replace("\\", "/", $className));
        if (is_file($file_name)) {
            include_once $file_name;
        }
    }
}
spl_autoload_register(['autoload','load']);


?>
