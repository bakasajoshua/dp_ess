$(document).ready(function(){
    $("#adminLoginForm").submit(function(e){
        e.preventDefault();


        $personID = $("#navCodeLogin").val().trim();
        $pass = $("#passwordLogin").val().trim();
        $user = $("#usernameLogin").val();

        $(".overlay").show();
        $.post($adminLoginUrl,{"personID":$personID, "password":$pass, "user":$user},function(data, status){
            console.log(data);
            $resp = JSON.parse(data);
            $status = $resp['status'];            

            if($status == 1){
                $("#error").html("<center> <em>Error:</em> "+$resp['message']+" </center>");
                //display then hide notification box
                $("#error").css({
                    "padding-top":"65px",
                    "visibility":"visible"
                });
                hideNotificationBox();
                //display then hide notification box
            }else if($status == 0){
                $("#error").html("<center> <em>Success:</em> "+$resp['message']+" </center>");

                console.log("redirect");
                window.location = $adminPageRedirectURL;
            }          
        });
    });
});