$(document).ready(function(){
  //email editor
    // $("#txtEditor").Editor();
    // $("#txtEditor2").Editor();

    //save a template
    // $("#saveEmailTemplate").click(function(){
    //     $emailTemplate = $("#txtEditor").Editor("getText");
    //     $emailFooter = $("#txtEditor2").Editor("getText");
    //     $newSubject = $("#newSubject").val();        

    //     if($emailTemplate == null || $emailTemplate == "" || $emailTemplate == undefined || $emailFooter == null || $emailFooter == "" || $emailFooter == undefined || 
    //       $newSubject == null || $newSubject == "" || $newSubject == undefined){
    //       $("#loginerrorBox p").html("Please provide all the email component detalis.");
    //       hideLoginErrorBox();
    //     }else{
    //       $confirm = confirm("Are you sure");
    //       if($confirm == true){
    //         $emailTemplate = JSON.stringify($emailTemplate);
    //         $emailID = $("#emailID").val();
            
    //         $.post($updateSpecificEmailURL,{'emailID':$emailID,"emailContent":$emailTemplate,"newSubject":$newSubject,"emailFooter":$emailFooter},function(data, status){
    //           // console.log(data);
    //           if(data == "Updated"){
    //             window.location = $refreshEditEmailURL+"/"+$emailID+"?resp=1";
    //           }else{
    //             window.location = $refreshEditEmailURL+"/"+$emailID+"?resp=2";
    //           }
    //         });
    //       }
    //     }
    // });
    //save a template

    //runs when you hit the edit button on adminDash
    // $("#EditEmailTemplate").click(function(){
    //     $emailID = $("#emailIDModal").val();
    //     window.location = $editTemplateURL+"/"+$emailID;//redirects to edit page and gets the email details
    // });
    //runs when you hit the edit button on adminDash

    window.getEmailID = function($emailID){
      $.post($getSpecificEmailForDisplayURL,{'emailID':$emailID},function(data, status){
          console.log(data);
          $(".overlay").show();
          $data = JSON.parse(data);
          $subject = $data[0]['subject'];
          $content = $data[0]['emailContent'];
          $reason = $data[0]['reasonForSending'];
          $footer = $data[0]['emailFooter'];

          $("#emailSubjectModal").val($subject);
          $("#emailContentModal").html($content);
          $("#reasonForSendingModal").val($reason);
          $("#emailFooterModal").html($footer);
      });

      $("#emailIDModal").val($emailID);
    }
    //email editor      
});
