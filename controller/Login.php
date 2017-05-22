<?php
namespace controller;
use libs\User;

/**
* 登录注册操作类
*/
class Login
{
    // 用户登录
    public function check($username,$password){
        $data=array();
        $user=new User();
        $userid=$user->selectUserPass($username,$password);
        if ($userid==false) {
            $data['code']=400;
            $data['msg']="用户或者密码不正确";
        }else{
            $data['code']=200;
            $data['msg']="ok";
            $data['userid']=$userid;
        }
        return $data;
    }

    // 用户注册
    public function add($username,$password){
        $user=new User();
        $password=sha1($password);
        $ret=$user->addUser($username,$password);
        if ($ret=="ok") {
            $data['code']=200;
            $data['msg']="注册成功";
        }elseif ($ret=='exist') {
            $data['code']=400;
            $data['msg']="该用户已注册！";
        }else{
            $data['code']=400;
            $data['msg']="注册失败，刷新试试";
        }
        return $data;
    }

    // 用户修改密码
    public function change($userId,$o_password,$n_password){
        $user=new User();
        $ret=$user->updatePass($userId,$o_password,$n_password);
        if ($ret==true) {
            $data['code']=200;
            $data['msg']="success";
        }else{
            $data['code']=400;
            $data['msg']="密码不正确";
        }
        return $data;
    }

    // 用户信息
    public function setUserInfo($userId,$name,$sex,$birthday,$phone,$email,$QQ){
        $user=new User();
        $ret=$user->setUserInfo($userId,$name,$sex,$birthday,$phone,$email,$QQ);
        if ($ret==true) {
            $data['code']=200;
            $data['msg']="success";
        }else{
            $data['code']=400;
            $data['msg']="保存失败";
        }
        return $data;
    }

}
?>