<?php


////////////////////////////
//html头部
/////////////////////////////
function do_html_header($title,$js = ''){    
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="../config/css/bootstrap.css" type="text/css">
        <!-- 可选的Bootstrap主题文件（一般不用引入） -->
        <link rel="stylesheet" href="../config/css/bootstrap-theme.min.css" type="text/css">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="../config/js/jquery-2.1.1.min.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="../config/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../config/css/main.css">
        <!--<script type="text/javascript" src="js/show_cart.js"></script>-->
		<?php
			if($js != ''){
				echo "<script type=\"text/javascript\" src=\"../config/js/".$js.".js\"></script>";
			}
		?>
        <title><?php echo $title?></title>
    </head>
    <body>
    <div id="mainbody">
<?php    
}


////////////////////////////////
//logo图
/////////////////////////////////
function display_logo($cart = 1){
    ?>
<div class="container">
    <div class="row" >
        <div class="col-md-5"></div > 
        <div class="col-md-2" style="color:black;font-weight:900;
                    				border-radius:10px;font-size:30px;
                    				text-align:center;height:60px;padding-top:15px;">
        	<a href="index.php">在 线 书 店</a>
        </div >
        <div class="col-md-5">
			<?php
				//如果登录了，并且不是管理员，就展示购物车图标
				//var_dump($_SESSION);
			if(!empty($_SESSION['customerid'])  && !(@$_SESSION['is_admin'])){//当登录了并且不是管理员的时候，才展示购物车
				if($cart == 1){
					?>
					<!--购物车图标-->
					<div style="padding-top:12px;">
						<a href="show_cart.php" style="float:right;">
						<div style="
								padding:10px 20px 10px 20px;
								border-radius:4px;border:1px solid #eee;
								background-color:#f9f9f9">
							<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"> </span>
						我的购物车
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"> </span></div>
						</a>
					</div>
					<?php
				}
			}
			?>
        </div > 
    </div >    
</div>  
    <?php   
}


//////////////////////////////////////
//导航条
//需要传入参数，当前的页面是几，如果没有的就默认是0，走lastpage
//////////////////////////////////////
function display_nav($page_no = 0){
    //判断当前页是那个页面
    if($page_no > 0){   //如果当前页面大于0
        $nav[$page_no] = " class=\"active\"";//进度条nav[pageno]变active
        $_SESSION['last_page'] = $page_no;  //将这个页面存到lastpage里,以便没有pageno的页面调用
    }else{
        $page_no = @$_SESSION['last_page'] ;//将存的lastpage给pageno.
        $nav[$page_no] = " class=\"active\"";//同上一个内容
    }
    
    //判断用户是否登陆,是admin?是user(customer)?
    if(!empty($_SESSION['is_admin']) && !empty($_SESSION['current_user'])) {
        $is_admin = true;
    }
    if(!empty($_SESSION['current_user']) && !empty($_SESSION['customerid'])){
        $is_customer = true;
    }
    
    //var_dump($_SESSION);
?>
<!--共用的List-->
<div style="background-color:#f9f9f9;margin-top:20px;margin-bottom:20px;border-top:solid 1px #eee;border-bottom:solid 1px #eee;">
    <div class="container">
    <ul class="nav admin_nav nav-tabs">
      <li role="presentation" <?php echo @$nav[1];?> >
          <a href="index.php">
              首页  <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
      <li role="presentation" <?php echo @$nav[2];?> >
          <a href="show_all_cats.php">
              书籍分类  <span class="glyphicon glyphicon-list" aria-hidden="true"></span></a></li>
        
<!--admin追加的List-->   
    <?php 
    if(@$is_admin){
        ?>
      <li role="presentation" <?php echo @$nav[3];?>>
          <a href="book_new_form.php">
              提交书籍  <span class="glyphicon glyphicon-book" aria-hidden="true"></span></a></li>
		
	  <li role="presentation" <?php echo @$nav[4];?>>
          <a href="show_all_orders.php">
              所有订单  <span class="glyphicon glyphicon-book" aria-hidden="true"></span></a></li>
        <?php 
    }
    ?>
        
<!--customer追加的List-->       
    <?php     
    if(@$is_customer){
      ?>
      <li role="presentation" <?php echo @$nav[5];?> >
          <a href="show_my_orders.php">
              查看订单  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a></li>
      <li role="presentation" <?php echo @$nav[6];?> >
          <a href="myprofile.php">
              个人设置  <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
      <?php 
    }
    ?>
    </ul>
    </div>
</div>
<?php
}


//////////////////////////////////////
//个人设置页面的导航条
//需要传入参数，当前的页面是几，如果没有的就默认是1，走个人信息
//个人信息：1，收货地址：2，修改密码：3
//////////////////////////////////////
function display_list($list_no){
    //判断当前页是那个list页面
    if($list_no > 0){   //如果当前页面大于0
        $list[$list_no] = " active";//进度条nav[$list_no]变active
    }
?>
 <div class="list-group" >
    <a href="myprofile.php" class="list-group-item<?php echo @$list[1]?>">
      <p class="list-group-item-heading" >个人信息</p>
    </a>
    <a href="addr_list.php" class="list-group-item<?php echo @$list[2]?>">
      <p class="list-group-item-heading">管理收货地址</p>
    </a>
    <a href="change_pwd.php" class="list-group-item<?php echo @$list[3]?>">
      <p class="list-group-item-heading">修改密码</p>
    </a>
  </div>
<?php
}



/////////////////////////////////////////////
//个人信息栏，展示当前用户的用户名和EMAIL
////////////////////////////////////////////////
function display_personal_inf(){
    $useremail = get_email_fromname($_SESSION['current_user']);
  //  var_dump($useremail);
?>
    <div class="profiletab" id="information"  >
        <div class="container">
            <div class="col-md-3">
                <?php display_img('error');?>
            </div>
            <div class="col-md-3">
                <p>用户名: <?php echo @$_SESSION['current_user'];?></p>
                <p>用户EMAIL: <?php echo @$useremail;?></p>
            </div>
        </div>
    </div>
<?php
}
    
    
/////////////////////////////////////////////
//登录注册的图像
//如果没登录就显示登录注册，如果登录了就展示登录名称和logout摁钮
////////////////////////////////////////////////
function login_up(){
?>
<div class="container">
    <div class="row" style="margin-top:8px;">
        <div class="col-md-10"></div > 
        <div class="col-md-2">
		<?php
			if((!isset($_SESSION['current_user'])) && (!isset($_SESSION['admin']))){//判断是否不是admin并且用户应经登录。
				?> 
				<div class="text-right">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					<a href="login_register.php?action=login">登录</a> 
					<a href="login_register.php?action=register">注册</a> 
				</div>
				<?php
			}else{
				?>
				<div style="float:right;">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							你好，<?php echo $_SESSION['current_user'];?>
					<a href="../action/action_user.php?act=logout">登出</a>
				</div>
				<?php    
			}
		?>
        </div > 
    </div >           
</div>
<?php
}


////////////////////////////
//HTML尾部
/////////////////////
function do_html_footer(){
?>
</div>
    <div class="container" id="myfooter" style="padding-top:5px;margin-bottom:8px;margin-top:15px;">
        <small><p class="text-right help-block center-block;" >团队介绍 · 联系我们 · 使用条款 · 网站地图</p></small>
    </div > 

</body>
</html>
</html>
<?php
}


/////////////////////////
//展示所有的目录
///////////////////////////
function display_categories($array){
    if(!empty($array)){
    echo "<div class=\"container\">";
    echo "<ul>";
    foreach($array as $arr){
        
        if(contain_books($arr[0])){
            echo "<li>
                <p><a href='show_books_bycat.php?catid=".$arr[0]."'>"
                .$arr[1].
                "</a></p>
                </li>";
        }
    }
    echo "</ul>";
    echo "</div>";
    }else{
    echo "<p>还没有书籍分类呢！</p>";
    }
}


