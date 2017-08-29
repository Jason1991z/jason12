<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class PrivilegeModel extends Model{
    //只允许接收某些字段

    protected $insertFields=array('pri_name','module_name','controller_name','action_name','pid');
    protected $updateFields = array('pri_name','module_name','controller_name','action_name','pid');
    //TP验证接收过来的数据
    protected $_validate=array(
        array('pri_name', 'require', '权限名称不能为空！', 1, 'regex', 3),
        array('module_name', 'require', '模块名称不能为空！', 1, 'regex', 3),
        array('controller_name', 'require', '控制器名称不能为空！', 1, 'regex', 3),
        array('action_name', 'require', '方法名称名称不能为空！', 1, 'regex', 3),

    );

    //获取不同管理员的权限名称显示在左侧菜单中
    public function getbtn(){
        $adminId=$_SESSION['userinfo']['id'];
        $primodel=D("privilege");
        if($adminId==1){
            $pridata=$primodel->select();
        }else{
            $pridata=$primodel->alias("a")
            ->join("left join role_pri b on a.id =b.pri_id
                    left join admin_role c on b.role_id=c.role_id")
            ->where("admin_id={$adminId}")->select();
            
        }
        $arr=array();
        foreach($pridata as $k=>$v){
            if($v['pid']==0){
                foreach($pridata as $k1=>$v1){
                    if($v1['pid']==$v['id']){
                        $v['children'][]=$v1;
                    }
                }
                $arr[]=$v;
            }
        }
        return $arr;
    }

    //每次访问前判断是否有权限
    public function chkpri(){
        //获取模块名,控制器名,方法名MODULE_NAME,CONTROLLER_NAME,ACTION_NAME
        //从数据库中获取信息

        $armodel=D("admin_role");
        $adminId=$_SESSION['userinfo']['id'];
        $rs=$armodel->alias("a")
        ->join("left join role_pri b on a.role_id=b.role_id
                left join privilege c on b.pri_id=c.id
            ")
        ->where("admin_id={$adminId} and module_name='".MODULE_NAME."' 
            and controller_name='".CONTROLLER_NAME."' and action_name='".ACTION_NAME."'")
        ->count();
        
        if($adminId==1){
            return true;
        }
        return $rs; 
    }

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
                $arr[]=$v['id'];
                $this->_getChildren($data,$v['id']);
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
                $this->_getTree($data,$v['id'],$level+1);
            }
        }

        return $arr;
    }

    public function _before_delete($option){
       $arr= $this->getChildren($option['where']['id']);
        if($arr){
            $str=implode(",",$arr);
            M('privilege')->delete($str);

        }

        /***删除中间表***/
        $id=$option['where']['id'];
        $rpmodel=D("role_pri");
        $rpmodel->where("pri_id={$id}")->delete();
    }


}