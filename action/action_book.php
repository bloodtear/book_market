<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        参数初始化
    
*******************************************/

/*   do_html_header('上传图片');
   
    hr();*/



    $isbn 			= trim(@$_REQUEST['isbn']);
    $author 		= trim(@$_REQUEST['author']);
    $title 			= trim(@$_REQUEST['title']);
    $cat 			= trim(@$_REQUEST['cat']);
    $price 			= trim(@$_REQUEST['price']);
    $description 	= addslashes(trim(@$_REQUEST['description']));

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

if($act == 'new'){

	
var_dump($_REQUEST);
hr();
var_dump($_FILES);
hr();
	
	
try{
	/*校验部分*///然后在判断类别是否已经存在，如果没存在，就新增这个类别,返回这个类别的catid。
	if(!is_cat_exist($cat)){
		if(!($catid = add_cat($cat))){
			throw new Exception(30003);
		}
	}else{
		$catid = get_categories_id($cat);
	}

	//然后新增新书的相关信息到数据库
	if(!(add_book($isbn,$author,$title,$catid,$price,$description))){
		throw new Exception(30004);
	}

	echo "提交的默认编号";
	var_dump($set_def_page);	
	foreach($_FILES as $no=>$value){
		hr();
		var_dump($no);
		var_dump($value);
		
		$no = substr($no,14);//裁剪字符串，得到对应的NO
		//判断当前数值
		$default = 0;
		if($set_def_page == $no){
			echo "============";
			$default = 1;
		}else{
			echo "!!!!!!!!!!==";
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
		var_dump($new_name);
		
		if(!($add_result = add_image_sql($isbn,$new_name,$default))){
			//throw new Exception(30101);
			echo "NOk";
		}
		var_dump($add_result);

		hr();
	}

	header("Location:http://$server/book_market/view/book_new_success.php?isbn=$isbn");

    }catch(Exception $e){
        $error_id = $e->getMessage();
	 	header("Location:http://$server/book_market/view/book_new_form.php?error_id=$error_id");
    }

}
/******************************************
    
如果是删除图书
    
*******************************************/

if($act == 'delete'){
    try{
		if(!delete_book($isbn)){
			throw new Exception(30006);
		}
		header("Location:http://$server/book_market/view/book_delete_success.php?isbn=$isbn");
    }catch(Exception $e){
		header("Location:http://$server/book_market/view/book_modify_form.php?isbn=$isbn&error_id=$error_id");
    }
}

  
/******************************************
    
如果是修改图书
    
*******************************************/

if($act == 'modify'){
try{
    
    //先判断是否有这个存在这个isbn，如果没有就报错。
    if(!is_isbn_exist($isbn)){
        throw new Exception(30007);
    }
        
    if(empty($author) || empty($title) || empty($cat) || empty($description) || empty($price)){
        throw new Exception(30008);
    }

    //然后在判断类别是否已经存在，如果没存在，就新增这个类别。
    if(!is_cat_exist($cat)){
        if(!($catid = add_cat($cat))){
            throw new Exception(30009);
        }
    }else{
        $catid = get_categories_id($cat);
    }
        
    //然后修改相关信息到数据库
    if(!(modify_book($isbn,$author,$title,$catid,$price,$description))){
        throw new Exception(30010);
    }
        
    header("Location:http://$server/book_market/view/book_modify_success.php?isbn=$isbn");
	
    }catch(Exception $e){
		$error_id = $e->getMessage();
		header("Location:http://$server/book_market/view/book_modify_form.php?isbn=$isbn&error_id=$error_id");
    } 

}

?>