///////////////////////////////
//显示所有书籍,通过查询类别
//////////////////////////////
function display_books($books){
    foreach($books as $arr){
        $isbn = $arr[0];
        $title = $arr[1];
	?>
    <div class="container" id="books" style="padding-bottom:15px">
        <div class="row">
            <div class="col-md-2">
                <div class="text-center">
                    <?php display_img_default($isbn,100,false,true);?>
                </div>
            </div>
            <div class="col-md-10">
                <div style="text-align:left">
                    <p><a href="show_book_detail.php?isbn=<?php echo"$isbn";?>"><?php echo"$title";?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
	<?php
    }
}


/////////////////////////////////
//展示单个图书的细节
////////////////////////////////
function display_book_detail($book_array){
    if(is_array($book_array)){
		$title 			= $book_array['title'];
		$isbn 			= $book_array['isbn'];
		$author 		= $book_array['author'];
		$price		 	= $book_array['price'];
		$description 	= nl2br($book_array['description']);
		$catid 			= $book_array['catid'];
		$catname 		= get_categories_name($catid);
			
		$default_image_id = get_default_imageid($isbn);
		$default_image_name = get_image_name($default_image_id);
		
		$images_list = get_images_list($isbn);		
		//var_dump($description);
?>
  <div class="container" style="padding:20px;">
<!--    <div class="row">
        <div class="container">
            <h2 style="padding:30px;"><?php echo $title;?></h2>
        </div>
    </div>-->
    <div class="row">
      <div class="col-md-5 text-center">
          <div class="img_preview center-block">
			  <?php display_img_default($isbn,350,false,false);?>
		  </div>
		  <div class="thumb_imgs_module">
			  <div class="icon_left icon_left_cannot" ></div>
			  <div class="thumb_imgs">
				  <div class="thumb_imgs_list">
						<?php	  
							foreach($images_list as $key=>$value){
								$name = $value['name'];
								display_thumb_img($isbn,$name);
							}
						?>
				  </div>
			  </div>
			  <div class="icon_right icon_right_cannot"></div>
		  </div>
      </div>
      <div class="col-md-6">
		  <table class="table" style="margin-top:35px;">
		  	<tr>
				<td class="text-center col-md-3">编号：</td> 
				<td><?php echo $isbn; ?></td> 
			</tr>
			<tr>
				<td class="text-center">类别：</td> 
				<td><?php echo $catname; ?></td> 
			</tr>
			<tr>
				<td class="text-center">作者：</td> 
				<td><?php echo $author; ?></td> 
			</tr>
			<tr>
				<td class="text-center">价格：</td> 
				<td><?php echo $price; ?></td> 
			</tr>
			<tr>
				<td class="text-center">内容：</td> 
				<td><div><?php echo $description; ?></div></td> 
			</tr>
		  </table>
      </div> 
    </div>
  </div>


<?php
    }else{
        display_intro('呃喔，没有您所找的这本书哦');
        display_error();
    }
}


/////////////////////////////////
//图片展示函数,需要输入ISBN号码,宽度，高度随着宽度自动变化，默认居中，如果不是就靠左边
//////////////////////////////////
function display_img($isbn,$width = 100,$center = false,$is_link = false){
    if(!$center){
        $center = '';//如果没有默认不居中，就为空
    }else{
        $center = "center-block";
    }
    if($is_link){//如果是连接的话，就套A连接
		?>
		<a href="show_book_detail.php?isbn=<?php echo $isbn;?>">
			<img src="../images/<?php echo $isbn;?>.jpg" 
				 class="<?php echo $center;?>"  
				 style="max-width:<?php echo $width;?>px;">
		</a>
		<?php
    }else{
        ?>
        <img src="../images/<?php echo $isbn;?>.jpg" 
             class="<?php echo $center;?>"  
             style="max-width:<?php echo $width;?>px;">
        <?php
    }
        
}

/////////////////////////////////
//默认封面，图片展示函数,需要输入ISBN号码,宽度，高度随着宽度自动变化，默认居中，如果不是就靠左边
//////////////////////////////////
function display_img_default($isbn,$width = 100,$center = false,$is_link = false){
	
	$default_image_id = get_default_imageid($isbn);
	$name = get_image_name($default_image_id);
	$path = "../images/$isbn/$name.jpg";
	
    if(!$center){
        $center = '';//如果没有默认不居中，就为空
    }else{
        $center = "center-block";
    }
    if($is_link){//如果是连接的话，就套A连接
		?>
		<a href="show_book_detail.php?isbn=<?php echo $isbn;?>">
			<img src="<?php echo $path;?>" 
				 class="<?php echo $center;?>"  
				 style="max-width:<?php echo $width;?>px;border:#dfdfdf 1px solid;">
		</a>
		<?php
    }else{
        ?>
        <img src="<?php echo $path;?>" 
             class="<?php echo $center;?>"  
             style="max-width:<?php echo $width;?>px;border:#dfdfdf 1px solid;">
        <?php
    }
        
}


/////////////////////////////////
//展示错误图片
//////////////////////////////////
function display_error($width = 200){
?>
    <div class="container">
        <div class="row">
            <?php display_img('error',200);?>
        </div>
        <div class="row">
            <a href="#" onClick="javascript :history.back(-1);" >
                <h5>点我可以回到上一个页面</h5>
            </a> 
        </div>
    </div>
<?php
}

//////////////////////////////////
//摁钮展示函数，需要输入连接和文本
/////////////////////////////////
function display_button($url,$title){
?>
    <a href="<?php echo $url;?>" 
       class="btn active btn-success col-md-1" 
       role="button" style="width:auto;margin:20px 10px 0px 10px;">
    <?php echo $title;?>
    </a>
<?php
}

/////////////////////////////////////////////
//展示首页的缩略图-给首页用，现在是所有的图书都展示
/////////////////////////////////////////////
function display_book_thumbnail($arr){
	

	
	
    
    echo "<div class='container' id='thumbnail'>";
    echo    "<div class='row'>";

    foreach($arr as $book){
        $title 	= $book['title'];
        $isbn 	= $book['isbn'];
        $author = $book['author'];
		
		$default_image_id = get_default_imageid($isbn);
		$name = get_image_name($default_image_id);
		$path = "../images/$isbn/$name.jpg";			
		
        ?>
    <div class="col-md-3" style="padding-bottom:10px;">
        <div style="margin-bottom:5px;"><a href="show_book_detail.php?isbn=<?php echo $isbn;?>">
            <img src="<?php echo $path;?>" style="width:200px;height:280px;border:#dfdfdf 1px solid;border-radius:3px;">
		</a></div>
        <div><a href="show_book_detail.php?isbn=<?php echo $isbn;?>"><?php echo $title;?></a></div>
        <div><?php echo $author;?></div>
    </div>
<?php
}
    echo    "</div>";
    echo "</div>";
}


///////////////////////
//展示每页的说明
/////////////////////////
function display_intro($content){
?>
<div class="container" style="padding-top:20px;font-size:24px;">
    <p><?php echo $content;?></p>
</div>
<?php
}


////////////////
//我是分割线
//////////////////////
function hr(){
    ?>
<div class="container">
    <hr>
</div>
<?php
}


