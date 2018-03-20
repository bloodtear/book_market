$(document).ready(function(){
    
    //判断是否所有的Item都被选中，如果有的话，就把#check_all勾选上，如果没有的话，就把check_all取消掉
	function change_allchk (){
		
		//判断是否item_check是否都全部被选中，如果都被选中，flag=0.
		function is_all_chk(){
			var flag = 0;
			$('.item_check').each(function(){
				var chk = $(this).prop("checked");
				if(!chk){
					flag++;
				}
			});
			return flag;
		}
		
		var is_all_chk = is_all_chk();
		
		//如果被全选，就把全选的摁钮勾上，反之亦然。
		if(is_all_chk == 0){
			$(".check_all").prop("checked",true);
		}else{
			$(".check_all").prop("checked",false);
		}
	}
    
    /*点击[+号]触发事件*/
    $(".plus").click(function(){       
        var now = $(this).siblings("input").val();  						/*读取当前的数量，从当前对象的父类的子类过滤input*/
        var price = $(this).parent().parent().siblings(".price").text(); 	//读取此行的价格
        var isbn = $(this).siblings("input").attr('isbn');
        now++;                                               /*数量+1*/
        $(this).siblings("input").val(now);                  /*设置对应数量为原数值+1*/
        
        var total_price = price*now;
        total_price = total_price.toFixed(2);                     //取两位
        $(this).parent().parent().siblings(".price_total").text(total_price);            //旁边的小计数量随之变化
        
        //数量变化添加本行被选中的效果和check的对勾
        $(this).parent().parent().parent().addClass('warning');
        $(this).parent().parent().siblings().children().children("input").prop("checked",true);
        
		change_allchk();
        total_changed();
        
		$.post('../action/action_cart.php',{isbn:isbn,num:now});

		
    });
    
    
    
    /*点击[-号]触发事件*/
    $(".minus").click(function(){       
        var now = $(this).siblings("input").val();  					 /*读取当前的数量，从当前对象的父类的子类过滤input*/
        var price = $(this).parent().parent().siblings(".price").text(); //读取此行的价格
		var isbn = $(this).siblings("input").attr('isbn');
		
        if(now > 1 ){
            now--;                                               /*数量-1*/
            $(this).siblings("input").val(now);   /*设置对应数量为原数值-1*/
			$(this).siblings("input").slideDown(); 
            $(this).css("cursor","pointer");
            
            var total_price = price*now;
            total_price = total_price.toFixed(2);           //取两位
            $(this).parent().parent().siblings(".price_total").text(total_price);    
            
        }else{
            $(this).css("cursor","default");
        }
        
        //数量变化添加本行被选中的效果和check的对勾
        $(this).parent().parent().parent().addClass('warning');
        $(this).parent().parent().siblings().children().children("input").prop("checked",true);
		
		change_allchk();
        total_changed();
		
		$.post('../action/action_cart.php',{isbn:isbn,num:now});
    });
    
    
    
    /*点击[确认删除]（单行）触发事件*/         
    $(".delete-btn").click(function(){
		
		var isbn = $(this).attr('isbn');//取得ISBN
        var name = 'myModal'+isbn;      //拼接id名称
    
		$("#name").hide();
        $(this).parents('.cart_item_no').remove();
		$('body').removeClass('modal-open');
		$('.modal-backdrop').hide();
		
		change_allchk();
        total_changed();
		
		$.post("../action/action_cart.php",{is_del:true,isbn:isbn})
		
        is_show_empty()
		$('body').css('padding-right',0);	//修正整体偏移
    });
	

	
	

    /*点击单个的购物车中的[复选框]后被选中的效果*/
    $(".item_check").click(function(){

        $(this).parent().parent().parent().toggleClass("warning");
		
		change_allchk();
        total_changed();
    });
    
    
    //点击[全选]摁键的效果
    $(".check_all").click(function(){
        var is_all_check = $(this).is(':checked');  //取得当前的check all状态。
        
        //如果是没被选中，那就all item都设置为选中，并且样式发生变化
        if(is_all_check){
            $(".cart_item_no").addClass("warning");  
            $(".item_check").prop("checked",true);
            $(".check_all").prop("checked",true);

        }else{
            $(".cart_item_no").removeClass("warning");  
            $(".item_check").prop("checked",false);
            $(".check_all").prop("checked",false);
        }
        total_changed();
    });
    
    //当[input数量]的输入框有变化，就对应的[小计]也随之变化，并且[选中框]也随之变化
	$('.num').keyup(function (){

		var now = $(this).val();  	/*读取当前的数量，从当前对象的父类的子类过滤input*/
        var price = $(this).parent().parent().siblings(".price").text(); //读取此行的价格
		var isbn = $(this).attr('isbn');
		
		total_price = now*price;
		total_price = total_price.toFixed(2);           //取两位

        $(this).parent().parent().siblings(".price_total").text(total_price);    
		
		//数量变化添加本行被选中的效果和check的对勾
        $(this).parent().parent().parent().addClass('warning');        
        $(this).parent().parent().siblings().children().children("input").prop("checked",true);
		change_allchk();
        total_changed();
		
		$.post('../action/action_cart.php',{isbn:isbn,num:now});
	});
    
    
    //当有商品被选中了之后，总计数量进行变化，以及总计价格变化。
    function total_changed(){
        var selected_num = 0;
        var total_price = 0;
        $(".item_check").each(function(){
            if($(this).prop('checked') == true){
                var isbn= $(this).parents('.cart_item_no').attr('isbn');
                var price = $(this).parents('.cart_item_no').children('.price').attr('price');
                var number = $(this).parent().parent().siblings().children().children('input').val();
                var row_price = price*number;
                selected_num = parseInt(number)+parseInt(selected_num);
                total_price = parseFloat(total_price)+parseFloat(row_price);
            }
        });
        $('.item_nums').text(selected_num);
        $('#selected_price').text(total_price.toFixed(2));
    }
    
    
    
    
    //点击[删除所选中的商品]，先判断是否有商品被选中
    $('#want_del_items').click(function(){	
        var flag = 0;
        $('.item_check').each(function(){
            var chk = $(this).prop("checked");
            if(chk){
                flag++;
            }
        });
        if(flag == 0){
            $('#no_selected').modal('show');
            console.log('1');
        }else{
            $('#del_selected').modal('show');
        }
    });
    
    
    //点击[删除所选中的商品]，有商品被选中后出现提示框，点击[确认删除]的处理。
    $('.del_selected_items').click(function (){
        $(".item_check").each(function(){
            if($(this).prop('checked') == true){
                var isbn = $(this).parents('.cart_item_no').attr('isbn');//取得ISBN
                console.log(isbn);
                
                $('#del_selected').modal('hide');
                $(this).parents('.cart_item_no').remove();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').hide();
                
                change_allchk();
                total_changed();

                $.post("../action/action_cart.php",{is_del:true,isbn:isbn})
            }
        });
        is_show_empty()
    });
    
    
    //判断当前页面的session是否没有isbn了，如果购物车中没有物品，table就展示空购物车的页面empty_cart();
    function is_show_empty(){
        var flag = 0;
        $(".cart_item_no").each(function (){
            var is = $(this).length;
            if(is>0){
                flag++;
            }
        });       
        if(flag == 0){
            var empty_cart = $('#empty_cart').html();
            $('#cart_content').html(empty_cart);
        }
    }
    
	//点击【去结算】摁键。如果没选中任何东西，就展示提示框，如果有选中商品，就走submit提交流程。
	$('#make_order').click(function (){
        var flag = 0;
        $('.item_check').each(function(){
            var chk = $(this).prop("checked");
            if(chk){
                flag++;
            }
        });
		
        if(flag == 0){
			console.log('1');
            $('#no_selected').modal('show');
            $("form").bind('submit',(function(e){
    			e.preventDefault();
        	}));
		}else{
			$("form").unbind('submit');
		}
    });
	
});
