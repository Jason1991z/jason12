<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Verify;

class LoginController extends Controller{
    public function index(){
        
        $this->display();
    }

    /* 验证码功能 */
    public function verify(){
    	//验证码功能
        $verify=new Verify();
        $verify->fontSize = 18;
     	$verify->length = 4;
     	$verify->useNoise=false;
     	//$verify->useCurve=false;
     	$verify->entry();


    }
    
    /*登录*/
    public function login(){
    	$verify=new Verify();
    	$result=$verify->check($_POST['chkcode']);
    	$username=$_POST['username'];
    	$password=md5($_POST['password']);
    	if($result){
    		$rs=M("admin")->where("username='{$username}' and password='{$password}'")->find();
    		if($rs>0){
    			$_SESSION['userinfo']=$rs;
    			$this->success("登录成功",__APP__);
    		}else{
    			$this->success("用户名或密码错误,登录失败",__APP__."/login/index");
    		}
    	}else{
    			$this->success("验证码不正确");
    	}
    }

    public function logout(){
        
            unset($_SESSION['userinfo']);
            $this->success("退出成功",__APP__."/login/index");
       
    }
    /***********************************************************/
}