//////////////////////
//登录注册页面
///////////////////////
function login_register($action = 'login'){
?>
<div class="container" id="login_register">
  <!-- 注册登录模块的标签 -->
  <div class="row" id="login_list">
  <ul class="nav nav-tabs horizontal-center" role="tablist">
    <li role="presentation" 
	<?php 
		if($action == 'login'){
			echo "class=\"active\"";
		}
	?>> 
        <a href="#login" aria-controls="login" role="tab" data-toggle="tab">登录</a>
    </li>
    <li role="presentation"
	<?php 
		if($action == 'register'){
			echo "class=\"active\"";
		}
	?>>
        <a href="#register" aria-controls="register" role="tab" data-toggle="tab">注册</a>
    </li>
  </ul>
  </div>
    
  <!-- 注册登录模块的内容标签页 -->
  <div class="row">  
  <div class="tab-content" style="margin:60px;">
    <div role="tabpanel" class="tab-pane 		
	<?php 
		if($action == 'login'){
			echo "active";
		}
	?>" id="login">
    <!--登录模块-->
        <div class="container" style="width:430px;background-color:#eee; border-radius:10px; padding:10px">
            <form method="post" action="../action/action_user.php">
              <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" class="form-control" id="username" placeholder="请输入用户名" name="username"
					   data-toggle="tooltip" 
					   data-placement="left" title="此用户名不存在" data-trigger="manual">
              </div>
              <div class="form-group">
                <label for="password">密码</label>
                <input type="password" class="form-control" id="password" placeholder="请输入密码" name="password"
					   data-toggle="tooltip" 
					   data-placement="left" title="密码不能为空！" data-trigger="manual">
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="is_admin[]" value="1" id="is_admin" > 我是管理员
                </label>
              </div>
              <button id="login_btn" type="submit" class="btn btn-default" style="width:100%;">登录</button>
			  <input type="text" class='hide' name="act" value="login">
            </form>
        </div>
    </div>
           
    <!--注册模块-->
    <div role="tabpanel" class="tab-pane 
	<?php 
		if($action == 'register'){
			echo "active";
		}
	?>" id="register">
        <div class="container" style="width:430px;background-color:#eee; border-radius:10px; padding:10px">
            <form method="post" action="../action/action_user.php">
              <div class="form-group">
                <label for="inputemail">邮箱地址</label>
                <input type="email" class="form-control" id="inputemail" 
					   placeholder="请输入邮箱地址" name="inputemail" 
					   data-toggle="tooltip" 
					   data-placement="left" title="此邮箱已被使用过！" data-trigger="manual">
              </div>
              <div class="form-group">
                <label for="inputusername">用户名</label>
                <input type="text" class="form-control" 
                       id="inputusername" placeholder="请输入您的用户名" name="inputusername"
					   data-toggle="tooltip" 
					   data-placement="left" title="此用户名已被使用过！" data-trigger="manual">
              </div>
              <div class="form-group">
                <label for="inputpwd1">请输入密码</label>
                <input type="password" class="form-control" 
                       id="inputpwd1" placeholder="请输入密码" name="inputpwd1"
					   data-toggle="tooltip" 
					   data-placement="left" title="密码长度必须在6-13位字符之间！" data-trigger="manual">
              </div>
              <div class="form-group">
                <label for="inputpwd2">请再次输入密码</label>
                <input type="password" class="form-control" 
                       id="inputpwd2" placeholder="请再次输入密码" name="inputpwd2"
					   data-toggle="tooltip" 
					   data-placement="left" title="前后两次输入的密码不一致！" data-trigger="manual">
              </div>
              <button type="submit" class="btn btn-default" id="register_btn" style="width:100%" >注册</button>
			  <input type="text" class='hide' name="act" value="register">
            </form>
        </div>    
		<div class="alert alert-warning alert-dismissible fade in hide center-block" role="alert" id="alert_register" 
			 style="width:430px;border-radius:5px;margin-top:10px;">
		  <strong>抱歉！无法注册</strong>
			<br> 输入的信息不完整，请重新输入！
		</div>
    </div>
    </div>
   </div>
</div>

<?php
}






//////////////////////
//block空白行,占空间用
///////////////////////
function display_block($height = 40){
    
    echo "<div style=\"height:".$height."px\">";
    echo "</div>";
}

//////////////////////
//block空白行,高度=login-register的高度
///////////////////////
function display_login_block(){
    
    echo "<div id=\"login_bolck\" style=\"display:block;\">";
    echo "</div>";
}

//////////////////////////
//添加地址用的摁钮及弹出的表单
//////////////////////////
function add_addr_form(){
?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-default btn-xs" data-toggle="modal" 
         data-target="#add_addr_form" style="width:100%;margin-top:5px;">
  新增收货地址
</button>
<!-- Modal 新增地址部分-->
<div class="modal fade" id="add_addr_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
  <?php addr_form('new');?>
</div>

<?php
}



/***********************************
    展示删除收货地址的删除按钮
**********************************/
function btn_del_addr($del_ship_id){
?>
    <button type="button" class="close" data-dismiss="modal" 
            aria-label="Close" data-toggle="modal" 
            data-target="#del_addr<?php echo $del_ship_id; ?>">
        <span aria-hidden="true">&times;</span>
    </button>
    <!-- Modal -->
	<?php del_addr_form($del_ship_id);

}

//展示删除收货地址的确认模态框
function del_addr_form($del_ship_id){
?>
	<div class="modal fade" 
		 id="del_addr<?php echo $del_ship_id; ?>" 
		 tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="color:black;">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel">确认删除</h4>
		  </div>
		  <div class="modal-body">
			请确认是否删除此收货地址？
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
			<button class="btn btn-danger del_addr-btn" want_del="<?php echo $del_ship_id; ?>">确认删除</button>
		  </div>
		</div>
	  </div>
	</div>
<?php
}

/***********************************
    展示收货地址细节detail
**********************************/
function display_addr_detail($addr_detail,$is_default){
    $ship_id        = $addr_detail['ship_id'];
    $ship_person    = $addr_detail['ship_person'];
    $ship_city      = $addr_detail['ship_city'];
    $ship_district  = $addr_detail['ship_district'];
    $ship_addr      = $addr_detail['ship_addr'];
    $ship_tel       = $addr_detail['ship_tel'];
    
?>
<div style="border-radius:2px;border:2px #eee solid;margin-bottom:10px;margin-top:10px;padding:10px;" 
     class="addr_detail" id="addr_no_<?php echo $ship_id; ?>">
    <div class="row">
        <div class="col-md-3 def_addr">
            <?php
            /*如果是默认地址，就展示默认地址标签，如果不是，就不展示*/
                if($is_default){
                    show_default();
                }
            ?>
        </div>
        <div class="col-md-7">
        </div>
        <div class="col-md-2">
            <!--删除此收货地址按钮-->
            <?php btn_del_addr($ship_id);?>
        </div>
    </div>
    <div class="row">
        <table class="table-condensed" 
               style="width:100%;">
            <tr>
                <td class="table-left"><span>收货人:</span></td>
                <td class="now_ship_person"><?php echo $ship_person; ?></td>
            </tr>
            <tr>
                <td class="table-left "><span>城市:</span></td>
                <td class="now_ship_city"><?php echo $ship_city; ?></td>
            </tr>
            <tr>
                <td class="table-left "><span>地区:</span></td>
                <td class="now_ship_district"><?php echo $ship_district; ?></td>
            </tr>
            <tr>
                <td class="table-left "><span>详细地址:</span></td>
                <td class="now_ship_addr"><?php echo $ship_addr; ?></td>
            </tr>
            <tr>
                <td class="table-left "><span>联系电话:</span></td>
                <td class="now_ship_tel"><?php echo $ship_tel; ?></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-2">
            <!--设置默认收货地址按钮-->   
                <span class="set_def_addr" act="set_def_addr" set_def_addr_id="<?php echo $ship_id; ?>">设为默认</span>
        </div>
        <div class="col-md-2" style="padding-right:30px;">
            <!--编辑修改收货地址按钮-->
			<span data-toggle="modal" class="edit_btn"
        		data-target="#modify_addr_model<?php echo $ship_id;?>" >编辑
    		</span>
            <?php modify_addr_form($ship_id)?>
        </div>
    </div>
</div>
<?php
}


