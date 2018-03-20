<?php

//////////////////////////
//连接数据库
////////////////////////
function db_connect(){
    $db = new mysqli('180.76.160.113','book_market','book_market','book_market');
    if(!$db){
        throw new Exception('连接数据库出现问题');
    }
    return $db;
}

//////////////////////////
//开启实务
////////////////////////
function begin($db){
	//$db= db_connect();
	$query = "BEGIN";
	$result = $db->query($query);
	if(!$result){
		throw new Exception('事务开启失败1');
	}
	return true;
}


//////////////////////////
//事务提交
/////////////////////////
function commit($db){
	//$db= db_connect();
	$query = "commit";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	return true;
}

/////////////////////////
//事务回滚
////////////////////////
function rollback($db){
	//$db= db_connect();
	$query = "rollback";
	$result = $db->query($query);
	if(!$result){
		return false;
	}
	return true;
}


?>