<?php

require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
    $item_id = @$_REQUEST['isbn'];   //提取当时的内容
   
/******************************************
    
        头部
    
*******************************************/
    do_html_header('添加购物车');
    login_up();
    display_logo();
    display_nav(@$page_no);  //传入当前页面，画nav
    display_intro('添加购物车');
    hr();

/******************************************
    
        BODY
    
*******************************************/
    
?>
<div class="container">
    <div class="row">
<?php
    try{
        if(empty($item_id)){
           throw new Exception('抱歉，添加的物品是空的哦！'); 
        }
        $book_detail = get_book_detail($item_id);
        if(!$book_detail){   
            throw new Exception('抱歉，找不到你添加的物品呢！'); 
        }
        ?>
        <!--展示成功信息-->
        <div id="cart_success">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <span class="text-success" style="font-size:30px;">商品已成功加入购物车！</span>
            <a href="show_cart.php"><button class="btn btn-primary btn-lg" style="padding-left:20px;">去购物车结算</button></a>
            <span style="padding-left:10px;">您还可以<a href="show_book_detail.php?isbn=<?php echo $item_id;?>">继续购物</a></span>
        </div>
        <?php   
	}catch(Exception $e){
        echo $e->getMessage();
        display_error();
    }
?>
    </div>
</div>
<?php

/******************************************
    
        尾部
    
*******************************************/

    do_html_footer();

?>