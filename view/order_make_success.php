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
    do_html_header('订单提交成功','');
	if($error_id){
		display_error_info($error_id);
	}
    login_up();
    display_logo();
    display_nav($page_no);  //传入当前页面，画nav
    display_intro('订单提交成功！');
    hr();

/******************************************
    
        BODY
    
*******************************************/
?>

 <!--展示删除成功信息-->
	<div class="container">
        <div id="" style="margin-top:30px;">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <span class="text-success" style="font-size:30px;">订单已经成功提交！</span>
            <a href="show_order_detail.php?order_id=<?php echo $order_id;?>">
				<button class="btn btn-primary btn-lg" style="padding-left:20px;">查看此订单</button>
			</a>
            <span style="padding-left:10px;">您还可以<a href="index.php">返回主页</a></span>
        </div>
	</div>



<?php

/******************************************
    
        尾部
    
*******************************************/

    do_html_footer();

?>