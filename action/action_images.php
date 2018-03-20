<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        参数初始化
    
*******************************************/

/*   do_html_header('上传图片');
   
    hr();*/

    $isbn 			= trim(@$_REQUEST['isbn']);
	$image_id		= @$_REQUEST['image_id'];

	$act			= @$_REQUEST['act'];
	$set_def_page 	= @$_REQUEST['set_def_page'];
	$server = $_SERVER['HTTP_HOST'];

/******************************************
    
如果是查询校验
    
*******************************************/

if($act == 'check'){
	if(is_isbn_exist($isbn)){	//判断是否ISBN存在了已经
        echo 300;
    }else{
		echo 100;
	}
}


/******************************************
    
如果是新增图书
    
*******************************************/

if($act == 'add'){
try{
	echo "提交的默认编号";
	var_dump($set_def_page);	
	foreach($_FILES as $no=>$value){
		$no = substr($no,14);//裁剪字符串，得到对应的NO
		//判断当前数值
		$default = 0;
		if($set_def_page == $no){
			$default = 1;
		}
		echo 'set_def/NO/default值'.$set_def_page.":".$no.":".$default;
		
		//$_FILES是存储上传文件信息的二维数组。
		//一维数组是上传文件的name，Html里写的是userfile。
		//二维数组分别是，文件名称、类型、临时存储地址、错误码、文件大小。
		$error 			= $value['error'];
		$name 			= $value['name'];
		$type 			= $value['type'];
		$tmp_name 		= $value['tmp_name'];
		$size 			= $value['size'];

		if(!($new_name = upload_image($error,$name,$type,$tmp_name,$size,$isbn))){//数据库都OK之后再上传
			throw new Exception(30005);
		}
		if(!($add_result = add_image_sql($isbn,$new_name,$default))){
			throw new Exception(30101);
		}
	}
	header("Location:http://127.0.0.1/book_market/view/book_add_images_success.php?isbn=$isbn");

}catch(Exception $e){
	$error_id = $e->getMessage();
	header("Location:http://127.0.0.1/book_market/view/book_new_form.php?error_id=$error_id");
}

}
/******************************************
    
如果是删除图书
    
*******************************************/

if($act == 'del'){
    try{
		if(!($result = delete_img($image_id))){
			throw new Exception(430006);
		}
		echo $result;
    }catch(Exception $e){
		
    }
}

  
/******************************************
    
如果是修改图书
    
*******************************************/

if($act == 'modify'){
try{
    var_dump($image_id);
    //var_dump($_REQUEST);
    if(!($result = set_default_image($image_id))){
		throw new Exception(4300077);
	}
	var_dump($result);
    header("Location:http://$server/book_market/view/book_modify_images_success.php?isbn=$isbn");
	
    }catch(Exception $e){
		var_dump($result);
		$error_id = $e->getMessage();
		echo 123;
		header("Location:http://$server/book_market/view/book_modify_images.php?isbn=$isbn&error_id=$error_id");
    } 

}

?>