////////////////////////////////////////
//修改addr信息的表单
///////////////////////////////////
function modify_addr_form($ship_id){
    
    $ship_detail = get_addr_detail($ship_id);
    
    //$ship_id        = @$ship_detail['ship_id'];             //收件ID
    $ship_person    = @$ship_detail['ship_person'];         //收件人
    $ship_city      = @$ship_detail['ship_city'] ;          //收件城市/省
    $ship_district  = @$ship_detail['ship_district'];       //收件地区/县
    $ship_addr      = @$ship_detail['ship_addr'] ;          //收件详细地址
    $ship_zip       = @$ship_detail['ship_zip'] ;           //收件邮编
    $ship_tel       = @$ship_detail['ship_tel'];            //收件人联系电话
    $ship_tel2      = @$ship_detail['ship_tel2'];           //备用联系电话
    $ship_email     = @$ship_detail['ship_email'] ;         //收件人邮箱
    $submit_time    = @$ship_detail['submit_time'] ;        //提交时间
    
?>
 
    
<!-- Modal -->
<div class="modal fade addr_modify" ship_id="<?php echo $ship_id;?>" id="modify_addr_model<?php echo $ship_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
  <?php addr_form('modify',$ship_id);?>
</div>
<?php
}
    
    
////////////////////////////////////////
//收货地址的标签页里展示默认收货地址记号
///////////////////////////////////
function show_default(){
?>
<div>
    <p class="text-center" style="width:100%;background-color:orange;color:white;">默认地址</p>
</div>
<?php
}


//////////////////////
//返回上一个页面的连接
///////////////////////
function back_link(){
    echo "<div style=\"height:".$height."px\">";
    echo "</div>";
}

//////////////////////
//展示购物车里面的内容，在我的购物车页面。
///////////////////////
function display_item($isbn,$num){

    $detail = get_book_detail($isbn);
    $price = $detail['price'];
    $title = $detail['title'];
    $price_total = $price*$num;
?>
    <tr class="cart_item_no" style="margin-top:10px;" id="item_<?php echo $isbn;?>" isbn="<?php echo $isbn;?>">
        <td class="check">
            <div style="margin-right:15px;margin-left:5px;float:left;" >
                <input type="checkbox" class="item_check" name="checked[<?php echo $isbn;?>]"> 
            </div>
            <div style="float:left;">
            <?php display_img_default($isbn,120,false,true);?>
            </div>
        </td>
        <td style="padding-top:20px;">
            <a href="show_book_detail.php?isbn=<?php echo $isbn;?>"><?php echo $title;?></a>
        </td>
        <td class="price" style="padding-top:20px;" price="<?php echo $price;?>">
            <p><?php echo $price;?></p>
			<input class="hide" name="<?php echo $isbn;?>_price" value="<?php echo $price;?>">
        </td>
        <td style="padding-top:20px;">
            <div>
                <div class="minus">-</div>
                <input class="num" value="<?php echo $num;?>" name="<?php echo $isbn;?>_num" 
                       type="text" maxlength="3" size="3" style="text-align:center;float:left;" isbn='<?php echo $isbn;?>'>
                <div class="plus">+</div>
            </div>
        </td>
        <td class="price_total" style="padding-top:20px;">
            <?php echo sprintf("%0.2f",$price_total);?>
        </td>
        <td style="padding-top:20px;">
			<!-- Button trigger modal -->
			<div class="item-del"  data-toggle="modal" data-target="#myModal<?php echo $isbn;?>">删除</div>
			<!-- Modal -->
			<div class="modal fade" id="myModal<?php echo $isbn;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">确认删除</h4>
				  </div>
				  <div class="modal-body">
					是否要将此件商品移出购物车？
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					<button type="button" class="btn btn-danger delete-btn" isbn="<?php echo $isbn;?>">确认删除</button>
				  </div>
				</div>
			  </div>
			</div>
        </td>
    </tr>
<?php
}




//购物车为空的时候展示的页面
function empty_cart(){
?>
	<div class="center-block">
		<div class="row" style="padding:60px;">
			<div class="col-md-4 text-right"><img src="../images/cart.png" style="width:100px;opacity:0.5;"></div>
			<div class="col-md-4" style="padding:20px;">
				<p>购物车空空的哦~，去看看心仪的书籍吧~</p>
				<p><a href="index.php">去看看></a></p>
			</div>
		</div>
	</div>
<?php
}




//////////////////////
//书籍的表单,可用于添加，修改，删除用。
///////////////////////
function book_form($action,$book_array = null){

    $isbn        = @$book_array['isbn'];
    $author      = @$book_array['author'];
    $title       = @$book_array['title'];
    $catid       = @$book_array['catid'];
    $cat         = @get_categories_name($catid);
    $price       = @$book_array['price'];
    $description = @$book_array['description'];

?>
<div class="container">
    <div class="row">
		<div class="col-md-4 text-center">
		<!--图片展示处-->
			<div id="preview">
				<?php 
				if($action == 2){
					display_img_default($isbn,200);
				}
				?>
			</div>
		</div>
		<!--图书细节处-->
        <div class="container col-md-4 center-block" 
             style="width:430px;background-color:#eee; border-radius:10px; padding:10px">
        <form method="post" 
			  
			  <?php 
				if($action == 1){
					echo "action='book_new_images.php'";
			  	}else{
					echo "action='../action/action_book.php'";
				}
			  ?>
			  
			  >
          <div class="form-group">
            <label for="isbn">ISBN编号</label>
            <input type="text" class="form-control" id="isbn" maxlength="13"
                   placeholder="请输入13位纯数字" name="isbn" value="<?php echo $isbn;?>" 
				   data-toggle="tooltip" data-placement="left" title="输入的ISBN已经存在，请重新输入！" data-trigger="manual"
				   <?php if($action == 2){ echo "readonly";}?>>
          </div>
          <div class="form-group">
            <label for="author">作者</label>
            <input type="text" class="form-control" id="author" 
				   placeholder="请输入作者的姓名" name="author" value="<?php echo $author;?>">
          </div>
          <div class="form-group">
            <label for="title">标题</label>
            <input type="text" class="form-control" id="title" 
				   placeholder="请输入书籍的标题" name="title" value="<?php echo $title;?>">
          </div>
          <div class="form-group">
            <label for="cat">图书类别</label>
            <input type="text" class="form-control" id="cat" 
				   placeholder="请输入书籍所属类别" name="cat" value="<?php echo $cat;?>">
          </div>
          <div class="form-group">
            <label for="price">书籍定价</label>
            <input type="text" class="form-control" id="price" placeholder="请输入书籍价格" name="price" value="<?php echo $price;?>">
          </div>
          <div class="form-group">
            <label for="description">图书描述</label>
            <!--<input type="text" class="form-control" >-->
              <textarea class="form-control" id="description" placeholder="请输入图书描述" 
                        rows="3" name="description" ><?php echo $description;?></textarea>
          </div>    
		 
<!--如果ACTION为1就展示添加-->	
<?php 
	if($action == 1){
		?>
	<div>
		<button type="submit" class="btn btn-success btn-lg" style="width:48%;float:left;" id="add_images">继续添加图片</button>
		<a href="#" onClick="javascript :history.back(-1);" >
			<button type="button" class="btn btn-default btn-xs" style="width:48%;float:right;" >返回</button>
		</a>
		<input class="hide" name='act' value="new">
		<button type="reset" class="btn btn-danger btn-xs" data-toggle="modal" id="clear-btn" 
							data-target="#myModal" style="width:48%;float:right;margin-top:5px;">
					  清空信息
		</button>	
	</div>
		<?php
	}
?>
<!--如果ACTION为2就展示修改-->
<?php 
	if($action == 2){
			?>
            <div>
				<input class="hide" name='act' value="modify">
                <button type="submit" class="btn btn-success btn-lg" style="width:48%;float:left;">
                    确定修改
                </button>
				</form>
             <form action="../action/action_book.php" method="post">
                <a href="#" onClick="javascript :history.back(-1);" >
                    <button type="button" class="btn btn-default btn-xs" style="width:48%;float:right;" >返回上一页面</button>
                </a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                        data-target="#myModal" style="width:48%;float:right;margin-top:5px;">
                  删除图书
                </button>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                          <h4 class="modal-title" id="myModalLabel"><strong>确认是否删除此书籍</strong></h4>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-2">
                            <?php display_img_default($book_array['isbn']) ?>
                          </div>  
                            <div class="col-md-10">
                                <ul>
                                <?php
                                  echo "<li>作者：".$book_array['author']."</li>";
                                  echo "<li>名称：".$book_array['title']."</li>";
                                  echo "<li>ISBN：".$book_array['isbn']."</li>";
                                  echo "<li>价格：".$book_array['price']."</li>";
                                ?>
                                </ul>
                            </div>
                          <div class="col-md-10">
                          </div> 
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="width:20%">取消</button>
                        <input class="hide" name='act' value="delete">
						<input class="hide" name="isbn" value="<?php echo $isbn;?>">
                        <button type="submit" class="btn btn-danger" style="width:20%">确认删除</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
			<?php 
	}
	?>
        </form>
        </div>
    </div>
</div>
<?php
    
}



