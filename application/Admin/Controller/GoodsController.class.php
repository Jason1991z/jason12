<?php
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends BaseController{
    //goods_number商品库存添加显示
    public function goods_number(){
        $goods_id=I("get.id");
        $gamodel=D("goods_attr");
        $gnmodel=D("goods_number");

        /***处理数据提交表单***/
        if(IS_POST){
            /***修改前先删除数据后再添加进去***/
            $gnmodel->where("goods_id=".I("post.goods_id"))->delete();
            
            $good_attr_id=I("post.good_attr_id");
            $goods_number=I("post.goods_number");


            /***获取倍率***/
            $gaiC=count($good_attr_id);
            $gnC=count($goods_number);
            $rate=$gaiC/$gnC;
            $_i=0;
            foreach($goods_number as $k=>$v){
                $_arr=array();
                for($i=0;$i<$rate;$i++){
                    $_arr[]=$good_attr_id[$_i];
                    $_i++;
                }
                
                /***数组转字符串,并以升序排列***/
                sort($_arr,SORT_NUMERIC);
                
                $str=implode(",",$_arr);

                $gnmodel->add(array(
                        "goods_id"=>I("post.goods_id"),
                        "goods_number"=>$v,
                        "goods_attr_id"=>$str,
                    ));
            }
            
            $this->success("设置成功",__APP__."/goods/goods_number/id/".I("post.goods_id"));
        }
        
        $gainfo=$gamodel->field("a.*,b.attr_name,b.attr_type")->alias("a")
        ->join("left join attribute b on a.attr_id=b.id")
        ->where("goods_id={$goods_id} and b.attr_type='可选'")->select();

        /***goods_number中如果有数据就取出显示***/
        $gninfo=$gnmodel->where("goods_id={$goods_id}")->select();
        
        
        $_gainfo=array();
        foreach($gainfo as $k=>$v){
            if($v['attr_type']=='可选'){
                $_gainfo[$v['attr_name']][]=$v;
            }
        }
        
        $this->assign(array(
            "page_title"=>"库存量",
            "page_btn"=>"返回列表",
            "page_url"=>__APP__."/Goods/lst",
            "gainfo"=>$gainfo,  
            "_gainfo"=>$_gainfo,
            "gninfo"=>$gninfo,
        ));


        $this->display();
    }

    //ajax处理商品[-]属性值
    public function ajaxdelattr(){
        $id=I("get.gaid");
        $gamodel=D("goods_attr");
        $gamodel->where("id={$id}")->delete();

        //删除库存量相应的属性商品
        $goodid=I("get.goods_id");
        $goodnumod=D("goods_number");
        $goodnumod->where("goods_id={$goodid} and find_in_set({$id},goods_attr_id)")->delete();

    }
    //ajax处理商品属性
    public function ajaxgetattr(){
        $typeid=I("get.type_id");
        $attrmodel=D("attribute");
        $data=$attrmodel->where("type_id={$typeid}")->select();
        echo json_encode($data);

    }
    // 处理AJAX删除图片的请求
    public function ajaxDelPic()
    {
        $picId = I('get.picid');
        // 根据ID从硬盘上数据删除中删除图片
        $gpModel = D('goods_pic');
        $pic = $gpModel->field('pic,sm_pic,mid_pic,big_pic')->find($picId);
        // 从硬盘删除图片
        deleteImage($pic);
        // 从数据库中删除记录
        $gpModel->delete($picId);
    }
    public function index(){
        //查询品牌
        $brand_model=D("brand");
        $cat_model=D("category");

        $member_model=D("member_level");
        $member=$member_model->select();
        $arr=$cat_model->getTree();

        $brand_name=$brand_model->query("select * from brand");
        $this->assign(array(
            "page_title"=>"添加商品",
            "page_btn"=>"商品列表",
            "page_url"=>__APP__."/Goods/lst",
            "brand_name"=>$brand_name,
            "member"=>$member,
            "tree"=>$arr,
        ));


        $this->display();
    }

    public function add(){
        $model=D('goods');

        //TP自带的判断是否接收数据
        if(IS_POST){

            //如果使用create方法,只能用D函数而不能用M函数,model文件夹
            //也要建立对应的表模型


            //TP用I函数进行接收数据
            if($model->create(I('post.'),1)){
                if($model->add()){
                    
                    //$this->success("添加成功",__APP__."/Goods/lst");
                }
            }else{
                $error=$model->getError();
                $this->success("{$error}",__APP__."/Goods/index");
            }
        }else{
            $this->display("index");
        }

    }

    public function lst(){
        
        $model=D('goods');

        $membermodel=D('member_level');
        $cat_model=D("category");

        $tree=$cat_model->getTree();
        /*********物品展示************/
        $arr=$model->showgoods();
        $pageList=$arr['0'];
        $goodsinfo=$arr['1'];

        $this->assign("pageList",$pageList);
        $this->assign("goodsinfo",$goodsinfo);
        $this->assign(array(
            "page_title"=>"商品列表",
            "page_btn"=>"添加商品",
            "page_url"=>__APP__."/Goods/index",
            "tree"=>$tree
        ));
        $this->display();
    }

    public function delgoods($id){
        $model=D("goods");
        if(($model->delete(I("get.id")) )>0){
            $this->success("删除成功",__APP__."/Goods/lst");
        }else{
            $error=$model->getError();
            $this->success("$error",__APP__."/Goods/lst");
        }

    }

    public function edit(){

        $id=I('get.id');

        $model=D('goods');
        $cat_model=D('category');
        $gp_model=D("goods_pic");
        $gc_model=D("goods_cat");
        $brand_model=D("brand");
        $attr_model=D("attribute");



        $gc_data=$gc_model->where("goods_id={$id}")->select();

        $brand=$brand_model->select();

        $pic=$gp_model->field("id,mid_pic")->where("goods_id={$id}")->select();


        $member=M("member_price")->join("left join member_level on member_price.level_id=member_level.id")->where("goods_id={$id}")->select();


        $editinfo=$model->find(I('get.id'));

        $attrinfo=$attr_model->alias("a")
            ->field("a.id attrs_id,a.attr_name,a.attr_type,a.attr_option_values,a.type_id,b.id,b.attr_value,b.attr_id,b.goods_id")
            ->join("left join goods_attr b on a.id=b.attr_id and b.goods_id={$id}")
            ->where("a.type_id={$editinfo['type_id']}")
            ->order("attr_id asc")
            ->select();

        $tree=$cat_model->getTree();
        $children=$cat_model->getChildren(I('get.id'));

        $this->assign("editinfo",$editinfo);
        $this->assign(array(
            "page_title"=>"修改商品",
            "page_btn"=>"商品列表",
            "page_url"=>__APP__."/Goods/lst",
            "tree"=>$tree,
            "children"=>$children,
            "member"=>$member,
            "pic"=>$pic,
            "gc_data"=>$gc_data,
            "brand"=>$brand,
            "editinfo"=>$editinfo,
            "attrinfo"=>$attrinfo,
        ));
        $this->display();
    }

    public function up(){
        $model=D('goods');
        
        if(IS_POST){
            //var_dump($_POST);
            //如果使用create方法,只能用D函数而不能用M函数,model文件夹

            //TP用I函数进行接收数据
            if($model->create(I('post.'),2)){
                if($model->save()){
                    //echo M()->getLastSql();
                    $this->success("修改成功",__ROOT__."/lst");
                }
            }else{
                //echo M()->getLastSql();
                $error=$model->getError();
                $this->success("{$error}",__ROOT__."/edit");
            }
        }

    }
}