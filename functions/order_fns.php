<?php


//////////////////////////////////////////
//将商品插入订单系统中 order_itmes
//////////////////////////////////////////
function order_new_items($order_items,$db){
	//$db = db_connect();
	$time = time();//当前时间作为ID，如果ID存在就++
	
	$query = "select order_items_id from order_items where order_items_id = '$time'";
	$result = $db->query($query);
	if(!$result){
		throw new Exception('订单货物信息提交失败1');
	}
	$existed = $result->num_rows;//取出的数据是否为空
    if($existed > 0 ){
    	$time++;
    }
	
	//拆分对应的内容。
	if($order_items){
	foreach($order_items as $key=>$value){
		$isbn 		= $key;
		$item_price = $value['price'];
		$num 		= $value['num'];
		$row_price  = $item_price*$num;
		
    	$query = "insert into order_items values ('$time','$isbn','$item_price','$num','$row_price')"; 
		$result = $db->query($query);
		if(!$result){
			throw new Exception('订单货物信息提交失败2');
		}
	}
	return $time;
	
	}
}



//////////////////////////////////////////
//将地址插入订单系统中 order_itmes
//////////////////////////////////////////
function order_new_address
	   ($last_ship_city,
		$last_ship_district,
		$last_ship_addr,
		$last_ship_person,
		$last_ship_tel,
		$last_ship_tel2,
		$last_ship_zip,
		$last_ship_email,$db){

	//$db = db_connect();
	//c插入动作
	$query = "insert into order_address values 
	('','$last_ship_person',
	'$last_ship_city',
	'$last_ship_district',
	'$last_ship_addr',
	'$last_ship_zip',
	'$last_ship_tel',
	'$last_ship_tel2',
	'$last_ship_email')"; 
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	//取得自增的ID
	$query = "select last_insert_id()";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$order_address_id = $result->fetch_row();
	
	return $order_address_id[0];
	
}

//////////////////////////////////////////
//将支付信息插入到订单系统中，pay_mode
//////////////////////////////////////////
function order_new_payments($pay_mode,$db){
	//$db = db_connect();
	
	$query = "insert into order_payments values ('','$pay_mode','','')";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	
	//取得自增的ID
	$query = "select last_insert_id()";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$order_pay_id = $result->fetch_row();
	return $order_pay_id[0];
}
	

//////////////////////////////////////////
//初始化订单的快递信息
//////////////////////////////////////////
function order_new_express($db){
	//$db = db_connect();
	
	$query = "insert into order_express values ('','','','')";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	
	//取得自增的ID
	$query = "select last_insert_id()";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$order_express_id = $result->fetch_row();
	return $order_express_id[0];
}



//////////////////////////////////////////
//发票信息的新建
//////////////////////////////////////////
function order_new_invoice($selected_invoice_mode,$selected_invoice_title,$selected_invoice_content,$db){
	//$db = db_connect();

	$query = "insert into order_invoices values ('',
	'$selected_invoice_mode',
	'$selected_invoice_title',
	'$selected_invoice_content','0')";
	$result = $db->query($query);
	if(!$result){
		throw new Exception('订单支付相关提交失败1');
	}
	
	//取得自增的ID
	$query = "select last_insert_id()";
	$result = $db->query($query);
	if(!$result){
		throw new Exception('订单支付相关提交失败22');
	}
	$order_invoice_id = $result->fetch_row();
	return $order_invoice_id[0];
}


//////////////////////////////////////////
//新建状态信息
//////////////////////////////////////////
function order_new_status($db){
	//$db = db_connect();
	$query = "insert into order_status values ('',0,now(),'','','','','')";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	
	//取得自增的ID
	$query = "select last_insert_id()";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$order_status_id = $result->fetch_row();
	return $order_status_id[0];
}


//////////////////////////////////////////
//取得当前订单中物品的总价格
//////////////////////////////////////////
function get_total_amount($new_items_id,$db){
	//$db = db_connect();
	$query = "select sum(row_price) from order_items where order_items_id = $new_items_id";
	$result = $db->query($query);
	if(!$result){
		throw new Exception('求总价格失败');
	}
	$total_amount = $result->fetch_row();
	return $total_amount[0];
}


//////////////////////////////////////////
//新建订单住信息
//////////////////////////////////////////
function order_new_main(
		$new_items_id,
		$new_address_id,
		$new_payments_id,
		$new_invoice_id,
		$new_express_id,
		$new_status_id,$db){
	
	$customerid = $_SESSION['customerid'];
	$total_amount = get_total_amount($new_items_id,$db);
		
	//$db = db_connect();
	$query = "insert into orders values (
	'',
	'$new_status_id',
	'$customerid',
	'$new_items_id',
	'$total_amount',
	'$new_address_id',
	'$new_express_id',
	'$new_payments_id',
	'$new_invoice_id'
	)";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	
	//取得自增的ID
	$query = "select last_insert_id()";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$order_status_id = $result->fetch_row();
	return $order_status_id[0];
}

