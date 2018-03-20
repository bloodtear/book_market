<?php

////////////////////
/*插入新的地址*/
////////////////////
function add_addr
    ($ship_person,
     $ship_city,
     $ship_district,
     $ship_addr,
     $ship_zip,
     $ship_tel,
     $ship_tel2,
     $ship_email){
    
    $db = db_connect();
    
    $customerid = $_SESSION['customerid'];
    $is_default = 0;
	
    $query = 
        "insert into address 
            (customerid,
             is_default,
             ship_person,
             ship_city,
             ship_district,
             ship_addr,
             ship_zip,
             ship_tel,
             ship_tel2,
             ship_email) 
        values 
            ('".$customerid."',
             '".$is_default."',
             '".$ship_person."',
             '".$ship_city."',
             '".$ship_district."',
             '".$ship_addr."',
             '".$ship_zip."',
             '".$ship_tel."',
             '".$ship_tel2."',
             '".$ship_email."')";
    
    $result = $db->query($query);
    if(!$result){
		return false;
    }
    
    //查询插入之后的ship_ID
    $query = 
        "select ship_id from address where 
        ship_person     = '".$ship_person."'    and 
        ship_city       = '".$ship_city."'      and 
        ship_district   = '".$ship_district."'  and 
        ship_addr       = '".$ship_addr."'      and 
        ship_zip        = '".$ship_zip."'       and 
        ship_tel        = '".$ship_tel."'       and
        ship_tel2       = '".$ship_tel2."'      and
        ship_email      = '".$ship_email."'";
        
    $result = $db->query($query);
    if(!$result){
        return false;
    }    
    $num = $result->num_rows;//取出的数据是否为空
    if($num == 0 ){
		return false;
        /*throw new Exception('查询ship_id失败10002');*/
    }
    $result = $result->fetch_assoc();
    $ship_id = $result['ship_id'];//取得刚刚插入后的shipid。
	
    return $ship_id;
}

/*************************************************************************
    判断当前用户是否有默认收货地址,有的话返回ship_id,如果没有返回false;
*************************************************************************/    
function get_def_addr($customerid){
    $db = db_connect();
    //查看是否当前有默认收货地址,is_default=1
    $query = "select ship_id from address where customerid = '".$customerid."' and is_default = '1'";
    //$query = "select ship_id from user_addr_list where customerid = '".$customerid."' and is_default = '1'"；
    $result = $db->query($query);
    if(!$result){
		return false;
    }
    $num = $result->num_rows;//取出的数据是否为空
    if($num == 0 ){
        return false ;
    }
    $default_ship_id = $result->fetch_assoc();  //提取关联数组
    $default_ship_id = $default_ship_id['ship_id']; //提取数组中的shipid
    return $default_ship_id;
}
    

/*************************************************************
    设定默认收货地址设置ship_id，作为这个customerid的默认ID
*************************************************************/       
function set_def_addr($customerid,$ship_id){
    $db = db_connect();
    //先清空customerid下的所有is-fault值，
    $query = "update address set is_default = 0 where customerid = ".$customerid."";
    $result = $db->query($query);
    if(!$result){
		return false;
    }
    
    //然后将此ship_id设定为用户的默认地址
    $query = "update address set is_default = 1 where customerid = '".$customerid."' and ship_id = '".$ship_id."'";
    $result = $db->query($query);
    if(!$result){
		return false;
    }
    return true;
}


/***************************************************************
    根据用户ID取得当前用户的ship_id和对应的is_default，取得形式为一个数组
*************************************************************/    
function get_addr_list($customerid){
    $db = db_connect();
    $query = 
       "select 
            ship_id,is_default 
        from 
            address 
        where 
            customerid = '".$customerid."' 
        order by 
            is_default desc,
            ship_id desc";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    
    $num_cuts = $result->num_rows;//取出的数据是否为空
    if($num_cuts == 0 ){
        return false;
    }
    
    $i=0;
    while($array = $result->fetch_assoc()){ //将关联数组传到array里
        $arr[$i] = $array;                  //arr拿到对应的单个数组。
        $i++;
    }
    return $arr;

}


/*******************************************
    根据提供的ship_id，读取相关的ship信息
*******************************************/    
function get_addr_detail($ship_id){
    $db = db_connect();
    $query = "select * from address where ship_id = '".$ship_id."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    
    $num_cuts = $result->num_rows;//取出的数据是否为空
    if($num_cuts == 0 ){
        return false;
    }
    
    while($array = $result->fetch_assoc()){ //将关联数组传到array里
            foreach($array as $key=>$value){//将array数组拆分为key,value
            $arr[$key] = $value;            //仅将value和数组关联起来。
            }
    }
    return $arr;

}


/*******************************************
    删除相关的ship信息  根据提供的del_ship_id
*******************************************/    
function delete_addr_byid($del_ship_id){
    $db = db_connect();
    $query = "delete from address where ship_id = '".$del_ship_id."'"; 
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    return true;
}


/*****************************************************
    更新addr_detail，除了提交时间和id，都需要重新上传。
*****************************************************/  
function update_addr_detail(
                $ship_id_m,
                $ship_person_m,
                $ship_city_m,
                $ship_district_m,
                $ship_addr_m,
                $ship_zip_m,
                $ship_tel_m,
                $ship_tel2_m,
                $ship_email_m)
{
    $db = db_connect();
    $query = 
        "UPDATE address SET 
        ship_person      = '".$ship_person_m."',
        ship_city        = '".$ship_city_m."',
        ship_district    = '".$ship_district_m."',
        ship_addr        = '".$ship_addr_m."',
        ship_zip         = '".$ship_zip_m."',
        ship_tel         = '".$ship_tel_m."',
        ship_tel2        = '".$ship_tel2_m."',
        ship_email       = '".$ship_email_m."'
        WHERE ship_id = '$ship_id_m'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    return true;
}















?>