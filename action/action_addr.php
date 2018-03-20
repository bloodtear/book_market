<?php

session_start();
require_once('../functions/book_sc_fns.php');

    $ship_id            = trim(@$_REQUEST['ship_id']) ;               //收件人ID
    $is_default         = trim(@$_REQUEST['is_default']) ;            //是否是默认地址
    $ship_person        = trim(@$_REQUEST['ship_person']);            //收件人
    $ship_city          = trim(@$_REQUEST['ship_city']) ;             //收件城市/省
    $ship_district      = trim(@$_REQUEST['ship_district']);          //收件地区/县
    $ship_addr          = trim(@$_REQUEST['ship_addr']) ;             //收件详细地址
    $ship_zip           = trim(@$_REQUEST['ship_zip']) ;              //收件邮编
    $ship_tel           = trim(@$_REQUEST['ship_tel']);               //收件人联系电话
    $ship_tel2          = trim(@$_REQUEST['ship_tel2']);              //备用联系电话
    $ship_email         = trim(@$_REQUEST['ship_email']) ;            //收件人邮箱

    $customerid         = @$_SESSION['customerid'];             //当期的用户ID

	$act 			    = @$_REQUEST['act'];					//期望的动作*/
	$show_list		    = @$_REQUEST['show_list'];				//是否调用展示list	
    $show_addr_detail   = @$_REQUEST['show_addr_detail'];		//是否调用展示detail
    $easy   			= @$_REQUEST['easy'];					//是否是EASY模式
				
	$server = $_SERVER['HTTP_HOST'];
	/*添加动作*/
try{
	if($act == 'add') {  
			if(!($ship_id = add_addr($ship_person,$ship_city,$ship_district,$ship_addr,
			 			$ship_zip,$ship_tel,$ship_tel2,$ship_email))){
				throw new Exception('20001');
			}
		
		$addr_detail = get_addr_detail($ship_id);
		if($easy){
			$display = display_addr_detail_easy($addr_detail,$is_default);
		}else{
			$display = display_addr_detail($addr_detail,$is_default);
		}
		
		echo $display;
	}

    //调取addr_list列表
	if($show_list == 1){
		$addr_list = get_addr_list($customerid);
		if(!$addr_list){
			throw new Exception('20002');
		}
		echo json_encode($addr_list);
	}

    //调取单个addr_detail
    if($show_addr_detail == 1){
        $addr_detail = get_addr_detail($ship_id);
		if(!$addr_detail){
			throw new Exception('20003');
		}

        $display_detail = display_addr_detail($addr_detail,$is_default);
        echo $display_detail;
    } 
	if($show_addr_detail == 2){
        $addr_detail = get_addr_detail($ship_id);
		if(!$addr_detail){
			throw new Exception('20003');
		}
        $display_detail = display_addr_detail_easy($addr_detail,$is_default);
        echo $display_detail;
    }

	//删除动作
	if($act == 'del' ){
		$del_state = delete_addr_byid($ship_id);
		if(!$del_state){
			throw new Exception('20004');
		}
		echo $del_state;
	}

	//设置默认地址动作
	if($act == 'set_def_addr'){
		$set_def_result = set_def_addr($customerid,$ship_id);
		if(!$set_def_result){
			throw new Exception('20005');
		}
		echo $set_def_result;
	}

	//修改地址信息动作
	if($act == 'modify'){
		$update_result = update_addr_detail($ship_id,$ship_person,$ship_city,$ship_district,
                							$ship_addr,$ship_zip,$ship_tel,$ship_tel2,$ship_email);
		if(!$update_result){
			throw new Exception('20006');
		}
		$addr_detail =  $addr_detail = get_addr_detail($ship_id);
		echo display_addr_detail($addr_detail,$is_default);

	}
}catch(Exception $e){
	$error_id = $e->getMessage();
	header("Location: http://$server/book_market/view/addr_list.php?error_id=$error_id");
}
?>