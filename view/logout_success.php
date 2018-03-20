<?php
require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
    $olduser = @$_REQUEST['olduser'];

/******************************************
    
        头部
    
*******************************************/
    do_html_header('登出');
    login_up();
    display_logo();
    display_block('40');

?>

<div class="container">
	<p>再见，<?php echo $olduser;?>，你已经登出成功！欢迎您的再次登录！</p>
	<?php  display_img('seeu',300,false);?>
	<br>
	<a href="index.php">点此进入主页</a>
</div>

<?php
  do_html_footer();
?>






