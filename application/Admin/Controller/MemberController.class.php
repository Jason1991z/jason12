<?php
namespace Admin\Controller;
use Think\Controller;


class MemberController extends BaseController{
    public function lst(){
        $model=D("member_level");

        /*********物品展示************/
        $arr=$model->showMembers();
        $pageList=$arr['0'];
        $memberinfo=$arr['1'];

        $this->assign("pageList",$pageList);
        $this->assign("memberinfo",$memberinfo);
        $this->assign(array(
            "page_title"=>"会员列表",
            "page_btn"=>"添加会员",
            "page_url"=>__APP__."/Member/add"
        ));

        $this->display();
    }



    public function add()
    {

        //TP自带的判断是否接收数据
        if (IS_POST) {
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            //也要建立对应的表模型
            $model = D('member_level');

            //TP用I函数进行接收数据
            if ($model->create(I('post.'), 1)) {
                $model->add();
                $this->success("添加成功", __APP__ . "/Member/lst");

            } else {
                $error = $model->getError();
                $this->success("{$error}", __APP__ . "/Member/add");
            }
        } else {

            $this->assign(array(
                "page_title" => "会员添加",
                "page_btn" => "会员列表",
                "page_url" => __APP__ . "/Member/lst"
            ));
            $this->display();
        }

    }


    public function delmember(){
        $model=D("member_level");
        if(($model->delete(I("get.id")) )>0){
            $this->success("删除成功",__APP__."/Member/lst");
        }else{
            $error=$model->getError();
            $this->success("$error",__APP__."/Member/lst");
        }

    }

    public function edit(){
        $model=D('member_level');

        $editinfo=$model->find(I('get.id'));

        $this->assign("editinfo",$editinfo);
        $this->assign(array(
            "page_title"=>"修改会员",
            "page_btn"=>"会员列表",
            "page_url"=>__APP__."/Member/lst"
        ));
        $this->display();
    }



    public function up(){
        $model=D('member_level');

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