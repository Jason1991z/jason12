<?php
namespace Admin\Controller;
use Think\Controller;


class PrivilegeController extends BaseController{
    public function lst(){
        $model=D("privilege");

        /*********物品展示************/
        $arr=$model->getTree();

        
        $this->assign(array(
            "page_title"=>"权限列表",
            "page_btn"=>"添加权限",
            "page_url"=>__APP__."/Privilege/add",
            "privilege"=>$arr
        ));

        $this->display();
    }



    public function add()
    {
        $model = D('privilege');
        $tree=$model->getTree();
        //TP自带的判断是否接收数据
        if (IS_POST) {
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            //也要建立对应的表模型


            //TP用I函数进行接收数据
            if ($model->create(I('post.'), 1)) {
                $model->add();
                $this->success("添加成功", __APP__ . "/privilege/lst");

            } else {
                $error = $model->getError();
                $this->success("{$error}", __APP__ . "/privilege/add");
            }
        } else {

            $this->assign(array(
                "page_title" => "添加权限",
                "page_btn" => "权限列表",
                "page_url" => __APP__ . "/privilege/lst",
                "tree"=>$tree
            ));
            $this->display();
        }

    }


    public function delpri(){
        $model=D("privilege");
        if(($model->delete(I("get.id")) )>0){
            $this->success("删除成功",__APP__."/privilege/lst");
        }else{
            $error=$model->getError();
            $this->success("$error",__APP__."/privilege/lst");
        }

    }

    public function edit(){
        $model=D('privilege');

        $editinfo=$model->find(I('get.id'));
        $tree=$model->getTree();
        $children=$model->getChildren(I('get.id'));


        $this->assign("editinfo",$editinfo);
        $this->assign(array(
            "page_title"=>"修改权限",
            "page_btn"=>"权限列表",
            "page_url"=>__APP__."/privilege/lst",
            "tree"=>$tree,
            "children"=>$children
        ));
        $this->display();
    }



    public function up(){
        $model=D('privilege');

        if(IS_POST){
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹

            //TP用I函数进行接收数据
            if($model->create(I('post.'),2)){
                
                $array=array();
                $array=array(
                        "pid"=>$_POST['pid'],
                        "pri_name"=>$_POST['pri_name'],
                        "module_name"=>$_POST['module_name'],
                        "controller_name"=>$_POST['controller_name'],
                        "action_name"=>$_POST['action_name'],
                    );
                $model->where("id={$_POST['id']}")->save($array);
                

                $this->success("修改成功",__ROOT__."/lst");

            }else{

                $error=$model->getError();
                $this->success("{$error}",__ROOT__."/edit");
            }
        }

    }

}