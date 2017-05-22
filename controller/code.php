<?php

namespace controller;
use libs\ValidateCode;

session_start();

if (isset($_POST['code'])) {
    $data=array();
    $code=strtolower($_POST['code']);
    $rcode=strtolower($_SESSION['code']);
    if ($code != $rcode) {
        $data['status']=400;
        $data['msg']="验证码错误";
        $data['code']=$_SESSION['code'];
    }else{
        $data['status']=200;
        $data['msg']="ok";
    }
    echo json_encode($data);

}else{
    $vcode=new ValidateCode();
    $code=$vcode->outimg();
    $_SESSION['code']=$vcode->getcode();
    echo $code;
}

?>