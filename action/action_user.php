<?php
require_once('../functions/book_sc_fns.php');
session_start();

/******************************************
    
        初始化参数
    
*******************************************/
    //获取注册页参数
    $email 			= trim(@$_REQUEST['inputemail']);
    $username 		= trim(@$_REQUEST['inputusername']);
    $pwd1			= trim(@$_REQUEST['inputpwd1']);
    $pwd2			= trim(@$_REQUEST['inputpwd2']);

 	//获取登录页参数
    $login_username = trim(@$_REQUEST['username']);
    $login_pwd		= trim(@$_REQUEST['password']);
	$is_admin 		= @$_REQUEST['is_admin'];

	//动作参数
	$act = @$_REQUEST['act'];

	$server = $_SERVER['HTTP_HOST'];
    
/******************************************
	如果是注册命令
*******************************************/
if($act == 'register'){
	try{
      	if(!do_register($email,$username,$pwd1)){
			throw new Excpetion(10001);
		}
      	$_SESSION['current_user'] = $username;
			header("Location: http://$server/book_market/view/register_success.php");
	}catch(Exception $e){
		$error_id = $e->getMessage();
		header("Location: http://$server/book_market/view/login_register.php?action=register&error_id=$error_id");
	}
}
/******************************************
	如果是查询输入合法命令
*******************************************/

if($act == 'email_valid'){
	$is_existed = valid_email_existed($email);
	echo $is_existed;
}

//此命令可复用2次
if($act == 'username_valid'){
	$is_existed = valid_username_existed($username);
	echo $is_existed;

}


/******************************************
	如果是登录命令
*******************************************/
if($act == 'login'){
	try{
		if($is_admin){  //如果勾选了管理员选型
				if(!(admin_login($login_username,$login_pwd))){
						throw new Exception(11001);
				}else{
						$_SESSION['current_user'] = $login_username;
						$_SESSION['is_admin'] = true;
				}
		}else{  //否则就进入
				if(!(user_login($login_username,$login_pwd))){
						throw new Exception(11002);
				}else{
						$_SESSION['current_user'] = $login_username;
						$customerid = get_customerid_fromname($login_username);
						$_SESSION['customerid'] = $customerid;
				}
		}
		header("Location: http://$server/book_market/view/login_success.php");
	}catch(Exception $e){
		$error_id = $e->getMessage();
		header("Location: http://$server/book_market/view/login_register.php?action=login&error_id=$error_id");
	} 
}


/******************************************
	如果是logout登出命令
*******************************************/
if($act =='logout'){

    $olduser = @$_SESSION['current_user'];
    unset($_SESSION['current_user']);
    $result_dest = session_destroy();

	header("Location: http://$server/book_market/view/logout_success.php?olduser=$olduser");
	
}
?>