<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class RoleModel extends Model{
    //只允许接收某些字段

    protected $insertFields=array('role_name','pri_id');
    protected $updateFields = array('role_name','pri_id');
    //TP验证接收过来的数据
    protected $_validate=array(
        array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
        array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('role_name', '', '角色名称已经存在', 1, 'unique', 1),
        

    );

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
                $this->_getTree($data,$v['id'],$level+1);
            }
        }

        return $arr;
    }

    protected function _after_insert($data,$option){
    	
    	$rpmodel=D("role_pri");
    	$pri_id=I("post.pri_id");
    	foreach($pri_id as $v){
    		$rpmodel->add(array(
    				"pri_id"=>$v,
    				"role_id"=>$data['id']
    			));
    	}
    	
    }

    protected function _before_update(&$data,$option){
        /***处理拥有的权限***/
        
        $id=$_POST['id'];
        $priId=I("post.pri_id");
        $rpmodel=D("role_pri");
        $rpmodel->where("role_id={$id}")->delete();
        
        foreach($priId as $k=>$v){
            $rpmodel->add(array(
                    "pri_id"=>$v,
                    "role_id"=>$id,
                ));
        }
    }

    protected function _before_delete($option){
        
        $id=$option['where']['id'];
        $rpmodel=D("role_pri");
        $rpmodel->where("role_id={$id}")->delete();


        /***处理中间表***/
        $armodel=D("admin_role");
        $armodel->where("role_id={$id}")->delete();
    }


}