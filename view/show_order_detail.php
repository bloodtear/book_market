<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
   
*******************************************/
	$customerid = @$_SESSION['customerid'];
	$order_id	= $_REQUEST['order_id'];
/******************************************
    
        头部
    
*******************************************/
    do_html_header('订单详情');
    login_up();
    display_logo();
    display_nav(@$page_no);
    display_intro('订单详情');
	hr();

/******************************************
    
        BODY
    
*******************************************/
 ?>

<div id="my_orders" class="container">
	<?php
		display_order_detail($order_id);//展示订单
	?>
</div>




        <?php
/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();

?>