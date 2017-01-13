$(document).ready(function(){
	        //requisitions page
         $("#uniqueItemDiv").hide();

        $("#itemInputBox").click(function(){
          $("#selectItemDiv").hide();
          $("#uniqueItemDiv").show();
        });

        $("#viewItemList").click(function(){
          $("#selectItemDiv").show();
          $("#uniqueItemDiv").hide();
        });

        //add items to request cart
        window.getRequisitionItem = function(){
          if($("#selectItemDiv").css('display') == 'none'){
            $item = $("#uniqueItem").val();
          }else{
            $item = $("#reqItem").val();
          }
          return $item;
        }

        $items = [];
        $itemCollection = [];
        $k = 0;
        $("#addNewItem").click(function(e){
          e.preventDefault();
          $duplicateEntry = "";
          //get item and qty
          $qty = $("#qty").val();
          $item = getRequisitionItem();

          if($item == null || $item == undefined || $item == "" || $qty == null || $qty == undefined || $qty == "" || $item == "Choose option"){
            $("#loginerrorBox p").html("Please fill in all the fields.");
            hideLoginErrorBox();
          }else{
            $items = [$item,$qty];
            
            //ensures you can't add duplicate values to cart
            for($i=0;$i<$itemCollection.length;$i++){
              if ( $.inArray( $item, $itemCollection[$i] ) > -1 ){
                $duplicateEntry = 1;
              }else{
                $duplicateEntry = 0;
              }
            }

            if($duplicateEntry == 1){
              $("#loginerrorBox p").html("This item exists in your cart.");
              hideLoginErrorBox();
            }else{
              $itemCollection.push($items);
            }

            //ensures you can't add duplicate values to cart
            $("#itemsInCart").html($itemCollection.length+" item(s)");
          }
        });
        //add items to request cart

        //view cart items
        $("#viewCartItems").click(function(){
          $itemList = "";
          for($i=0;$i<$itemCollection.length;$i++){
            $itemList += "<tr>";
            $itemList += "<td>"+($i+1)+"</td>";
            $itemList += "<td>"+$itemCollection[$i][0]+"</td>";
            $itemList += "<td>"+$itemCollection[$i][1]+"</td>";
            $itemList += "</tr>";
          }

          $("#previewRequisitionTable").html($itemList);
        });
        //view cart items

        //place requisition
        $("#makeRequisition").click(function(e){
          e.preventDefault();
          $qty = $("#qty").val();
          
          if($itemCollection == null || $itemCollection == undefined || $itemCollection == ""){
            // || $qty == null || $qty == undefined || $qty == "" || $item == "Choose option"
            $("#loginerrorBox p").html("Add an item to your requisitions cart.");
            hideLoginErrorBox();
          }else{
            $itemsArray = $itemCollection;
            $proceed = confirm("Proceed?");
            if($proceed == true){
              $.post($makerequisitionUrl,{"items":$itemsArray},function(data, status){
                console.log(data);

                $resp = JSON.parse(data);
                $status = $resp['status'];
                if($status == 0){
                  $("#loginSuccessBox p").html($resp['message']);
                  hideLoginSuccessBox();
                  $items = [];
                  $itemCollection = [];
                  $("#reqItem").val();
                  $("#qty").val();
                }else{
                  $("#loginerrorBox p").html($resp['message']);
                  hideLoginErrorBox();
                }
              });
            }else{

            }
          }
        });

        $(".checkbox").change(function() {
            if(this.checked) {
                console.log("clicked add to array");
                //get the requstID
                //get the the row details
                //add details to array
                $empNo =  $('#approveRequisitionTable tr').find(".empNO").html();
                $item =  $('#approveRequisitionTable tr').find(".itemName").html();
                $qty =  $('#approveRequisitionTable tr').find(".qty").html();
                $requestDate =  $('#approveRequisitionTable tr').find(".requestDate").html();
                console.log($empNo+" "+$item+" "+$qty+" "+$requestDate);
            }else{
                console.log("clicked remove from array");
                //remove from from the array if uncheckd.
            }
        });


        //actOnRequisition
        window.actOnRequisition = function($requisitionID){
          $empNo =  $('#approveRequisitionTable tr').find(".empNO").html();
          $item =  $('#approveRequisitionTable tr').find(".itemName").html();
          $qty =  $('#approveRequisitionTable tr').find(".qty").html();
          $requestDate =  $('#approveRequisitionTable tr').find(".requestDate").html();
          $requestersID =  $('#approveRequisitionTable tr').find(".empNO").html();

          $("#requisitionID").val($requisitionID);
          $("#requestedItem").val($item);
          $("#requestersID").val($requestersID);
          $("#qtyrequested").val($qty);
          $("#dateRequested").val($requestDate);
        }
        //actOnRequisition

        $("#approveRequisition").click(function(){
          $item = $("#requestedItem").val();
          $qty = $("#qtyrequested").val();
          $dateRequested = $("#dateRequested").val();
          $requisitionID = $("#requisitionID").val();
          $requestersID = $("#requestersID").val();
          $comment = $("#comment").val();
          $requisitionResponse = "APPROVED";
          //format date
          $dateValue = $dateRequested.split('-');
          $year = $dateValue[2];
          $month = $dateValue[1];
          $dayofWeek = $dateValue[0];
          //format date
          $dateRequested = $year+$dayofWeek+$month;
          
          $.post($approveRequisitionUrl, {"requisitionID":$requisitionID, "dateRequested":$dateRequested,"qty":$qty, "item":$item,"requestersID":$requestersID,"comment":$comment, "action":$requisitionResponse},function(data,status){
             $resp = JSON.parse(data);
            $status =$resp['status'];
            if($status == 0){
              $("#loginSuccessBox").html($resp['message']);
              hideLoginSuccessBox();
              window.location = $refreshRequisitionPageurl;
            }else{
              $("#loginSuccessBox").html($resp['message']);
              hideLoginSuccessBox();
            }
          })

        });

        $("#rejectRequisition").click(function(){
          $item = $("#requestedItem").val();
          $qty = $("#qtyrequested").val();
          $dateRequested = $("#dateRequested").val();
          $requisitionID = $("#requisitionID").val();
          $requestersID = $("#requestersID").val();
          $comment = $("#comment").val();
          $requisitionResponse = "REJECTED";
          //format date
          $dateValue = $dateRequested.split('-');
          $year = $dateValue[2];
          $month = $dateValue[1];
          $dayofWeek = $dateValue[0];
          //format date
          $dateRequested = $year+$dayofWeek+$month;
          
          //$approveRequisition = "<?php echo base_url('home/approveRequisition/approve'); ?>";
          $.post($approveRequisition, {"requisitionID":$requisitionID, "dateRequested":$dateRequested,"qty":$qty, "item":$item,"requestersID":$requestersID,"comment":$comment,"requisitionResponse":$requisitionResponse},function(data,status){
             $resp = JSON.parse(data);
            $status =$resp['status'];
            if($status == 0){
              $("#loginSuccessBox").html($resp['message']);
              hideLoginSuccessBox();
              window.location = $refreshRequisitionPageurl;
            }else{
              $("#loginSuccessBox").html($resp['message']);
              hideLoginSuccessBox();
            }
          })
        });

        window.getRequisitionID = function($requisitionID){
          return $requisitionID;
        }
        //enable bulk action
        $('table input[type=checkbox]').attr('disabled','true');
        $("#apploveReqisitionBulkAction").click(function(){
          $("table input[type=checkbox]").removeAttr("disabled");
          $("actionBox").attr('disabled','true');
        });
        //requisitions page
});