<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - 商品列表 </title>
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
    function del(id){
        if(confirm("确定要删除该记录吗?")){
            window.location="/ECshop/admin.php/Brand/delbrand/id/"+id;
        }
    }


    $(function(){
        $("#fa").ECalendar({
            type:"time",   //模式，time: 带时间选择; date: 不带时间选择;
            stamp : false,   //是否转成时间戳，默认true;
            offset:[0,2],   //弹框手动偏移量;
            format:"",   //时间格式 默认 yyyy-mm-dd hh:ii;
            skin:2,   //皮肤颜色，默认随机，可选值：0-8,或者直接标注颜色值;
            step:10,   //选择时间分钟的精确度;
        });

        $("#ta").ECalendar({
            type:"time",   //模式，time: 带时间选择; date: 不带时间选择;
            stamp : false,   //是否转成时间戳，默认true;
            offset:[0,2],   //弹框手动偏移量;
            format:"",   //时间格式 默认 yyyy-mm-dd hh:ii;
            skin:2,   //皮肤颜色，默认随机，可选值：0-8,或者直接标注颜色值;
            step:10,   //选择时间分钟的精确度;
        });
    });



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
    <form action="/ECshop/admin.php/Goods/lst" name="searchForm" method="get">

        <!--商品名称-->
        <label>品牌名称:</label>
        <input type="text" name="gn" size="60" value="<?php echo I('get.gn')?>"/>
        <br/><br/>




        <label>排序方式</label>
        <?php  $odby=I('get.odby')?>
        <input onclick="this.parentNode.submit()" type="radio" name="odby" value="id_desc" <?php if($odby=='id_desc'){echo "checked='checked'";}?>/>以id降序
        <input onclick="this.parentNode.submit()" type="radio" name="odby" value="id_asc" <?php if($odby=='id_desc'){echo "checked='checked'";}?>/>以id升序


        <input type="submit" value="搜索" />
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>品牌名称</th>
                <th>官方网址</th>
                <th>logo</th>
                <th>操作</th>
            </tr>

            <?php foreach($goodsinfo as $v){?>
                <tr class="tron">
                    <td align="center"><?php echo $v['id']?></td>
                    <td align="center" class="first-cell"><span><?php echo $v['brand_name']?></span></td>
                    <td align="center"><?php echo $v['site_url']?></td>
                    <td align="center"><span><?php showImg($v['logo'],50)?></span></td>


                    <td align="center"><a href="/ECshop/admin.php/Brand/edit/id/<?php echo $v['id']?>">修改</a> | <a href="javascript:del(<?php echo $v['id']?>)">删除</a></td>
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