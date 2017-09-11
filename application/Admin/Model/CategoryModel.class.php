<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class CategoryModel extends Model{
    //只允许接收某些字段

    protected $insertFields=array('cat_name','pid','is_floor');
    protected $updateFields = array('cat_id','cat_name','pid','is_floor');
    //TP验证接收过来的数据
    protected $_validate=array(
        array('cat_name', 'require', '分类名称不能为空！', 1, 'regex', 3),

    );

    //删除操作时找到子类并一起删除
    public function getChildren($id){
        $data=$this->select();

        return $this->_getChildren($data,$id,true);
    }

    private function _getChildren($data,$id,$isclear=false){

        static $arr=array();
        if($isclear){
            $arr=array();
        }

        foreach($data as $k=>$v){
            if($v['pid']==$id){
                $arr[]=$v['cat_id'];
                $this->_getChildren($data,$v['cat_id']);
            }

        }

        return $arr;
    }
    //分类列表递归函数显示名称
    public function getTree(){
        $data=$this->select();
        return $this->_getTree($data);
    }

    private function _getTree($data,$pid=0,$level=0){
        static $arr=array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->_getTree($data,$v['cat_id'],$level+1);
            }
        }

        return $arr;
    }

    public function _before_delete($option){
       $arr= $this->getChildren($option['where']['cat_id']);
        if($arr){
            $str=implode(",",$arr);
            M('category')->delete($str);

        }
    }
/*****************************前台操作******************************************/
//获取商品顶层推荐
    public function get_floor(){

        $floorInfo=M("category")->where("is_floor='是' and pid=0")->select();
        
        foreach($floorInfo as $k=>$v){
            //查出右侧品牌图片
            $goodsId=D("Admin/Goods")->category("cat_id");
            // 再取出这些商品所用到的品牌
                $floorInfo[$k]['brand'] = D("goods")->alias('a')
                ->join('LEFT JOIN brand b ON a.brand_id=b.id')
                ->field('DISTINCT brand_id,b.brand_name,b.logo')
                ->where(array(
                    'a.id' => array('in', $goodsId),
                    'a.brand_id' => array('neq', 0),
                ))->limit(9)->select();
              
            //查出未推荐的分类
            $floorInfo[$k]['subcat']=M("category")->where("is_floor='否' and pid='{$v['cat_id']}'")->select();
            
            
            //查出推荐的分类
            $floorInfo[$k]['recsubcat']=M("category")->where("is_floor='是' and pid='{$v['cat_id']}'")->select();

            /********* 循环每个推荐的二级分类取出分类下的8件被推荐到楼层的商品 *********/
                foreach ($floorInfo[$k]['recsubcat'] as $k1 => &$v1)
                {
                    // 取出这个分类下所有商品的ID并返回一维数组
                    $gids = D("Admin/Goods")->category($v1['cat_id']);
                    
                    // 再根据商品ID取出商品的详细信息
                    $v1['goods'] = M("goods")->field('id,mid_logo,goods_name,shop_price')->where(array(
                        'is_on_sale' => array('eq', '是'),
                        'is_floor' => array('eq', '是'),
                        'id' => array('in', $gids),
                    ))->order('sort_num asc')->limit(8)->select();
                }
        }
        
        S("floorInfo",$floorInfo,86400);
        
        return $floorInfo;

    }

    public function getParents($cat_id){
        static $ret=array();
        $info=$this->find($cat_id);
        $ret[]=$info;
        if($info['pid']>0){
            $this->getparents($info['pid']);
        }
        
        return $ret;
        
    }
/******************************底层********************************************/
}
