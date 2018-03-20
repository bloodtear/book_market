<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
    $isbn 		= @$_REQUEST['isbn'];
    $error_id 	= @$_REQUEST['error_id'];
    $book_array = get_book_detail($isbn);//读取图书的细节
/******************************************
    
        头部
    
*******************************************/   
    do_html_header('修改图书细节','book_form');
	if($error_id){
		display_error_info($error_id);
	}
    login_up();
    display_logo();
    display_nav();


/******************************************
    
        BODY
    
*******************************************/
    if(!empty($book_array)){
        display_intro('请修改图书的细节');
        hr();
        book_form(2,$book_array);  //展示修改表单
    }else{
        display_intro('抱歉,找不到你所要修改的这本图书');
        display_error();
        hr();
    }
/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();

?>