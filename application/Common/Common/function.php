<?php 
function makeAlipayBtn($orderId, $btnName = '去支付宝支付')
{
	return require('./alipay/alipayapi.php');
}
