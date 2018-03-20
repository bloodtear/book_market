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
    do_html_header('添加图片成功-'.$book_array['title']);
    login_up();
    display_logo();
    display_nav();
    display_intro('添加图片成功');
	hr();

/******************************************
    
        BODY
    
*******************************************/
 ?>
        <!--展示删除成功信息-->
	<div class="container">
        <div id="delete_book_success" style="margin-top:30px;">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <span class="text-success" style="font-size:30px;">所选图片已经成功添加！</span>
            <a href="show_book_detail.php?isbn=<?php echo $isbn; ?>">
				<button class="btn btn-primary btn-lg" style="padding-left:20px;">查看此书籍</button>
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