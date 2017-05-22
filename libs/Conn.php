<?php
namespace libs; 
/**
* 连接数据库     
*/
class Conn
{

    public static function conn(){
        $conn=mysqli_connect("127.0.0.1","root","toor","changeapp");
        if (!$conn) {
            die("连接失败!".mysqli_connect_errno());
            return false;
        }else{
            mysqli_query($conn,"SET NAMES UTF8");
            return $conn;
        }
    }
}
?>

