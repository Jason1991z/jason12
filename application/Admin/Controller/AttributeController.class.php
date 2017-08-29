<?php
namespace Admin\Controller;
use Think\Controller;


class AttributeController extends BaseController{
    public function lst(){


        /*********物品展示************/
        if(I("get.id")){
            $type_id=I("get.id");
        }elseif(I("get.type_id")){
            $type_id=I("get.type_id");
        }

        $attr_name=I("get.attr_name");
        $attr_type=I("get.attr_type");
        if($attr_name){
            $where=" and attr_name='{$attr_name}'";
        }elseif($attr_type=="-1"){
            $where="";
        }elseif($attr_type=="唯一" || $attr_type=="可选"){
            $where=" and attr_type='{$attr_type}'";
        }
        echo I("get.type_id");
       $attribute=M("attribute")->where("type_id={$type_id}".$where)->select();



        $this->assign(array(
            "page_title"=>"属性列表",
            "page_btn"=>"添加属性",
            "page_url"=>__APP__."/attribute/add",
            "attribute"=>$attribute,
        ));

        $this->display();
    }



    public function add()
    {
        $model = D('attribute');
        //TP自带的判断是否接收数据

        if (IS_POST) {
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            //也要建立对应的表模型
            $typeid=I("post.type_id");

            //TP用I函数进行接收数据
            if ($model->create(I('post.'), 1)) {
                $model->add();
                $this->success("添加成功", __APP__ . "/attribute/lst/id/{$typeid}");

            } else {
                $error = $model->getError();
                $this->success("{$error}", __APP__ . "/attribute/add");
            }
        } else {

            $this->assign(array(
                "page_title" => "添加属性",
                "page_btn" => "属性列表",
                "page_url" => __APP__ . "/attribute/lst",

            ));
            $this->display();
        }

    }


    public function del(){
        $model=D("attribute");
        if(($model->delete(I("get.id")) )>0){
            $typeid=I('get.type_id');
            $this->success("删除成功",__APP__."/attribute/lst/id/{$typeid}");
        }else{
            $error=$model->getError();
            $this->success("$error",__APP__."/attribute/lst");
        }

    }

    public function edit(){
        $model=D('attribute');

        $editinfo=$model->find(I('get.id'));



        $this->assign("editinfo",$editinfo);
        $this->assign(array(
            "page_title"=>"修改属性",
            "page_btn"=>"属性列表",
            "page_url"=>__APP__."/attribute/lst",
            "editinfo"=>$editinfo,
        ));
        $this->display();
    }



    public function up(){
        $model=D('attribute');

        if(IS_POST){
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹

            //TP用I函数进行接收数据
            if($model->create(I('post.'),2)){

                $id=$_POST['id'];
                $data=array(
                    "attr_name"=>$_POST['attr_name'],
                    "attr_type"=>$_POST['attr_type'],
                    "attr_option_values"=>$_POST['attr_option_values'],
                    "type_id"=>$_POST['type_id']
                );
                $model->where("id={$id}")->save($data);

                $typeid=I('post.type_id');
                $this->success("修改成功",__APP__."/attribute/lst/id/$typeid");

            }else{

                $error=$model->getError();
                $this->success("{$error}",__APP__."/attribute/edit");
            }
        }

    }

}