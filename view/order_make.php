<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
    $page_no 		= 1;   //当前页面编号是1
	$customerid 	= @$_SESSION['customerid'];
	$addr_list 		= @get_addr_list($customerid);  
	$def_addr 		= get_def_addr($customerid);
	$error_id		= @$_REQUEST['error_id'];
/******************************************
    
        头部
    
*******************************************/
    do_html_header('提交订单','order_make');
	if($error_id){
		display_error_info($error_id);
	}
    login_up();
    display_logo();
    display_nav($page_no);  //传入当前页面，画nav
    display_intro('结算页');
	
	var_dump($_REQUEST);
    hr();

/******************************************
    
        BODY
    
*******************************************/

?>


<div class="container">
	<!--第一行，表头-->
	<div id="order_hint"><p>填写并核对订单信息</p></div>
	<!--第二DIV，整个订单信息-->
	<div id="order_info">
		<!--收货人信息，此处只是做选择和修改，不在form内-->
		<div id="personal_addr_info" class="order_div">
			<div class="row">
				<div class="col-md-2 order_title">收货人信息</div>
				<div class="col-md-2 col-md-offset-8"><span style="float:right;">
					<?php add_addr_form();?></span></div>
			</div>
			<div style="padding:10px;" id="my_addr">
				<?php
				//从数据库中取得addrlist,，排序第一位为is_default,然后按照sumbit-time排序
				if($addr_list){
					$l = 0;
					while(@$addr_list[$l]){
						$ship_id    = $addr_list[$l]['ship_id'];    //读取当前的shipid
						$is_default = $addr_list[$l]['is_default']; //读取当前shipid是否为is_default;

						$addr_detail = get_addr_detail($ship_id);   //根据shipid去得相关的详细信息，以数组形式
						display_addr_detail_easy($addr_detail,$is_default);  //展示对应的详细信息
						$l++;
					}
				}else{
					echo "你尚未设置过收货地址，请新建收货地址~";
				}
				?>
			</div>
		</div>
