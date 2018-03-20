<?php
require_once('../functions/book_sc_fns.php');
session_start();

	$act 				= @$_REQUEST['act'];
	$invoice_no			= @$_REQUEST['invoice_no'];
	$invoice_title_text	= @$_REQUEST['invoice_title_text'];
	$server = $_SERVER['HTTP_HOST'];
		
try{
	if($act =='del'){
		$del = del_invoice_title($invoice_no);
		echo $del;
	}

	if($act =='new'){
		$new = new_invoice_title($invoice_title_text);
		echo $new;
	}
	
	if($act =='modify'){
		$modify = modify_invoice_title($invoice_no,$invoice_title_text);
		echo $modify;
	}
	
}catch(Exception $e){
	echo $e->getMessage();
}


?>