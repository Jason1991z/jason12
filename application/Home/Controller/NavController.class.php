<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class NavController extends Controller {
	public function __construct(){
		parent::__construct();
		//获取导航左侧菜单信息
        $pridata=M("category")->select();

            $_arr=array();
            
            foreach($pridata as $k=>$v){
                if($v['pid']==0){
                    foreach($pridata as $k1=>$v1){
                        if($v1['pid']==$v['cat_id']){
                            foreach($pridata as $k2=>$v2){
                                if($v2['pid']==$v1['cat_id']){
                                    $v1['children'][]=$v2;
                                }
                            }
                            $v['children'][]=$v1;
                        }
                    }
                    $_arr[]=$v;
                }
            }
         S("arr",$_arr,86400);
         
        $this->assign(array(
        		"catdata"=>$_arr,
        	));
		 

	}	

	public function getNav(){
        
    }
/***************************************************************************************/
}