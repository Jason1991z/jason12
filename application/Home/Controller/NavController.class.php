<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class NavController extends Controller {
	public function __construct(){
		parent::__construct();
		//获取导航左侧菜单信息
    	
    	$this->getNavdata();

	}
/***************************************************************************************/
}