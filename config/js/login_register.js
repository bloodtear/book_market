$(document).ready(function(){

///////////////
/*注册页的逻辑*/
//////////////
		var register_error = new Array();
		register_error["email"] = 1;
		register_error["username"] = 1;
		register_error["inputpwd1"] = 1;
		register_error["inputpwd2"] = 1;
	
		////////////////////////////////
		//针对输入邮箱的校验
		//////////////////////////
			//当键盘输入 或 失去交单的时候校验输入的email是否已存在，
			//如果存在就弹出提示，并且记录error-mail为1
		$('#inputemail').on('keyup blur',function (){
			var act = 'email_valid';
			var inputemail = $('#inputemail').val();
			var length = inputemail.length;
			
			$.post('../action/action_user.php',
				{
				act				:act,
				inputemail		:inputemail
				},
				function(data){
				if(data == 1){	//数值存在的话，就展示错误，并且error+1
					$('#inputemail').tooltip('show');
					register_error["email"] = 1;
				}else{
					$('#inputemail').tooltip('destroy');	
					register_error['email'] = 0;
				}
			});
			
			//如果没输入，就记录ERROR，但是不出提示
			if(length == 0){
				register_error["email"] = 1;
			}
		});
			//当选中 或 得到的时销毁弹出提示，
			//并且记录error-mail为0
		$('#inputemail').on('click focus',function (){
			$('#inputemail').tooltip('destroy');	
			register_error['email'] = 0;
			$('#alert_register').addClass('hide');
		});

	
		////////////////////////////////
		//针对输入用户名的校验
		//////////////////////////
		$('#inputusername').on('keyup blur',function (){
			var act = 'username_valid';
			var inputusername = $('#inputusername').val();
			var length = inputusername.length;
			
			$.post('../action/action_user.php',
				{
				act					:act,
				inputusername		:inputusername
				},
				function(data){
				console.log(data);
				if(data == 1){
					$('#inputusername').tooltip('show');
					register_error["username"] = 1;
				}else{
					$('#inputusername').tooltip('destroy');	
					register_error['username'] = 0;
				}
			});
			//如果没输入，就记录ERROR，但是不出提示
			if(length == 0){
				register_error["username"] = 1;
			}
			
			
		});
		//当选中 或 得到的时销毁弹出提示，并且记录error-username为0
		$('#inputusername').on('click focus',function (){
			$('#inputusername').tooltip('destroy');	
			register_error['username'] = 0;
			$('#alert_register').addClass('hide');
		});


		///////////////////////////////
		//针对输入密码1的校验
		//////////////////////////
		$('#inputpwd1').on('blur',function (){
			var inputpwd1 = $('#inputpwd1').val();
			var length = inputpwd1.length;
			
			if(length>0){
				if(length < 6 || length > 13){
					$('#inputpwd1').tooltip('show');
					register_error["inputpwd1"] = 1;
				}else{
				$('#inputpwd1').tooltip('destroy');		
				register_error['inputpwd1'] = 0;
				}
			}else{
				register_error["inputpwd1"] = 1;
			}
		});
		//当选中 或 得到的时销毁弹出提示，并且记录error-username为0
		$('#inputpwd1').on('click focus',function (){
			$('#inputpwd1').tooltip('destroy');	
			register_error['inputpwd1'] = 0;
			$('#alert_register').addClass('hide');
		});

		///////////////////////////////
		//针对输入密码2的校验
		//////////////////////////	
		$('#inputpwd2').on('blur',function (){
			var inputpwd1 = $('#inputpwd1').val();
			var inputpwd2 = $('#inputpwd2').val();
			
			var length2 = inputpwd2.length;
			
			if(length2 > 0){
				if(inputpwd1 != inputpwd2){
					$('#inputpwd2').tooltip('show');
					register_error["inputpwd2"] = 1;
				}else{
					$('#inputpwd2').tooltip('destroy');	
					register_error['inputpwd2'] = 0;
				}
			}else{
				register_error['inputpwd2'] = 1;
			}
		});
		//当选中 或 得到的时销毁弹出提示，并且记录error-username为0
		$('#inputpwd2').on('click focus',function (){
			$('#inputpwd2').tooltip('destroy');	
			register_error['inputpwd2'] = 0;
			$('#alert_register').addClass('hide');
		});
	
	
		///////////////////////////////
		//针对注册摁钮的校验
		//////////////////////////	
		//如果有ERROR就弹出提示，并且不走跳转，
		//如果没有ERROR就跳转。
		$('#register_btn').click(function(e){
			console.log('==========================================');
			if(register_error["email"]		==1 || 
			   register_error["username"]	==1 || 
			   register_error["inputpwd1"]	==1 || 
			   register_error["inputpwd2"]	==1){
				console.log('error!!');
				e.preventDefault();
				$('#alert_register').removeClass('hide');
			}
		});

	
///////////////
/*登录页的逻辑*/
//////////////
		var login_error = new Array();
		login_error["login_username"] = 1;
		login_error["login_pwd"] = 1;

		////////////////////////////////
		//针对输入用户名的校验
		//////////////////////////
		$('#username').on('blur',function (){
			var act = 'username_valid';
			var username = $('#username').val();
			var length = username.length;
			var is_admin = $('#is_admin').prop('checked');
			
			if(!is_admin){
				if(length > 0){
					$.post('../action/action_user.php',
						{
						act					:act,
						inputusername		:username
						},
						function(data){
						console.log(data);
						if(data == 0){
							$('#username').tooltip('show');
							login_error["username"] = 1;
						}else{
							$('#username').tooltip('destroy');	
							login_error['username'] = 0;
						}
					});
				}else{//如果没输入，就记录ERROR，但是不出提示
					login_error["username"] = 1;
					$('#username').tooltip('destroy');	
				}
			}
		});		
		$('#username').on('click focus',function (){
			$('#username').tooltip('destroy');	
			login_error['username'] = 0;
		});
	
	
		///////////////////////////////
		//针对登录摁钮的校验
		//////////////////////////	
		//如果有ERROR就弹出提示，并且不走跳转，
		//如果没有ERROR就跳转。
		$('#login_btn').click(function(e){

			//读取登录密码长度，如果没有密码，就提示无法登录。
			var username = $('#username').val();
			var password = $('#password').val();
			var is_admin = $('#is_admin').prop('checked');
			
			var length = password.length;
			var length2 = username.length;
			var act = 'login';
			
			if(length == 0 ){
				$('#password').tooltip('show');
				e.preventDefault();
			}
			
			if(length2 == 0 ){
				$('#username').tooltip('show');
				e.preventDefault();
			}
			
			//如果有错误，就提示错误，不进行登录。
			if(login_error["username"] == 1 || login_error["inputpwd"]	== 1 ){
				e.preventDefault();
			}
		});
	
		//当点击密码框或者获得焦点的时候，将ERROR置零，并且消除错误提示
		$('#password').on('click focus',function (){
			$('#password').tooltip('destroy');	
			login_error['password'] = 0;
		});
	
		//当我是管理员被选中的时候，清楚错误信息。不进行错误提示。
		$('#is_admin').click(function (){
			
			$('#username').tooltip('destroy');	
			$('#password').tooltip('destroy');	
			
			login_error['username'] = 0;
			login_error['password'] = 0;
		});
	
	
	
});