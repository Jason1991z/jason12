<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class GoodsModel extends Model{
    //只允许接收某些字段

    protected $insertFields="goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,price,cat_id,type_id";
    protected $updateFields="cat_id,id,goods_name,market_price,shop_price,is_on_sale,goods_desc,member_price[],brand_id,";
    //TP验证接收过来的数据
    protected $_validate=array(
        array("goods_name","require","商品名称不能空!",1),
        array("market_price","currency","市场价格必须是货币类型！",1),
        array('shop_price', 'currency', '本店价格必须是货币类型！', 1),


    );

    protected function _before_insert(&$data,$option){

        $data['addtime']=date('Y-m-d H:i:s',time());

        $data['goods_desc']=removeXSS($_POST['goods_desc']);

        // 判断有没有选择图片
        if($_FILES["logo"]["error"]==0) {
            $ret = uploadOne('logo', 'goods', array(
                array(700, 700),
                array(350, 350),
                array(130, 130),
                array(50, 50),
            ));
            if ($ret['ok'] == 1) {
                $data['logo'] = $ret['images'][0];
                $data['mbig_logo'] = $ret['images'][1];
                $data['big_logo'] = $ret['images'][2];
                $data['mid_logo'] = $ret['images'][3];
                $data['sm_logo'] = $ret['images'][4];
            } else {
                $this->error = $ret['error'];
                return FALSE;
            }
        }



    }

    public function category($cat_id){
        $cat_model=D("category");
        $children=$cat_model->getChildren($cat_id);
        $children[]=$cat_id;
        $children=implode(",",$children);

        /*********************主分类下的子类的商品Id或扩展类的商品Id************************/

        //1.取出商品在主类下的商品Id
        $gids=$this->field("id")->where("cat_id in ({$children})")->select();
        //$gids=4
        //2.取出扩展分类下的商品Id
        $gcmodel=D("goods_cat");
        $gids1=$gcmodel->field("distinct goods_id id")->where("cat_id in ({$children})")->select();
        //$gids1=null;
        //3.合并1,2的商品id;
        if($gids1 && $gids  ) {
            $gids = array_merge($gids1, $gids);
        }else if($gids1){
            $gids=$gids1;
        }
        $arr=array();
        foreach($gids as $k=>$v){
            if(!in_array($v['id'],$arr)){
                $arr[]=$v['id'];
            }
        }

        return $arr;
    }

    public function showgoods($pageshow=5){

        /*********搜索查询************/

        $where=array();
        $gn=I('get.gn');
        $fp=I('get.fp');
        $tp=I('get.tp');
        $fa=I('get.fa');
        $ta=I('get.ta');
        $ios=I('get.ios');
        $brand=I('get.brand');
        $tna=I('get.tna');

        //分类
        if($tna){
            $id=$this->category($tna);
            $id=implode(",",$id);
            $where["a.id"]=array("in","$id");

        }
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
        if($brand){
            $where['brand_id']=array('eq',"$brand");
        }

        /**********排序方式***********/
        $odby=I('get.odby');

        $orbyway="asc";
        $orbyval="a.id";
        if($odby=="id_desc"){
            $orbyval="a.id";
            $orbyway="desc";
        }elseif($odby=="id_asc") {
            $orbyway="asc";
            $orbyval="a.id";
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

        $goodsinfo=$this->field("a.*,b.brand_name,c.cat_name,group_concat(e.cat_name separator '<br/>') as ext_cat_name")
            ->alias("a")
            ->join("left join brand b on a.brand_id=b.id
                  left join category c on a.cat_id=c.cat_id
                  left join goods_cat d on a.id=d.goods_id
                  left join category e on e.cat_id=d.cat_id")
            ->where($where)->order("$orbyval $orbyway")
            ->group("a.id")
            ->limit($page->firstRow,$page->listRows)->select();

        $pageList=$page->show();

        $arr=array($pageList,$goodsinfo);
        return $arr;

    }

    protected function _before_delete($option){

        $id=$option['where']['id'];

        /***删除库存量***/
        $gnmodel=D("goods_number");
        $gnmodel->where("goods_id={$id}")->delete();

        /**********删除商品属性***********/
        $attrmodel=D("goods_attr");
        $attrmodel->where("goods_id={$id}")->delete();




        /******************删除扩展分类*******************/
        $gc=D("goods_cat");
        $gc->where("goods_id={$id}")->delete();

        /**************删除文件路径****************/

        //删除文件之前先查询数据库中图片路径
        $path=$this->field("logo,sm_logo,mid_logo,big_logo,mbig_logo")->find($id);
        deleteImage($path);


        /*****************删除会员价格*********************/
        $mp=D("member_price");
        $mp->where("goods_id={$id}")->delete();

        /*****************删除磁盘中相册图片*****************/
        $gp=D("goods_pic");
        //循环删除每个文件
        $pics=$gp->where("goods_id={$id}")->select();

        foreach($pics as $k=>$v){
            $arr=array();
            $arr=array(
                "pic"=>$v['pic'],
                "sm_pic"=>$v['sm_pic'],
                "mid_pic"=>$v['mid_pic'],
                "big_pic"=>$v['big_pic'],
            );
            deleteImage($arr);
            $gp->where("id={$v['id']}")->delete();
        }



    }

    protected function _before_update(&$data,$option){
            $id=I('post.id');
        /*********处理商品属性更新*************/
        
            $gamodel=D("goods_attr");
            $attrinfo=I("post.attr_value");
            $gaid=I("post.goods_attr_id");
            /*echo"<pre>";
            var_dump($attrinfo);
            echo"</pre>";
            echo"<pre>";
            var_dump($gaid);
            echo"</pre>";*/
            $i=0;
            foreach($attrinfo as $k=>$v){
                foreach($v as $k1=>$v1){
                    if($gaid[$i]==""){
                        //如果新[+]了属性就insert,否则update
                        //如果这个值不在原有属性中就添加
                        
                            $data=array(
                                "attr_value"=>$v1,
                                "attr_id"=>$k,
                                "goods_id"=>$id,
                            );
                            $gamodel->add($data);
                        
                    }else{
                        //如果有修改
                        
                            $gamodel->where("id={$gaid[$i]}")->setField("attr_value",$v1);
                        
                    }
                    $i++;
                }
            }

        
        $data['goods_desc']=removeXSS($_POST['goods_desc']);
        $data['goods_name']=I('post.goods_name');
        $data['shop_price']=I('post.shop_price');
        $data['is_on_sale']=I('post.is_on_sale');
        $data['market_price']=I('market_price');
        $data['goods_desc']=I('goods_desc');


        //判断图片是否有更改,如有更改就删除原图片,上传新图片
        if($_FILES["logo"]["error"]==0){
            //删除文件之前先查询数据库中图片路径
            $path=$this->field("logo,sm_logo,mid_logo,big_logo,mbig_logo")->find($id);
            deleteImage($path);

            /**********添加图片**************/
            if($_FILES['logo']['error']==0) {
                $ret = uploadOne('logo', 'goods', array(
                    array(700, 700),
                    array(350, 350),
                    array(130, 130),
                    array(50, 50),
                ));
                if ($ret['ok'] == 1) {
                    $data['logo'] = $ret['images'][0];
                    $data['mbig_logo'] = $ret['images'][1];
                    $data['big_logo'] = $ret['images'][2];
                    $data['mid_logo'] = $ret['images'][3];
                    $data['sm_logo'] = $ret['images'][4];
                } else {
                    $this->error = $ret['error'];
                    return FALSE;
                }
            }

        }

        /*****************处理相册图片*******************/
        if(isset($_FILES['pic'])){

            $pics=array();

            foreach($_FILES['pic']['name'] as $k=>$v){
                $pics[]=array(
                    "name"=>$v,
                    "type"=>$_FILES['pic']['type'][$k],
                    "tmp_name"=>$_FILES['pic']['tmp_name'][$k],
                    "error"=>$_FILES['pic']['error'][$k],
                    "size"=>$_FILES['pic']['size'][$k]
                );
            }
        }

        $_FILES=$pics;

        $gpmodel=D("goods_pic");
        foreach($pics as $k=>$v){
            if($v['error']==0){
                $ret = uploadOne($k, 'Goods', array(
                    array(650, 650),
                    array(350, 350),
                    array(50, 50),
                ));
                if ($ret['ok'] == 1) {
                    $gpmodel->add(array(
                        "pic"=>$ret['images'][0],
                        "big_pic"=>$ret['images'][1],
                        "mid_pic"=>$ret['images'][2],
                        "sm_pic"=>$ret['images'][3],
                        "goods_id"=>$id
                    ));
                }
            }
        }



        /*****************会员价格更新*******************/
        $mp = I('post.member_price');
        $mpModel = D('member_price');
        // 先删除原来的会员价格
        $mpModel->where(array(
            'goods_id' => array('eq', $id),
        ))->delete();

        foreach ($mp as $k => $v)
        {
            $_v = (float)$v;
            // 如果设置了会员价格就插入到表中
            if($_v > 0)
            {
                $mpModel->add(array(
                    'price' => $_v,
                    'level_id' => $k+1,
                    'goods_id' => $id,
                ));
            }
        }


        /************ 处理扩展分类 ***************/
        $ecid = I('post.ext_cat_id');
        $gcModel = D('goods_cat');
        // 先删除原分类数据
        $gcModel->where("goods_id={$id}")->delete();
        if($ecid)
        {
            foreach ($ecid as $k => $v)
            {
                if(empty($v))
                    continue ;
                $gcModel->add(array(
                    'cat_id' => $v,
                    'goods_id' => $id,
                ));
            }
        }



    }

    public function _after_insert($data,$option)
    {

        /*************处理商品属性****************/
        $attrmodel=D("goods_attr");
        $attrinfo=I('post.attr_value');
        foreach($attrinfo as $k=>$v){
            array_unique($v);
            foreach($v as $k1=>$v1){
                $attrmodel->add(array(
                    "attr_value"=>$v1,
                    "attr_id"=>$k,
                    "goods_id"=>$data['id'],
                ));
            }
        }
        /*********处理会员价格************/
        $mp=I('post.price');

        $model=D('member_price');

        foreach($mp as $k=>$v){
            $val=(float)$v;
            if($val>0){
            $model->add(array(
                "price"=>$v,
                "level_id"=>$k,
                "goods_id"=>$data['id']
            ));
            }
        }

        //添加扩展类 cat_id,goods_id

        $cat_goods_model=D("goods_cat");
        $extinfo=I('post.ext_cat_id');

        foreach($extinfo as $v){
            if(empty($v)){
                continue;
            }
            $arr=array(

                "cat_id"=>$v,
                "goods_id"=>$data['id'],
            );
            $cat_goods_model->add($arr);
        }

    }


}