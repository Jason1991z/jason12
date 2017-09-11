<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="keyword" content="<?php echo $keyword?>">
	<meta name="description" content="<?php echo $description?>">
	<title><?php echo $_page_title?></title>
	<link rel="stylesheet" href="/ECshop/public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/ECshop/public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/ECshop/public/Home/style/header.css" type="text/css">
	<link rel="stylesheet" href="/ECshop/public/Home/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/ECshop/public/Home/style/footer.css" type="text/css">

	<script type="text/javascript" src="/ECshop/public/Home/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/ECshop/public/Home/js/header.js"></script>
</head>
<body>
<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w1210 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>

					<li id="loginInfo"></li>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	
	

<link rel="stylesheet" href="/ECshop/Public/Home/style/cart.css" type="text/css">
<script type="text/javascript" src="/ECshop/Public/Home/js/cart1.js"></script>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="/ECshop/Public/Home/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr">
				<ul>
					<li class="cur">1.我的购物车</li>
					<li>2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="mycart w990 mt10 bc">
		<h2><span>我的购物车</span></h2>
		<table>
			<thead>
				<tr>
					<th class="col1">商品名称</th>
					<th class="col2">商品信息</th>
					<th class="col3">单价</th>
					<th class="col4">数量</th>	
					<th class="col5">小计</th>
					<th class="col6">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  $tp = 0; foreach ($data as $k => $v){ ?>
				<tr>
					<td class="col1"><a href=""><?php showImg($v['mid_logo']); ?></a>  
					<strong><a href="<?php echo U('Index/goods?id='.$v['goods_id']); ?>"><?php echo $v['goods_name']; ?></a></strong></td>
					<td class="col2"> 
						<?php foreach ($v['gaData'] as $k1 => $v1): ?>
							<p><?php echo $v1['attr_name']; ?>：<?php echo $v1['attr_value']; ?></p>
						<?php endforeach; ?>
					</td>
					<td class="col3">￥<span><?php echo $v['price']; ?>元</span></td>
					<td class="col4"> 
						<a href="javascript:;" class="reduce_num" id="reduce_num<?php echo $k?>" onclick="changeNum(<?php echo $k.",".$v['goods_id']?>)"></a>
						<input type="text" name="goods_number" val="" value="<?php echo $v['goods_number']; ?>" class="amount" id="write_num<?php echo $k?>" onchange="w_changeNum(<?php echo $k.",".$v['goods_id']?>)"/>
						<a href="javascript:;" class="add_num" id="add_num<?php echo $k?>" onclick="changeNum(<?php echo $k.",".$v['goods_id'];?>)"></a>
					</td>
					<td class="col5">￥<span><?php $xj = $v['price'] * $v['goods_number'];$tp+=$xj;echo $xj; ?></span></td>
					<td class="col6"><a href="javascript:delGoods(<?php echo $v['goods_id'].",".session("m_id");?>)">删除</a></td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">购物金额总计： <strong>￥ <span id="total"><?php echo $tp; ?></span></strong></td>
				</tr>
			</tfoot>
		</table>
		<div class="cart_btn w990 bc mt10">
			<a href="/ECshop/index.php/index/index" class="continue">继续购物</a>
			<a href="/ECshop/index.php/Orders/add" class="checkout">结 算</a>
		</div>
	</div>
	<!-- 主体部分 end -->

	<script>
		//[-][+]键的ajax
		function changeNum(k,goods_id){
			//ajax 自减
			$("#reduce_num"+k).click(function(){
				$.ajax({
					type:'get',
					url:"/ECshop/index.php/cart/ajaxReduce?goods_id="+goods_id,

				});
			});

			//ajax 自增
			$("#add_num"+k).click(function(){
				$.ajax({
					type:'get',
					url:"/ECshop/index.php/cart/ajaxAdd?goods_id="+goods_id,
					
				});
			});
		}

		//文本框改变数字
		function w_changeNum(k,goods_id){
			var i = $("#write_num"+k).attr("value");
			$.ajax({
				type:"get",
				url:"/ECshop/index.php/cart/ajaxWriNum?goods_id="+goods_id+"&num="+i,
			})	
		}

		function delGoods(goods_id,m_id){

			if(confirm("确定要删除该商品吗?")){
				window.location="/ECshop/index.php/cart/delGoods/goods_id/"+goods_id+"/m_id/"+m_id;
			}
		}
	</script>

	<!-- 底部导航 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt10">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="images/xin.png" alt="" /></a>
			<a href=""><img src="images/kexin.jpg" alt="" /></a>
			<a href=""><img src="images/police.jpg" alt="" /></a>
			<a href=""><img src="images/beian.gif" alt="" /></a>
		</p>
	</div>
	</body>
	</html>
	<!-- 底部版权 end -->
	<script>
		$.ajax({
			type:"get",
			url:"/ECshop/index.php/Member/ajaxChkLogin",
			dataType:"json",
			success:function(data){
				var li="";
				if(data.login==1){
					li +="<li>您好，"+data.username+"[<a href='/ECshop/index.php/Member/logout'>退出</a>]";
				}else{
					li +="<li>您好，欢迎来到京西！[<a href='/ECshop/index.php/Member/login'>登录</a>] [<a href='/ECshop/index.php/Member/regist'>免费注册</a>] </li>";
				}
				$("#loginInfo ").html(li);
			}
		});
	</script>