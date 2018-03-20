$(document).ready(function (){

//点击删除摁钮的时候，弹出对应的模态框
$('.delete_self').click(function(){
	var del_no = $(this).attr('del_no');
	$('#del_selected_'+del_no).modal('show');
});

//点击确认删除，从后台请求删除对应数据库中数据，以及存储的图片。然后前台展示
$('.del_selected_items').click(function(){
	//先判断当前数量，如果数量唯一的话，就不能删除
	var nums = $('.uploaded_img').length;
	console.log(nums);
	if(nums == 1){
		alert('抱歉~仅剩一张图片，无法删除！');
	}else{
		var image_id	= $(this).attr('del_no');	
		var img 		= $('#img_'+image_id);
		var img_modal 	= $('#del_selected_'+image_id);
		
	
		
		
		$.post('../action/action_images.php',
		   {act		:'del',
		   image_id	:image_id},
		   function(data){
			console.log(data);
			console.log(123);
			if(data == true){
				$('body').removeClass('modal-open');
				$('.modal-backdrop').hide();
				$('body').css('padding','0');

				$(img_modal).remove();
				$(img).fadeOut(300,function(){
					$(img).remove();
				});
			}
		});
	}
	
	
	
});











});