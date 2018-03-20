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
<form method="post" action="../action/action_book.php" enctype="multipart/form-data">

<div class="hide">
    <input type="text" id="isbn" maxlength="13" name="isbn" value="<?php echo $isbn;?>"> 
	<input type="text" id="author" name="author" value="<?php echo $author;?>">
	<input type="text" id="title" name="title" value="<?php echo $title;?>">
	<input type="text" id="cat"  name="cat" value="<?php echo $cat;?>">
	<input type="text" id="price" name="price" value="<?php echo $price;?>">
	<textarea id="description" rows="3" name="description" ><?php echo $description;?></textarea>
	<input type="text" id="act" placeholder="动作" name="act" value="<?php echo $act;?>">
</div>  
	
<?php display_add_images();?>

</form> 
<?php
  do_html_footer();

?>