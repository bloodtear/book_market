$(document).ready(function(){
	

//点击首次上传摁钮的时候的处理
$('.a-upload').on('change',function(){
	$('.a-upload').addClass('hide');
	$('#label_upload_images').addClass('hide');
	$('.upload_image_bar').removeClass('hide');
	$('#preview_images').removeClass('hide');
});


//多次添加图片的时候，将input自身hide，并添加新的input(input添加现在在新的image新建函数中)
$(document).on("change",'.upload_more_input',function(){	
	$(this).hide();
});

	
//点击删除自身的img模块,并且remove对应的Input，
$(document).on("click",'.delete_self',function(){	
	$(this).parents('.uploaded_img').fadeOut(300,function(){
		$(this).remove();
		low_canvas_height();
		is_show_empty();
	});;
	
	var del_no = $(this).attr('del_no');
	console.log('要删除的ID是：'+del_no);
	var del_input_no = 'upload_no_'+del_no ;
		
	if(del_no ==1){
		//$('#'+del_input_no).show();
		var obj = document.getElementById('upload_no_1') ; 
		obj.outerHTML=obj.outerHTML;
		console.log('进行清除的input的id是1!');
	}else{
		$('#'+del_input_no).remove();
		console.log('删除了的input的id是'+del_input_no);
	}
	console.log('~~~~~~~~~~~~~~~~~删除流程完毕~~~~~~~~~~~~~~~~');
});

//点击提交保存的时候，需要判断是否有图片上传，如果没有就alert
$('#submit_btn').click(function(e){
	var pre_length = $('.uploaded_img').length;
	
	if(pre_length == 0){
		e.preventDefault();
		alert('尚未上传图片，无法保存！');
	}else{
		//删除为空的file-input
		$(':file').each(function(){
			var weight = $(this).val();
			if(weight == ''){
				$(this).remove();
			}
		});
	}
});
	
	

});
	
	
	
	





/*添加预览图片*/
var no = 1;
function preview(file){
	if(file.files[0]){//如果上传的图片存在的话，
		//将图片作为dataURL读取出来，再将其添加到展示div内。
		var reader = new FileReader();
		reader.readAsDataURL(file.files[0]);
		reader.onload = function(e){
		//新建图片预览DIV
		var img = 	"<div class='uploaded_img'><img src='" + e.target.result + "'/><div class='upload_img_control'><span><label><input type='radio' name='set_def_page' value="+no+"> 设为封面</label></span><span class='delete_self' del_no="+no+">删除</span></div></div>";
		$('#preview_images').append(img);
		tall_canvas_height();
		console.log('新建了图片预览，id是'+no);
		no++;
			
		//新建图片input-DIV
		var new_input = "<input type='file' class='upload_more_input' onchange='preview(this)' name='upload_images_"+no+"' id=upload_no_"+no+" multiple>";
		$('#upload_more').append(new_input);
		console.log('新建了图片input，id是'+no);
			
		console.log('~~~~~~~~~~~~~~~~~新建流程完毕~~~~~~~~~~~~~~~~');
		}
	}
}


//需要判断预览内容中的长度是否超过默认值，如果超过，就添加画布高度
function tall_canvas_height(){
	var pre = window.document.getElementById('preview_images');
	var height = pre.offsetHeight;
	if(height>335){
		$('#canvas_background').css('height',height+75);
	}
}

//删除的时候判断画布高度和pre的高度，如果画布高度大于pre高度，则降低,最低是400
function low_canvas_height(){
	var pre_height = window.document.getElementById('preview_images').offsetHeight;
	var canvas_height = window.document.getElementById('canvas_background').offsetHeight;
	//console.log('pre_height:'+pre_height);
	//console.log('canvas_height:'+canvas_height);
	if(canvas_height > 400 ){
		if(canvas_height >= pre_height+75){
			if(pre_height+75 > 400){	
				$('#canvas_background').css('height',pre_height+75);
			}else{
				$('#canvas_background').css('height',400);
			}
		}
	}
}

//判断pre是否为空，如果为空就renew画布
function is_show_empty(){
	var pre_length = $('.uploaded_img').length;//判断是否是最后一张图片。

	if(pre_length == 0){
		//如果是最后一张图片，就做对应的图像处理
		$('.a-upload').removeClass('hide');
		$('#label_upload_images').removeClass('hide');
		$('.upload_image_bar').addClass('hide');
		$('#preview_images').addClass('hide');
		
		//将NO1的input清空，但是不删除
		var obj = document.getElementById('upload_no_1') ; 
		obj.outerHTML=obj.outerHTML;
		
		//删除其他的所有input:file。
		$(':file').each(function(){
		var file_id = $(this).attr('id');
			if(file_id != 'upload_no_1'){
				$(this).remove();
			}
		});
	}
	var file_input_length = $('input:file').length;
	console.log('当前图像数量为：'+pre_length);
	console.log('当前file-input数量为：'+file_input_length);
}