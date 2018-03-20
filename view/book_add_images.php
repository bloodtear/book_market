<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
 $isbn 			= @$_REQUEST['isbn'];
 $author 		= @$_REQUEST['author'];
 $title 		= @$_REQUEST['title'];
 $cat 			= @$_REQUEST['cat'];
 $price 		= @$_REQUEST['price'];
 $description 	= @$_REQUEST['description'];
 $act 			= @$_REQUEST['act'];




/******************************************
    
        头部
    
*******************************************/
    do_html_header('上传图片','upload_images');
    login_up();
    display_logo();
    display_nav();  //传入当前页面，画nav
    display_intro('请选择图片上传');
    hr();
	//var_dump($_REQUEST);
?>
<form method="post" action="../action/action_images.php" enctype="multipart/form-data">

<div class="hide">
    <input type="text" id="isbn" maxlength="13" name="isbn" value="<?php echo $isbn;?>"> 
	<input type="text" id="act" placeholder="动作" name="act" value="add">
</div>  
	
<?php display_add_images();?>

</form> 
<?php
  do_html_footer();

?>