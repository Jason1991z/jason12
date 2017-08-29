<?php
namespace Admin\Controller;
use Think\Controller;


class TypeController extends BaseController{
    public function lst(){
        $type_model=D("type");

        /*********类型展示************/
        $arr=$type_model->showtypes();
        $pageList=$arr[0];
        $typeinfo=$arr[1];


        $this->assign(array(
            "page_title"=>"类型列表",
            "page_btn"=>"添加类型",
            "page_url"=>__APP__."/Type/add",
            "typeinfo"=>$typeinfo,
            "pageList"=>$pageList,
        ));

        $this->display();
    }

    public function deltype(){
        $model=D("type");
        if($model->delete(I("get.id")) >0){

           $this->success("删除成功",__APP__."/type/lst");
        }else{
            $error=$model->getError();
            $this->success("$error",__APP__."/type/lst");
        }

    }

    public function edit(){
        $id=I('get.id');
        $model=D('type');

        $editinfo=$model->find(I('get.id'));


        $this->assign("editinfo",$editinfo);
        $this->assign(array(
            "page_title"=>"修改类型",
            "page_btn"=>"类型列表",
            "page_url"=>__APP__."/type/lst",

            "editinfo"=>$editinfo,

        ));
        $this->display();
    }

    public function up(){
        $model=D('type');

        if(IS_POST){
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹

            //TP用I函数进行接收数据
            if($model->create(I('post.'),2)){
                $id=$_POST["id"];
                $type_name=$_POST[type_name];
                if($model->where("id={$id}")->setField("type_name",$type_name)){
                    $this->success("修改成功",__ROOT__."/lst");
                }
            }else{
                $error=$model->getError();
                $this->success("{$error}",__ROOT__."/edit");
            }
        }

    }

    public function add()
    {
        $model = D('type');

        //TP自带的判断是否接收数据
        if (IS_POST) {
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            //也要建立对应的表模型


            //TP用I函数进行接收数据
            if ($model->create(I('post.'), 1)) {
                $model->add();
                $this->success("添加成功", __APP__ . "/type/lst");

            } else {
                $error = $model->getError();
                $this->success("{$error}", __APP__ . "/type/add");
            }
        } else {

            $this->assign(array(
                "page_title" => "添加类型",
                "page_btn" => "类型列表",
                "page_url" => __APP__ . "/type/lst",

            ));
            $this->display();
        }

    }


}
