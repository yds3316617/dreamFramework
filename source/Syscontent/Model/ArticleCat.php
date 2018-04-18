<?php
namespace Syscontent\Model;
use Core\FactoryManager;
use Core\DatabaseManager;


class ArticleCat extends DatabaseManager{

    var $tableName = 'syscontent_article_cat';

    //获取某个分类的所有父分类
    function getParentIds($cat_id,&$rs){
        $catInfo = $this->getList('parent_id',array('id'=>$cat_id));

        if($catInfo[0]['parent_id']){
            $rs[] = $catInfo[0]['parent_id'];
            $this->getParentIds($catInfo[0]['parent_id'],$rs);
        }else{
            $rs = array_reverse(array_unique($rs));
            return $rs;
        }
    }

    //获取某个分类的所有父分类
    function doRemove($cat_id){
        $child_catInfo = $this->getList('id',array('parent_id'=>$cat_id));
        error_log(var_export($cat_id,1),3,'E:/555.txt');
        if($child_catInfo){
            $this->error = '请先删除子集分类。';
            return false;
        }else{
            $rs = $this->delete(array('id'=>$cat_id));
            return $rs;
        }
        
    }

}