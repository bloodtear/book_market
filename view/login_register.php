<?php
require_once('../functions/book_sc_fns.php');
session_start();

	$error_id 	= @$_REQUEST['error_id'];
	$action 	= @$_REQUEST['action'];


/******************************************
    
        头部
    
*******************************************/
    do_html_header('注册/登录页面','login_register');
//错误展示
	if($error_id){
		display_error_info($error_id);
	}
    display_block('28');    //浏览器通过ctrl+shift+c可以看页面中的内容
    display_logo(0);
    display_block('40');

/******************************************
    
        BODY
    
*******************************************/


    login_register($action);

/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();

?>