<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>ECSHOP 管理中心 - 添加管理员 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/ECshop/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/ECshop/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>

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
        <form enctype="multipart/form-data" action="/ECshop/admin.php/admin/add" method="post">
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">角色名称：</td>
                    <td>
                        <?php foreach($arinfo as $k=>$v){?>
                            <input  type="checkbox" name="role_id[]" value="<?php echo $v['id']?>"/>
                            <?php echo $v['role_name']?>
                        <?php }?>
                    </td>
                </tr>

                <tr>
                    <td class="label">管理员名称：</td>
                    <td><input type="text" name="username" value="" size="30" />
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <tr>
                    <td class="label">管理员密码：</td>
                    <td><input type="text" name="password" value="" size="30" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                
                <tr>
                    <td class="label">确认密码：</td>
                    <td><input type="text" name="cpassword" value="" size="30" />
                        <span class="require-field">*</span>
                    </td>
                </tr>



            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>

<div id="footer">
    共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>