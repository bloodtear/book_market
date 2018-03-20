<?php

session_start();
require_once('../functions/book_sc_fns.php');

do_html_header('上传图片','');

var_dump($_REQUEST);
var_dump($_SESSION);
//获取参数
$pay_mode 					= @$_REQUEST['pay_mode'];
$order_items 				= @$_REQUEST['order_items'];
$selected_invoice_mode 		= @$_REQUEST['selected_invoice_mode'];
$selected_invoice_title 	= @$_REQUEST['selected_invoice_title'];
$selected_invoice_content 	= @$_REQUEST['selected_invoice_content'];
$act 						= $_REQUEST['act'];
$last_ship_city 			= @$_REQUEST['last_ship_city'];
$last_ship_district 		= @$_REQUEST['last_ship_district'];
$last_ship_addr 			= @$_REQUEST['last_ship_addr'];
$last_ship_person 			= @$_REQUEST['last_ship_person'];
$last_ship_tel 				= @$_REQUEST['last_ship_tel'];
$last_ship_tel2 			= @$_REQUEST['last_ship_tel2'];
$last_ship_zip 				= @$_REQUEST['last_ship_zip'];
$last_ship_email 			= @$_REQUEST['last_ship_email'];
$order_id					= @$_REQUEST['order_id'];

$express_company			= @$_REQUEST['express_company'];
$express_no					= @$_REQUEST['express_no'];

$server = $_SERVER['HTTP_HOST'];

//如果是NEW新提交ORDER订单的话
if($act == 'new'){
try{
	//事务处理期间不能进行数据库重连，如果重连的话，事务处理方式则归零，变成自动提交模式。
	$db = db_connect();
	//开启事务处理
	if(!$begin = begin($db)){
		throw new Exception('事务开启失败3');
	}
	//提交货物
	if(!$new_items_id = order_new_items($order_items,$db)){
		throw new Exception('订单货物信息提交失败');
	}
	//提交地址
	if(!$new_address_id = order_new_address
	   ($last_ship_city,
		$last_ship_district,
		$last_ship_addr,
		$last_ship_person,
		$last_ship_tel,
		$last_ship_tel2,
		$last_ship_zip,
		$last_ship_email,$db)){
		throw new Exception('订单地址信息提交失败');
	}
	//提交支付相关
	if(!$new_payments_id = order_new_payments($pay_mode,$db)){
		throw new Exception('订单支付相关提交失败');
	}
	//提交发票相关
	if(!$new_invoice_id = order_new_invoice($selected_invoice_mode,$selected_invoice_title,$selected_invoice_content,$db)){
		throw new Exception('订单发票信息提交失败');
	}
	//新建快递相关？
	if(!$new_express_id = order_new_express($db)){
		throw new Exception('订单快递信息提交失败');
	}	
	//新建状态相关
	if(!$new_status_id = order_new_status($db)){
		throw new Exception('订单状态信息提交失败');
	}
	//新建订单主信息
	if(!$new_order_id = order_new_main(
		$new_items_id,
		$new_address_id,
		$new_payments_id,
		$new_invoice_id,
		$new_express_id,
		$new_status_id,$db)){
		throw new Exception('订单主信息提交失败');
	}
	//提交信息
	if(!commit($db)){
		throw new Exception('事务提交失败');
	}
	//跳转到成功提示页面
	header("Location:http://$server/book_market/view/order_make_success.php?order_id=$new_order_id");
	
}catch(Exception $e){
	//如果有错误，拿到错误信息，翻转到原来的网页并附带error信息回去。
	rollback($db);
	$error = $e->getMessage();
	echo $error;
}
}

//撤消订单
if($act == 'cancel_order'){
	//修改订单状态
	try{
		if(!$cancel = order_cancel($order_id)){
			throw new Exception('撤消订单失败');
		}
		//跳转到成功提示页面
		header("Location:http://$server/book_market/view/order_cancel_success.php?order_id=$order_id");
	}catch(Exception $e){
		//如果有错误，拿到错误信息，翻转到原来的网页并附带error信息回去。
		$error = $e->getMessage();
		echo $error;
	}
}

//收到货物
if($act == 'receive_order'){
	//
	try{
		if(!$order_receive = order_receive($order_id)){
			throw new Exception('确认收货失败');
		}
		header("Location:http://$server/book_market/view/order_receive_success.php?order_id=$order_id");
	}catch(Exception $e){
		//如果有错误，拿到错误信息，翻转到原来的网页并附带error信息回去。

		$error = $e->getMessage();
		echo $error;
	}
}

//要求退还货物
if($act == 'return_order'){

	try{
		
	}catch(Exception $e){
		//如果有错误，拿到错误信息，翻转到原来的网页并附带error信息回去。
		$error = $e->getMessage();
		echo $error;
	}
}

//厂家输入快递信息，表示已经发货
if($act == 'input_express_info' || $act == 'modify_express_info'){
	try{
		var_dump($_REQUEST);
		if(!$order_send = order_has_send($express_company,$express_no,$order_id)){
			throw new Exception('输入快递信息失败');
		}
		header("Location:http://$server/book_market/view/order_send_success.php?order_id=$order_id");
	}catch(Exception $e){
		//如果有错误，拿到错误信息，翻转到原来的网页并附带error信息回去。
		$error = $e->getMessage();
		echo $error;
	}
}

//修改快递信息
if($act == 'modify_express_info'){
	try{
		
	}catch(Exception $e){
		//如果有错误，拿到错误信息，翻转到原来的网页并附带error信息回去。
		$error = $e->getMessage();
		echo $error;
	}
}

//处理退换货
if($act == 'deal_return_order'){
	try{
		
	}catch(Exception $e){
		//如果有错误，拿到错误信息，翻转到原来的网页并附带error信息回去。
		$error = $e->getMessage();
		echo $error;
	}
}






?>