/*预览图片*/
function preview(file){
	var prevDiv = document.getElementById('preview');
	if(file.files[0]){
		var reader = new FileReader();
		reader.readAsDataURL(file.files[0]);
		reader.onload = function(e){
			prevDiv.innerHTML = '<img src = "' + e.target.result + '"/>';
		}
	}
}

$(document).ready(function (){
	//点击清空摁钮的时候，预览图随之消失
	$('#clear-btn').click(function(){
		var prevDiv = document.getElementById('preview');
		prevDiv.innerHTML = '';
	});




});





