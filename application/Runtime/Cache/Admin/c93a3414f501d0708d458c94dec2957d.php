<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - 库存量 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/ECshop/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/ECshop/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />

</head>
<script type="text/javascript" src="/ECshop/library/jquery/jquery-1.4.js"></script>
<!--鼠标划入高亮显示-->
<script src="/ECshop/Public/js/tron.js"></script>
<script type="text/javascript">
    function addnum(a){
        if($(a).find("input[type='button']").val()=="+"){
            var tr =$(a).parent("tr").clone();
            $(a).parents("table").find("input[type='submit']").parent().parent().before(tr);
            tr.find("input[type='button']").val("-");
        }else{
            $(a).parent("tr").remove();
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


<!-- 商品列表 -->
<form method="post" action="/ECshop/admin.php/goods/goods_number" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <?php foreach($_gainfo as $k=>$v){?>
                    <th><?php echo $k?></th>
                <?php }?>
                <th>库存量</th>
                <th>操作</th>
            </tr>

            
             <?php if(!empty($gninfo)){?>
                <?php foreach($gninfo as $k0=>$v0){?>
                    <tr>
                        <?php $gaCount=count($_gainfo); ?>
                        <?php  foreach($_gainfo as $k=>$v){ ?>
                            <input type="hidden" name="goods_id" value="<?php echo $v[0]["goods_id"] ?>"/>
                            <td>
                                <select name="good_attr_id[]">
                                    <option value="">请选择</option>
                                    <?php foreach($v as $k1=>$v1){ $_arr=explode(",",$v0['goods_attr_id']); if(in_array($v1['id'],$_arr)){ $select="selected='selected'"; }else{ $select=""; } ?>
                                        <option <?php echo $select?> value="<?php echo $v1['id']?>"><?php echo $v1['attr_value']?></option>
                                    <?php }?>
                                </select>
                            </td>
                        <?php }?>
                        <td align="center"><input type="text" name="goods_number[]" value="<?php echo $v0['goods_number']?>"></td>
                        <td align="center" onclick="addnum(this)"><input type="button" neme="butt" value="<?php if($k0==0){echo "+";}else{echo "-";}?>"/></td>
                    </tr>
                <?php }?>
                <tr align="center">
                    <td colspan="<?php echo $gaCount+2?>"><input type="submit" value="提交"/></td>
                </tr>
             <?php }else{?>  
                <tr>
                    <?php $gaCount=count($_gainfo); ?>
                    <?php  foreach($_gainfo as $k=>$v){ ?>
                        <input type="hidden" name="goods_id" value="<?php echo $v[0]["goods_id"] ?>"/>
                        <td>
                            <select name="good_attr_id[]">
                                <option value="">请选择</option>
                                <?php foreach($v as $k1=>$v1){?>
                                    <option value="<?php echo $v1['id']?>"><?php echo $v1['attr_value']?></option>
                                <?php }?>
                            </select>
                        </td>
                    <?php }?>
                    <td align="center"><input type="text" name="goods_number[]"></td>
                    <td align="center" onclick="addnum(this)"><input type="button" neme="butt" value="+"/></td>
                </tr>
                <tr align="center">
                    <td colspan="<?php echo $gaCount+2?>"><input type="submit" value="提交"/></td>
                </tr>
            <?php }?>
        </table> 
    </div>
</form>
<div id="footer">
    共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>