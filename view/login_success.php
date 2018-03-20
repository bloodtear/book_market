<?php
require_once('../functions/book_sc_fns.php');
session_start();

/******************************************
    
        初始化参数
    
*******************************************/
    //获取POST参数
    $username = @$_SESSION['current_user'];
    $is_admin = @$_POST['is_admin'][0];
	$customerid = @$_SESSION['customerid'];

/******************************************
    
        头部
    
*******************************************/
    do_html_header('注册/登录页面');
    display_block('28');    //浏览器通过ctrl+shift+c可以看页面中的内容
    display_logo(0);
    display_block('40');

/******************************************
    
        BODY
    
*******************************************/
   
        echo "<div class='container'>";
        echo "<p>欢迎回来！".$username."</p>";
        
        if(!@$_SESSION['is_admin']){
            echo "<p>你的账号ID：".$customerid."</p>";
        }else{
            echo "<p>你的账号类型为：管理员大人</p>";
        }
        echo "<a href='index.php'>";
        	display_img('welcome',300,false);
        echo "</a>";
        echo "<br>";
        echo "<a href='index.php'>点此进入主页</a>";
        echo "</div>";

/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();
?>