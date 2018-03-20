<?php

//读取当前用户的发票列表
function get_invoice_list($customerid){
    $db_conn= db_connect();
    
	$query = "select invoice_no from invoice where customerid = '".$customerid."'";
	$result = $db_conn->query($query);
	if(!$result){
		return false;
	}
	$i=0;
    while($array = $result->fetch_assoc()){ 						//将关联数组传到array里
        $invoice_list[$i] = $array['invoice_no'];                  //arr拿到对应的单个数组。
        $i++;
    }
return $invoice_list;

}

//读取当前用户的发票抬头，根据invoice_no
function get_invoice_title($invoice_no){
	$db_conn= db_connect();
	$query = "select title from invoice where invoice_no = '".$invoice_no."'";
	$result = $db_conn->query($query);
	if(!$result){
		return false;
	}
	$invoice_title = $result->fetch_row();
return $invoice_title[0];
}
	

//新增发票抬头
function new_invoice_title($invoice_title_text){
    $db = db_connect();
	$customerid = $_SESSION['customerid'];
    $query = "insert into invoice values ('','".$customerid."','".$invoice_title_text."')";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    return true;
}

//删除发票抬头
function del_invoice_title($invoice_no){
 	$db = db_connect();
	$query = "delete from invoice where invoice_no = '".$invoice_no."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    return true;
}

//修改发票抬头
function modify_invoice_title($invoice_no,$invoice_title_text){
 	$db = db_connect();
	$query = "update invoice set title = '".$invoice_title_text."' where invoice_no = '".$invoice_no."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    return true;
}

?>