<form method="post" action="../action/action_order.php">
		<!--支付方式，默认为货到付款-->
		<div id="pay_mode" class="order_div">
			<p class="order_title">支付方式</p>
			<div class="row" style="padding-left:20px;">
				<div class="text-center pay_moder col-md-1 choosed">
					<input class="hide" type="radio" id="pay_moder_after" name="pay_mode" value="1" checked>
					货到付款
				</div>
				<div class="text-center pay_moder col-md-1">
					<input class="hide" type="radio" id="pay_moder_before" name="pay_mode" value="2">
					在线支付
				</div>
			</div>
		</div>
		
		<!--送货清单，此处无法修改，直接放入form内-->
		<div id="selected_items" class="order_div">
			<p class="order_title">送货清单</p>
			<div class="row" id="order_list">
				<div class="col-md-4 bg-warning" id="list-left">
					<p style="color:black;"><b>送货方式</b></p>
					<div>
						<br>
						<p>由商家发送快递</p>
						<p>待客户下订单或支付成功后</p>
						<p>商家会提供快递公司和快递单号</p>
					</div>
				</div>
				<div class="col-md-8"id="list-right">
					<p>
						<b>商品清单</b>
						<a href="show_cart.php"><span style="float:right;">返回修改购物车</span></a>
					</p>
					<table class="table">
						<?php
							$selected = $_REQUEST['checked'];
							$total_nums = 0;
							$all_prices = 0;
							foreach($selected as $key=>$value){
								$isbn = $key;
								$num = $isbn.'_num';
								$num = $_REQUEST["$num"];
								$total_nums += $num;

								$price = $isbn.'_price';
								$price = $_REQUEST["$price"];
								$price_total = $price*$num;
								$all_prices += $price_total;

								display_book_detail_easy($isbn,$num,$price);
							}
						?>
					</table>
				</div>
			</div>
		</div>
		
		<!--发票信息-->
		<div id="invoice_info" class="order_div">
			<p class="order_title">发票信息</p>
			<p class="selected_invoice_info">
				<span id="selected_invoice_mode">普通发票</span>
				<span id="selected_invoice_title">个人</span>
				<span id="selected_invoice_content">明细</span>
				<input id="selected_invoice_mode_p" class="hide" name="selected_invoice_mode" value="普通发票">
				<input id="selected_invoice_title_p" class="hide" name="selected_invoice_title" value="个人">
				<input id="selected_invoice_content_p" class="hide" name="selected_invoice_content" value="明细">
				<input id="act" class="hide" name="act" value="new">
				<span id="modify_invoice_info" data-toggle="modal" data-target="#modify_invoice_form">修改</span>
			</p>
			<?php display_invoice_form();?>
		</div>
	</div>
	
	<!--总计内容-->
	<div id="total_info" class="order_div">
		<div class="row text-right">
			<div class="col-md-11"><p><span style="color:red;"><?php echo $total_nums;?></span> 件商品，总商品金额：</p></div>
			<div class="col-md-1 "><p>￥<?php echo sprintf("%0.2f",$all_prices);?></p></div>
		</div>			
		<div class="row text-right">
			<div class="col-md-11"><p>应付总额：</p></div>
			<div class="col-md-1 "><p>￥<?php echo sprintf("%0.2f",$all_prices);?></p></div>
			</tr>
		</div>
	</div>	
	
	<!--选中的地址-->
	<div id="address_final" class="order_div text-right">
	<?php 
		//如果有默认地址，这默认展示默认地址，否则直接出提示
			
			$def_addr_detail 	= get_addr_detail(@$def_addr);
			$ship_person    	= $def_addr_detail['ship_person'];
			$ship_city      	= $def_addr_detail['ship_city'];
			$ship_district  	= $def_addr_detail['ship_district'];
			$ship_addr      	= $def_addr_detail['ship_addr'];
			$ship_tel       	= $def_addr_detail['ship_tel'];
			$ship_tel2       	= $def_addr_detail['ship_tel2'];
			$ship_zip       	= $def_addr_detail['ship_zip'];
			$ship_email       	= $def_addr_detail['ship_email'];
		?>
		<p>
			<span id="last_addr_info" class="<?php if(!$def_addr){echo "hide";}?>">寄送至：</span>
			<span id="last_ship_city">
				<?php if($def_addr){echo $ship_city;}else{echo "收货地址尚未设置，请设置";}?>
			</span>
			<span id="last_ship_district"><?php echo $ship_district;?></span>
			<span id="last_ship_addr"><?php echo $ship_addr;?></span>
		</p>
		<p>
			<span id="last_addr_person" class="<?php if(!$def_addr){echo "hide";}?>">收货人：</span>
			<span id="last_ship_person"><?php echo $ship_person;?></span>
			<span id="last_ship_tel"><?php echo $ship_tel;?></span>
		</p>

		<input id="last_ship_city_p" 
			   class="hide" type="text" 
			   name="last_ship_city" 
			   value="<?php echo $ship_city;?>">
		<input id="last_ship_district_p" 
			   class="hide" type="text" 
			   name="last_ship_district" 
			   value="<?php echo $ship_district;?>">			
		<input id="last_ship_addr_p" 
			   class="hide" type="text" 
			   name="last_ship_addr" 
			   value="<?php echo $ship_addr;?>">
		<input id="last_ship_person_p" 
			   class="hide" type="text" 
			   name="last_ship_person" 
			   value="<?php echo $ship_person;?>">
		<input id="last_ship_tel_p" 
			   class="hide" type="text" 
			   name="last_ship_tel" 
			   value="<?php echo $ship_tel;?>">		
		<input id="last_ship_tel2_p" 
			   class="hide" type="text" 
			   name="last_ship_tel2" 
			   value="<?php echo $ship_tel2;?>">		
		<input id="last_ship_zip_p" 
			   class="hide" type="text" 
			   name="last_ship_zip" 
			   value="<?php echo $ship_zip;?>">		
		<input id="last_ship_email_p" 
			   class="hide" type="text" 
			   name="last_ship_email" 
			   value="<?php echo $ship_email;?>">
	</div>

	<!--此处为最尾部，应付金额和提交摁钮-->
	<div id="make_order" class="text-right row">
		<div class="col-md-10" id="will_pay">
			应付金额：<span style="color:red;"><b>￥<?php echo sprintf("%0.2f",$all_prices);?></b></span>
		</div>
		<div class="col-md-1 text-center" >
			<input type="submit" id="order_make_btn" value="提交订单">
			<!-- 如果没选择收货地址弹出的Modal -->
			<div class="modal fade text-left" id="alert_order_make" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">提示</h4>
				  </div>
				  <div class="modal-body">
					您尚未选择收货地址，请选择！
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				  </div>
				</div>
			  </div>
			</div>
		</div>
	</div>

</div>
</form>

<?php

/******************************************
    
        尾部
    
*******************************************/

    do_html_footer();

?>