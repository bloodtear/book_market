<?php
require_once('../functions/book_sc_fns.php');
session_start();

/******************************************
    
        初始化参数
    
*******************************************/
    //获取session参数
	$username = $_SESSION['current_user'];

/******************************************
    
        头部
    
*******************************************/
    do_html_header('注册/登录页面');
    display_block('28');    //浏览器通过ctrl+shift+c可以看页面中的内容
    display_logo();
    display_block('40');

/******************************************
    
        BODY
    
*******************************************/
  ?>
        <div class="container">
			<p>恭喜你，你已经注册成功，用户名：<?php echo $username;?></p>
			<?php echo display_img('thx_reg',300,false);?>
			<br>
			<p><a href="index.php">点此进入主页</a></p>
        </div>
<?php
/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();

?>