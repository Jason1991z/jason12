<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - 属性列表 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/ECshop/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/ECshop/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />

</head>
<script type="text/javascript" src="/ECshop/library/jquery/jquery-1.4.js"></script>
<!-- 时间插件 -->
<link rel="stylesheet" href="/ECshop/library/datetimepicker/css/style.css" />
<script src="/ECshop/library/datetimepicker/js/jquery.min.js"></script>
<script src="/ECshop/library/datetimepicker/js/Ecalendar.jquery.min.js"></script>
<!--鼠标划入高亮显示-->
<script src="/ECshop/Public/js/tron.js"></script>
<script type="text/javascript">
    function del(id,type_id){
        if(confirm("确定要删除该记录吗?")){
            window.location="/ECshop/admin.php/attribute/del/id/"+id+"/type_id/"+type_id;
        }
    }

</script>

<body>
<h1>
    <span class="action-span"><a href="<?php echo $page_url?>"><?php echo $page_btn?></a>
    </span>
    <span class="action-span1"><a href="/ECshop/admin.php/Index/index">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $page_title?> </span>
    <div style="clear:both"></div>
</h1>

<div class="form-div">
    <form action="/ECshop/admin.php/attribute/lst" name="searchForm" method="get">
        <p>
            属性名称：
            <input type="text" name="attr_name" size="30" value="<?php echo I('get.attr_name'); ?>" />
        </p>
        <p>
            属性类型：
            <input type="radio" value="-1" name="attr_type"  <?php if(I("get.attr_type")==""|| I("get.attr_type")==-1){echo "checked='checked'";}?>/> 全部
            <input type="radio" value="唯一" name="attr_type" <?php if(I("get.attr_type")=="唯一"){echo "checked='checked'";}?>/> 唯一
            <input type="radio" value="可选" name="attr_type"  <?php if(I("get.attr_type")=="可选"){echo "checked='checked'";}?>/> 可选
        </p>
        <p>
            所属类型：<?php $id=I("get.id");if(I("get.type_id")){ $id=I("get.type_id"); }; showSelect("type","type_id","id","type_name",$id)?>
        </p>
        <p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">

            <tr>
                <th >属性名称</th>
                <th >属性类型</th>
                <th >属性可选值</th>
                <th >所属类型Id</th>
                <th width="60">操作</th>
            </tr>
            <?php foreach ($attribute as $k=>$v): ?>
            <tr class="tron">
                <td align="center"><?php echo $v['attr_name']; ?></td>
                <td align="center"><?php echo $v['attr_type']; ?></td>
                <td align="center"><?php echo $v['attr_option_values']; ?></td>
                <td align="center"><?php echo $v['type_id']; ?></td>
                <td align="center">
                    <a href="/ECshop/admin.php/attribute/edit/id/<?php echo $v['id']?>">编辑</a> |
                    <a href="javascript:del(<?php echo ($v['id'].",".$v['type_id']) ?>)">移除</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(preg_match('/\d/', $page)): ?>
            <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr>
            <?php endif; ?>
        </table>
        <!-- 分页结束 -->
    </div>
</form>
<div id="footer">
    共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>