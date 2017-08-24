<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>ECSHOP 管理中心 - 修改商品 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/ECshop/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/ECshop/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<style>
    li{list-style: none;}
</style>
<script src="/ECshop/library/jquery/jquery-1.4.js"></script>
<script src="/ECshop/library/kindeditor/kindeditor.js"></script>
<script type="text/javascript">
    var editor;
    KindEditor.ready(function(e){
        editor= e.create("[name=goods_desc]",{
            width:"660",
            height:"250"
        });
    });


    $(function(){
        $(".frm>table").hide();
        $(".tab_table").eq(0).show();

        $("#tabbar-div>p>span").click(function(){
            var i=$(this).index();
            $(".tab_table").hide();
            $(".tab_table").eq(i).show();
            $(this).siblings().removeClass("tab-front").addClass("tab-back");
            $(this).addClass("tab-front").removeClass("tab-back");

        });


        //商品相册
        $(function(){
            $("#addpic").click(function(){
                $("#pic").append($("#pic").find("ul").eq(0).clone());
            })
        });
    });

    //ajax删除商品
    $(function(){
        $(".btn_del_pic").click(function(){
            //选中删除按钮所在li标签
                var li = $(this).parent();
            //从按钮中获取pic_id属性
            var pid=$(this).attr("pic_id");

            //ajax
            $.ajax({
                type:"get",
                url:"/ECshop/admin.php/Goods/ajaxDelPic",
                data:"picid="+pid,
                success:function(re){
                    li.remove();
                }
            });
        });
    });

    function addext(){
        $("#sele").append($("#sele>li").eq(0).clone()).append("<br/>");
    }

        /*****[+]的添加属性******/
    function addattr(a){
        var li =$(a).parent();
        
        if(a.text=="[+]"){
            var newli=li.clone();
            newli.find("select").val("");
            li.after(newli);
            newli.find("a").text("[-]");
            newli.find("input[name='goods_attr_id[]']").val("");
        }else{
            var gaid=li.find("input[name='goods_attr_id[]']").val();
            //当移除的时候判断是否是有原值,有原值则ajax删除,无则直接删除
            if(gaid==""){
                li.remove();
            }else{
                $.ajax({
                    type:"get",
                    url:"/ECshop/admin.php/goods/ajaxdelattr/goods_id/<?php echo $editinfo['id'] ?>",
                    data:"gaid="+gaid,
                    success:function(re){
                        li.remove();
                    }
                });
            }
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


<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab" >通用信息</span>
            <span class="tab-back" >商品描述</span>
            <span class="tab-back" >会员价格</span>
            <span class="tab-back" >商品属性</span>
            <span class="tab-back" >商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/ECshop/admin.php/Goods/up ?>" method="post" class="frm">

            <!--通用信息-->
            <table width="90%" id="general-table" align="center" class="tab_table">
                <tr>
                    <td><input type="hidden" name="id" value="<?php echo $editinfo['id']?>"></td>
                </tr>
                <tr>
                    <td class="label" style="width:42%">分类级别</td>
                    <td>
                        <select name="cat_id">
                            <option value="0">顶级菜单</option>

                            <?php foreach($tree as $v){ if($v['cat_id']==$editinfo['cat_id']){ $sel="selected='selected'"; }else{ $sel=""; } ?>
                            <option value="<?php echo $v['cat_id']?>" <?php echo $sel?>><?php echo str_repeat("--",8*$v['level']).$v['cat_name']?></option>
                            <?php }?>
                        </select>
                    </td>
                </tr>
                <!--扩展分类-->
                <tr>
                    <td class="label">扩展分类：<input type="button" value="添加一个分类" onclick="addext()"></td>
                    <ul>

                        <td id="sele">
                            <?php foreach($gc_data as $k1=>$v1){?>
                            <li>
                                <select name="ext_cat_id[]">

                                    <option value="0">请选择</option>

                                    <?php foreach($tree as $k=>$v){ if($v1['cat_id']==$v['cat_id']){ $sele="selected='selected'"; }else{ $sele=""; } ?>
                                    <option <?php echo $sele?> value="<?php echo $v['cat_id']?>"><?php echo str_repeat('--',8*$v['level']).$v['cat_name']?></option>
                                    <?php }?>
                                </select>
                            </li><br/>
                            <?php }?>
                        </td>

                    </ul>
                </tr>
                <!--品牌-->
                <tr>
                    <td class="label">品牌名称：</td>

                    <td>
                        <select name="brand_id">
                            <?php foreach($brand as $k=>$v){ if($v['id']==$editinfo['brand_id']){ $sele="selected='selected'"; }else{ $sele=""; } ?>
                            <option <?php echo $sele?> value="<?php echo $v['id']?>"><?php echo $v['brand_name']?></option>
                            <?php }?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="<?php echo $editinfo['goods_name']?>"size="30" />
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <!--商品logo-->
                <tr>
                    <td class="label">商品logo：</td>

                    <td><?php showImg($editinfo['logo'],150)?><br/><input type="file" name="logo"></td>
                    <td></td>
                </tr>


                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo $editinfo['shop_price']?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <tr>
                    <td class="label">是否上架：</td>
                    <?php $onsale=$editinfo['is_on_sale']?>
                    <td>

                        <input type="radio" name="is_on_sale" value="是" <?php if("$onsale=='是'"){ echo "checked='checked'";}?>/> 是
                        <input type="radio" name="is_on_sale" value="否" <?php if("$onsale=='否'"){ echo "checked='checked'";}?>/> 否

                    </td>
                </tr>

                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo $editinfo['market_price']?>" size="20" />
                    </td>
                </tr>



            </table>



            <!--商品描述-->
            <table width="90%"  align="center" class="tab_table" >
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <textarea name="goods_desc" cols="40" rows="3"><?php echo $editinfo['goods_desc']?></textarea>
                    </td>
                </tr>
            </table>
            <!--会员价格-->
            <table width="90%"  align="center" class="tab_table">
                <tr>
                    <td class="label">会员价格：</td>
                    <td>
                        <?php foreach($member as $v){?>
                        <?php echo $v['level_name']?>:￥<input type="text" name="member_price[]" value="<?php echo $v['price']?>"  size="5" />元<br/><br/>
                        <?php }?>
                    </td>
                </tr>
            </table>

            <!--商品属性-->
            <table  width="90%" align="center" class="tab_table">
                <tr>
                    <td class="label">类型:</td>
                    <td>
                        <?php showSelect("type","type_id","id","type_name",$editinfo['type_id'])?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <?php $attrId=array(); ?>
                           <?php foreach($attrinfo as $k=>$v){?>
                                <li>
                                    <?php
 echo "<input type='hidden'  value='".$v['id']."' name='goods_attr_id[]' >"; if(in_array($v['attr_id'], $attrId)){ $opt = '-'; }else{ $opt = '+'; $attrId[] = $v['attr_id']; } if($v['attr_type']=="可选"){ echo"<a href='javascript:void(0)' onclick='addattr(this)'>[".$opt."]</a>"; } ?>
                                    <?php echo $v['attr_name']?>:
                                    <?php
 if($v['attr_option_values']!=""){ $_arr=array(); $_arr=explode(",",$v["attr_option_values"]); echo"<select name='attr_value[".$v['attr_id']."][]'>"; echo"<option value=''>请选择</option>"; foreach($_arr as $k1=>$v1){ if($v1==$v['attr_value']){ $sele="selected='selected'"; }else{ $sele=""; } echo"<option value=".$v1." $sele>".$v1."</option>o"; } echo"</select>"; }else{ echo"<input type='text' name='attr_value[".$v['attr_id']."][]' value='".$v['attr_value']."'>"; } ?>
                                </li>
                           <?php }?>
                        </ul>
                    </td>
                </tr>
                <tr align="center" >
                    <td class="label">
                        <ul id="attr_list"></ul>
                    </td>
                </tr>
            </table>

            <!--商品相册-->
            <table width="90%"  align="center" class="tab_table">
                <tr>
                    <td><input type="button" value="添加一张"  id="addpic"/><hr/></td>
                </tr>
                <tr>
                    <td id="pic">

                        <ul>
                            <li><input type="file" name="pic[]" multiple="multiple"/></li><br/>
                        </ul>

                        <ul>
                            <?php
 if($pic!=null){ foreach($pic as $v){?>
                            <li>
                                <input type="button" value="删除" pic_id="<?php echo $v['id']?>" class="btn_del_pic"/><br/>
                                <?php showImg($v['mid_pic'],150)?>
                            </li><br/>
                            <?php }}?>
                        </ul>

                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 修改 " class="button"/>
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