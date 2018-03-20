<?php

	function get_error_info($error_id){
		switch($error_id){
/*用户注册相关错误*/
		case 10001:
			return '抱歉，注册新用户失败！';
			break;
		case 11001:
			return '抱歉，管理员登录失败！';
			break;
		case 11002:
			return '抱歉，用户登录失败！';
			break;
/*地址相关错误*/			
		case 20001:
			return '抱歉，添加新的收货地址失败！';
			break;
		case 20002:
			return '抱歉，读取收货地址列表失败！';
			break;
		case 20003:
			return '抱歉，读取收货地址信息列表失败！';
			break;
		case 20004:
			return '抱歉，删除新的收货地址失败！';
			break;
		case 20005:
			return '抱歉，设置默认收货地址失败！';
			break;
		case 20006:
			return '抱歉，修改收货地址信息失败！';
			break;
/*书籍操作相关错误*/
		case 30000:
			return '抱歉，你新增的书籍没有填写完整！请重新填写完整，谢谢！';
			break;
		case 30001:
			return '抱歉，你输入的ISBN必须为13位，谢谢！';
			break;
		case 30002:
			return '抱歉,这个ISBN号码已经重复了，请重新填写，谢谢';
			break;
		case 30003:
			return '抱歉，添加新的类别失败了，请稍等一会重新填写！';
			break;
		case 30004:
			return '抱歉，您提交的新书籍，在上传数据库的时候失败了！';
			break;
		case 30005:
			return '抱歉，您提交的新书籍图片上传失败了！';
			break;
		case 30006:
			return '抱歉，未能删除此图书！';
			break;
		case 30007:
			return '抱歉,这个ISBN号码不存在，无法修改，谢谢！';
			break;
		case 30008:
			return '抱歉，你要修改的信息尚未填写完整！请重新填写完整，谢谢';
			break;
		case 30009:
			return '抱歉，添加新的类别失败了，请稍等一会重新填写！';
			break;
		case 30010:
			return '抱歉，您修改的书籍信息，在上传数据库的时候失败了！';
			break;
		case 33331:
			return '抱歉，上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值！';
			break;
		case 33332:
			return '抱歉，上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值！';
			break;
		case 33333:
			return '抱歉，文件只有部分被上传！';
			break;
			
			
		case 30011:
			return '抱歉，您修改的书籍信息，在更新图片的时候失败了！';
			break;
		default:
			return '抱歉，未知原因引起的错误';
		}
	
	}

















//用户错误类
	class ErrorUser extends Exception{
		public $error_id;
		public $error_info;
		
		function __construct($error_id,$error_info){ 
 			$this->error_id 	= $error_id;
 			$this->error_info 	= $error_info;
  		} 
		
		function get_error_id(){
			return $this->error_id;
		}
		
		function get_error_info(){
			return $this->error_info;
		}
	
	}

//地址错误类
	class error_addr extends Exception{
	
	}


//书籍错误类
	class error_book extends Exception{
	
	}


//购物车错误类
	class error_cart extends Exception{
	
	}






?>