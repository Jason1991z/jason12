<?php
namespace Admin\Controller;
use Think\Controller;


class AdminController extends BaseController{
    public function lst(){
        $model=D("admin");

        /*********物品展示************/
        //$arr=$model->select();

        $arr=$model->field("a.*,group_concat(c.role_name separator',') role_name")->alias("a")
        ->join("left join admin_role b on a.id = b. admin_id")
        ->join("left join role c on c.id=b.role_id")
        ->group("admin_id")
        ->select();


        $this->assign(array(
            "page_title"=>"管理员列表",
            "page_btn"=>"添加管理员",
            "page_url"=>__APP__."/admin/add",
            "admin"=>$arr
        ));

        $this->display();
    }



    public function add()
    {
        $model = D('admin');
        
        $romodel=D("role");

        $arinfo=$romodel->select();
        
        //TP自带的判断是否接收数据
        if (IS_POST) {
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            //也要建立对应的表模型


            //TP用I函数进行接收数据
            if ($model->create(I('post.'), 1)) {
                $_POST['password']=md5($_POST['password']);
                
                $model->add(array(
                        "username"=>$_POST['username'],
                        "password"=>$_POST['password']
                    ));

                $this->success("添加成功", __APP__ . "/admin/lst");

            } else {
                $error = $model->getError();
                $this->success("{$error}", __APP__ . "/admin/add");
            }
        } else {

            $this->assign(array(
                "page_title" => "添加管理员",
                "page_btn" => "管理员列表",
                "page_url" => __APP__ . "/admin/lst",
                "arinfo"=>$arinfo,
            ));
            $this->display();
        }

    }


    public function deladm(){
        $model=D("admin");
        if(($model->delete(I("get.id")) )>0){
            $this->success("删除成功",__APP__."/admin/lst");
        }else{
            $error=$model->getError();
            $this->success("$error",__APP__."/admin/lst");
        }

    }

    public function edit(){
        $model=D('admin');

        $editinfo=$model->find(I('get.id'));
        
        $romodel=D("role");
        $roleinfo=$romodel->select();
        
        $armodel=D("admin_role");
        $arinfo=$armodel->field("group_concat(role_id) role_id")->where("admin_id=".I("get.id"))->select();

        
        $this->assign("editinfo",$editinfo);
        $this->assign(array(
            "page_title"=>"修改管理员",
            "page_btn"=>"管理员列表",
            "page_url"=>__APP__."/admin/lst",
            "roleinfo"=>$roleinfo   ,
            "arinfo"=>$arinfo[0]['role_id'],
        ));
        $this->display();
    }



    public function up(){
        $model=D('admin');

        if(IS_POST){
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            var_dump($_POST);exit;
            //TP用I函数进行接收数据
            if($model->create(I('post.'),2)){
                
                if($_POST['password']==""){
                    unset($_POST['password']);
                    $model->where("id={$_POST['id']}")->save(array(
                        "username"=>$_POST['username'],
                    ));
                }else{
                    $model->where("id={$_POST['id']}")->save(array(
                        "username"=>$_POST['username'],
                        "password"=>md5($_POST['password'])
                    ));
                }
                
                

                $this->success("修改成功",__ROOT__."/lst");

            }else{

                $error=$model->getError();
                $this->success("{$error}",__ROOT__."/edit");
            }
        }

    }

}