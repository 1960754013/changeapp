<?php
namespace controller;
use libs\User;

/**
* 地址操作类
*/
class Address
{
    public function addUserAddr($userId,$name,$phone,$email,$detail_add){

        if ($name=="" || $phone=="" || $email=="" || $detail_add=="") {
            return false;
        }
        $address=new User();
        if ($this->existAddr($userId)==false) {
            $flag=1;
        }else{
            $flag=0;
        }
        $result=$address->addUserAddr($userId,$name,$phone,$email,$detail_add,$flag);
        if ($result) {

           return $result;
        }else{
            return false;
        }
    }

}
?>