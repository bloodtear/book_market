
<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
        初始化参数
*******************************************/
    $isbn = @$_REQUEST['isbn'];

/******************************************
        头部
*******************************************/
    do_html_header('欢迎来到书店~');
    login_up();
    display_logo();
    display_nav();
	
/******************************************
    
        BODY
    
*******************************************/
    try{
        
		$book_detail = get_book_detail($isbn);    //读取数据信息
		display_intro('恭喜，修改书籍的相关信息成功！');   
		hr();
		display_book_detail($book_detail);         //展示图书信息
        
    }catch(Exception $e){
        display_intro('抱歉，修改书籍的相关信息失败！'); 
        echo "<div class='container'>";
        echo $e->getMessage();
        display_error();
        echo "<br>";
        echo "<a href='#'>重新修改书籍</a>";
        echo "</div>";
    }
/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();


?>
