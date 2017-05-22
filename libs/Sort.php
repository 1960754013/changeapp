<?php
namespace libs; 
/*
*商品分类
*/
class Sort{

    public $conn;

    public function __construct(){
        $this->conn=Conn::conn();
    }

    // 获取特定商品分类
    public function getSort($gid){
        if ($this->conn) {
            $data=array();
            $query="select * from goods_info where pid='$gid'";
            $result=mysqli_query($this->conn,$query);
            while ($row=mysqli_fetch_assoc($result)) {
                $data[]=$row;
            }
            mysqli_free_result($result);
            return $data;
        }
    }

    // 获取商品信息信息
    public function getDetail($detail_id){
        if ($this->conn) {
            $data=array();
            $query="select goods_weight,total_weight,goods_jifen,goods_info,goods_name,goods_price,goods_made,goods_img from goods_info,goods_info_list where goods_info.detail_id=goods_info_list.detail_id and goods_info.detail_id=$detail_id and goods_info_list.detail_id=$detail_id limit 1";

            $result=mysqli_query($this->conn,$query);
            while ($row=mysqli_fetch_assoc($result)) {
                $data=$row;
            }
            mysqli_free_result($result);
            return $data;
        }
    }

    // 查找商品
    public function searchGoods($content){
        $ret=array();
        $query="select goods_name,detail_id from goods_info where goods_name like '%$content%'";
        $result=mysqli_query($this->conn,$query);
        while ($row=mysqli_fetch_assoc($result)) {
            $ret[]=$row;
        }
        return $ret;
    }

    public function __destruct(){
        mysqli_close($this->conn);
    }
}

?>