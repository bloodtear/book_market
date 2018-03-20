<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
   
*******************************************/
    $isbn = $_REQUEST['isbn'];
    $book_array = get_book_detail($isbn);//读取图书的细节

/******************************************
    
        头部
    
*******************************************/
    do_html_header('删除图书-'.$book_array['title']);
    login_up();
    display_logo();
    display_nav();
    display_intro('删除所选图书成功');
	hr();

/******************************************
    
        BODY
    
*******************************************/
 ?>
        <!--展示删除成功信息-->
	<div class="container">
        <div id="delete_book_success" style="margin-top:30px;">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <span class="text-success" style="font-size:30px;">所选图书已经成功删除！</span>
            <a href="index.php"><button class="btn btn-primary btn-lg" style="padding-left:20px;">返回主页</button></a>
            <span style="padding-left:10px;">您还可以<a href="book_new_form.php">添加书籍</a></span>
        </div>
	</div>
        <?php
/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();

?>