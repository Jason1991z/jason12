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
					<li><a href="/ECshop/index.php/My/order">我的订单</a></li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	
	

<link rel="stylesheet" href="/ECshop/Public/Home/style/home.css" type="text/css">
<link rel="stylesheet" href="/ECshop/Public/Home/style/order.css" type="text/css">
<script type="text/javascript" src="/ECshop/Public/Home/js/home.js"></script>

<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 头部 start -->
	<div class="header w1210 bc mt15">
		<!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
		<div class="logo w1210">
			<h1 class="fl"><a href="index.html"><img src="/ECshop/Public/Home/images/logo.png" alt="京西商城"></a></h1>
			<!-- 头部搜索 start -->
			<div class="search fl">
				<div class="search_form">
					<div class="form_left fl"></div>
					<form action="" name="serarch" method="get" class="fl">
						<input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
					</form>
					<div class="form_right fl"></div>
				</div>
				
				<div style="clear:both;"></div>

				<div class="hot_search">
					<strong>热门搜索:</strong>
					<a href="">D-Link无线路由</a>
					<a href="">休闲男鞋</a>
					<a href="">TCL空调</a>
					<a href="">耐克篮球鞋</a>
				</div>
			</div>
			<!-- 头部搜索 end -->

			<!-- 用户中心 start-->
				<div class="user fl" id="test">
				<dl>
					<dt>
						<em></em>
						<a href="" >用户中心</a>
						<b></b>
					</dt>
					<dd>
						<p id="userLoging"><div class='prompt'>您好，请<a href=''>登录</a></div></p>
						<div class="uclist mt10">
							<ul class="list1 fl">
								<li><a href="">用户信息></a></li>
								<li><a href="">我的订单></a></li>
								<li><a href="">收货地址></a></li>
								<li><a href="">我的收藏></a></li>
							</ul>

							<ul class="fl">
								<li><a href="">我的留言></a></li>
								<li><a href="">我的红包></a></li>
								<li><a href="">我的评论></a></li>
								<li><a href="">资金管理></a></li>
							</ul>

						</div>
						<div style="clear:both;"></div>
						<div class="viewlist mt10">
							<h3>最近浏览的商品：</h3>
							<div id="look_history" style="font-size:15px;">最近无浏览历史</div>
						</div>
					</dd>
				</dl>
			</div>
			<!-- 用户中心 end-->


			<!-- 购物车 start -->
			<div class="cart fl">
				<dl>
					<dt>
						<a href="">去购物车结算</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							购物车中还没有商品，赶紧选购吧！
						</div>
					</dd>
				</dl>
			</div>
			<!-- 购物车 end -->
		</div>
		<!-- 头部上半部分 end -->
		
		<div style="clear:both;"></div>

		<!-- 导航条部分 start -->
		<div class="nav w1210 bc mt10">
			<!--  商品分类部分 start-->
			<div class="category fl <?php if($_show_nav==0){echo 'cat1';}?>"> <!-- 非首页，需要添加cat1类 -->
				<div class="cat_hd <?php if($_show_nav==0){echo 'off';}?>">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
					<h2>全部商品分类</h2>
					<em></em>
				</div>
				
				<div class="cat_bd <?php if($_show_nav==0){echo 'none';}?>">
					
					
					<?php foreach($catdata as $k=>$v){?>
						<div class="cat item1">
							<h3><a href=""><?php echo $v['cat_name']?></a><b></b></h3>
							<div class="cat_detail">
								<?php foreach($v['children'] as $k1=>$v1){?>
									<dl class="dl_1st">
										<dt><a href=""><?php echo $v1['cat_name']?></a></dt>
										<dd>
											<?php foreach($v1['children'] as $k2=>$v2){?>
												<a href=""><?php echo $v2['cat_name']?></a>
											<?php }?>				
										</dd>
									</dl>
								<?php }?>
							</div>
						</div>
					<?php }?>


				</div>

			</div>
			<!--  商品分类部分 end--> 

			<div class="navitems fl">
				<ul class="fl">
					<li class="current"><a href="">首页</a></li>
					<li><a href="">电脑频道</a></li>
					<li><a href="">家用电器</a></li>
					<li><a href="">品牌大全</a></li>
					<li><a href="">团购</a></li>
					<li><a href="">积分商城</a></li>
					<li><a href="">夺宝奇兵</a></li>
				</ul>
				<div class="right_corner fl"></div>
			</div>
		</div>
		<!-- 导航条部分 end -->
	</div>
	<!-- 头部 end-->
	<div style="clear:both;"></div>

	<script>
	
	//用户信息	
	$.ajax({
		type:"get",
		url:"/ECshop/index.php/index/AjaxUserCenter",
		dataType:"json",
		success:function(data){
			
			var i="";

			if(data!=""){
				i += "<div class='prompt'>您好,<a href=''>"+data.username+"</a></div>";
			}
			
			$("#userLoging").html(i);
		}
	});

	//用户中心->最近浏览的商品
	
	$.ajax({
		type:'get',
		url:"/ECshop/index.php/index/AjaxLook_history",
		dataType:"json",
		success:function(data){
			
			var i ="";
			if(data != null){
				i+="<ul>";

				$(data).each(function(k,v){
					
					i+="<li><a href=''><img src='/ECshop/public/uploads/"+v.mid_logo+"' alt='' /></a></li>";

				});
				
				i+="</ul>";
			}
			$("#look_history").html(i);
		}
	});
		
		
	

	
	

	</script>

	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的定单 </strong><span>> 我的订单</span></h2>
		</div>
		
		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="<?php echo U('order'); ?>">我的订单</a></dd>
					<dd><b>.</b><a href="">我的关注</a></dd>
					<dd><b>.</b><a href="">浏览历史</a></dd>
					<dd><b>.</b><a href="">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd><b>.</b><a href="">账户信息</a></dd>
					<dd><b>.</b><a href="">账户余额</a></dd>
					<dd><b>.</b><a href="">消费记录</a></dd>
					<dd><b>.</b><a href="">我的积分</a></dd>
					<dd><b>.</b><a href="">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">返修/退换货</a></dd>
					<dd><b>.</b><a href="">取消订单记录</a></dd>
					<dd><b>.</b><a href="">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->


		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">
			<div class="order_hd">
				<h3>我的订单</h3>
				<dl>
					<dt>便利提醒：</dt>
					<dd>待付款（<?php echo $data['noPayCount']; ?>）</dd>
				</dl>
			</div>

			<div class="order_bd mt10">
				<table class="orders">
					<thead>
						<tr>
							<th width="10%">订单号</th>
							<th width="20%">订单商品</th>
							<th width="10%">收货人</th>
							<th width="20%">订单金额</th>
							<th width="20%">下单时间</th>
							<th width="10%">订单状态</th>
							<th width="10%">操作</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($data['data'] as $k => $v): ?>
						<tr>
							<td><?php echo $v['id']; ?></td>
							<td><a href=""><?php $_arr = explode(',', $v['logo']);foreach ($_arr as $k1 => $v1) showImg($v1); ?></a></td>
							<td><?php echo $v['shr_name']; ?></td>
							<td>￥<?php echo $v['total_price']; ?></td>
							<td><?php echo date('Y-m-d H:i:s', $v['addtime']); ?></td>
							<td>
							<?php if($v['pay_status'] == '是'): ?>
								已支付
							<?php else: ?>
								<?php echo makeAlipayBtn($v['id']); ?>
							<?php endif; ?>
							</td>
							<td>
								<?php if($v['pay_status'] == '否'): ?>
									<a href="">查看</a> | <a href="">取消定单</a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody> 
				</table>
				
				<p><?php echo $data['page']; ?></p>
			</div>
		</div>
		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->


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