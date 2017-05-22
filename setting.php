<?php
include "autoload.php";
session_start();

$userId=$_SESSION['user_id']?$_SESSION['user_id']:"";
$user=new libs\User();

/*
*进行设置操作
*/

if(isset($_GET['act']) && $_GET['act']=='loginout') { 

	//退出登录

    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    header("Location:personal.php");

}elseif(isset($_GET['act']) && $_GET['act']=='address'){  //显示用户地址

	$data=$user->userAddr($userId);
	include("view/address.html");

}elseif (isset($_POST['act']) && $_POST['act']=='add') {  //添加用户地址

	$name=isset($_POST['name'])?trim($_POST['name']):""; //姓名
	$phone=isset($_POST['phone'])?trim($_POST['phone']):"";  //号码
	$email=isset($_POST['email'])?trim($_POST['email']):""; //邮箱

	if($_POST['city']=='市辖区' || $_POST['city']=='县'){
		$address=$_POST['province'].'市'.$_POST['area'];
	}else{
		$address=$_POST['province'].'省'.$_POST['city'].trim($_POST['area']);
		
	}

	$detail=$address.$_POST['detail']; //地址

	$address=new libs\User();
	$data=$address->addUserAddr($userId,$name,$phone,$email,$detail);
	header("Location:setting.php?act=address");

}elseif (isset($_GET['act']) && $_GET['act']=='default') {  //设置默认地址

	$id=$_GET['id'];
	// 设置默认地址
	$user->defaultUserAddr($userId,$id);
	// 返回地址列表
	header("Location:setting.php?act=address");

}elseif (isset($_GET['act']) && $_GET['act']=='change') {  //修改地址信息

	$id=$_GET['id'];
	// 修改地址信息
	$address=$user->selectOneAddr($userId,$id);
	// var_dump($address);
	// exit();
	// 返回到添加地址
	include("view/add-address.html");

}elseif (isset($_GET['act']) && $_GET['act']=='del') {  //删除地址

	$id=$_GET['id'];
	
	// 删除地址
	$user->delUserAddr($userId,$id);
	// 返回地址列表
	header("Location:setting.php?act=address");

}elseif (isset($_GET['act']) && $_GET['act']=='collect') {  //显示我的收藏

	require "view/collect.html";

}elseif (isset($_GET['act'])&& $_GET['act']=='userinfo') { //显示个人信息
	
	// 查看用户信息
	$data=$user->userInfo($userId);

	include ("view/userinfo.html");

}elseif(isset($_POST['act']) && $_POST['act']=='update_userinfo'){  
	
	//修改个人信息
	$name=isset($_POST['name'])?trim($_POST['name']):"";
	$birthday=isset($_POST['birthday'])?trim($_POST['birthday']):"";
	$email=isset($_POST['email'])?trim($_POST['email']):"";
	$phone=isset($_POST['phone'])?trim($_POST['phone']):"";
	$sex=isset($_POST['sex'])?trim($_POST['sex']):"";
	$QQ=isset($_POST['QQ'])?trim($_POST['QQ']):"";

	$userinfo=new controller\Login();
	$data=$userinfo->setUserInfo($userId,$name,$sex,$birthday,$phone,$email,$QQ);

	echo json_encode($data);

}elseif(isset($_GET['act']) && $_GET['act']=='pay') { 
	//支付页面
	if (!empty($userId)) {
		$cart=libs\Goods::getCart();
		$tprice=$cart->TotalPrice();
		$address=$user->getDefault($userId);
		if (empty($address)) {

			// 如果没有地址先添加地址
			header("Location:setting.php?act=address");

		}else{
			// 进行支付页面
			include_once "view/pay.html";
		}

	}else{
		// 跳转到登录页面
		header('Location:/changeapp/login.php');
	}
}else{

	// 添加用户地址
	require "view/add-address.html";
}

?>
