<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
 $isbn 			= @$_REQUEST['isbn'];
/*
 $author 		= @$_REQUEST['author'];
 $title 		= @$_REQUEST['title'];
 $cat 			= @$_REQUEST['cat'];
 $price 		= @$_REQUEST['price'];
 $description 	= @$_REQUEST['description'];
 $act 			= @$_REQUEST['act'];*/




/******************************************
    
        头部
    
*******************************************/
    do_html_header('图片批量修改','book_modify_images');
    login_up();
    display_logo();
    display_nav();  //传入当前页面，画nav
    display_intro('请选择对应图片进行修改');
    hr();
	//var_dump($_REQUEST);
?>
<form method="post" action="../action/action_images.php" enctype="multipart/form-data">

<div class="hide">
    <input type="text" id="isbn" maxlength="13" name="isbn" value="<?php echo $isbn;?>"> 
    <input type="text" id="act" maxlength="13" name="act" value="modify"> 
</div>  
	
<div class="container">
	<div id="canvas_background" class="center-block">
		<div id="preview_images">
			<?php
				$images_list = get_images_list($isbn);
				foreach($images_list as $no=>$array){
					display_image_modify($array);
				}
			?>
		</div>
	</div>
	<div class="control_bar">
		<button class="btn btn-success" type="submit" id="submit_btn">保存</button>
		<a href="#" onClick="javascript :history.back(-1);" >
			<button class="btn btn-default" type="button">返回</button>
		</a> 
	</div>
</div>
</form> 
<?php
  do_html_footer();

?>