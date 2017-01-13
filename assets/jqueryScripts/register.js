$(document).ready(function(){
	$("#signupForm").submit(function(e){
		e.preventDefault();

		$username = $("#username").val().trim();
	    $pass = $("#pass").val().trim();
	    $pass1 = $("#pass1").val().trim();
	    $navcode = $("#navCode").val().trim();

	    if($pass === $pass1){
    		$passowrdCheck = validatePassword($pass);
	    	if($passowrdCheck == true){
	    		$(".overlay").show();
			    $formDetails = $("#signupForm").serializeArray();

			    //ajax to register user
			    $("#error").html('');
			    $.post($regiUrl,$formDetails,function(data, status){
			    	console.log(data);
			    	$resp = JSON.parse(data);
			    	if($resp['status'] == 3){
						$("#error").html("<center> <em>Success:</em> "+$resp['message']+" </center>");

				    	//display notification box
				        $("#error").css({
				        	"padding-top":"65px",
				        	"visibility":"visible"
				        });
				        //display notification box	

				        $(".overlay").hide();

				        setTimeout(function(){
		                  window.location = $rerouteToLoginUrl;
		                },6000);		    		
			    	}else{
			    		$("#error").html("<center> <em>Error:</em> "+$resp['message']+" </center>");
				    	//display notification box
				        $("#error").css({
				        	"padding-top":"65px",
				        	"visibility":"visible"
				        });
				        $(".overlay").hide();
				        //display notification box			    		
			    	}
			    });
			    //ajax to register user

			    //hide notification box
		        hideNotificationBox();
		        //hide notification box
	    	}else{
	    		$("#error").html("<center> <em>Error:</em> Passwords does not meet the password complexity. </center>");
		    	//display then hide notification box
		        $("#error").css({
		        	"padding-top":"65px",
		        	"visibility":"visible"
		        });
		        hideNotificationBox();
		        //display then hide notification box

		        //empty fields
		        $("#pass").val('');
		        $("#pass1").val('');
		        //empty fields
	    	}
	    }else{
	    	$("#error").html("<center> <em>Error:</em> Passwords do not match. </center>");
	    	//display then hide notification box
	        $("#error").css({
	        	"padding-top":"65px",
	        	"visibility":"visible"
	        });
	        hideNotificationBox();
	        //display then hide notification box
	    }
	})

	//ensures password has no special characters
	$("#pass").focusout(function(){
		$("#passwordPolicy").hide('slow');
		$pass = $("#pass").val();	
		$specialCharactersResult = checkForSpecialCharacters($pass);
		if($specialCharactersResult == true){
	    	$("#error").html("<center> <em>Error:</em> The systems does not accept special characters in the password. </center>");
	    	//display then hide notification box
	        $("#error").css({
	        	"padding-top":"65px",
	        	"visibility":"visible"
	        });
	        hideNotificationBox();
	        //display then hide notification box
	        $("#pass1").prop("disabled", true);
		}else{
			$("#pass1").prop("disabled", false);
		}
	});
	//ensures password has no special characters

	//displays the password policy
	$("#pass").focusin(function(){
		$("#passwordPolicy").show('slow');
		$("#passwordPolicy").css({
			"z-index": 1000
		});
	});
	//displays the password policy
});