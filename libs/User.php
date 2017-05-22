<?php
namespace libs;

class User{
    private $conn;

    public function __construct(){
        $this->conn=Conn::conn();
    }

    // 添加用户名，返回userId
    public function addUser($username,$password){
        $ret="";
        if ($this->selectUser($username)) {
            return $ret="exist";
        }
        $query="insert into user values(null,'$username','$password')";
        $result=mysqli_query($this->conn,$query);
        if ($result) {
            $ret="ok";
        }
        return $ret;   
    }

    // 检测用户名是否存在
    public function selectUser($username){
        $ret=false;
        $query="select userId from user where username=$username";
        $result=mysqli_query($this->conn,$query);
        if (mysqli_num_rows($result)>0) {
            $ret=true;
        }
        return $ret;
    }

    // 修改密码
    public function updatePass($userId,$o_pass,$n_pass){
        if (!$this->selectPass($userId,$o_pass)) {
            return false;
        }else{
            $query="update user set password=sha1($n_pass) where userId=$userId";
            $result=mysqli_query($this->conn,$query);
            if ($result) {
                return true;
            }else{
                return false;
            }
        }
    }

    // 检测用户名密码
    public function selectUserPass($username,$password){
        if (!$this->selectUser($username)) {
            return false;
        }else{
            $query="select userId from user where username=$username and password=sha1($password) limit 1";
            $result=mysqli_query($this->conn,$query);
            if (mysqli_num_rows($result)>0) {
                $ret= $result->fetch_array(MYSQLI_NUM)[0];
                return $ret;
            }else{
                return false;
            }
        }
    }

    // 检测密码是否正确
    public function selectPass($userId,$password){
        $query="select * from user where userId=$userId and password=sha1($password)";
        $result=mysqli_query($this->conn,$query);
        if (mysqli_num_rows($result)>0) {
            return true;
        }else{
            return false;
        }
    }

    // 获取用户信息
    public function userInfo($userId){
        $ret=array();
        if ($userId=="") {
            return false;
        }
        $query="select name,sex,birthday,phone,email,QQ from user_info where userId=$userId";
        $result=mysqli_query($this->conn,$query);
        while ($row=mysqli_fetch_assoc($result)) {
            $ret=$row;
        }
        mysqli_free_result($result);
        return $ret;
    }

    // 修改用户信息
    public function setUserInfo($userId,$name,$sex,$birthday,$phone,$email,$QQ){
        if (!$this->existUserInfo($userId)) {
            // 插入数据
            $query="insert into user_info values($userId,'$name','$sex','$birthday','$phone','$email','$QQ')";
        }else{
            // 更新数据
            $query="update user_info set name='$name',sex='$sex',birthday='$birthday',phone='$phone',email='$email',QQ='$QQ' where userId=$userId";
        }
        $result=mysqli_query($this->conn,$query);

        if ($result) {
            return true;    

        }else{
            return false;
        }
    }
    
    // 检测是否有用户信息
    public function existUserInfo($userId){
        $query="select userId from user_info where userId=$userId limit 1";
        $result=mysqli_query($this->conn,$query);
        if (mysqli_num_rows($result)>0) {
            return true;    
        }else{
            return false;
        }
    }


    // 获取用户地址信息
    public function userAddr($userId){
        $ret=array();
        if ($userId=="") {
            return false;
        }
        $query="select name,phone,email,detail_add,flag,id from user_addr where userId=$userId";
        $result=mysqli_query($this->conn,$query);
        while ($row=mysqli_fetch_assoc($result)) {
            $ret[]=$row;
        }
        mysqli_free_result($result);
        return $ret;
    }
    // 获取用户的特定地址
    public function selectOneAddr($userId,$id){
        $ret=array();
        if ($this->existAddr($userId)==false) {
            return false;
        }
        $query="select * from user_addr where userId=$userId and id=$id";
        $result=mysqli_query($this->conn,$query);
        while ($row=mysqli_fetch_assoc($result)) {
            $ret=$row;
        }
        mysqli_free_result($result);
        return $ret;
    }

    // 检测是否添加了地址
    public function existAddr($userId){
        $query="select * from user_addr where userId=$userId limit 1";
        $result=mysqli_query($this->conn,$query);
        if (mysqli_num_rows($result)>0) {
            return true;
        }else{
            return false;
        }
    }

    // 添加用户地址
    public function addUserAddr($userId,$name,$phone,$email,$detail_add){
        if ($this->existAddr($userId)==false) {
            $flag=1;
        }else{
            $flag=0;
        }
        $query="insert into user_addr values($userId,'$name','$phone','$email','$detail_add',$flag,null)";
        $result=mysqli_query($this->conn,$query);
        if ($result) {
            return true;

        }else{
            return false;
        }   
    }


    // 修改默认地址
    public function defaultUserAddr($userId,$id){
        // 直接调用存储过程
        $result=mysqli_query($this->conn,"call defaultAddr($userId,$id)");
        if ($result) {
            return true;
        }else{
            return false;
        }
    }

    // 删除地址
    public function delUserAddr($userId,$id){
        $query="delete from user_addr where userId=$userId and id=$id";
        $result=mysqli_query($this->conn,$query);
        if ($result) {
            return true;
        }else{
            return false;
        }
    }

    // 返回默认地址
    public function getDefault($user_id){
        $ret=array();
        $query="select name,phone,detail_add from user_addr where userId=$user_id and flag=1 limit 1";
        $result=mysqli_query($this->conn,$query);
        while ($row=mysqli_fetch_assoc($result)) {
            $ret=$row;
        }
        return $ret;
    }

    public function __destruct(){
        mysqli_close($this->conn);
    }

}

?>