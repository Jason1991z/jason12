<?php
namespace Admin\Controller;
use Think\Controller;


class CategoryController extends Controller{
    public function lst(){
        $model=D("category");

        /*********物品展示************/
        $arr=$model->getTree();



        $this->assign(array(
            "page_title"=>"分类列表",
            "page_btn"=>"添加分类",
            "page_url"=>__APP__."/Category/add",
            "category"=>$arr
        ));

        $this->display();
    }



    public function add()
    {
        $model = D('category');
        $tree=$model->getTree();
        //TP自带的判断是否接收数据
        if (IS_POST) {
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            //也要建立对应的表模型


            //TP用I函数进行接收数据
            if ($model->create(I('post.'), 1)) {
                $model->add();
                $this->success("添加成功", __APP__ . "/Category/lst");

            } else {
                $error = $model->getError();
                $this->success("{$error}", __APP__ . "/Category/add");
            }
        } else {

            $this->assign(array(
                "page_title" => "添加分类",
                "page_btn" => "分类列表",
                "page_url" => __APP__ . "/Category/lst",
                "tree"=>$tree
            ));
            $this->display();
        }

    }


    public function delcategory(){
        $model=D("category");
        if(($model->delete(I("get.id")) )>0){
            $this->success("删除成功",__APP__."/Category/lst");
        }else{
            $error=$model->getError();
            $this->success("$error",__APP__."/Category/lst");
        }

    }

    public function edit(){
        $model=D('category');

        $editinfo=$model->find(I('get.id'));
        $tree=$model->getTree();
        $children=$model->getChildren(I('get.id'));


        $this->assign("editinfo",$editinfo);
        $this->assign(array(
            "page_title"=>"修改分类",
            "page_btn"=>"分类列表",
            "page_url"=>__APP__."/Category/lst",
            "tree"=>$tree,
            "children"=>$children
        ));
        $this->display();
    }



    public function up(){
        $model=D('category');

        if(IS_POST){
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹

            //TP用I函数进行接收数据
            if($model->create(I('post.'),2)){
                $model->save();

                $this->success("修改成功",__ROOT__."/lst");

            }else{

                $error=$model->getError();
                $this->success("{$error}",__ROOT__."/edit");
            }
        }

    }

}