<?php
include("autoload.php");

// 开启会话，执行购物车操作
session_start();
$cart=libs\Goods::getCart();

if (isset($_POST['act']) && $_POST['act']=='buy') { //商品添加

    $gid=isset($_POST['gid'])?$_POST['gid']:"";

    if ($_POST['act']=='buy' && $gid) {
        $name=isset($_POST['name'])?trim($_POST['name']):"";
        $price=isset($_POST['price'])?trim($_POST['price']):"";
        $img=isset($_POST['img'])?trim($_POST['img']):"";
        $num=1;
        
        // 添加商品
        $cart->AddItem($gid,$name,$price,$img,$num);

        //返回信息
        $info=array(
            'status'=>1,
            'info'=>'success',
        );
        $data=json_encode($info);
        echo $data;
    }
}elseif(isset($_POST['act']) && $_POST['act']=='search'){ //商品搜索

    $content=$_POST['conent'];
    $goods=new libs\Sort();
    $result=$goods->searchGoods($content);
    echo json_encode($result);
    

}elseif(isset($_GET['act'])){  //商品操作

    $act=$_GET['act'];
    $gid=isset($_GET['gid'])?$_GET['gid']:"";

    if ($act=='add') { //该商品数量加一

        $cart->AddOneItem($gid);

    }elseif($act=='reduce'){ //该商品数量减一
        
        $cart->ReduceOneItem($gid);

    }elseif ($act="del") {  //删除该商品
        $cart->DelItem($gid);
    }

    header("Location:cart.php");

}else{//显示购物车
    $cart_list=$cart->ItemList();
    
    $cart_num=$cart->ItemTotal();

    $total_price=$cart->TotalPrice();

    include("view/cart.html");
}

?>