////////////////////////////////////////
//地址表单，可用户添加，修改，删除，设定默认地址用
///////////////////////////////////
function addr_form($act,$ship_id = null){
    
    $ship_detail 	= get_addr_detail($ship_id);
    $ship_person    = @$ship_detail['ship_person'];         //收件人
    $ship_city      = @$ship_detail['ship_city'] ;          //收件城市/省
    $ship_district  = @$ship_detail['ship_district'];       //收件地区/县
    $ship_addr      = @$ship_detail['ship_addr'] ;          //收件详细地址
    $ship_zip       = @$ship_detail['ship_zip'] ;           //收件邮编
    $ship_tel       = @$ship_detail['ship_tel'];            //收件人联系电话
    $ship_tel2      = @$ship_detail['ship_tel2'];           //备用联系电话
    $ship_email     = @$ship_detail['ship_email'] ;         //收件人邮箱
    $submit_time    = @$ship_detail['submit_time'] ;        //提交时间
    
	if($act == 'new'){
		$title = '新增收货地址';
	}else if($act == 'modify'){
		$title = '修改收货地址';
	}
?>
<!-- Modal -->
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="color:black;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
          <h4 class="modal-title" id="myModalLabel1"><strong><?php echo $title; ?></strong></h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="ship_person">收件人<span>*</span></label>
            <input type="text" class="form-control ship_person" value="<?php echo $ship_person; ?>"
                   id="ship_person" placeholder="收件人" name="ship_person_m" required="required" >
          </div>
          <div class="form-group" style="width:48%;float:left;">
            <label for="ship_city">城市/省<span>*</span></label>
            <input type="text" class="form-control ship_city" value="<?php echo $ship_city; ?>"
                   id="ship_city" placeholder="城市/省" name="ship_city_m" required="required" >
          </div>
          <div class="form-group" style="width:48%;float:right;">
            <label for="ship_district">区/县<span>*</span></label>
            <input type="text" class="form-control ship_district" value="<?php echo $ship_district; ?>"
                   id="ship_district" placeholder="区/县" name="ship_district_m" required="required" >
          </div>
          <div class="form-group">
            <label for="ship_addr">详细地址<span>*</span></label>
            <input type="text" class="form-control ship_addr" value="<?php echo $ship_addr; ?>"
                   id="ship_addr" placeholder="详细地址" name="ship_addr_m" required="required" >
          </div>
          <div class="form-group" >
            <label for="ship_zip">邮编</label>
            <input type="text" class="form-control ship_zip" value="<?php echo $ship_zip; ?>"
                   id="ship_zip" placeholder="邮编" name="ship_zip_m" maxlength="6">
          </div>
          <div class="form-group" style="width:48%;float:left;">
            <label for="ship_tel">联系人电话<span>*</span></label>
            <input type="text" class="form-control ship_tel" value="<?php echo $ship_tel; ?>"
                   id="ship_tel" placeholder="联系人电话" name="ship_tel_m" maxlength="11" required="required" >
          </div>
          <div class="form-group" style="width:48%;float:right;">
            <label for="ship_tel2">备用电话</label>
            <input type="text" class="form-control ship_tel2" value="<?php echo $ship_tel2; ?>"
                   id="ship_tel2" placeholder="备用电话" name="ship_tel2" maxlength="11">
          </div>
          <div class="form-group">
            <label for="ship_email">EMAIL</label>
            <input type="text" class="form-control ship_email" value="<?php echo $ship_email; ?>"
                   id="ship_email" placeholder="EMAIL" name="ship_email">
            <input type="text" value="<?php echo $ship_id; ?>" class="hide" name="ship_id_m">
          </div>
      </div>
		<div class="modal-footer">
<!--如果是新增地址-->
<?php
	if($act == 'new'){
		?>
		  <button type="button" class="btn btn-default" data-dismiss="modal" style="width:20%">取消</button> 
          <button class="btn btn-success" style="width:20%" id="add_addr_btn">确认添加</button>
		<?php
	}
?>
<!--如果是修改地址-->
<?php
	if($act == 'modify'){
		?>
        <button type="button" class="btn btn-default" data-dismiss="modal" style="width:20%">取消</button>
        <button type="submit" class="btn btn-success modify_btn" style="width:20%">确认编辑</button>
		<?php
	}
?>
      </div>
    </div>
  </div>
<?php
}
   

/*展示报错信息，需要输入errorid*/
function display_error_info($error_id){
	$error_info = get_error_info($error_id);
?>
<div class="container">
	<div class="alert alert-warning center-block" style="width:62%;margin-top:10px;" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><strong>提示：</strong><br>
		<?php echo $error_info;?><br>
		错误代码：<?php echo $error_id;?></p>
	</div>
</div>
<?php

}


