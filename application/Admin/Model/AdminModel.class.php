<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class AdminModel extends Model{
    //只允许接收某些字段

    protected $insertFields=array('username','password','cpassword');
    protected $updateFields = array('username','password','role_id');
    //TP验证接收过来的数据
    protected $_validate=array(
        array('username', 'require', '用户名称不能为空！', 1, 'regex', 3),
        array('username', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('username', '', '角色名称已经存在', 1, 'unique', 3),
        array('password', 'require', '密码不能为空！', 1, 'regex', 1),
        array('cpassword', 'password', '两次输入密码必须一致！', 1, 'confirm', 3),
    );

    protected function _before_delete($option){
        if($option['where']['id']==1){
            $this->error="超级管理员无法删除";
            return false;
        }

        /***处理admin_role***/
        $id=$option['where']['id'];
        $armodel=D("admin_role");
        $armodel->where("admin_id={$id}")->delete();
    }
    
    protected function _after_insert($data,$option){
        $roleId=$_POST['role_id'];

        $armodel=D("admin_role");
        foreach($roleId as $k=>$v){
            $armodel->add(array(
                    "admin_id"=>$data['id'],
                    "role_id"=>$v,
                ));
        }
    }

    protected function _before_update(&$data,$option){
        
        $roleId=$_POST['role_id'];
        $id=$option['where']['id'];
        $armodel=D("admin_role");
        $armodel->where("admin={$id}")->delete();
        foreach($roleId as $v){
            $armodel->add(array(
                    "admin_id"=>$id,
                    "role_id"=>$v
                ));
        }
    }

}