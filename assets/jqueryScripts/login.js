$(document).ready(function(){
    $("#ftlcodeContainer").hide();//hide unless needed

    $("#loginForm").submit(function(e){
    	e.preventDefault();
        $loginDetails = $("#loginForm").serializeArray();

        $ftlcode = $("#ftlcode").val().trim();
        if($ftlcode == undefined || $ftlcode == "" || $ftlcode == null){
            //not first time to login
            //login as ussual
           // console.log($loginDetails);
            $(".overlay").show();
            $.post($loginUrl,$loginDetails,function(data, status){
               console.log("Data: " + data + "\nStatus: " + status);
                
                $resp = JSON.parse(data);
                $status = $resp['status'];
                

                // $(".overlay").css("display","none");
                // console.log($resp);
                if($status == 1){
                  $("#usernameLogin").val("");
                  $("#navCodeLogin").val("");
                  $("#passwordLogin").val("");
                  $("#error").html("<center> <em>Error:</em> "+$resp['message']+" </center>");

                  //display notification box
                  $("#error").css({
                    "padding-top":"65px",
                    "visibility":"visible"
                  });
                  //display notification box  
                  $(".overlay").hide();
                }else if($status == 0){
                  $("#error").html("<center> <em>Success:</em> "+$resp['message']+" </center>");

                  //display notification box
                  $("#error").css({
                    "padding-top":"65px",
                    "visibility":"visible"
                  });
                  //display notification box  
                  
                  console.log("redirect");
                  window.location = $dashboardURL;//defined in loginTemplate_v.php
                }else if($status == 2){
                  $url = "<?php echo base_url('Login/changepass?cp=2') ?>";
                  window.location = $url;
                }else if($status == 3){
                  $("#ftlcode").show();
                  $("#error").html("<center> <em>Success:</em> "+$resp['message']+" </center>");

                  //display notification box
                  $("#error").css({
                    "padding-top":"65px",
                    "visibility":"visible"
                  });
                  //display notification box  
                }else{}
            });
        }else{
            //first time to login
            //login using first time login function
            $(".overlay").show();
            //window.location = $dashboardURL;//redirect to home page
            console.log($loginDetails);
        }        
    });

    $("#passwordLogin").focusout(function(){
        $("#passwordPolicy").hide('slow');
        $pass = $("#passwordLogin").val();   
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
});