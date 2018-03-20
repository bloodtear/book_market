<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
   
*******************************************/
    $page_no = 4;
	$customerid = @$_SESSION['customerid'];

/******************************************
    
        头部
    
*******************************************/
    do_html_header('所有订单');
    login_up();
    display_logo();
    display_nav($page_no);
    display_intro('展示所有订单');
	hr();

/******************************************
    
        BODY
    
*******************************************/
 ?>

<div id="my_orders" class="container">
	<div>
		<ul class="list-inline">
			<li>全部订单</li>	
			<li>待付款</li>	
			<li>待收货</li>	
			<li>待评价</li>	
		</ul>
	</div>
	<table class="table">
		<tr class='table-bordered active text-center'>
			<td colspan="3">订单详情</td>
			<td>收货人</td>
			<td>金额</td>
			<td>全部状态</td>
			<td>操作</td>
		</tr>
	<?php
	//读取所有的订单ID
	$orders_id = get_admin_all_orders_id();
	//var_dump($orders_id);
	//展示订单
	foreach($orders_id as $key=>$order_id){
		display_order_easy($order_id);
	}


	
	?>


	</table>
</div>


















        <?php
/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();

?>