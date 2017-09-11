<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class IndexController extends NavController {
    //ajax获取最近浏览历史
    public function AjaxLook_history(){
        $data=isset($_COOKIE['history'])?unserialize($_COOKIE['history']):array();

        $idata=implode(',', $data);

        $goodsModel=D("goods");
        
        if($data!=""){
        $gdata=$goodsModel->field("mid_logo,goods_name,id")->where(array(
                "id"=>array("in",$idata),
                "is_on_sale"=>array("eq","是"),
            ))->order("field(id,{$idata})")->select();
        }else{
            $gdata="";
        }
        
        echo json_encode($gdata);
    }

    //ajax 获取用户中心信息
    public function AjaxUserCenter(){
        $m_id=session("m_id");

        if($m_id!=""){
            $data=M("Member")->field("username,face,jifen")->where(array(
                "id"=>$m_id
            ))->find();
        }else{
            $data="";
        }
        echo json_encode($data);
    }

    //ajax获取该用户该商品会员价格
    public function ajaxGetPrice(){
        $id=I("get.goods_id");
        $gmodel=D("Admin/Goods");
        $price=$gmodel->getMemberPrice($id);
        $a=M()->getLastSql();
        echo $price;
    }
    //ajax浏览历史
    public function dishistory(){
        $id=I("get.id");
        //从Cookie中取出浏览历史的ID数组
        $data=isset($_COOKIE['history'])?unserialize($_COOKIE['history']):array();
        //把新浏览物品放到数组第一个位置
        array_unshift($data,$id);
        //去重
        $data=array_unique($data);

        //只取数组中前6个
        if(count($data)>6){
            $data=array_slice($data,0,6);
        }
        setcookie("history",serialize($data),time()+30*86400,"/");
        $goodsModel=D("goods");
        $idata=implode(',', $data);
        $gdata=$goodsModel->field("mid_logo,goods_name,id")->where(array(
                "id"=>array("in",$data),
                "is_on_sale"=>array("eq","是"),
            ))->order("field(id,{$idata})")->select();
        
        echo json_encode($gdata);
        
    }

    public function index(){
		
        $model=D("Admin/Goods");
		
        //取出抢购商品
        $proinfo=$model->get_pro();
        
        //取出热卖商品
        $hotinfo=$model->get_good_info(is_hot);

        //取出推荐商品
        $bestinfo=$model->get_good_info(is_best);

        //取出新品
        $newinfo=$model->get_good_info(is_new);
		
		//取出顶层推荐
        $catModel=D("Admin/Category");
		$floorInfo=$catModel->get_floor();
        
    	$this->assign(array(
    			"_page_title"=>"商城首页",//title名称
    			"keyword"=>"商城首页",
    			"description"=>"商城首页",
    			"_show_nav"=>1,//控制导航菜单,0:关闭 1:显示
    			"proinfo"=>$proinfo,
                "hotinfo"=>$hotinfo,
                "bestinfo"=>$bestinfo,
                "newinfo"=>$newinfo,
                "floorInfo"=>$floorInfo,
    		));
        
        
        
        $this->display();
    }
    
	
    public function goods(){
        //获取面包屑导航
        //获取商品Id
        $id=I("get.id");
        //获取商品详情信息
        $info=M("goods")->find($id);
        //根据主分类ID找出这个分类所有上级
        $catInfo=D("Admin/Category")->getParents($info['cat_id']);
        
        //获取详情页图片
        $gpData=D("goods_pic")->where(array(
                "goods_id"=>array("eq",$id),
            ))->select();
        //取出这件商品所有的属性
        $gaData=D("goods_attr")->alias("a")
        ->field("a.*,b.attr_name,b.attr_type")
        ->join("left join attribute b on a.attr_id=b.id")
        ->where(array(
                "a.goods_id"=>array("eq",$id),
            ))
        ->select();

        //整理所有的商品,把唯一的和可选的属性分开放
        $uniArr=array();//唯一属性
        $mulArr=array();//可选属性
        foreach($gaData as $k=>$v){
            if($v['attr_type']=='唯一'){
                $uniArr[]=$v;
            }else{
                $mulArr[$v['attr_name']][]=$v;
            }
        }

        //取出这件商品的所有会员价格
        $mpData=D("member_price")->alias("a")
        ->field("a.price,b.level_name")
        ->join("left join member_level b on a.level_id=b.id")
        ->where(array(
                "a.goods_id"=>array("eq",$id),
            ))
        ->select();
        $viewPath=C("IMG_CONFIG");
        $this->assign(array(
                "_page_title"=>"商城首页",//title名称
                "keyword"=>"商城首页",
                "description"=>"商城首页",
                "_show_nav"=>0,//控制导航菜单,0:关闭 1:显示
                "info"=>$info,
                "catInfo"=>$catInfo,
                'gpData' => $gpData,
                'uniArr' => $uniArr,
                'mulArr' => $mulArr,
                'mpData' => $mpData,
                'viewPath' => $viewPath['viewPath'],
            ));
        
        $this->display();
    }
    
    /********************************************************/
}