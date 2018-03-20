$(document).ready(function(){
	
	//重新计算thumb_img们的长度。并修改父类的list长度。
	var img_nums = $('.thumb_img').length;
	var imgs_length = img_nums*74;
	if(imgs_length > 370){
		$('.thumb_imgs_list').css('width',imgs_length);
	}else{
		$('.thumb_imgs_list').css('width',370);
	}

	//点击向左划动
	$('.icon_left').click(function(){
		//先判断左边是否还有东西，也就是说img_list左边是否超出了imgs左边的范围。
		var position_list = $('.thumb_imgs_list').offset().left;
		var position_imgs = $('.thumb_imgs').offset().left;
		console.log("===========");
		console.log(position_list);
		console.log(position_imgs);
		if(position_list < position_imgs){
			console.log('<<<<<<<<<<<<<');
			if(!$('.thumb_imgs_list').is(":animated")){
				$('.thumb_imgs_list').animate({left:'+='+74},'fast');
			}
		}
	});	
	
	//点击向右边划动
	$('.icon_right').click(function(){
		//先判断右边是否还有东西，也就是说img_list右边是否超出了imgs右边的范围。
		var position_list = $('.thumb_imgs_list').offset().left+imgs_length;
		var position_imgs = $('.thumb_imgs').offset().left+370;
		console.log("===========");
		console.log(position_list);
		console.log(position_imgs);
		if(position_list > position_imgs){
			console.log('<<<<<<<<<<<<<');
			if(!$('.thumb_imgs_list').is(":animated")){
				$('.thumb_imgs_list').animate({left:'-='+74},'fast');
			}
		}
	});

	//向左向右摁键hover效果
	$('.icon_right').hover(function(){
		$(this).toggleClass('icon_right_hover');
	});	
	$('.icon_left').hover(function(){
		$(this).toggleClass('icon_left_hover');
	});
	
	//图片悬停效果
	$('.thumb_img').mouseover(function(){
		$(this).siblings().removeClass('thumb_img_hover');
		$(this).addClass('thumb_img_hover');
	});	
	//图片预览效果
	$('.thumb_img').hover(function(){
		var src = $(this).attr('src');
		var pre =  "<img src="+src+" class='center>' style='max-width:350px;border:#dfdfdf 1px solid;'>";
		$('.img_preview').html(pre);
	});
	
	
	
	
	
	
	
	
	
	
});


function preview(file){
	if(file.files[0]){//如果上传的图片存在的话，
		//将图片作为dataURL读取出来，再将其添加到展示div内。
		var reader = new FileReader();
		reader.readAsDataURL(file.files[0]);
		reader.onload = function(e){
			
			
		}
	}
}