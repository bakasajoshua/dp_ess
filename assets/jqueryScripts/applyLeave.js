$(document).ready(function(){
  //start date option 
  $("#startDate").datepicker({
      inline: true,
      minDate: new Date(),
      // beforeShowDay: $.datepicker.noWeekends,
      beforeShowDay: DisableSpecificDates
  });
  //start date option

  //gets the holidays set in the system
  window.getHolidays = function(){
      $.ajax({
        url:$getHolidays,
        data:{},
        type:'POST',
        success:function($resp,status){
          console.log($resp);
          $holidays = JSON.parse($resp);
          // console.log($holidays[0]['holidayName']);
          return $holidays;
        }
      });
  }   
  getHolidays();//this is called to pre-popuate the holidays variable
  //gets the holidays set in the system

  var disableddates = ["30-12-2016", "29-12-2016", "28-12-2016", "27-12-2016"];


  function DisableSpecificDates(date) {
      var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
      return [disableddates.indexOf(string) == -1];
  }
  //Apply for Leave JS

  $("#absenceReason").prop('disabled', true);
  $('#daysAvaliable').prop('disabled', true);
  $('#daysToApply').prop('disabled', true);
  $('#daysRemaining').prop('disabled', true);
  $('#returnDate').prop('disabled', true);
  $("#applyLeave").prop('disabled', true);

  $("#startDate").focusout(function(){
    $("#absenceReason").prop('disabled', false);
  });

  //apply leave
    //auto populates the number of days field during leave application
  $("#absenceReason").change(function(){
    $daysNID = $("#absenceReason").val();

    $daysNID = $daysNID.split("k"); 
    $leavedays = Math.ceil($daysNID[0]);
    $leaveTypeID = $daysNID[1];
    console.log($leaveTypeID);

    if($leaveTypeID == "MATERNITY" || $leaveTypeID == "PATERNITY"){
      $("#daysAvaliable").val($leavedays);
      $("#daysToApply").val($leavedays);
      // $('#daysToApply').attr('max', $leavedays);
      // $('#daysToApply').attr('min', parseInt(0));
      $("#daysToApply").prop('disabled', true);
      $("#applyLeave").prop('disabled', false);
      $("#daysRemaining").val(0);

      $days = $("#daysToApply").val();
      $startDate = $('#startDate').val();

      //format date
      $dateValue = $startDate.split('/');
      $year = $dateValue[2];
      $month = $dateValue[0];
      $dayofWeek = $dateValue[1];
      $newDate = $month+'/'+$dayofWeek+'/'+$year;

      //format date
      $expectedReturnDate = getdate($newDate,$days);
      $("#returnDate").val($expectedReturnDate);
      $("#applyLeave").prop('disabled', false);
    }else{
      $("#daysAvaliable").val($leavedays);
      $('#daysToApply').attr('max', $leavedays);
      $('#daysToApply').attr('min', parseInt(0));
      $("#daysToApply").prop('disabled', false);
    }
  });
  //auto populates the number of days field during leave application


  //get expected return date
  function getdate($newDate,$leavedays) {
      var date = new Date($newDate);
      var newdate = new Date(date);
      $newdayvalue = parseInt(newdate.getDate()) + parseInt($leavedays);
      newdate.setDate($newdayvalue);   
      
      var dd = ("0" + newdate.getDate()).slice(-2);;//newdate.getDate();
      var mm = ("0" + (newdate.getMonth() + 1)).slice(-2);
      var y = newdate.getFullYear();

      var someFormattedDate = dd + '/' + mm + '/' + y;
      return someFormattedDate;
  }
  //get expected return date

  //populate remaing days field
  // $("#daysToApply").focusout(function(){  
  //   $daysApplied = parseInt($("#daysToApply").val());
  //   $availableDays = parseInt($("#daysAvaliable").val());
    
  //   if($daysApplied === parseInt($daysApplied, 10)){
  //     // console.log("data is integer");
  //     if($availableDays < $daysApplied){
  //       alert("You have "+$availableDays+" leave days only.");
  //       $("#daysToApply").val("");
  //       $("#daysRemaining").val("");
  //     }else if($availableDays > $daysApplied){
  //       $remaingDays = $availableDays - $daysApplied;
  //       $("#daysRemaining").val($remaingDays);
  //     }else if($daysApplied == $availableDays){
  //       $remaingDays = $availableDays - $daysApplied;
  //       $("#daysRemaining").val($remaingDays);
  //     }else{}

  //     $days = $("#daysToApply").val();
  //     $startDate = $('#startDate').val();

  //     //format date
  //     $dateValue = $startDate.split('/');
  //     $year = $dateValue[2];
  //     $month = $dateValue[0];
  //     $dayofWeek = $dateValue[1];
  //     $newDate = $month+'/'+$dayofWeek+'/'+$year;

  //     //format date
  //     $expectedReturnDate = getdate($newDate,$days);
  //     $("#returnDate").val($expectedReturnDate);
  //   }else{
  //     // console.log("data is not an integer"+$daysApplied);
  //     $("#returnDate").val("");
  //     $("#daysRemaining").val();
  //   }
  // });
  $("#daysToApply").change(function(){
    $daysApplied = parseInt($("#daysToApply").val());
    $availableDays = parseInt($("#daysAvaliable").val());
    
    if($daysApplied === parseInt($daysApplied, 10)){
      // console.log("data is integer");
      if($daysApplied > 0){
          $("#daysAppliedError").hide();
          $("#daysToApply").css("border", "1px solid #ccc");
          if($availableDays < $daysApplied){
            alert("You have "+$availableDays+" leave days only.");
            $("#daysToApply").val("");
            $("#daysRemaining").val("");
          }else if($availableDays > $daysApplied){
            $remaingDays = $availableDays - $daysApplied;
            $("#daysRemaining").val($remaingDays);
          }else if($daysApplied == $availableDays){
            $remaingDays = $availableDays - $daysApplied;
            $("#daysRemaining").val($remaingDays);
          }else{}

          $days = $("#daysToApply").val();
          $startDate = $('#startDate').val();

          //format date
          $dateValue = $startDate.split('/');
          $year = $dateValue[2];
          $month = $dateValue[0];
          $dayofWeek = $dateValue[1];
          $newDate = $month+'/'+$dayofWeek+'/'+$year;

          //format date
          $expectedReturnDate = getdate($newDate,$days);
          $("#returnDate").val($expectedReturnDate);
          $("#applyLeave").prop('disabled', false);
      }else{
        $("#applyLeave").prop('disabled', true);
        $("#daysToApply").css("border", "red solid 1px");
        $("#daysAppliedError p").html("Invalid character entered. Please provide a positive digit.");
        $("#daysRemaining").val("");
        $("#daysAppliedError").show();
      }
    }else{
      $("#applyLeave").prop('disabled', true);
      $("#daysToApply").css("border", "red solid 1px");
      $("#daysAppliedError p").html("Invalid character entered. Please provide a positive digit.");
      $("#daysRemaining").val("");
      $("#daysAppliedError").show();
      // console.log("data is not an integer"+$daysApplied);
    }
  });

  $("#daysToApply").keyup(function(){
    $daysApplied = parseInt($("#daysToApply").val());
    $availableDays = parseInt($("#daysAvaliable").val());
    
    if($daysApplied === parseInt($daysApplied, 10)){
      // console.log("data is integer");
      if($daysApplied > 0){
          $("#daysAppliedError").hide();
          $("#daysToApply").css("border", "1px solid #ccc");
          if($availableDays < $daysApplied){
            alert("You have "+$availableDays+" leave days only.");
            $("#daysToApply").val("");
            $("#daysRemaining").val("");
          }else if($availableDays > $daysApplied){
            $remaingDays = $availableDays - $daysApplied;
            $("#daysRemaining").val($remaingDays);
          }else if($daysApplied == $availableDays){
            $remaingDays = $availableDays - $daysApplied;
            $("#daysRemaining").val($remaingDays);
          }else{}

          $days = $("#daysToApply").val();
          $startDate = $('#startDate').val();

          //format date
          $dateValue = $startDate.split('/');
          $year = $dateValue[2];
          $month = $dateValue[0];
          $dayofWeek = $dateValue[1];
          $newDate = $month+'/'+$dayofWeek+'/'+$year;

          //format date
          $expectedReturnDate = getdate($newDate,$days);
          $("#returnDate").val($expectedReturnDate);
          $("#applyLeave").prop('disabled', false);
      }else{
        $("#applyLeave").prop('disabled', true);
        $("#daysToApply").css("border", "red solid 1px");
        $("#daysAppliedError p").html("Invalid character entered. Please provide a positive digit.");
        $("#daysRemaining").val("");
        $("#daysAppliedError").show();
      }
    }else{
      $("#applyLeave").prop('disabled', true);
      $("#daysToApply").css("border", "red solid 1px");
      $("#daysAppliedError p").html("Invalid character entered. Please provide a positive digit.");
      $("#daysRemaining").val("");
      $("#daysAppliedError").show();
      // console.log("data is not an integer"+$daysApplied);
    }
  });
  //populate remaing days field


$("#applyLeave").click(function(e){
    e.preventDefault();
    $daysRemaining = $("#daysRemaining").val();
    $daysToApply = $("#daysToApply").val();

    if($daysRemaining == "" || $daysRemaining == undefined || $daysRemaining == null || $daysToApply == null || $daysToApply == undefined || $daysToApply == ""){
      $("#loginSuccessBox p").html("Complete the application form.");
      hideLoginSuccessBox();
    }else{
        $(".overlay").show();
        $startDate = $('#startDate').val();
        $daysNID = $('#absenceReason').val();

        $daysNID = $daysNID.split("k"); 
        $leaveTypeID = $daysNID[1]; 

        $daysAvaliable = $('#daysAvaliable').val();
        $daysToApply = $('#daysToApply').val();
        $daysRemaining = $('#daysRemaining').val();
        $returnDate = $('#returnDate').val();
        // $comment = $('#comment').val();

        //format start date
        $dateValue = $startDate.split('/');
        $year = $dateValue[2];
        $month = $dateValue[0];
        $dayofWeek = $dateValue[1];
        $startDate = $year+'/'+$month+'/'+$dayofWeek;
        //format start date
        
        //format end date
        $dateValue = $returnDate.split('/');
        $year = $dateValue[2];
        $month = $dateValue[1];
        $dayofWeek = $dateValue[0];
        $endDate = $year+'/'+$month+'/'+$dayofWeek;
        //format end date

        $confirm = confirm("Are your sure");

        if($confirm == true){
          $.post($applyLeaveUrl,{"startDate":$startDate, "returnDate":$endDate,"absenceReason":$leaveTypeID, "daysApplied":$daysToApply, "daysAvaliable":$daysAvaliable},function(data, status){
            console.log(data);
            $resp = JSON.parse(data);
            $status =$resp['status'];
            if($status == 0){
              $(".overlay").hide();
              $message = $resp['message'];
              $("#loginSuccessBox p").html($resp['message']);
              hideLoginSuccessBox();

              $("#startDate").val("");
              $("#absenceReason").val("");
              $("#daysAvaliable").val("");
              $("#daysToApply").val("");
              $("#daysRemaining").val("");
            }else{
              $(".overlay").hide();
              $message = $resp['message'];
              $("#loginerrorBox p").html($resp['message']);
              hideLoginErrorBox();
            }
          });
        }else{
          $(".overlay").hide();
        }
    }
});
//apply leave
});