//////////////////////////////////////////
//拿到所有的ORDERID BY customerid
//////////////////////////////////////////
function get_all_orders_id($customerid){
	$db = db_connect();
	$query = "select order_id from orders where customerid = '$customerid'";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$i = 0;
	while($orders_id = $result->fetch_assoc()){
		$array[$i] = $orders_id['order_id'];
		$i++;
	}
	return $array;
	
}


//////////////////////////////////////////
//通过orderid拿到order整体信息
//////////////////////////////////////////
function get_order_main_detail($order_id){
	$db = db_connect();
	
	$query = "select * from orders where order_id = '$order_id'";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$order_main_detail = $result->fetch_assoc();
	return $order_main_detail;
}


//////////////////////////////////////////
//读取状态细节
//////////////////////////////////////////
function get_status_detail($order_status_id){
	$db = db_connect();
	
	$query = "select * from order_status where order_status_id = '$order_status_id'";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$status_detail = $result->fetch_assoc();
	return $status_detail;
}

//////////////////////////////////////////
//读取商品细节
//////////////////////////////////////////
function get_order_items($order_items_id){
	$db = db_connect();
	
	$query = "select * from order_items where order_items_id = '$order_items_id'";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$i = 0;
	while($order_item = $result->fetch_assoc()){
		$order_items[$i] = $order_item;
		$i++;
	}
	return $order_items;
}


//////////////////////////////////////////
//读取地址细节
//////////////////////////////////////////
function get_order_address($order_address_id){
	$db = db_connect();
	
	$query = "select * from order_address where order_address_id = '$order_address_id'";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$order_address = $result->fetch_assoc();
	return $order_address;
}


//////////////////////////////////////////
//读取支付细节
//////////////////////////////////////////
function get_order_pay_detail($order_pay_id){
	$db = db_connect();
	
	$query = "select * from order_payments where order_pay_id = '$order_pay_id'";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$pay_detail = $result->fetch_assoc();
	return $pay_detail;
}

//////////////////////////////////////////
//拿到状态的中文
//////////////////////////////////////////
function get_status_name($order_status){
	switch($order_status){
	case 0:
		return '已提交';
		break;
	case 1:
		return '已付款';
		break;
	case 2:
		return '已发货';
		break;
	case 3:
		return '已收货';
		break;
	case 6:
		return '已撤消';
		break;
	case 7:
		return '申请退换';
		break;
	case 8:
		return '退换成功';
		break;
	default:
		return "未知";
	}
}


//////////////////////////////////////////
//拿到支付方式的中文
//////////////////////////////////////////
function get_pay_mode($order_pay_mode){
	switch($order_pay_mode){
	case 0:
		return '货到付款';
		break;
	case 1:
		return '在线支付';
		break;
	default:
		return "未知";
	}
}


//////////////////////////////////////////
//读取发票细节
//////////////////////////////////////////
function get_order_invoice_detail($order_invoice_id){
	$db = db_connect();
	
	$query = "select * from order_invoices where order_invoice_id = '$order_invoice_id'";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$invoice_detail = $result->fetch_assoc();
	return $invoice_detail;
}

//////////////////////////////////////////
//读取收货快递细节
//////////////////////////////////////////
function get_order_express($order_express_id){
	$db = db_connect();
	
	$query = "select * from order_express where order_express_id = '$order_express_id'";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$order_express_detail = $result->fetch_assoc();
	return $order_express_detail;
}




 
//读取所有订单，管理员admin用	 
function get_admin_all_orders_id(){
	$db = db_connect();
	$query = "select order_id from orders";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	$i = 0;
	while($orders_id = $result->fetch_assoc()){
		$array[$i] = $orders_id['order_id'];
		$i++;
	}
	return $array;
}

//订单撤消
function order_cancel($order_id){
	$db = db_connect();
	$query = 
		"UPDATE orders a,order_status b SET 
			b.status = 6,b.cancel_time = NOW()
		WHERE 
			a.order_id = $order_id AND a.order_status_id = b.order_status_id";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	return true;
}
	 
//输入订单快递信息
function order_has_send($express_company,$express_no,$order_id){
	$db = db_connect();
	//开启事务处理
	if(!$begin = begin($db)){
		throw new Exception('事务开启失败4');
	}
	
	$query = "UPDATE orders a,order_express b SET 
				b.express_company ='$express_company' , b.express_no = '$express_no' , b.status = 1
				WHERE a.order_id =$order_id AND a.order_express_id = b.order_express_id";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	
	$query = "UPDATE orders a,order_status c SET
				c.status = 2,c.send_time= NOW() 
				WHERE a.order_status_id = c.order_status_id AND a.order_id ='$order_id' ";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	
	if(!commit($db)){
		throw new Exception('事务提交失败');
	}
	return true;
}

//确认收货
function order_receive($order_id){
	$db = db_connect();
	$query = 
		"UPDATE orders a,order_status b SET 
			b.status = 3,b.receive_time = NOW()
		WHERE 
			a.order_id = $order_id AND a.order_status_id = b.order_status_id";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	return true;
}


?>