<?php
session_start();
require_once('../functions/book_sc_fns.php');




/******************************************
    
        初始化参数
    
*******************************************/

  	$customerid = @$_SESSION['customerid'];	//当前用户ID
    $page_no 	= 6;   						//页面编码
    $list_no 	= 2;  						//设置页面中list编码
	$error_id 	= @$_REQUEST['error_id'];		//错误代码

/******************************************
    
        头部
    
*******************************************/
    do_html_header('个人设置',"addr_list");
//报错信息
if($error_id){
	display_error_info($error_id);
}
    login_up();
    display_logo();
    display_nav($page_no);
    display_intro('请选择你想查看的设置');
    hr();

/******************************************
    
        BODY
    
*******************************************/
?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
        <?php display_list($list_no); //显示左侧导航条  ?>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
<?php 
    add_addr_form();//显示添加收货地址的表单，并且提交给本页面
	echo "<div id='my_addr'>";
/******************************************
    
        展示收货地址部分
        下面是显示addr_list的内容
        
*******************************************/
    $addr_list = get_addr_list($customerid);  
    //从数据库中取得addrlist,，排序第一位为is_default,然后按照sumbit-time排序
        $l = 0;
        while(@$addr_list[$l]){
            $ship_id    = $addr_list[$l]['ship_id'];    //读取当前的shipid
            $is_default = $addr_list[$l]['is_default']; //读取当前shipid是否为is_default;

            $addr_detail = get_addr_detail($ship_id);   //根据shipid去得相关的详细信息，以数组形式
            display_addr_detail($addr_detail,$is_default);  //展示对应的详细信息
            $l++;
        }
        //add_addr_form();//显示添加收货地址的表单，并且提交给本页面
	echo "</div>";
?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

/******************************************
    
        尾部
    
*******************************************/

    do_html_footer();
?>