///////////////////////////////////////////////////
/*展示简略的地址信息，需要输入地址ID,在订单提取页展示*/
////////////////////////////////////////////////
function display_addr_detail_easy($addr_detail,$is_default){
    $ship_id        = $addr_detail['ship_id'];
    $ship_person    = $addr_detail['ship_person'];
    $ship_city      = $addr_detail['ship_city'];
    $ship_district  = $addr_detail['ship_district'];
    $ship_addr      = $addr_detail['ship_addr'];
    $ship_tel       = $addr_detail['ship_tel'];
    $ship_tel2      = $addr_detail['ship_tel2'];
    $ship_zip       = $addr_detail['ship_zip'];
    $ship_email     = $addr_detail['ship_email'];
	
?>
	 
 <div class="row addr_list" style="color:#666;padding:5px;" id="addr_no_<?php echo $ship_id; ?>">
	 <div class="col-md-2 text-center select_addr_btn <?php if($is_default){echo "choosed";}?>" 
		  style="height:35px;width:160px;border:1px solid #eee;padding:5px;cursor:pointer;">
		 <span class="addr_person"><?php echo $ship_person; ?></span>-<span class="ship_city"><?php echo $ship_city; ?></span>
	 </div>
	 <div class="col-md-7 addr_body" style="padding:8px;">
		 <span class="addr_person"><?php echo $ship_person;?></span>&nbsp;&nbsp;
		 <span class="addr_info">
			 <span class="ship_city"><?php echo $ship_city;?></span>
			 <span class="ship_district"><?php echo $ship_district;?></span>
			 <span class="ship_addr"><?php echo $ship_addr;?></span>
		 </span>&nbsp;&nbsp;
		 <span class="addr_tel"><?php echo $ship_tel;?></span>&nbsp;&nbsp;
		 <span class="addr_tel2 hide"><?php echo $ship_tel2;?></span>
		 <span class="ship_zip hide"><?php echo $ship_zip;?></span>
		 <span class="ship_email hide"><?php echo $ship_email;?></span>
		 <span style="background-color:grey;color:white;" class="show_def_addr		 
		 <?php
			if(!$is_default){
			echo "hide";
			}
		 ?>">&nbsp;默认地址&nbsp;
</span>
	 </div>
	 
	 <?php del_addr_form($ship_id);?>
	 <?php modify_addr_form($ship_id)?>
	 <div class="col-md-3 addr_control hide" style="padding:8px;">			 
		 <span data-dismiss="modal" class="delete_addr_easy"
			aria-label="Close" data-toggle="modal" 
			data-target="#del_addr<?php echo $ship_id; ?>" style="cursor:pointer;">删除
		 </span>
		 <span class="modify_addr_easy">
			 <span data-toggle="modal" class="edit_btn" data-target="#modify_addr_model<?php echo $ship_id;?>" >编辑</span>
		 </span>
		 <span class="set_def_addr 
			<?php
				if($is_default){
					echo "hide";
				}
			?>" set_def_addr_id="<?php echo $ship_id; ?>">
			
			 <span style='cursor:pointer;'>设为默认</span>
		 </span>
	 </div>
</div>
	

<?php
}

///////////////////////////////////
/*提交订单的时候展示商品的detail*/
//////////////////////////////////////
function display_book_detail_easy($isbn,$num,$price){
	$detail 	= get_book_detail($isbn);
	$title 		= $detail['title'];
	$total_price = $num*$price;
?> 
<tr>

	<td class="col-md-3"><?php display_img_default($isbn);?></td>
	<td class="col-md-3"><a href="show_book_detail.php?isbn=<?php echo $isbn; ?>" target="_blank"><?php echo $title;?></a></td>
	<td class="col-md-3"><span style="color:red;font-weight:bold;">￥<?php echo $price;?></span></td>
	<td class="col-md-3">x<?php echo $num;?></td>
	
	<td><input class="hide" type="checkbox" name="order_items[<?php echo $isbn;?>]" checked="checked"></td>
	<td><input class="hide" type="text" name="order_items[<?php echo $isbn;?>][price]" value="<?php echo $price; ?>"></td>
	<td><input class="hide" type="text" name="order_items[<?php echo $isbn;?>][num]" value="<?php echo $num; ?>"></td>

</tr>
<?php
}

///////////////////////////
/*发票信息的内容修改表单*/
/////////////////////////
function display_invoice_form(){
	?>
<!-- 发票信息FORM Modal -->
<div class="modal fade" id="modify_invoice_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">发票信息</h4>
	  </div>
	  <div class="modal-body">
		  <div class="container-fluid">
			<div class="row" id="invoice_mode_list">
				<div class="text-center invoice_mode col-md-1 choosed">普通发票</div>	
			</div>
			<div class="row" style="margin-top:10px;">
				<div class="col-md-3 text-right invoice_label">发票抬头：</div>
				<div class="col-md-9" >
					<div id="invoice_list">
						<div class='invoice_title choosed' id="invoice_title_person">
							<input value="个人" class='invoice_title_text' readonly>
						</div>
						<?php
							$customerid = $_SESSION['customerid'];
							$invoice_list = @get_invoice_list($customerid);
							if($invoice_list){
								foreach($invoice_list as $key=>$invoice_no){
									$invoice_title = get_invoice_title($invoice_no);
									display_invoice_title($invoice_title,$invoice_no);
								}
							}
						?>
					</div>
					<div style="margin-top:5px;"><p><span id="new_invoice_title">新增发票信息</span></p></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 text-right invoice_label"><p>发票内容：</p></div>
				<div class="col-md-9" id="invoice_content_list">
					<div class="text-center invoice_content col-md-1 choosed">明细</div>
					<div class="text-center invoice_content col-md-1">办公用品</div>
				</div>
			</div>
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" id="invoice_form_save" class="btn btn-primary">保存修改</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
	  </div>
	</div>
  </div>
</div>
<?php
}

///////////////////////////////////
//展示发票抬头
////////////////////////////
function display_invoice_title($invoice_title,$invoice_no){
?>
<div class='invoice_title' invoice_no="<?php echo $invoice_no;?>">
	<span>
		<input value="<?php echo $invoice_title; ?>" size='40' class='invoice_title_text' readonly>
	</span>
	<span class="invoice_control_list hide">
		<span class="invoice_modify">编辑</span>
		<span class="invoice_save hide">保存</span>
		<span class="invoice_delete">删除</span>
	</span>
</div>
<?php
}

///////////////////////////////////
//添加图片的模块
//////////////////////////////
function display_add_images(){
?>
<div class="container">
	<div id="canvas_background" class="center-block">
		<div class="upload_image_bar hide" >
			<button class="btn btn-default" id="upload_more"  type="button">选择图片上传</button>
			<span class="label_upload">提示：请选择要上传的照片（单张图片大小限制为10M）。</span>
			<span class="upload_status"></span>
		</div>
		<div id="preview_images" class="hide"></div>
		<div class="a-upload text-center center-block">选择照片上传
			<input type="file" id="upload_no_1" onchange="preview(this)"  name='upload_images_1' multiple>
		</div>
		<div id="label_upload_images" class="text-center label_upload">
			提示：请选择要上传的照片, 最多不超过5张（单张图片大小限制为10M）。
		</div>
	</div>
	<div class="control_bar">
		<button class="btn btn-success" type="submit" id="submit_btn">保存</button>
		<a href="#" onClick="javascript :history.back(-1);" >
			<button class="btn btn-default" type="button">返回</button>
		</a> 
	</div>
</div>
<?php
}
	
////////////////////////////////////
//修改图片的图片展示
//////////////////////////////
function display_image_modify($array){
	$image_id 		= $array['image_id'];
	$name 			= $array['name'];
	$isbn 			= $array['isbn'];
	$default_image 	= $array['default_image'];
	
	$path = "../images/$isbn/$name.jpg";
?>
<div class='uploaded_img' id="img_<?php echo $image_id;?>">
	<img src='<?php echo $path;?>'/>
	<div class='upload_img_control'>
		<span><label><input type='radio' name='image_id' value="<?php echo $image_id;?>"
							<?php if($default_image == 1){echo 'checked';}?>>
			设为封面</label></span>
		<span class='delete_self' del_no="<?php echo $image_id;?>">删除</span>
	</div>

</div>

	<!--确认删除模态框	-->
	<div class="modal fade" id="del_selected_<?php echo $image_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">提示</h4>
		  </div>
		  <div class="modal-body">
			请确认是否删除所选中的图片？
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			<button type="button" class="btn btn-danger del_selected_items" del_no="<?php echo $image_id;?>">确认删除</button>
		  </div>
		</div>
	  </div>
	</div>
<?php	
}
	
