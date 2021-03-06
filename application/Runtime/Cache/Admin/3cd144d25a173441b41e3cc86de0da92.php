<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>ECSHOP 管理中心 - 添加新商品 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/ECshop/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/ECshop/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<style>
    li{list-style: none;}
</style>
<script src="/ECshop/library/jquery/jquery-1.4.js"></script>
<script src="/ECshop/library/kindeditor/kindeditor.js"></script>
<!-- 时间插件 -->
<link rel="stylesheet" href="/ECshop/library/datetimepicker/css/style.css" />
<script src="/ECshop/library/datetimepicker/js/jquery.min.js"></script>
<script src="/ECshop/library/datetimepicker/js/Ecalendar.jquery.min.js"></script>
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

    });

    function addext(){
        $("#sele").append($("#sele>li").eq(0).clone()).append("<br/>");
    }

    $(function(){
        $("[name=type_id]").change(function(){
            var type_id=$(this).val();
            //ajax
            $.ajax({
                type:"get",
                url:"/ECshop/admin.php/goods/ajaxgetattr",
                data:"type_id="+type_id,
                dataType:"json",
                success: function (data) {
                    var i="";
                   $(data).each(function(k,v){
                       i +="<li>";
                        if(v.attr_type =='可选'){
                            i+="<a href='javascript:void(0)' onclick='addattr(this)'>[+]</a>"
                        }
                       i+= v.attr_name+":";
                        if(v.attr_option_values!=""){
                            i+="<select name='attr_value["+ v.id+"][]'>";
                                i+="<option value=''>请选择</option>";
                                var _arrt= v.attr_option_values.split(",");

                                for(var a=0;a < (_arrt.length);a++){
                                    i+="<option value='"+_arrt[a]+"'>"+_arrt[a]+"</option>";
                                }
                            i+="</select>";
                        }else{
                            i+="<input type='text' name='attr_value["+ v.id+"][]'/>";
                        }
                       i+="</li>";
                   });
                    $("#attr_list").html(i);
                }
            });
        });
    });

    function addattr(a){
        var li =$(a).parent();
        var newli=li.clone();
            if(a.text=="[+]"){
                li.after(newli);
                newli.find("a").text("[-]");
            }else{
                li.remove();
            }



    }


//时间插件
$(function(){
        $("#promote_start_date").ECalendar({
            type:"time",   //模式，time: 带时间选择; date: 不带时间选择;
            stamp : false,   //是否转成时间戳，默认true;
            offset:[0,2],   //弹框手动偏移量;
            format:"",   //时间格式 默认 yyyy-mm-dd hh:ii;
            skin:2,   //皮肤颜色，默认随机，可选值：0-8,或者直接标注颜色值;
            step:10,   //选择时间分钟的精确度;
        });

        $("#promote_end_date").ECalendar({
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
        <form enctype="multipart/form-data" action="/ECshop/admin.php/Goods/add" method="post" class="frm">
            <!--通用信息-->
            <table width="90%" id="general-table" align="center" class="tab_table">
                <tr>
                    <td class="label">分类级别：</td>
                    <td>
                        <select name="cat_id">
                            <option value="0">请选择</option>
                            <?php foreach($tree as $v){ ?>
                                <option value="<?php echo $v['cat_id']?>"><?php echo str_repeat('--',8*$v['level']).$v['cat_name']?></option>
                            <?php }?>
                        </select>

                    </td>
                </tr>
                <br/>
                <!--扩展分类-->
                <tr>
                    <td class="label">扩展分类：<input type="button" value="添加一个分类" onclick="addext()"></td>
                    <ul>
                    <td id="sele">
                        <li>
                        <select name="ext_cat_id[]">

                            <option value="0">请选择</option>

                            <?php foreach($tree as $v){?>
                            <option value="<?php echo $v['cat_id']?>"><?php echo str_repeat('--',8*$v['level']).$v['cat_name']?></option>
                            <?php }?>
                        </select>
                        </li><br/>

                    </td>
                    </ul>
                </tr>


                <!--品牌-->
                <tr>
                    <td class="label">所在品牌：</td>
                    <td>
                        <?php showSelect("brand","brand_id","id","brand_name");?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" checked="checked"/> 是
                        <input type="radio" name="is_on_sale" value="否"/> 否
                    </td>
                </tr>

                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                    </td>
                </tr>

                <tr>
                    <td class="label">促销价格：</td>
                    <td>
                        ￥<input type="text" name="promote_price" value="0" size="5" />元；
                        从<input type="text" size="23" name="promote_start_date" value="" id="promote_start_date"/>到
                        <input type="text" size="23" name="promote_end_date" value="" id="promote_end_date"/>结束

                    </td>
                </tr>
                
                <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="是" /> 是
                        <input type="radio" name="is_best" value="否" checked="checked"/> 否
                    </td>
                </tr>

                <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="是" /> 是
                        <input type="radio" name="is_new" value="否" checked="checked"/> 否
                    </td>
                </tr>

                <tr>
                    <td class="label">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" value="是" /> 是
                        <input type="radio" name="is_hot" value="否" checked="checked"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">推荐到楼层：</td>
                    <td>
                        <input type="radio" name="is_floor" value="是" /> 是
                        <input type="radio" name="is_floor" value="否" checked="checked"/> 否
                    </td>
                </tr>
				
                <tr>
                    <td class="label">商品排序：</td>
                    <td>
                        <input type="text" name="sort_num" value="100" size="5"/>
                    </td>
                </tr>
            </table>

            <!--商品描述-->
            <table width="90%"  align="center" class="tab_table">

                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <textarea name="goods_desc" cols="40" rows="3"></textarea>
                    </td>
                </tr>

            </table>


            <!--会员价格-->
            <table width="90%"  align="center" class="tab_table">
                <tr>
                    <td class="label">会员价格：</td>
                    <td>
                        <?php foreach($member as $v){?>
                        <?php echo $v['level_name']?>:￥<input type="text" name="price[<?php echo $v['id']?>]" value="0"  size="5" value=""/>元<br/><br/>
                        <?php }?>
                    </td>
                </tr>
            </table>

            <!--商品属性-->
            <table  width="90%" align="center" class="tab_table">
                <tr>
                    <td class="label">类型:</td>
                    <td>
                        <?php showSelect("type","type_id","id","type_name")?>
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
                    <td class="label">上传图片:</td>
                    <td>
                        <input type="file" name="logo"/>
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