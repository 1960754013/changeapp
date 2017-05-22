<?php
include("autoload.php");

if (isset($_GET['gid'])) { 

	//通过pid获取物品
    $gid=$_GET['gid'];

    $sort=new libs\Sort();
    $data=$sort->getSort($gid);

    include("view/show-sort.html");

}elseif (isset($_GET['act'])&&$_GET['act']=='detail'){ 

	//查看详细信息
    $detail_id=isset($_GET['detail_id'])?$_GET['detail_id']:"";

    $data=controller\SortClass::getDetail($detail_id);

    include("view/show-sortinfo.html");

}else{
    
    include("view/sort.html");
}

?>