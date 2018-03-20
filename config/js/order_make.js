$(document).ready(function(){

//送货清单中的快递信息，随着右边的物品清单高度变化。
	var list_right =  window.document.getElementById('list-right');
	var list_right_height = list_right.offsetHeight;
	$('#list-left').css('height',list_right_height);
	
//支付方式.发票内容。发票抬头悬停的CSS样式
	$('.pay_moder,.invoice_content').hover(function(){
		$(this).toggleClass('choosing');
	});
	
//支付方式点击的CSS样式
	$('.pay_moder').click(function(){
		$(this).addClass('choosed');
		$(this).siblings().removeClass('choosed');
		$(this).find('input').prop('checked','true');
	});
	
//收货地址的悬停样式
	$(document).on("mouseover mouseout",".addr_list",function(){
		$(this).find('.addr_body').toggleClass('bg-pink');
		$(this).find('.addr_control').toggleClass('bg-pink');
		$(this).find('.addr_control').toggleClass('hide');
		
	});

//收货地址头部的悬停样式（特殊）
	$(document).on("mouseover mouseout",".select_addr_btn",function(){
		$(this).toggleClass('choosing');
	});
		
//点击收货地址的头部摁钮发生的事件
	$(document).on("click",".select_addr_btn",function(){
		//添加CSS样式
		$(this).addClass('choosed');
		$(this).parent().siblings().find('.select_addr_btn').removeClass('choosed');
		//读取当前的选中框的数值
		var selected_ship_person 	= $(this).siblings('.col-md-7').find('.addr_person').text();
		var selected_ship_tel 		= $(this).siblings('.col-md-7').find('.addr_tel').text();
		var selected_ship_tel2 		= $(this).siblings('.col-md-7').find('.addr_tel2').text();
		var selected_ship_zip 		= $(this).siblings('.col-md-7').find('.addr_zip').text();
		var selected_ship_email 	= $(this).siblings('.col-md-7').find('.ship_email').text();
		var selected_ship_city 		= $(this).siblings('.col-md-7').find('.ship_city').text();
		var selected_ship_district 	= $(this).siblings('.col-md-7').find('.ship_district').text();
		var selected_ship_addr 		= $(this).siblings('.col-md-7').find('.ship_addr').text();
		//修改最底部input中的相关信息
		$('#last_ship_city_p').val(selected_ship_city);
		$('#last_ship_district_p').val(selected_ship_district);
		$('#last_ship_addr_p').val(selected_ship_addr);
		$('#last_ship_person_p').val(selected_ship_person);
		$('#last_ship_tel_p').val(selected_ship_tel);
		$('#last_ship_tel2_p').val(selected_ship_tel2);
		$('#last_ship_zip_p').val(selected_ship_zip);
		$('#last_ship_email_p').val(selected_ship_email);
		//修改最底部last_addr_info的相关信息
		$('#last_ship_city').text(selected_ship_city);
		$('#last_ship_district').text(selected_ship_district);
		$('#last_ship_addr').text(selected_ship_addr);
		$('#last_ship_person').text(selected_ship_person);
		$('#last_ship_tel').text(selected_ship_tel);
		//将底部的提示语言展示出来
		$('#last_addr_person').removeClass('hide');
		$('#last_addr_info').removeClass('hide');
	});
	

	
//点击提交摁钮的时候，如果没有设定收货地址，就弹出报错提示。
	$('#order_make_btn').click(function(e){
		var last_ship_person = $('#last_ship_person').text();
		if(last_ship_person == ''){
			$('#alert_order_make').modal('show');
			e.preventDefault();
		}else{
			console.warn('222');
		}
	});
	
////////////////////////////////////	
//发票信息相关处理
///////////////////////////////////

//发票内容点击的CSS效果，
$(document).on("click",".invoice_content",function(){
	$(this).addClass('choosed');
	$(this).siblings('.invoice_content').removeClass('choosed');
	$(this).find('input').prop('checked','true');
});

//发票抬头点击的CSS效果
$(document).on("click",".invoice_title",function(){
	$(this).addClass('choosed');
	$(this).siblings('.invoice_title').removeClass('choosed');
	$('.new_title').remove();
	$('#new_invoice_title').removeClass('hide');
});
	
//发票抬头的hover效果
$(document).on("mouseover",".invoice_title",function(){
	$(this).find('.invoice_control_list').removeClass('hide');	
});
$(document).on("mouseout",".invoice_title",function(){
	$(this).find('.invoice_control_list').addClass('hide');	
});

		
//点击删除的效果
$(document).on("click",".invoice_delete",function(){
	$(this).parents('.invoice_title').remove();
	$('#invoice_title_person').addClass('choosed');
	var invoice_no 			= $(this).parents('.invoice_title').attr('invoice_no');
	$.post('../action/action_invoice.php',{
		act					:	'del',
		invoice_no			:	invoice_no,
		},function(data){console.log(data)});
});
	

//点击编辑的效果
$(document).on("click",".invoice_modify",function(){
	$(this).addClass('hide');
	$(this).siblings('.invoice_save').removeClass('hide');
	var title 				= $(this).parents('.invoice_title').find('.invoice_title_text');
	var text 				= title.val();

	title.removeAttr("readonly");
	$(this).parents('.invoice_title').find('.invoice_title_text').focus();

	}
);
	
//点击保存的效果
$(document).on("click",".invoice_save",function(){
	console.log('save');
	$(this).addClass('hide');
	$(this).siblings('.invoice_modify').removeClass('hide');
	var title = $(this).parents('.invoice_title').find('.invoice_title_text');
	var text = title.val();
	if(text == ''){
		alert('输入的内容不能为空');
		title.focus();
	}else{
		title.attr("readonly","readonly");
		var invoice_no 			= $(this).parents('invoice_title').attr('invoice_no');
		$.post('../action/action_invoice.php',{
			act					:	'modify',
			invoice_no			:	invoice_no,
			invoice_title_text	:	text
		});
	}
	}
);
	

//当发票编辑框失去焦点的时候
$(document).on("blur",".invoice_title_text",function(){
	var title = $(this).parents('.invoice_title').find('.invoice_title_text');
	var text = title.val();
	if(text == ''){
		alert('输入的内容不能为空');
		title.focus();
	}else{
		title.attr("readonly","readonly");
		$(this).parents('.invoice_title').find('.invoice_save').addClass('hide');
		$(this).parents('.invoice_title').find('.invoice_modify').removeClass('hide');
		
		var invoice_no 			= $(this).parents('.invoice_title').attr('invoice_no');
		$.post('../action/action_invoice.php',{
			act					:	'modify',
			invoice_no			:	invoice_no,
			invoice_title_text	:	text
		});
	}
});
	
//当点击新增发票摁钮的时候
$('#new_invoice_title').click(function(){
	console.log('new invoice');
	var new_invoice_info = "<div class='new_title choosed'><span><input size='40' class='invoice_title_text' placeholder='请输入发票抬头'></span><span class='invoice_save_new'>保存</span><span class='invoice_control_list hide'><span class='invoice_modify'>编辑</span><span class='invoice_save hide'>保存</span><span class='invoice_delete'>删除</span></span></div>";
	$('.invoice_title:last').after(new_invoice_info);
	$('.invoice_title_text:last').focus();
	$(this).addClass('hide');
	$('.invoice_title').removeClass('choosed');
	$('.new_title').focus();
});
	
//针对新建发票抬头的保存的click逻辑
$(document).on("click",'.invoice_save_new',function(){	
	var text = $(this).parents('.new_title').find('.invoice_title_text').val();
	if(text == ''){
		alert('输入信息不能为空！');
		$(this).parents('.new_title').find('.invoice_title_text').focus();
	}else{
		$(this).hide();
		$(this).parents('.new_title').addClass('invoice_title');
		$(this).parents('.new_title').removeClass('new_title');
		$(this).parents('.invoice_title').find('.invoice_title_text').attr('readonly','readonly');
		$(this).parents('.invoice_title').find('.invoice_control_list').removeClass('hide');
		$('#new_invoice_title').removeClass('hide');
		$.post('../action/action_invoice.php',{
			act					:	'new',
			invoice_title_text	:	text
		});
	}
});
	
//当点击Form下面保存修改摁钮的时候的逻辑
$('#invoice_form_save').click(function (){
	var new_text = $('.new_title').find('.invoice_title_text').val();
	console.log(new_text);
	//如果new_title存在，则错如下处理，如果不存在就走更下面的
	if($('.new_title').find('.invoice_title_text').length>0){
		if(new_text ==''){
			alert('输入信息不能为空！');
			$('.new_title').find('.invoice_title_text').focus();
		}else{
			//先针对new_title相关内容进行处理
			$('.new_title').find('.invoice_title_text').attr('readonly','readonly');
			$('.new_title').find('.invoice_save_new').hide();
			$('.new_title').addClass('invoice_title');
			$('.new_title').removeClass('new_title');
			$('#new_invoice_title').removeClass('hide');
			$.post('../action/action_invoice.php',{
				act					:	'new',
				invoice_title_text	:	new_text
			});
		}
	}else{
		//现将modal隐去
		$('#modify_invoice_form').modal('hide');
		$('.modal-backdrop').hide();
		$('body').removeClass('modal-open');
		//经内容投射到order_make页中。
		//读取相关信息，然后投射
		var invoice_mode = $('#invoice_mode_list').find('.choosed').text();
		var invoice_title = $('#invoice_list').find('.choosed').find('input').val();
		var invoice_content = $('#invoice_content_list').find('.choosed').text();
		$('#selected_invoice_mode').text(invoice_mode);
		$('#selected_invoice_title').text(invoice_title);
		$('#selected_invoice_content').text(invoice_content);		
		$('#selected_invoice_mode_p').val(invoice_mode);
		$('#selected_invoice_title_p').val(invoice_title);
		$('#selected_invoice_content_p').val(invoice_content);

		
		
	}
});

	
///////////////////////////////////////////////////////
//		此处是处理收货地址的处理逻辑		    		////
//		借用book_form的js					       ////
////////////////////////////////////////////////////
		//刷新页面的收货列表。
   //判断是否为空的函数
	function empty(v){ 
		switch (typeof v){ 
			case 'undefined' : 
				return true; 
			case 'string' : 
				if(v.length == 0) 
					return true; break; 
			case 'boolean' : 
				if(!v) 
					return true; break; 
			case 'number' : 
				if(0 === v) 
					return true; break; 
			case 'object' : 
				if(null === v) 
					return true; 
				if(undefined !== v.length && v.length==0) 
					return true; 
				for(var k in v){return false;
				} 
					return true; 
			break; 
		} 
		return false; 
	}
    

	
	//点击确认添加摁钮之后，先判断是否必选项有空值，如果没有就走POST相关信息到addr_fns.PHP页面中
    $('#add_addr_btn').on("click",function (){
		var ship_person 	= $('#add_addr_form').find('.ship_person').val();
		var ship_city 		= $('#add_addr_form').find('.ship_city').val();
		var ship_district 	= $('#add_addr_form').find('.ship_district').val();
		var ship_addr 		= $('#add_addr_form').find('.ship_addr').val();
		var ship_zip 		= $('#add_addr_form').find('.ship_zip').val();
		var ship_tel 		= $('#add_addr_form').find('.ship_tel').val();
		var ship_tel2 		= $('#add_addr_form').find('.ship_tel2').val();
		var ship_email 		= $('#add_addr_form').find('.ship_email').val();
		var act 			= 'add';	//动作为添加
		console.log(act);
		
        //判断必填项是否填写完整了。
		if(!empty(ship_person) 		&& 
		   !empty(ship_city) 		&& 
		   !empty(ship_district) 	&& 
		   !empty(ship_addr) 		&& 
		   !empty(ship_tel)){
			
            //确认填写完整了之后，消除模态框引起的效果。
            $('#add_addr_form').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').hide();
            
			//post信息过去，做添加处理
            $.post('../action/action_addr.php',{
                    act             :act,
					easy			:1,
					ship_person 	:ship_person,
					ship_city 		:ship_city,
					ship_district 	:ship_district,
					ship_addr 		:ship_addr,
					ship_zip 		:ship_zip,
					ship_tel 		:ship_tel,
					ship_tel2 		:ship_tel2,
					ship_email 		:ship_email},
				   	function(data){
						//如果地址为空，先清空提示，然后在插入地址。
						var addr_nums = $('.addr_list').length;
						if(addr_nums == 0){
							$('#my_addr').html(data);
						}else{
							//将这货扔到ADDR_LIST的第一位
							var first_div = $('#my_addr').find('.addr_list:first');
							first_div.before(data);
						}
						//清空添加地址表单的input,以便再次使用
						$('#add_addr_form').find('input').each(function(){
							$(this).val('');
						});
			});
            //填写不完整则提示
			}else{
                alert('抱歉，填写的信息尚未完整, 无法添加！');
			}
		
	});
	
	//点击删除摁钮
	$(document).on("click",".del_addr-btn",function(){
		var ship_id 	= $(this).attr('want_del');
		var model_id 	= "del_addr"+ship_id;
		var act 		= 'del';
		
		$(model_id).modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').hide();
		
		$.post('../action/action_addr.php',
		   {ship_id	:ship_id,
			act		:act		}
		);
		$(this).parents('.addr_list').remove();
		$('body').css('padding-right',0);	//修正整体偏移
		
		//如果地址里空了，则展示提示信息
		var addr_nums = $('.addr_list').length;
		if(addr_nums == 0){
			var hint = '你尚未设置过收货地址，请新建收货地址~';
			$('#my_addr').html(hint);
		}
	});
							 

	//设置默认收货地址
	$(document).on("click",".set_def_addr",function(){
		//逻辑处理
		var ship_id = $(this).attr('set_def_addr_id');
		var act = 'set_def_addr';
		$.post('../action/action_addr.php',{act:act,ship_id:ship_id});
		//前端效果处理
		//最后将自身移动到LIST的第一位。先拿到第一位的div
		//var first_div = $('#my_addr').find('.addr_list:first');
		//$(this).parents('.addr_list').insertBefore(first_div);
		//先将自身添加上默认地址的标签，并且去除设置默认的标签
		$(this).parents('.addr_list').find('.show_def_addr').removeClass('hide');
		$(this).parents('.addr_list').find('.set_def_addr').addClass('hide');
		//之后将兄弟类的默认标签去除，展示设置标签
		$(this).parents('.addr_list').siblings().find('.show_def_addr').addClass('hide');
		$(this).parents('.addr_list').siblings().find('.set_def_addr').removeClass('hide');

	});
	
    //修改收货地址
	$(document).on("click",".modify_btn",function(){
		var ship_id 		= $(this).parents('.addr_modify').attr('ship_id');
		var ship_person 	= $(this).parents('.addr_modify').find('.ship_person').val();
		var ship_city 		= $(this).parents('.addr_modify').find('.ship_city').val();
		var ship_district 	= $(this).parents('.addr_modify').find('.ship_district').val();
		var ship_addr 		= $(this).parents('.addr_modify').find('.ship_addr').val();
		var ship_zip 		= $(this).parents('.addr_modify').find('.ship_zip').val();
		var ship_tel 		= $(this).parents('.addr_modify').find('.ship_tel').val();
		var ship_tel2 		= $(this).parents('.addr_modify').find('.ship_tel2').val();
		var ship_email 		= $(this).parents('.addr_modify').find('.ship_email').val();
		var act 			= 'modify';
		
    	//判断必填项是否填写完整了。
		if(!empty(ship_person) 		&& 
		   !empty(ship_city) 		&& 
		   !empty(ship_district) 	&& 
		   !empty(ship_addr) 		&& 
		   !empty(ship_tel)){
			
            //确认填写完整了之后，消除模态框引起的效果。
            $('.addr_modify').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').hide();
            
			//post信息过去，php页面做修改处理
            var data = $.post('../action/action_addr.php',{
                    act             :act,
					ship_id			:ship_id,
					ship_person 	:ship_person,
					ship_city 		:ship_city,
					ship_district 	:ship_district,
					ship_addr 		:ship_addr,
					ship_zip 		:ship_zip,
					ship_tel 		:ship_tel,
					ship_tel2 		:ship_tel2,
					ship_email 		:ship_email},
				   	function(data,state){
						//现将对应展现内容变为修改后的新的内容
				 		$("#addr_no_"+ship_id).find('.addr_person').text(ship_person);
				 		$("#addr_no_"+ship_id).find('.ship_city').text(ship_city);
				 		$("#addr_no_"+ship_id).find('.ship_district').text(ship_district);
				 		$("#addr_no_"+ship_id).find('.ship_addr').text(ship_addr);
				 		$("#addr_no_"+ship_id).find('.addr_tel').text(ship_tel);
						//然后更新被选中状态
						console.log("#addr_no_"+ship_id);
						$("#addr_no_"+ship_id).find('.col-md-2').addClass('choosed');
						$("#addr_no_"+ship_id).find('.col-md-2').parent().siblings().find('.select_addr_btn').removeClass('choosed');
						//更新最下方的LAST的TEXT和对应的INPUT。
							//修改最底部input中的相关信息
							$('#last_ship_city_p').val(ship_city);
							$('#last_ship_district_p').val(ship_district);
							$('#last_ship_addr_p').val(ship_addr);
							$('#last_ship_person_p').val(ship_person);
							$('#last_ship_tel_p').val(ship_tel);
							$('#last_ship_tel2_p').val(ship_tel2);
							$('#last_ship_zip_p').val(ship_zip);
							$('#last_ship_email_p').val(ship_email);
							//修改最底部last_addr_info的相关信息
							$('#last_ship_city').text(ship_city);
							$('#last_ship_district').text(ship_district);
							$('#last_ship_addr').text(ship_addr);
							$('#last_ship_person').text(ship_person);
							$('#last_ship_tel').text(ship_tel);
							//将底部的提示语言展示出来
							$('#last_addr_person').removeClass('hide');
							$('#last_addr_info').removeClass('hide');
				
				
				
			});

            //填写不完整则提示
			}else{
                alert('抱歉，填写的信息尚未完整, 无法修改！');
			}
	});		
   
});

