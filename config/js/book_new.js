$(document).ready(function (){
	
var book_check = new Array();
book_check["isbn"] = 1;
	
//针对ISBN的校验。
$('#isbn').on('blur',function (){
	var act = 'check';
	var isbn = $('#isbn').val();
	var length = isbn.length;
	var is_admin = $('#is_admin').prop('checked');
	var rule = /^[-+]?\d*$/;
	console.log('输入的ISBN长度为：'+length);

	if(length == 0){			//长度为空的话，就不展示错误，但是计ERROR为1
		$('#isbn').tooltip('destroy');
		book_check["isbn"] = 1;
	}else if(length != 13){		//长度不是13的话报错。
		$('#isbn').attr('title','抱歉！输入的数值必须满13位！');
		$('#isbn').tooltip('show');
		book_check["isbn"] = 1;
	}else{
		var result = isbn.match(rule);
		console.log('正则判断的结果是'+result);
		if(result == null){		//正则的结果不正确的时候报错。
			$('#isbn').attr('title','抱歉！输入的数值必须是数字！');
			$('#isbn').tooltip('show');
			book_check["isbn"] = 1;
		}else{

			$.post('../action/action_book.php',
				{act		:act,
				isbn		:isbn},
			function(data){
				if(data == 300){	//ISBN号码重复的话报错。
					$('#isbn').attr('title','输入的ISBN已经存在，请重新输入！');
					$('#isbn').tooltip('show');
					book_check["isbn"] = 1;
					console.log(data);
								console.log(222);
				}else{
					$('#isbn').tooltip('destroy');	
					book_check["isbn"] = 0;
								console.log(data);
				}
			});													
		}
	}
});
	
	$('#isbn').on('click focus',function (){
			$('#isbn').tooltip('destroy');	
			book_check["isbn"] = 0;
	});
	
//点击提交的校验
$('#add_images').click(function(e){
	console.log(book_check["isbn"]);
	if(book_check["isbn"] 				== 1 ||
	  $('#author').val().length 		== 0 ||
	  $('#title').val().length 			== 0 ||
	  $('#cat').val().length 			== 0 ||
	  $('#price').val().length 			== 0 ||
	  $('#description').val().length 	== 0 
	  ){
		alert('抱歉！书籍尚未填写完整或填写有误，无法添加！');
	   e.preventDefault();
	}
});

//点击清楚摁钮的时候，需要清楚
$('#clear-btn').click(function (){
	$('#isbn').tooltip('destroy');
});
	


});


