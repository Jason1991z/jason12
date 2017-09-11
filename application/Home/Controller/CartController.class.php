<?php
namespace Home\Controller;
use Think\Controller;

class CartController extends Controller 
{	
	//ajax自己改变商品数量
	public function ajaxWriNum(){
		//获取商品id
		$goods_id=I("get.goods_id");
		$num=I("get.num");
		$memberId=session("m_id");

		//自减
		$cartModel=D("cart");
		$cartModel->where(array(
			"goods_id"=>array("eq",$goods_id),
			"member_id"=>array("eq",$memberId),
			))->save(array("goods_number"=>$num));
	}

	//ajax减商品数量
	public function ajaxReduce(){
		//获取商品id
		$goods_id=I("get.goods_id");
		$memberId=session("m_id");
		//自减
		$cartModel=D("cart");
		$cartModel->where(array(
			"goods_id"=>array("eq",$goods_id),
			"member_id"=>array("eq",$memberId),
			))->setDec("goods_number");

	}

	//ajax增商品数量
	public function ajaxAdd(){
		//获取商品id
		$goods_id=I("get.goods_id");
		$memberId=session("m_id");
		//自减
		$cartModel=D("cart");
		$cartModel->where(array(
			"goods_id"=>array("eq",$goods_id),
			"member_id"=>array("eq",$memberId),
			))->setInc("goods_number");
	}

	public function adds(){
		$model=D("Cart");
		
		if(IS_POST){
			if($model->create(I('post.'),1)){
				
				if($model->add()){

					$this->redirect("/cart/lst");
				}
			}else{
				$this->error('添加失败，原因：'.$cartModel->getError());
			}
		}


	}
	



	public function lst(){
		$cartModel=D("cart");

		$data=$cartModel->cartList();

		//设置页面信息
		$this->assign(array(
				"data"=>$data,
				'_page_title' => '购物车列表',
    			'_page_keywords' => '购物车列表',
    			'_page_description' => '购物车列表',
			));

		$this->display();
	}

	public function delGoods(){
		//获取信息
		$goods_id=I("get.goods_id");
		$m_id=I("get.m_id");

		//删除商品
		$cartModel=D("cart");
		$cartModel->where(array(
				"goods_id"=>array("eq",$goods_id),
				"member_id"=>array("eq",$m_id),
			))->delete();
		
		redirect(__APP__."/cart/lst",3,"正在跳转页面");
	}

}





