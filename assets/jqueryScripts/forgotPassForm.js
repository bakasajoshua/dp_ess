$(document).ready(function(){
	$("#resetPassForm").submit(function(e){
		e.preventDefault();
		//display then hide notification box
        $("#error").css({
        	"padding-top":"65px",
        	"visibility":"visible"
        });
        $("#ajaxLoader").show();
        hideNotificationBox();
        //display then hide notification box
	});
});