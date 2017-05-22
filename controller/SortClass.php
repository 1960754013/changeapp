<?php

namespace controller;
use libs\Sort;

/**
* sort操作类
*/
class SortClass
{
    public static function getDetail($detail_id){
        $sort=new Sort();
        return $sort->getDetail($detail_id);
    }
}
?>