//detail下图片缩略图
function display_thumb_img($isbn,$name){
	$path = "$isbn/$name";
	
	$default_id = get_default_imageid($isbn);
	$default_name = get_image_name($default_id);
	$is_default = 0;
	if($default_name == $name){
		$is_default = 1;
	}
?>
	<img class="thumb_img <?php if($is_default == 1){echo 'thumb_img_hover';} ?>" src="../images/<?php echo $path;?>.jpg">
<?php
}
	
	
	
///////////////////////////////////
//订单系统中展示我的订单
//////////////////////////////////////
function display_order_easy($order_id){

	$order_detail 			= get_order_main_detail($order_id);		//取得订单整体细节
	$order_status_id 		= $order_detail['order_status_id'];
	$order_items_id 		= $order_detail['order_items_id'];
	$order_address_id 		= $order_detail['order_address_id'];
	$order_total_amount 	= $order_detail['total_amount'];
	$order_pay_id 			= $order_detail['order_pay_id'];
	
	$status_detail 			= get_status_detail($order_status_id);		//取得订单状态细节
	$submit_time 			= $status_detail['submit_time'];			//取得提交时间
	$order_status 			= $status_detail['status'];					//取得订单状态
	$order_items 			= get_order_items($order_items_id);			//取得订单物品detail
	$order_address 			= get_order_address($order_address_id);		//取得订单地址detail
	$order_pay_detail 		= get_order_pay_detail($order_pay_id);		//取得订单支付detail
	$order_person 			= $order_address['ship_person'];
	$order_status_name		= get_status_name($order_status);

?>

<tr style="display:block;height:40px;"></tr>
<tr class="active table-bordered ">
	<td colspan="7">
		<span style='color:#aaa;'><?php echo $submit_time;?></span>
		<span style="margin-left:30px;color:#aaa;">订单号：</span>
		<a href="show_order_detail.php?order_id=<?php echo $order_id;?>"><?php echo $order_id;?></a>
	</td>
</tr>
	
<?php
	$num = count($order_items);
	$i = 0;
	foreach($order_items as $index=>$item){
		//展示商品的照片
		//展示商品的名称以及连接
		$isbn = $item['isbn'];
		$book_detail = get_book_detail($isbn);
		$title = $book_detail['title'];
		$item_num = $item['quantity'];
		
		echo "<tr class='table-bordered order_items'>";
		echo "<td style='width:100px;'>";
		display_img_default($isbn,100,false,true);
		echo "</td>";
		echo "<td><a href='show_book_detail.php?isbn=$isbn'>".$title."<a/></td>";		
		echo "<td  style='width:100px;color:#aaa;'>x".$item_num."</td>";

		if($i == 0){
			echo "<td rowspan='$num' class='table-bordered text-center td-w-95'>";
			echo $order_person;
			echo "</td>";

			echo "<td rowspan='$num' class='table-bordered text-center td-w-95' style='color:#aaa;'>";
			echo "总额：¥".$order_total_amount;
			echo "</td>";

			echo "<td rowspan='$num'class='table-bordered text-center td-w-95'>";
			echo $order_status_name;
			echo "</td>";		

			echo "<td rowspan='$num'class='table-bordered text-center td-w-95'>";
			echo "<a href='show_order_detail.php?order_id=$order_id'>订单详情</a>";
			echo "</td>";		

		}
		echo "</tr>";
		$i++;
	}
}		
	
//展示我的订单的详情
function display_order_detail($order_id){

	$order_detail 			= get_order_main_detail($order_id);		//取得订单整体细节
	$order_status_id 		= $order_detail['order_status_id'];
	$order_items_id 		= $order_detail['order_items_id'];
	$order_address_id 		= $order_detail['order_address_id'];
	$order_total_amount 	= $order_detail['total_amount'];
	$order_pay_id 			= $order_detail['order_pay_id'];
	$order_invoice_id 		= $order_detail['order_invoice_id'];
	
	$status_detail 			= get_status_detail($order_status_id);		//取得订单状态细节
	$submit_time 			= $status_detail['submit_time'];			//取得提交时间
	$order_status 			= $status_detail['status'];					//取得订单状态
	$order_items 			= get_order_items($order_items_id);			//取得订单物品detail
	$order_address_detail 	= get_order_address($order_address_id);		//取得订单地址detail
	$order_pay_detail 		= get_order_pay_detail($order_pay_id);		//取得订单支付detail
	$order_invoice_detail	= get_order_invoice_detail($order_invoice_id);//取得发票detail
	
	$order_person 			= $order_address_detail['ship_person'];
	$order_address			= $order_address_detail['ship_city'];
	$order_tel				= $order_address_detail['ship_tel'];
	
	$order_invoice_mode		= $order_invoice_detail['invoice_mode'];
	$order_invoice_title	= $order_invoice_detail['invoice_title'];
	$order_invoice_content	= $order_invoice_detail['invoice_content'];

	$order_status_name		= get_status_name($order_status);
	$order_pay_mode 		= get_pay_mode($order_pay_detail['pay_mode']);
	
	$default_item_isbn = $order_items[0]['isbn'];
	
?>

<!--展示订单的主要状态-->
<div class="order_main_details">
	<div style="width:30%;float:left;">
		<div class="text-center" style="color:#666;">订单号：<?php echo $order_id;?></div>
		<div class="text-center order_main_detail_body" style=""><?php echo $order_status_name;?></div>
		<?php display_order_control($order_status,$order_id);?>
		
	</div>
	<div  style="width:70%;">
	
	
	</div>
</div>

<!--展示订单的次要状态-->
<div class="order_second_details">
	<div style="width:30%;float:left;">
		<?php display_img_default($default_item_isbn,100,false,true);?><span>送货方式：普通快递</span>
	</div>
	<div style="width:70%;">
		<?php display_order_history($order_status_id,$order_id); ?>
	</div>
</div>

<!--展示订单的细节-->
<div class="order_other_details">
	<div>
		<h4>收货人信息</h4>
		<span class="label_order">收货人:</span><div><?php echo $order_person;?></div>
		<span class="label_order">收货地址:</span><div><?php echo $order_address;?></div>
		<span class="label_order">联系电话:</span><div><?php echo $order_tel;?></div>
	</div>
	<div>
		<h4>配送方式</h4>
		<span class="label_order">配送方式</span><div>普通快递</div>
		<span class="label_order">运费：</span><div>¥0.00</div>
	</div>
	<div>
		<h4>付款信息</h4>
		<span class="label_order">付款方式:</span><div><?php echo $order_pay_mode;?></div>
		<span class="label_order">商品总额:</span><div>¥<?php echo $order_total_amount;?></div>
	</div>
	<div>
		<h4>发票信息</h4>
		<span class="label_order">发票类型：</span><div><?php echo $order_invoice_mode;?></div>
		<span class="label_order">发票抬头：</span><div><?php echo $order_invoice_title;?></div>
		<span class="label_order">发票内容：</span><div><?php echo $order_invoice_content;?></div>
	</div>
</div>

<!--展示商品-->
<table class="table">
<tr style="display:block;height:40px;"></tr>
<tr class="active table-bordered text-center">
	<td colspan="2">商品</td>	
	<td>商品编号</td>	
	<td>价格</td>	
	<td>数量</td>	
	<td>操作</td>		
</tr>
<?php
	foreach($order_items as $index=>$item){
		//展示商品的照片
		//展示商品的名称以及连接
		$isbn = $item['isbn'];
		$book_detail = get_book_detail($isbn);
		$title = $book_detail['title'];
		$item_num = $item['quantity'];
		$price	  = $item['item_price'];
		
		echo "<tr class='table-bordered order_items  text-center'>";
		echo "<td style='width:100px;'>";
		display_img_default($isbn,100,false,true);
		echo "</td>";
		echo "<td  class='text-left'><a href='show_book_detail.php?isbn=$isbn'>".$title."<a/></td>";		
		echo "<td style='width:15%;color:#aaa;'>$isbn</td>";		
		echo "<td style='width:15%;color:#aaa;'>".$price."</td>";
		echo "<td style='width:15%;color:#aaa;'>x".$item_num."</td>";
		echo "<td style='width:15%;'>退换货</td>";
		echo "</tr>";
	}
?>
</table>


<?php
}	

