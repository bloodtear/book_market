<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		
			<input type="checkbox" name="checked" checked="checked"> 
		
		

<?php



$str = '?action=qqinfo&message=#车找人 车找人 人找车 晚上5:55 大郊亭商务酒店-物美-兴业 hahahahh 67659769 联系电话18611551125';
$result = deal_message($str);
var_dump($result);

/*思路
1、先去除#号，拿到原始字符串
2、炸开字符串
3、针对每个信息段落进行判别。
4、其中类型、电话、时间必须存在，否则报错
5、如果没有报错，就返回OK信息，如果报错，实时返回错误信息*/
function deal_message($str){

	try{
	if(!$message_body = explode_string($str)){
		throw new Exception('没有井号啊~无法拆分原始字符串');
	}
	if(!$exploded_msg = explode_msg($message_body)){
		throw new Exception('无法2次拆分字符串');
	}	
	
	//初始化参数
	$result	 	= array();
	$flag 		= 0;
	$j 			= 0;	
		
	foreach($exploded_msg as $index=>$msg){
		if(is_type($msg)){
			$result[$j."-type"] = $msg;
			$flag += 100;
		}else if(is_time($msg)){
			$result[$j."-time"] = $msg;
			$flag += 10;
		}else if(is_tel($msg)){
			$result[$j."-tel"] = $msg;
			$flag += 1;
		}else{
			$result[$j."-message"] = $msg;
		}
		$j++;
	}
	$result['flag'] = $flag;
		
	if($flag >= 111){
		return /*json_encode*/($result);
	}else{
		return false;
	}
		
	}catch(Exception $e){
		$error = $e->getMessage();
		return $error;
	}
}

/*首次拆分#号原始数据*/
function explode_string($str){
	if(!stripos($str,'#')){
		return false;
	}
	$arr = explode('#',$str);
	$message_title 	= $arr[0];
	$message_body 	= $arr[1];
	
	return $message_body;
}

/*2次拆分字符串的内容*/
function explode_msg($message_body){
	$keyword = array('，',',',' ');
	$i = 0 ;
	while($i<3){
		$check = $keyword[$i];
		if(substr_count($message_body,$check) > 1 ){
			$exploded_msg = explode($check,$message_body);
			return $exploded_msg;
		}
		$i++;
	}
}

/*判别是否是车找人，人找车 类型*/
function is_type($msg){
	if($msg =='人找车' || $msg == '车找人'){
		return true;
	}else{
		return false;
	}
}

/*判别是否是时间信息*/
function is_time($msg){
	$keyword = array(':','：','点');
	$i = 0 ;
	while($i<3){
		$check = $keyword[$i];
		if(substr_count($msg,$check)){
			return true;
		}
		$i++;
	}
	return false;
}

/*判别是否是电话信息*/
function is_tel($msg){
	$rule = '/\d{11}|\d{8}/';
	if(preg_match($rule,$msg)){
		return true;
	}
	return false;
}













/*
echo "<hr>";
$string = "http://127.0.0.1/book_market/view/test2.php?error=1";
$string1 = "http://127.0.0.1/book_market/view/test2.php?id=1&error=1";

echo $string;
echo "<br/>";
echo $string1;

echo "<br/>";
echo "<br/>";
$url = get_no_error_url($string);
$url1 = get_no_error_url($string1);
echo $url;
echo "<br/>";
echo $url1;
*/


//针对url清楚error，得到对应内容，
//ERROR必须位于末尾！
/*
function get_no_error_url($string){
	//判断是否有error，没有直接返回
	if(!stripos($string,'error')){
		return $string;
	}
	//判断是否有&error，有的话，以这个拆分。
	//没有的话，以error拆分。
	if(stripos($string,'&error')){
		$arr = explode('&error',$string);
		$arr_left 	= $arr[0];
		$arr_right 	= $arr[1];
		
		return $arr_left;
	}else{
		$arr = explode('?error',$string);
		$arr_left 	= $arr[0];
		$arr_right 	= $arr[1];
		return $arr_left;
	}
}
*/























?>
		</body>