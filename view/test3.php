<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
    $page_no 		= 1;   //当前页面编号是1
	$customerid 	= @$_SESSION['customerid'];
	$error_id		= @$_REQUEST['error_id'];
	$order_id		= @$_REQUEST['order_id'];
/******************************************
    
        头部
    
*******************************************/
    do_html_header('订单快递信息填写成功','');
	if($error_id){
		display_error_info($error_id);
	}
    login_up();
    display_logo();
    display_nav();  //传入当前页面，画nav
    display_intro('订单快递信息填写成功！');
    hr();

/******************************************
    
        BODY
    
*******************************************/
	$server = $_SERVER['HTTP_HOST'];
echo $server;
?>

<?php

/******************************************
    
        尾部
    
*******************************************/

    do_html_footer();

?>