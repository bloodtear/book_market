$(document).ready(function(){
	
	//刷新页面的收货列表。
    function renew_addr_list(){
        $.post('../action/action_addr.php',{show_list:1},function(result,state){
			
            $('#my_addr').empty();//将页面中的ADDR列表置空

            $.each(JSON.parse(result),function(index, addr){
				//将结果拆分，提取出每一个addr_list的细节信息
                var ship_id 			= addr.ship_id;
                var is_default 			= addr.is_default;
                var show_addr_detail 	= 1;
                
				//将调取detail的输入值传到do_addr.php中，返回html输出。
                $.post('../action/action_addr.php',
					   {
						ship_id				:ship_id,
						is_default			:is_default,
						show_addr_detail	:1
					   },
                       function(detail,state){
                        $('#my_addr').append(detail);//添加到my_addr元素中。
                });

            });
        });					
    }
			
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
					ship_person 	:ship_person,
					ship_city 		:ship_city,
					ship_district 	:ship_district,
					ship_addr 		:ship_addr,
					ship_zip 		:ship_zip,
					ship_tel 		:ship_tel,
					ship_tel2 		:ship_tel2,
					ship_email 		:ship_email},
				   	function(data){

						//先判断是否有地址，如果没有地址，就直接放到地址栏内
						var addr_nums = $('.addr_detail').length;
						if(addr_nums == 0){
							$('#my_addr').append(data);
						}else{
							//如果有默认地址，就把他放到第二位，如果没有就第一位
							var first_div = $('#my_addr').find('.addr_detail:first');
							var has_def_addr = $('.def_addr').length;
							console.log('has_def_addr'+has_def_addr);

							if(has_def_addr > 0 ){
								first_div.after(data);
							}else{
								first_div.before(data);
							}
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
		$(this).parents('.addr_detail').hide();
		
		$('body').css('padding-right','0');	//修正引起的偏差
	});
							 

	//设置默认收货地址
	$(document).on("click",".set_def_addr",function(){
		//逻辑处理
		var ship_id = $(this).attr('set_def_addr_id');
		var act = 'set_def_addr';
		$.post('../action/action_addr.php',{act:act,ship_id:ship_id});
		//前端效果处理
		//最后将自身移动到LIST的第一位。先拿到第一位的div
		var first_div = $('#my_addr').find('.addr_detail:first');
		$(this).parents('.addr_detail').insertBefore(first_div);
		//先将自身添加上默认地址的标签，
		var def_addr_show = "<div><p class='text-center' style='width:100%;background-color:orange;color:white;'>默认地址</p></div>";
		$(this).parents('.addr_detail').find('.def_addr').html(def_addr_show);
		//之后将兄弟类的标签去除，
		$(this).parents('.addr_detail').siblings().find('.def_addr').empty();

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
				 		$("#addr_no_"+ship_id).find('.now_ship_person').text(ship_person);
				 		$("#addr_no_"+ship_id).find('.now_ship_city').text(ship_city);
				 		$("#addr_no_"+ship_id).find('.now_ship_district').text(ship_district);
				 		$("#addr_no_"+ship_id).find('.now_ship_addr').text(ship_addr);
				 		$("#addr_no_"+ship_id).find('.now_ship_tel').text(ship_tel);
			});

            //填写不完整则提示
			}else{
                alert('抱歉，填写的信息尚未完整, 无法修改！');
			}
	});		
    
    
    
    
});
    
    
    
    
    
    
    
    
    
    
    

