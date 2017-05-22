<?php
include("autoload.php");

// 开启会话
session_start();


if (isset($_SESSION['user_id'])&& !empty($_SESSION['user_id'])) { // 用户是否已登录

    include("view/personal.html");
   
}else{  //跳转到登录页面
	
    header("Location:login.php");
}

?>