$(document).ready(function(){

  $.post($getEntitlementsURL,function(data, status){
    console.log(data);
    console.log(JSON.parse(data));

    $data = JSON.parse(data);

    $('#annualLeaveChart').hide();
    $('#sickLeaveChart').hide();
    // $('#offdaysChart').hide();
    $('#ParternityLeaveChart').hide();

    for($i=0; $i<$data.length; $i++){
        entitlementDescription = $data[$i]['entitlementCode'];
        $totalEntitlementForPayment = Math.ceil($data[$i]['totalEntitlementForPayment']);
        $entitlementCode = $data[$i]['entitlementCode'];
        //$entitlementForPayment = $data[$i]['entitlementForPayment'];
        $totalDaysUsed = $data[$i]['daysUsed'];
        $totalDaysAvailable = $data[$i]['daysAvaliable'];

        if($totalDaysUsed == null || $totalDaysUsed == undefined || $totalDaysUsed == ''){
          $daysRemaining = $totalEntitlementForPayment;
          $totalDaysUsed = 0;
        }else{
          $daysRemaining = $totalEntitlementForPayment  - $totalDaysUsed;
        }
        console.log("populate the circles");

        if($(".main-chart-container").length) {
            var randomScalingFactor = function() {
                return Math.round(Math.random() * 100);
            };
        }

      // show scrollbar
      $("#chat-panel ul").mCustomScrollbar({
            scrollbarPosition : "inside",
            scrollInertia : 400
      });

      $('[data-toggle="popover').popover();
      $(".progress-bar").width("37" + '%');

        if(entitlementDescription == 'SICK'){  
            var miniChartData1 = [
                $totalDaysUsed,
                $daysRemaining
            ];
            var miniChartConfig1 = buildDChartConfig(miniChartData1, 
                        "Days Remaining", 
                        "Days Taken", 
                        "#f13e39",
                        "#a2130c",
                        entitlementDescription+" Leave",
                         false);
            attachChart("div.mini-chart-container:nth-of-type(1) canvas", miniChartConfig1);
            attachChartInnerLabel(".mini-chart-container:nth-of-type(1) .inner-text", miniChartData1);
            attachInfo(".mini-chart-container:nth-of-type(1) div.info-wrapper", miniChartData1);
        }else if(entitlementDescription == 'ANNUAL'){
            var mainChartData = [
                        $totalDaysUsed,
                        $daysRemaining
                    ];
            var mainChartConfig = buildDChartConfig(mainChartData, 
                        "Days Remaining", 
                        "Days Taken", 
                        "#8dc73f", 
                        "#056839", 
                        entitlementDescription+" Leave");
            attachChart(".main-chart-container canvas", mainChartConfig);
            attachChartInnerLabel(".main-chart-container .inner-text", mainChartData);
            attachInfo(".main-chart-container div.info-wrapper", mainChartData);
        }else if(entitlementDescription == 'PATERNITY' || entitlementDescription == 'MATERNITY'){
            var miniChartData3 = [
                $totalDaysUsed,
                $daysRemaining
            ];
            var miniChartConfig3 = buildDChartConfig(miniChartData3, 
                        "Days Remaining", 
                        "Days Taken", 
                        "#8dc73f", 
                        "#056839", 
                        entitlementDescription+" Leave",
                         false);
            attachChart("div.mini-chart-container:nth-of-type(3) canvas", miniChartConfig3);
            attachChartInnerLabel(".mini-chart-container:nth-of-type(3) .inner-text", miniChartData3);
            attachInfo(".mini-chart-container:nth-of-type(3) div.info-wrapper", miniChartData3);
        }else{
          console.log("Not sick");
        }

        // if(entitlementDescription == 'SICK'){    
        //     $("#sickLeaveChart h2").html("Total: "+$totalEntitlementForPayment+" days");
        //     $("#sickLeaveChart span").html(entitlementDescription+" Leave");
        //     $('#sickLeaveChart').show();

        //     if($totalDaysUsed == 0){
        //       Morris.Donut({
        //         element: 'graph_donut3',
        //         data: [
        //           {label: 'Available', value: $totalEntitlementForPayment}
        //         ],
        //         colors: ['#ff0000'],
        //         formatter: function (y) {
        //           return y + " days";
        //         },
        //         resize: true
        //       });
        //     }else{
        //       Morris.Donut({
        //         element: 'graph_donut3',
        //         data: [
        //           {label: 'Used', value: $totalDaysUsed },
        //           {label: 'Available', value: $daysRemaining}
        //         ],
        //         colors: ['#ff0000', '#FF4C4C'],
        //         formatter: function (y) {
        //           return y + " days";
        //         },
        //         resize: true
        //       });
        //     }
        // }else if(entitlementDescription == 'ANNUAL'){  
        // //     $("#annualLeaveChart h2").html("Total: "+$totalEntitlementForPayment+" days");
        // //     $("#annualLeaveChart span").html(entitlementDescription+" Leave");
        // //     $('#annualLeaveChart').show();

        // //     if($totalDaysUsed == 0){
        // //         Morris.Donut({
        // //           element: 'graph_donut4',
        // //           data: [
        // //             {label: 'Available', value: $daysRemaining}
        // //           ],
        // //           colors: ['#16701c'],
        // //           formatter: function (y) {
        // //             return y + " days";
        // //           },
        // //           resize: true
        // //         });
        // //     }else{
        // //         Morris.Donut({
        // //           element: 'graph_donut4',
        // //           data: [
        // //             {label: 'Used', value: $totalDaysUsed},
        // //             {label: 'Available', value: $daysRemaining}
        // //           ],
        // //           colors: ['#16701c', '#80ed88'],
        // //           formatter: function (y) {
        // //             return y + " days";
        // //           },
        // //           resize: true
        // //         });
        // //     }
        // }else if(entitlementDescription == 'PATERNITY' || entitlementDescription == 'MATERNITY'){
        //     $("#ParternityLeaveChart h2").html("Total: "+$totalEntitlementForPayment+" days");
        //     $("#ParternityLeaveChart span").html(entitlementDescription+" Leave");
        //     $("#ParternityLeaveChart").show();

        //     if($totalDaysUsed == 0){
        //         Morris.Donut({
        //           element: 'graph_donut',
        //           data: [
        //             {label: 'Available', value: $daysRemaining}
        //           ],
        //           colors: ['#16701c'],
        //           formatter: function (y) {
        //             return y + " days";
        //           },
        //           resize: true
        //         });
        //     }else{
        //         Morris.Donut({
        //           element: 'graph_donut',
        //           data: [
        //             {label: 'Used', value: $totalDaysUsed},
        //             {label: 'Available', value: $daysRemaining}
        //           ],
        //           colors: ['#16701c', '#80ed88'],
        //           formatter: function (y) {
        //             return y + " days";
        //           },
        //           resize: true
        //         });
        //     }
        // }else{
        //     console.log("not sick");
        // }          
    }

    //get all entitlements
      //PersonID
      //LeaveGroupCode
    //get days used and available for each entitlement


  });
});