<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class BrandModel extends Model{
	//只允许接收某些字段

	protected $insertFields=array('brand_name','site_url');
	protected $updateFields = array('id','brand_name','site_url');
	//TP验证接收过来的数据
	protected $_validate=array(
			array('brand_name', 'require', '品牌名称不能为空！', 1, 'regex', 3),
			array('brand_name', '1,30', '品牌名称的值最长不能超过 30 个字符！', 1, 'length', 3),
			array('site_url', '1,150', '官方网址的值最长不能超过 150 个字符！', 2, 'length', 3),
	);

	protected function _before_insert(&$data,$option){

		// 判断有没有选择图片
		if($_FILES['logo']['error']==0) {
			$ret = uploadOne('logo', 'brand');
			if ($ret['ok'] == 1) {
				$data['logo'] = $ret['images'][0];
			} else {
				$this->error = $ret['error'];
				return FALSE;
			}
		}



	}

	public function showbrand($pageshow=5){

		/*********搜索查询************/

		$where=array();
		$gn=I('get.gn');
		$fp=I('get.fp');
		$tp=I('get.tp');
		$fa=I('get.fa');
		$ta=I('get.ta');
		$ios=I('get.ios');
		//名称
		if($gn) {
			$where['goods_name'] = array('like', "%$gn%");
		}
		//价格
		if($fa !="" and $ta !=""){
			$where['addtime']=array('between',array($fa,$ta));
		}elseif($fa =="" and $ta!=""){
			$where['addtime']=array('elt',"$ta");
		}elseif($fa !="" and $ta==""){
			$where['addtime']=array('egt',"$fa");
		}
		//添加时间
		if($fp !="" and $tp !=""){
			$where['shop_price']=array('between',array($fp,$tp));
		}elseif($fp =="" and $tp!=""){
			$where['shop_price']=array('elt',"$tp");
		}elseif($fp !="" and $tp==""){
			$where['shop_price']=array('egt',"$fp");
		}

		if($ios){
			$where['is_on_sale']=array('eq',"$ios");
		}

		/**********排序方式***********/
		$odby=I('get.odby');

		$orbyway="asc";
		$orbyval="id";
		if($odby=="id_desc"){
			$orbyval="id";
			$orbyway="desc";
		}elseif($odby=="id_asc") {
			$orbyway="asc";
			$orbyval="id";
		}elseif($odby=="price_desc"){
			$orbyway="desc";
			$orbyval="shop_price";
		}elseif($odby=="price_asc"){
			$orbyway="asc";
			$orbyval="shop_price";
		}


		/******分页变量*******/
		$totalRow=$this->where($where)->count();

		$page=new Page($totalRow,$pageshow);
		/********美化分页**********/
		$page->setConfig("next","下一页");
		$page->setConfig("prev","上一页");

		$goodsinfo=$this->where($where)->order("$orbyval $orbyway")->limit($page->firstRow,$page->listRows)->select();

		$pageList=$page->show();

		$arr=array($pageList,$goodsinfo);
		return $arr;

	}

	protected function _before_delete($option){

		$id=$option['where']['id'];
		//删除文件之前先查询数据库中图片路径
		$path=$this->field("logo")->find($id);
		deleteImage($path);
	}

	protected function _before_update(&$data,$option){


		$id=I('post.id');

		$data['brand_name']=I('post.brand_name');
		$data['site_url']=I('post.site_url');

		//判断图片是否有更改,如有更改就删除原图片,上传新图片
		if($_FILES["logo"]["error"]==0){
			//删除文件之前先查询数据库中图片路径
			$path=$this->field("logo")->find($id);
			deleteImage($path);

			/**********添加图片**************/
			$ret = uploadOne('logo', 'brand');
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
			}
			else
			{
				$this->error = $ret['error'];
				return FALSE;
			}
		}
	}

}