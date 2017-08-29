<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class IndexController extends NavController {
    
    public function index(){
    	
    	$this->assign(array(
    			"_page_title"=>"商城首页",//title名称
    			"keyword"=>"商城首页",
    			"description"=>"商城首页",
    			"_show_nav"=>1,//控制导航菜单,0:关闭 1:显示
    			
    		));
        $this->display();
    }

    public function getNavdata(){
        $pridata=M("category")->select();
        $_arr=array();
            $pd=S("pd");
            if($pd==null){
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
            S('pd',$_arr,86400);
         }
        return $_arr;
    }
    /********************************************************/
}