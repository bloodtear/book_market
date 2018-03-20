<?php
require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
    $page_no = 6;
    $list_no = 1;
    do_html_header('个人设置');
/******************************************
    
        头部
    
*******************************************/
    login_up();
    display_logo();
    display_nav($page_no);
    display_intro('请选择你想查看的设置');
    hr();


/******************************************
    
        BODY
    
*******************************************/
?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
        <?php display_list($list_no); //显示列表 ?>
        </div>
        
        <div class="col-md-8">
        <?php display_personal_inf(); //显示个人信息?>
        </div>
    </div>
</div>
<?php
/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();
?>






