<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
        
*******************************************/
    $isbn = $_REQUEST['isbn'];
    $book_array = get_book_detail($isbn);   //读取某个ISBN书籍的数据
    $nowtime = time();

/******************************************
    
        头部
    
*******************************************/
    do_html_header("浏览图书：".$book_array['title'],'book_detail');
    login_up();
    display_logo();  
    display_nav();
	display_intro('图书信息：'.$book_array['title']);
    hr();

/******************************************
    
        BODY
    
*******************************************/
    if(is_isbn_exist($isbn)){ 
        display_book_detail($book_array);   //展示这个书籍细节

        echo "<div class='container'>";
        echo "<div class='row' style='margin-left:30px;'>";
        //如果是顾客才展示添加购物车
        if(!empty($_SESSION['customerid']) && !empty($_SESSION['current_user'])) {
            display_button("../action/action_cart.php?isbn=$isbn&act=add",'添加此书到购物车'); 
        }
        
        //如果是管理员才展示修改图书
        if(!empty($_SESSION['is_admin']) && !empty($_SESSION['current_user'])) {
            display_button("book_modify_form.php?isbn=".$isbn,"修改此图书");
            display_button("book_modify_images.php?isbn=".$isbn,"图片批量修改");
            display_button("book_add_images.php?isbn=".$isbn,"添加图片");
        }
        
        echo "</div>";
        echo "</div>";
		
    }else{
        display_intro('抱歉，找不到你所选的这本书啊');
        hr();
        display_error();
    }

/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();

?>