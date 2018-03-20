<?php

/******************************************
用户注册函数
******************************************/    
    function do_register($email,$username,$pwd){
        
        $db_conn= db_connect();
    
        //先判断数据库是否有这个名字了、
        $query = "select username from customers where username = '".$username."'";
        $result = $db_conn->query($query);
        if(!$result){
            throw new Exception('抱歉，数据库查询失败,在注册过程中');
        }
        $row = $result->num_rows;
        if($row>0){
            throw new Exception('抱歉，该用户名已经被占用，请重新起个名字吧！');
        }
        
        //插入数据
        $query = "insert into customers values ('','".$username."','".$email."','".$pwd."')";
        $result = $db_conn->query($query);
        
        if($result){
            return true;
        }else{
            throw new Exception('数据库插入信息失败了！');
        }
    
    }

/******************************************
用户登录函数
******************************************/  
function user_login($username,$password){
    
    $db_conn = db_connect();
    $query = "select customerid from customers where username = '".$username."' && password = '".$password."'";
    $result = $db_conn->query($query);
    if(!$result){
        return false;
        //throw new Exception('查询动作失败10001');
    }
    $row = $result->num_rows;
    if($row == 0){
        return false;
        //throw new Exception('查询结果为零，10002');
    }
    
    $result = $result->fetch_assoc();
    $customerid = $result['customerid'];
    return $customerid;
    }

/******************************************
    管理员登录函数
******************************************/  
function admin_login($username,$password){
    
    $db_conn = db_connect();
    $query = "select username from admin where username = '".$username."' && password = '".$password."'";
    $result = $db_conn->query($query);
    if(!$result){
        return false;
        //throw new Exception('查询动作失败10001');
    }
    $row = $result->num_rows;
    if($row == 0){
        return false;
        //throw new Exception('查询结果为零，10002');
    }
    return true;
    }

/******************************************
通过customerid取得用户姓名
******************************************/  
function get_name_fromid($customerid){
    $db_conn = db_connect();
    $query = "select username from customers where customerid = '".$customerid."'";
    $result = $db_conn->query($query);
    if(!$result){
        return false;
        //throw new Exception('查询动作失败10001');
    }
    $row = $result->num_rows;
    if($row == 0){
        return false;
        //throw new Exception('查询结果为零，10002');
    }
    
    $result = $result->fetch_assoc();
    $username = $result['username'];
    return $username;
}


/******************************************
通过username取得用户userid(customerid)
******************************************/  
function get_customerid_fromname($username){
    $db_conn = db_connect();
    $query = "select customerid from customers where username = '".$username."'";
    $result = $db_conn->query($query);
    if(!$result){
        //return false;
        throw new Exception('查询动作失败10001');
    }
    $row = $result->num_rows;
    if($row == 0){
        //return false;
        throw new Exception('查询结果为零，10004');
    }
    
    $result = $result->fetch_assoc();
    $customerid = $result['customerid'];
    return $customerid;

}


/******************************************
通过username取得用户email
******************************************/  
function get_email_fromname($username){
    $db_conn = db_connect();
    $query = "select email from customers where username = '".$username."'";
    $result = $db_conn->query($query);
    if(!$result){
        //return false;
        throw new Exception('查询动作失败10001');
    }
    $row = $result->num_rows;
    if($row == 0){
        //return false;
        throw new Exception('查询结果为零，10005');
    }
    
    $result = $result->fetch_assoc();
    $email = $result['email'];
    return $email;
}
?>