$(document).ready(function(){
	window.getmasterDataID = function($ID){
      $.post($getSpecificMasterDataURl,{'ID':$ID},function(data, status){
          console.log(data);
          $data = JSON.parse(data);

          $("#masterDataID").val($data[0]['id']);
          $("#masterDataObject").html($data[0]['dataobj']);
          $("#masterDataValue").html($data[0]['dataval']);         
      });

      // $("#emailIDModal").val($emailID);
    }

    $("#EditmasterData").click(function(){
    	$masterDataID = $("#masterDataID").val();
    	window.location = $editMasterDataURL+"/"+$masterDataID;//redirects to edit page and gets the email details
    });

    $("#updateActiveYear").click(function(e){
      e.preventDefault();

      $dataObjID = $("#dataObjID").val();
      $newActiveYear = $("#newActiveYear").val();

      $.post($updateMasterDataURL,{'dataObjID':$dataObjID,'newActiveYear':$newActiveYear},function(data, status){
        $resp = JSON.parse(data);

        $status = $resp['status'];
        $message = $resp['message'];
        if($status == 0){
          console.log($message);
          $("#loginSuccessBox p").html($resp['message']);
          hideLoginSuccessBox();
          setTimeout(function(){
            location.reload();
          },5000);
        }else{
          console.log($message);
          $("#loginerrorBox p").html($resp['message']);
          hideLoginErrorBox();
        }
      });   
    });
});