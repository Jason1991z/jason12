<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - 类型列表 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/ECshop/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/ECshop/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />

</head>
<script type="text/javascript" src="/ECshop/library/jquery/jquery-1.4.js"></script>

<!--鼠标划入高亮显示-->
<script src="/ECshop/Public/js/tron.js"></script>
<script type="text/javascript">
    function del(id){
        if(confirm("确定要删除该记录吗?")){
            window.location="/ECshop/admin.php/type/deltype/id/"+id;
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
    <form action="/ECshop/admin.php/type/lst" name="searchForm" method="get">

        <!--属性名称-->
        <label>属性名称:</label>
        <input type="text" value="" name="type_name"/>
        <br/><br/>
        <input type="submit" value="搜索" />
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>类型名称</th>
                <th>操作</th>

            </tr>

            <?php foreach($typeinfo as $v){?>
            <tr class="tron">
                <td align="center"><?php echo $v['type_name']?></td>
                <td align="center">
                    <a href="/ECshop/admin.php/attribute/lst/id/<?php echo $v['id']?>">属性列表</a> |
                    <a href="/ECshop/admin.php/type/edit/id/<?php echo $v['id']?>">修改</a> |
                    <a href="javascript:del(<?php echo $v['id']?>)">删除</a></td>
            </tr>
            <?php }?>
        </table>

        <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $pageList?>
                </td>
            </tr>
        </table>
        <!-- 分页结束 -->
    </div>
</form>
<div id="footer">
    共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>