<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/

$cart_items = @$_SESSION['cart'];   //读取购物车里面的物品及数量
    
/******************************************
    
        头部
    
*******************************************/
    do_html_header('我的购物车','show_cart');
    login_up();
    display_logo();
    display_nav(@$page_no);  //传入当前页面，画nav
/*	var_dump($_REQUEST);
	var_dump($_SESSION);*/
    display_intro('查看购物车');
    hr();

?>
<div class="container">
    <div class="row">
        <div class="container">
<?php


/******************************************
    
        BODY
    
*******************************************/

try{
    if(empty($cart_items)){
		 empty_cart();

    }else{
        ?>
        <!--头部-->
        <div id="cart_content">
        <p style="height:30px;margin:0 10px 0 10px;
                  font-size:20px;color:red;
                  border-bottom:2px solid red;
                  ">
            全部商品<span class="item_nums" style="font-size:16px"></span></p>
		<form method="post" action="order_make.php">
        <table class="table" id="cart_items" style="border:1px solid #f9f9f9;">
            <tr style="background-color:#f9f9f9;"> 
                <td style="width:15%">
                    <div style="margin-right:15px;margin-left:5px;float:left;">
                        <input type="checkbox" class="check_all">
                    </div>全选
                </td>
                <td style="width:30%">商品</td>
                <td style="width:15%">单价(元)</td>
                <td style="width:15%;padding-left:35px;">数量</td>
                <td style="width:15%">小计(元)</td>
                <td style="width:10%"><p>操作</p></td>
            </tr>
    <!--BODY:cart-items-->
        <?php
        foreach($cart_items as $isbn=>$num){
            display_item($isbn,$num);
        }
        ?>
        <!--尾部-->
            <tr>
                <td>
                    <div style="margin-right:15px;margin-left:5px;float:left;">
                        <input type="checkbox" class="check_all">
                    </div>全选
                </td>
                <td>
                    <span id="want_del_items">删除选中的商品</span>
                <!-- Modal提示未被选中 -->
                    <div class="modal fade" id="no_selected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">提示</h4>
                          </div>
                          <div class="modal-body">
                            请至少选中一件商品！
                          </div>
                          <!--<div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary del_selected_items">Save changes</button>
                          </div>-->
                        </div>
                      </div>
                    </div>
                <!-- Modal确认删除 -->
                    <div class="modal fade" id="del_selected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">提示</h4>
                          </div>
                          <div class="modal-body">
                            请确认是否删除所选中的商品？
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-danger del_selected_items">确认删除</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </td>
                <td>
                    <div class="text-right">已选择 <span class="item_nums" style="color:red;font-size:20px;">0</span> 件商品
                    </div>
                </td>
                <td colspan="2">
                    <div class="text-right" style="padding-right:30px;">总价（不含运费）：
                        <span style="font-size:20px;color:red;font-family:verdana;font-weight:bold;">¥</span>
                        <span id="selected_price" style="font-size:20px;color:red;font-family:verdana;font-weight:bold;">
                            0.00</span>
                    </div>
                </td>
                <td><button class="btn btn-danger btn-lg" type="submit" style="width:100%" id="make_order">去结算</button></td>
            </tr>
        </table>    
        </form>
        <div class="center-block hide" id="empty_cart">
		<div class="row" style="padding:60px;">
			<div class="col-md-4 text-right"><img src="../images/cart.png" style="width:100px;opacity:0.5;"></div>
			<div class="col-md-4" style="padding:20px;">
				<p>购物车空空的哦~，去看看心仪的书籍吧~</p>
				<p><a href="index.php">去逛逛></a></p>
			</div>
		</div>
	   </div>
       </div>     
            
        <?php
    }
}catch(Exception $e){
    echo $e->getMessage();
    display_error();
}


/******************************************
    
        尾部
    
*******************************************/
?>     
        </div>
    </div>
</div>
<?php

    do_html_footer();

?>