//展示针对订单的操作方式
function display_order_control($order_status,$order_id){
//如果是用户，可以撤掉订单/确认收货。
	//var_dump($order_status);
	$customerid 			= @$_SESSION['customerid'];
	$is_admin 				= @$_SESSION['is_admin'];
	
	$order_detail 			= @get_order_main_detail($order_id);		//取得订单整体细节
	$order_express_id 		= @$order_detail['order_express_id'];
	$order_express_detail 	= @get_order_express($order_express_id);
	$express_company		= $order_express_detail['express_company'];
	$express_no				= $order_express_detail['express_no'];
	
	
	if($customerid){
		if($order_status == 0 || $order_status == 1){
			?>
<button class="btn center-block" data-toggle="modal" data-target="#cancel_order">撤销订单</button>

<!-- Modal -->
<div class="modal fade" id="cancel_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">撤消订单</h4>
      </div>
      <div class="modal-body">
        确认是否撤消订单？
      </div>
      <div class="modal-footer">
		  <form method="post" action="../action/action_order.php">
		  <input type="text" class="hide" name="act" value="cancel_order" >
		  <input type="text" class="hide" name="order_id" value="<?php echo $order_id ;?>">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">确认撤消</button>
		  </form>
      </div>
    </div>
  </div>
</div>



			<?php
		}		
		if($order_status == 2){
			?>
<button class="btn center-block" data-toggle="modal" data-target="#order_receive">确认收货</button>

<!-- Modal -->
<div class="modal fade" id="order_receive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">收货确认</h4>
      </div>
      <div class="modal-body">
        确认是否已经收到商品？
      </div>
      <div class="modal-footer">
		  <form method="post" action="../action/action_order.php">
		  <input type="text" class="hide" name="act" value="receive_order" >
		  <input type="text" class="hide" name="order_id" value="<?php echo $order_id ;?>">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">确认收到</button>
		  </form>
      </div>
    </div>
  </div>
</div>

			<?php
		}		
		if($order_status == 3){
			?>
<button class="btn center-block" data-toggle="modal" data-target="#return_order">退换货</button>

<!-- Modal -->
<div class="modal fade" id="return_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">退换货</h4>
      </div>
      <div class="modal-body">
        确认是否退换货？
      </div>
      <div class="modal-footer">
		  <form method="post" action="../action/action_order.php">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">确认退换</button>
		  <input type="text" class="hide" name="act" value="return_order" >
			  <input type="text" class="hide" name="order_id" value="<?php echo $order_id ;?>">
		  </form>
      </div>
    </div>
  </div>
</div>

			<?php
		}
		
	}
//如果是商家，可以填写发货信息/修改发货信息
if($is_admin){
if($order_status == 0 || $order_status == 1){
?>
<button class="btn center-block" data-toggle="modal" data-target="#order_express">填写快递信息</button>

<!-- Modal -->
<div class="modal fade" id="order_express" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">填写快递信息</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="../action/action_order.php">
	    <label for="express_company">快递公司</label>
	    <input type="text" class="form-control" id="express_company"
			   placeholder="请填写快递公司名称" name="express_company" >
		<label for="express_no">快递单号</label>
	    <input type="text" class="form-control" id="express_no"
			   placeholder="请填写快递单号" name="express_no" >	        
		<input type="text" class="form-control hide" id="act"
			   name="act" value="input_express_info" >
			<input type="text" class="hide" name="order_id" value="<?php echo $order_id ;?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">确认发货</button>
      </div>
		</form>
    </div>
  </div>
</div>
<?php
}
		
if($order_status == 2){
?>
<button class="btn center-block" data-toggle="modal" data-target="#cancel_order">修改快递信息</button>

<!-- Modal -->
<div class="modal fade" id="cancel_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">修改快递信息</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="../action/action_order.php">
		<label for="express_company">快递公司</label>
	    <input type="text" class="form-control" id="express_company"
			   placeholder="请填写快递公司名称" name="express_company" value="<?php echo $express_company; ?>" >
		<label for="express_no">快递单号</label>
	    <input type="text" class="form-control" id="express_no"
			   placeholder="请填写快递单号" name="express_no"  value="<?php echo $express_no; ?>" >	    
		<input type="text" class="form-control hide" id="act"
			   name="act" value="modify_express_info" >
			<input type="text" class="hide" name="order_id" value="<?php echo $order_id ;?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">确认修改</button>
		</form>
      </div>
    </div>
  </div>
</div>
<?php
}	
		
if($order_status == 3){
?>
<button class="btn center-block" data-toggle="modal" data-target="#cancel_order">退换货处理</button>

<!-- Modal -->
<div class="modal fade" id="cancel_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">退换货处理</h4>
      </div>
      <div class="modal-body">
        确认处理退换货？
      </div>
      <div class="modal-footer">
		<form method="post" action="../action/action_order.php">
			<input name="act" class="hide" value="deal_return_order">
			<input type="text" class="hide" name="order_id" value="<?php echo $order_id ;?>">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			<button type="submit" class="btn btn-primary">处理退换</button>
		</form>
      </div>
    </div>
  </div>
</div>
<?php
}
		
}
	
}

//展示订单历史信息
function display_order_history($order_status_id,$order_id){
	$status_detail 			= get_status_detail($order_status_id);	//状态细节
	$submit_time			= $status_detail['submit_time'];
	$pay_time				= $status_detail['pay_time'];
	$send_time				= $status_detail['send_time'];
	$receive_time			= $status_detail['receive_time'];
	$evaluation_time		= $status_detail['evaluation_time'];
	$cancel_time			= $status_detail['cancel_time'];
	
		
	$order_detail 			= @get_order_main_detail($order_id);		//取得订单整体细节
	$order_express_id 		= @$order_detail['order_express_id'];
	$order_express_detail 	= @get_order_express($order_express_id);
	$express_company		= @$order_express_detail['express_company'];
	$express_no				= @$order_express_detail['express_no'];
		
	echo "<ul class='order_history'>";
		if($receive_time != '0000-00-00 00:00:00'){	
			echo "<li><span>$receive_time</span><span>您的订单已经签收，交易完成</span></li>";
		}
		if($send_time != '0000-00-00 00:00:00'){	
			echo "<li><span>$send_time</span><span>您的订单由卖家拣货完毕，
			已经经由 $express_company 负责运输,快递单号:$express_no</span></li>";
		}
		if($cancel_time != '0000-00-00 00:00:00'){	
			echo "<li><span>$cancel_time</span><span>您的订单已经成功撤消</span></li>";
		}
		if($pay_time != '0000-00-00 00:00:00'){	
			echo "<li><span>$pay_time</span><span>您完成订单在线支付，请等待卖家系统确认</span></li>";
		}
		if($submit_time != '0000-00-00 00:00:00'){	
			echo "<li><span>$submit_time</span><span>您提交了订单，请等待卖家系统确认</span></li>";
		}
	echo "</ul>";
	
}


?>


