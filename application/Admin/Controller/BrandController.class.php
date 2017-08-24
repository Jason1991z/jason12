<?php
namespace Admin\Controller;
use Think\Controller;

class BrandController extends Controller{
	public function index(){
		$this->assign(array(
				"page_title"=>"添加品牌",
				"page_btn"=>"品牌列表",
				"page_url"=>__APP__."/Brand/lst"
		));
		$this->display();
	}

	public function add(){

		//TP自带的判断是否接收数据
		if(IS_POST){
			//如果使用create方法,只能用D函数而不能用M函数,model文件夹
			//也要建立对应的表模型
			$model=D('brand');

			//TP用I函数进行接收数据
			if($model->create(I('post.'),1)){
				if($model->add()){
					$this->success("添加成功",__APP__."/Brand/lst");
				}
			}else{
				$error=$model->getError();
				$this->success("{$error}",__APP__."/Brand/index");
			}
		}else{

			$this->display("index");
		}

	}

	public function lst(){

		$model=D('brand');


		/*********物品展示************/
		$arr=$model->showbrand();
		$pageList=$arr['0'];
		$goodsinfo=$arr['1'];

		$this->assign("pageList",$pageList);
		$this->assign("goodsinfo",$goodsinfo);
		$this->assign(array(
				"page_title"=>"品牌列表",
				"page_btn"=>"添加品牌",
				"page_url"=>__APP__."/Brand/index"
		));
		$this->display();
	}

	public function delbrand(){
		$model=D("brand");
		if(($model->delete(I("get.id")) )>0){
			$this->success("删除成功",__APP__."/Brand/lst");
		}else{
			$error=$model->getError();
			$this->success("$error",__APP__."/Brand/lst");
		}

	}

	public function edit(){
		$model=D('brand');

		$editinfo=$model->find(I('get.id'));

		$this->assign("editinfo",$editinfo);
		$this->assign(array(
				"page_title"=>"修改品牌",
				"page_btn"=>"品牌列表",
				"page_url"=>__APP__."/Brand/lst"
		));
		$this->display();
	}

	public function up(){
		$model=D('brand');

		if(IS_POST){
			//如果使用create方法,只能用D函数而不能用M函数,model文件夹

			//TP用I函数进行接收数据
			if($model->create(I('post.'),2)){
				if($model->save()){

					$this->success("修改成功",__ROOT__."/lst");
				}
			}else{

				$error=$model->getError();
				$this->success("{$error}",__ROOT__."/edit");
			}
		}

	}
}