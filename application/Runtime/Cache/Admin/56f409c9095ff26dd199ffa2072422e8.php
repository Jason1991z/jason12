<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>ECSHOP 管理中心 - 修改类型 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/ECshop/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/ECshop/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<script src="/ECshop/library/kindeditor/kindeditor.js"></script>
<script type="text/javascript">
    var editor;
    KindEditor.ready(function(e){
        editor= e.create("[name=goods_desc]",{
            width:"660",
            height:"250"
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


<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/ECshop/admin.php/type/up ?>" method="post">
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td><input type="hidden" name="id" value="<?php echo $editinfo['id']?>"></td>
                </tr>
                <tr>
                    <td class="label">类型名称：</td>
                    <td><input type="text" name="type_name" value="<?php echo $editinfo['type_name']?>"size="30" />
                        <span class="require-field">*</span>
                    </td>
                </tr>


                <tr class="button-div">
                    <td colspan="2" class="button-div">
                        <input type="submit" value=" 修改 " class="button"/>
                        <input type="reset" value=" 重置 " class="button" />
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<div id="footer">
    共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>