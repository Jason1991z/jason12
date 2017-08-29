<?php
namespace Admin\Controller;
use Think\Controller;


class BaseController extends Controller{
    public function __construct(){
    //重载父类构造方法
        parent::__construct();
    //判断session
        if(!isset($_SESSION['userinfo'])){

            $this->error("未登录,无法访问,请先登录",__APP__."/login/index");
        }

    //访问先调用chkpri
        if(CONTROLLER_NAME=="Index"){
            return true;
        }
        $primodel=D("privilege");
        if($primodel->chkpri()){
            return true;
        }else{
            $this->error("无权访问",__APP__."/Index/index");
        }
    }
    /*****************************************************/
}