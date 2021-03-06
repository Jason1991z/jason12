<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>系统提示信息</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="/ECshop/public/css/bbs.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">
        var index = 5;
        function changeTime()
        {
            document.getElementById("timeSpan").innerHTML = index;
            index--;
            if(index < 0){
                window.location = "<?php echo ($jumpUrl); ?>";
            }
            else{
                window.setTimeout("changeTime()",1000);
            }
        }
    </script>
</head>
<body onload="changeTime()">
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

<table border="1" align="center" width="600">
    <tr>
        <td><b>系统提示信息</b></td>
    </tr>
    <tr>
        <td align="center">
            <br/><?php echo ($message); ?> 页面将在 <span id="timeSpan">5</span> 秒钟内自动跳转！<br/>
            <br/>如果没有自动跳转，<a href="<?php echo ($jumpUrl); ?>">请点击这里</a>。<br/><br/>
        </td>
    </tr>
</table>

</body>
</html>