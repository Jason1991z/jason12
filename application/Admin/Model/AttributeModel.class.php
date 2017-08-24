<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;

class AttributeModel extends Model{
    //只允许接收某些字段

    protected $insertFields=array("attr_name","attr_type","attr_option_values","type_id");
    protected $updateFields = array("attr_name","attr_type","attr_option_values","type_id");
    //TP验证接收过来的数据
    protected $_validate=array(
        array('attr_name', 'require', '属性名称不能为空！', 1, 'regex', 3),


    );



    public function _before_delete($option){

    }


}