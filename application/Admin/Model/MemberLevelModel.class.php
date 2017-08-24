<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;


class MemberLevelModel extends Model{
    //只允许接收某些字段

    protected $insertFields=array('level_name','jifen_bottom','jifen_top');
    protected $updateFields = array('id','level_name','jifen_bottom','jifen_top');
    //TP验证接收过来的数据
    protected $_validate=array(
        array('level_name', 'require', '会员名称不能为空！', 1, 'regex', 3),
        array('jifen_bottom', 'number', '积分下限为数字'),
        array('jifen_top', 'number', '积分上限为数字'),
    );



    public function showMembers($pageshow=5){

        /******分页变量*******/
        $totalRow=$this->count();

        $page=new Page($totalRow,$pageshow);
        /********美化分页**********/
        $page->setConfig("next","下一页");
        $page->setConfig("prev","上一页");

        $memberinfo=$this->limit($page->firstRow,$page->listRows)->select();

        $pageList=$page->show();

        $arr=array($pageList,$memberinfo);
        return $arr;

    }

    protected function _before_delete($option){

        $id=$option['where']['id'];
        //删除文件之前先查询数据库中图片路径
        $path=$this->field("logo")->find($id);
        deleteImage($path);
    }







}