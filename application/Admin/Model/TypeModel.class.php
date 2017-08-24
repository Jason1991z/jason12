<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class TypeModel extends Model{
    //只允许接收某些字段

    protected $insertFields="type_name";
    protected $updateFields="type_name";
    //TP验证接收过来的数据
    protected $_validate=array(
        array("type_name","require","类型名称不能空!",1),

    );

    protected function _before_insert(&$data,$option){

    }


    public function showtypes($pageshow=5){

        /*********搜索查询************/

        $where=array();
        $gn=I("get.type_name");


        //类型名称
        if($gn) {
            $where['type_name'] = array('like', "%$gn%");
        }



        /******分页变量*******/
        $totalRow=$this->where($where)->count();

        $page=new Page($totalRow,$pageshow);
        /********美化分页**********/
        $page->setConfig("next","下一页");
        $page->setConfig("prev","上一页");

        $typeinfo=$this
            ->where($where)
            ->limit($page->firstRow,$page->listRows)->select();

        $pageList=$page->show();

        $arr=array($pageList,$typeinfo);
        return $arr;

    }

    protected function _before_delete($option){
        //array(3) { ["where"]=> array(1) { ["id"]=> int(1) //类型id} ["table"]=> string(4) "type" ["model"]=> string(4) "type" }
        $typeid=$option["where"]["id"];
        $attrmodel=D("attribute");
        $attrmodel->where("type_id={$typeid}")->delete();
    }



    public function _after_insert($data,$option)
    {
    }


}