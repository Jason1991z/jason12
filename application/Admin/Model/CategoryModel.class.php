<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class CategoryModel extends Model{
    //只允许接收某些字段

    protected $insertFields=array('cat_name','pid');
    protected $updateFields = array('cat_id','cat_name','pid');
    //TP验证接收过来的数据
    protected $_validate=array(
        array('cat_name', 'require', '分类名称不能为空！', 1, 'regex', 3),

    );

    //删除操作时找到子类并一起删除
    public function getChildren($id){
        $data=$this->select();

        return $this->_getChildren($data,$id,true);
    }

    private function _getChildren($data,$id,$isclear=false){

        static $arr=array();
        if($isclear){
            $arr=array();
        }

        foreach($data as $k=>$v){
            if($v['pid']==$id){
                $arr[]=$v['cat_id'];
                $this->_getChildren($data,$v['cat_id']);
            }

        }

        return $arr;
    }
    //分类列表递归函数显示名称
    public function getTree(){
        $data=$this->select();
        return $this->_getTree($data);
    }

    private function _getTree($data,$pid=0,$level=0){
        static $arr=array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->_getTree($data,$v['cat_id'],$level+1);
            }
        }

        return $arr;
    }

    public function _before_delete($option){
       $arr= $this->getChildren($option['where']['cat_id']);
        if($arr){
            $str=implode(",",$arr);
            M('category')->delete($str);

        }
    }


}