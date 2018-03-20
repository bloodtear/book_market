<?php
require_once('../functions/book_sc_fns.php');
session_start();
/******************************************
    
        初始化参数
    
*******************************************/
    $page_no = 6;
    $list_no = 3;


/******************************************
    
        头部
    
*******************************************/
    do_html_header('个人设置');
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
        <?php display_list($list_no);?>
        </div>
        
        <div class="col-md-8">   
            <div class="profiletab" id="change_pwd">
                <p>旧密码</p>
                <p>请输入新密码</p>
                <p>请再次输入新密码</p>
                <p>确定</p>
                <br>
            </div>
        </div>
    </div>
</div>
<?php    


/******************************************
    
        尾部
    
*******************************************/
    do_html_footer();
?>






