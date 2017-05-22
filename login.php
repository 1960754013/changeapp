<?php
include("autoload.php");

session_start();

if(isset($_POST['username']) && (isset($_POST['password']))) { 

	// 登录操作
    
    $username=trim($_POST['username']);
    $password=trim($_POST['password']);

    $login=new controller\Login();
    $data=$login->check($username,$password);

    if ($data['code']==200) {
        $_SESSION['user_id']=$data['userid'];
        $_SESSION['username']=$username;
    }
    echo json_encode($data);

}elseif(isset($_POST['username1'])&&isset($_POST['password1'])){ 

	//注册操作

    $username=trim($_POST['username1']);
    $password=trim($_POST['password1']);

    $login=new controller\Login();
    $data=$login->add($username,$password);
    
    echo json_encode($data);

}elseif(isset($_POST['o_pass'])&&isset($_POST['n_pass'])){ 

    //修改密码
    $o_pass=trim($_POST['o_pass']);
    $n_pass=trim($_POST['n_pass']);
    $userId=isset($_SESSION['user_id'])?$_SESSION['user_id']:"";
    $login=new controller\Login();
    $data=$login->change($userId,$o_pass,$n_pass);
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    echo json_encode($data);

}else{ 

	//跳转到登录页面
    
    header("Location:view/login.html");
}

?>