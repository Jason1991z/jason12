<?php
namespace Admin\Controller;
use Think\Controller;


class RoleController extends BaseController{
    public function lst(){
        $model=D("role");

        /*********物品展示************/
        $arr=$model->field("a.*,group_concat(c.pri_name separator'<br/>') pri_name")->alias("a")
        ->join("left join role_pri b on a.id = b. role_id")
        ->join("left join privilege c on c.id=b.pri_id")
        ->group("role_name")
        ->select();
        

        $this->assign(array(
            "page_title"=>"角色列表",
            "page_btn"=>"添加角色",
            "page_url"=>__APP__."/role/add",
            "role"=>$arr
        ));

        $this->display();
    }



    public function add()
    {
        $model = D('role');
        $primodel=D('privilege');
        $tree=$primodel->getTree();
        //TP自带的判断是否接收数据
        if (IS_POST) {
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            //也要建立对应的表模型

            //TP用I函数进行接收数据
            if ($model->create(I('post.'), 1)) {
                $model->add();
                $this->success("添加成功", __APP__ . "/role/lst");

            } else {
                $error = $model->getError();
                $this->success("{$error}", __APP__ . "/role/add");
            }
        } else {

            $this->assign(array(
                "page_title" => "添加角色",
                "page_btn" => "角色列表",
                "page_url" => __APP__ . "/role/lst",
                "tree"=>$tree
            ));
            $this->display();
        }

    }


    public function delrol(){
        $model=D("role");
        if(($model->delete(I("get.id")) )>0){
            $this->success("删除成功",__APP__."/role/lst");
        }else{
            $error=$model->getError();
            $this->success("$error",__APP__."/role/lst");
        }

    }

    public function edit(){
        $model=D('role');

        $editinfo=$model->find(I('get.id'));
        
        $primodel=D('privilege');
        $tree=$primodel->getTree();

        $rpmodel=D("role_pri");
        $rpinfo=$rpmodel->field("group_concat(role_id) role_id ,role_name")->alias("a")
        ->join("left join role b on b.id=a.role_id")
        ->where("role_id=".I("get.id"))->select();
        
        $this->assign("editinfo",$editinfo);
        $this->assign(array(
            "page_title"=>"修改角色",
            "page_btn"=>"角色列表",
            "page_url"=>__APP__."/role/lst",
            "tree"=>$tree,
            "rpinfo"=>$rpinfo[0]['pri_id'],
        ));
        $this->display();
    }



    public function up(){
        $model=D('role');

        if(IS_POST){
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹

            //TP用I函数进行接收数据
            if($model->create(I('post.'),2)){
                
                

                $model->where("id={$_POST['id']}")->save(array(
                        "role_name"=>I("post.role_name")
                    ));
                

                $this->success("修改成功",__ROOT__."/lst");

            }else{

                $error=$model->getError();
                $this->success("{$error}",__ROOT__."/edit");
            }
        }

    }

}