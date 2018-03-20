$(document).ready(function(){

    $('#button1').click(function(){
        var ais = $("#www").is(':checked');
        alert(ais);
    });

    $('#button2').click(function(){
        var ais = $("#www").is(':checked');
        if(ais){
			alert(1);
            $("#www").prop("checked",false);
			alert(0);
        }else{
			alert(0);
            $("#www").prop("checked",true);
			alert(1);
        }
    });


	var sList = "";
	$('input[type=checkbox]').each(function () {
		var sThisVal = (this.checked ? "1" : "0");
		sList += (sList=="" ? sThisVal : "," + sThisVal);
	});
	console.log (sList);




});