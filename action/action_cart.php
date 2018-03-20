<?php
session_start();

/***************************************			
购物车的session修改
1、点击删除，相关的isbn被删除
2、点击【加号】【减号】【数值输入】isbn里面的数值变化

$is_del :删除标示，如果有此，则启动删除任务。
$isbn   :操作的对象isbn，
$num 	:数值是存储的数据

****************************************/


$act 	= @$_REQUEST['act'];	

$is_del = @$_REQUEST['is_del'];		//删除标示，如果有此，则启动删除任务
$isbn 	= @$_REQUEST['isbn'];		//操作的对象isbn
$num 	= @$_REQUEST['num'];		//数值是存储的数值
$server = $_SERVER['HTTP_HOST'];

if($act == 'add'){
	if(@$_SESSION['cart']["$isbn"]){
		@$_SESSION['cart']["$isbn"] += 1;
	}else{
		@$_SESSION['cart']["$isbn"] = 1;
	}
	header("Location: http://$server/book_market/view/cart_add_success.php?isbn=$isbn");

}


//如果删除标志true
if(($is_del) && !empty($isbn)){
	unset($_SESSION["cart"]["$isbn"]);
}

//处理数值
if(!empty($isbn) && !empty($num)){
	$_SESSION['cart']["$isbn"] = $num;
}

?>