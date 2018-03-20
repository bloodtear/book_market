<?php

////////////////
//是否填写完整。
////////////////
function filled_out($form_vars){
    foreach($form_vars as $key=>$value){
        if((!isset($key)) || ($value == '' )){
            return false;
        }
    }
    return true;
}

//判断输入的emai是否已经存在了，如果存在返回1,不存在0
function valid_email_existed($email){
     
        $db_conn= db_connect();
    
        //先判断数据库是否有这个名字了、
        $query = "select email from customers where email = '$email'";
	
        $result = $db_conn->query($query);
        if(!$result){
            throw new Exception('抱歉，数据库查询失败');
        }
        $row = $result->num_rows;
        if($row>0){
            return 1;
        }else{
			return 0;
		}
}


//判断输入的emai是否已经存在了，如果存在返回1,不存在0
function valid_username_existed($username){
     
        $db_conn= db_connect();
    
        //先判断数据库是否有这个名字了、
        $query = "select email from customers where username = '$username'";
	
        $result = $db_conn->query($query);
        if(!$result){
            throw new Exception('抱歉，数据库查询失败');
        }
        $row = $result->num_rows;
        if($row>0){
            return 1;
        }else{
			return 0;
		}
}














?>