<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/

/******************************************
    
        头部
    
*******************************************/
    do_html_header('上传图片成功','upload_images');
    login_up();
    display_logo();
    display_nav();  //传入当前页面，画nav
    display_intro('上传图片成功');
    hr();

	var_dump($_REQUEST);
	var_dump($_FILES);
?>

<?php
  do_html_footer();
?>