<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
    $page_no 		= 1;   //当前页面编号是1


/******************************************
    
        头部
    
*******************************************/
    do_html_header('提交订单','order_make');
    login_up();
    display_logo();
    display_nav($page_no);  //传入当前页面，画nav
    display_intro('结算页');
    hr();


        
$time = time();
	echo $time;
        

?>
        
<div class="container">
<div class="label">选择图片上传</div>

</div>
        
        
<?php

  do_html_footer();






?>