$(document).ready(function(){
  //leave approval
    window.actOnRequest = function($rowID){
      $requestID = $('#approveLeaveTable tr:eq('+$rowID+') td:eq(1)').text();
      $empNO = $('#approveLeaveTable tr:eq('+$rowID+') td:eq(2)').text();
      $leaveComment = $('#approveLeaveTable tr:eq('+$rowID+') td:eq(7)').text();

      $("#leaveRequestID").val($requestID);
      $("#leaveAppliersID").val($empNO);          
      $("#leaveComment").val($leaveComment);  
    }

      //approve leave
      $("#approveLeave").click(function(){
        $leaveRequestID = $("#leaveRequestID").val();
        $leaveComment = $("#leaveComment").val();
        var resp = confirm("Are you sure?");

        $("#rejectLeave").prop('disabled', true);
        $("#approveLeave").prop('disabled', true);

        if (resp == true) {
            $respMessage = $("#respMessage").val();
            $.post($approveLeaveUrl,{"RequestID":$leaveRequestID ,"respMessage":$respMessage, "leaveComment":$leaveComment},function(data, status){
              console.log(data);
              // console.log($leaveRequestID+" "+$respMessage+" "+$leaveComment);
              $resp = JSON.parse(data);
              $("#loginSuccessBox p").html($resp['message']);
              hideLoginSuccessBox();
              $status = $resp['status'];
              if($status == 0){
                //send email
                $empNo = $("#leaveAppliersID").val();
                $("#loginSuccessBox p").html('Still working ...');
                if($leaveComment == 'PENDING FINAL APPROVAL'){
                  $emailTemplateID = 5;
                }else{
                  $emailTemplateID = 7;
                }
                $.post($respondToLeaveEmailUrl,{"empNo":$empNo,"templateID":$emailTemplateID,"RequestID":$leaveRequestID,"action":"approve"},function(data, status){
                  console.log("send approve mail "+data);
                  $resp = JSON.parse(data);
                  $message = $resp['message'];
                  $("#loginSuccessBox p").html($resp['message']);
                  hideLoginSuccessBox();
                  setTimeout(function(){
                    window.location = $refreshApproveLeaveURL;
                  },9000);
                });
                //send email
              }else{
                $message = $resp['message'];
                $("#loginerrorBox p").html($resp['message']);
                hideLoginErrorBox();
               window.location = $refreshApproveLeaveURL;
              }
            });
        } else {
            console.log("You will now do nothing");
        }
      })
      //approve leave

      //reject leave
      $("#rejectLeave").click(function(){
        $leaveRequestID = $("#leaveRequestID").val();
        var resp = confirm("Are you sure?");
        
        $("#rejectLeave").prop('disabled', true);
        $("#approveLeave").prop('disabled', true);

        if (resp == true) {
            $respMessage = $("#respMessage").val();
            $.post($rejectLeaveUrl,{"RequestID":$leaveRequestID, "respMessage":$respMessage},function(data, status){
              console.log(data);
              $resp = JSON.parse(data);
              $("#loginSuccessBox p").html($resp['message']);
              hideLoginSuccessBox();
              $status =$resp['status'];
              if($status == 0){
                //send email
                $empNo = $("#leaveAppliersID").val();
                $.post($respondToLeaveEmailUrl,{"empNo":$empNo,"templateID":6,"RequestID":$leaveRequestID,"action":"reject"},function(data, status){
                  console.log("send reject mail "+data);
                  $resp = JSON.parse(data);
                  $message = $resp['message'];
                  $("#loginSuccessBox p").html($resp['message']);
                  hideLoginSuccessBox();
                  setTimeout(function(){
                    window.location = $refreshApproveLeaveURL;
                  },5000);
                });
                //send email
              }else{
                $message = $resp['message'];
                $("#loginerrorBox p").html($resp['message']);
                hideLoginErrorBox();
                window.location = $refreshApproveLeaveURL;
              }
            });
        } else {
            console.log("You will now do nothing");
        }
      })
      //reject leave
  //leave approval
});
