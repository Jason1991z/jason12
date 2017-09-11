<?php
namespace Home\Model;
use Think\Model;
use Think\Cache;
class CartModel extends Model 
{
	// 加入购物车时允许接收的字段
	protected $insertFields = "goods_id,goods_attr_id,goods_number";
	// 加入购物车时的表单验证规则
	protected $_validate = array(
		array('goods_id', 'require', '必须选择商品', 1),
		//array('goods_number', 'chkGoodsNumber', '库存量不足！', 1, 'callback'),
	);
	
	//检查库存量
	public function chkGoodsNumber($goodsNumber){
		//获取商品属性id
		$gaid=I("post.goods_attr_id");
		$gaid=sort($gaid);
		$gaid=implode(",", $gaid);

		//获取商品id
		$goods_id=I("post.goods_id");

		//从数据库中取出库存量
		$gn=M("goods_number")->field("goods_number")->where(array(
				"goods_id"=>array("eq",$goods_id),
				"goods_attr_id"=>array("in",$gaid),
			))->find();

		return $gn['goods_number']>$goodsNumber;
	}
	

	public function add(){
		
		$memberId=session("m_id");
		
		$goods_attr_id=implode(",", I("post.goods_attr_id"));

		//判断有没有登录
		if($memberId){
			$goodsNumber=I("post.goods_number");

			//从数据库中取出数据并存到模型中
			$has=$this->field('id')->where(array(
					"member_id"=>$memberId,
					"goods_id"=>I("post.goods_id"),
					"goods_attr_id"=>$goods_attr_id,
				))->find();
			 
			//如果购物车中已经有这个商品就在员数量上加上这次购买的数量
			if($has){
				$this->where(array('id'=>$has['id']))->setInc("goods_number",$goodsNumber);
				
			}else{
				parent::add(array(
						"member_id"=>$memberId,
						"goods_id"=>I("post.goods_id"),
						"goods_attr_id"=>$goods_attr_id,
						"goods_number"=>$goodsNumber,

					));
				
			}
		}else{

			//判断有没有COOKIE,有就取,没有就空数组
			$cart=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();

			//拼一下下标
			$key=I("post.goods_id").'-'.$goods_attr_id;

			if(isset($cart[$key])){
				
				$cart[$key] += $this->goods_number;
			}else{

				//把商品加进去
				$cart[$key]=$this->goods_number;
				
			}

			//把一位数组存回到COOKIE
			setcookie('cart',serialize($cart),time()+30*86400,"/");
		}
		return true;
	}
	/**
	 * \
	 * 把COOKIE中的数据移动到数据库中
	 */
	public function moveDataToDb(){
		$memberId=session('m_id');
		if($memberId){
			$cart=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();

			//循环购物车中每件商品
			foreach($cart as $k=>$v){
				$_k=explode("-",$k);
				//判断数据库中是否有这件商品
				$has=$this->field("id")->where(array(
						"member_id"=>$memberId,
						"goods_id"=>$_k[0],
						"goods_attr_id"=>$_k[1],
					))->find();

				//如果购物车中已经有这个商品就在员数量上加上这次购买的数量
				if($has){
					$memberId=session("m_id");
					$this->where(array("id"=>array("eq",$has['id'])))->setInc("goods_number",$v);

				}else{
					parent::add(array(
							"member_id"=>$memberId,
							"goods_id"=>$_k[0],
							"goods_attr_id"=>$_k[1],
							"goods_number"=>$v,
						));
				}
			}
			//清空cookie
			setcookie('cart',"",time()-1,"/");
		}
	}

	/**
	 *获取购物车中商品的详细信息
	 *
	 */
	public function cartList(){
		/*******先从购物车中取出商品的ID********/
		$memberId=session("m_id");
		if($memberId){
			$data=$this->where(array(
					"member_id"=>array("eq",$memberId),
				))->select();
		}else{
			$_data=isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();

			//把一维转成和上面一样的二维
			$data=array();
			foreach($data as $k=>$v){
				// 从下标中取出商品ID和商品属性ID
				$_k = explode('-', $k);
				$data[] = array(
					'goods_id' => $_k[0],
					'goods_attr_id' => $_k[1],
					'goods_number' => $v,
				);
			}
		}


		/**********再根据ID取出商品的详细信息*********/
		$gModel=D("Admin/Goods");
		$gaModel=D("goods_attr");

		//循环取出每件商品的详细信息
		foreach($data as $k=>$v){
			//取出商品名称和LOGO
			$info=$gModel->field("goods_name,mid_logo")->find($v["goods_id"]);
			//在存回到这个二维数组中
			$data[$k]['goods_name']=$info['goods_name'];
			$data[$k]['mid_logo']=$info['mid_logo'];
			
			//计算实际的购买价格
			$data[$k]['price']=$gModel->getMemberPrice($v['goods_id']);
			//根据商品属性ID计算出商品属性名称和属性值:属性名称:属性值
			if($v['goods_attr_id']){
				$data[$k]['gaData']=$gaModel->alias("a")
									 ->field("a.attr_value,b.attr_name")
									 ->join('attribute b on a.attr_id =b.id')
									 ->where(array(
									 		"a.id"=>array("in",$v['goods_attr_id'])
									 	))
									 ->select();
			}
		}

		return $data;
	}


}














