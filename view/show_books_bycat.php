<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
$catid = $_REQUEST['catid'];
$catname = get_categories_name($catid); //通过类别ID读取类别名称
$books = get_books($catid);         //通过类别ID,取出此类别下的所有书籍ISBN和TITLE，返回数组


/******************************************
    
        头部
    
*******************************************/
    do_html_header('书籍目录'.$catname);
    login_up();
    display_logo();
    display_nav();


/******************************************
    
        BODY
    
*******************************************/
    if($catname){

        display_intro('你所选的类别为：'.$catname);
        hr();
        display_books($books);    //展示类别下所有的书籍的图片和名称，以及对应链接 
    
    }else{
        display_intro('呃喔，编号为【'.$catid."】的类别不存在！");
        display_error();    //展示类别下所有的书籍的图片和名称，以及对应链接 
    }


/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();


?>