<?php
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends Controller{
    //goods_number商品库存添加显示
    public function goods_number(){
        
        $this->assign(array(
            '_page_title' => '库存量',
            '_page_btn_name' => '返回列表',
            '_page_btn_link' => "__APP__/goods/lst",
        
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
                    $this->success("添加成功",__APP__."/Goods/lst");
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