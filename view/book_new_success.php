
<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        参数初始化
    
******************************************/
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
        $book_detail = get_book_detail($isbn);  //读取上传的图书细节
        display_intro('成功添加！新书籍信息如下：');
        display_book_detail($book_detail);      //展示上传的结果
        
    }catch(Exception $e){
        display_intro('呃喔，图书添加失败咯！');
        echo "<div class='container'>";
        echo $e->getMessage();
        echo "<br>";
        display_error();
        echo "<a href='submit_book.php'>重新新增书籍</a>";
        echo "</div>";
    }

/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();
?>
