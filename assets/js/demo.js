$(document).ready(function(){

       if($(".main-chart-container").length) {
    // Chart.js data for demo purposes

        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
        };

        var mainChartData = [
                        randomScalingFactor(),
                        randomScalingFactor()
                    ];

        var mainChartConfig = buildDChartConfig(mainChartData, 
                    "Days Remaining", 
                    "Days Taken", 
                    "#8dc73f", 
                    "#056839", 
                    "Annual Leave");

        attachChart(".main-chart-container canvas", mainChartConfig);

        attachChartInnerLabel(".main-chart-container .inner-text", mainChartData);

        attachInfo(".main-chart-container div.info-wrapper", mainChartData);

        // Sick Leave
        var miniChartData1 = [
                        randomScalingFactor(),
                        randomScalingFactor()
                    ];

        var miniChartConfig1 = buildDChartConfig(miniChartData1, 
                    "Days Remaining", 
                    "Days Taken", 
                    "#8dc73f", 
                    "#056839", 
                    "Sick Leave",
                     false);

        attachChart("div.mini-chart-container:nth-of-type(1) canvas", miniChartConfig1);

        attachChartInnerLabel(".mini-chart-container:nth-of-type(1) .inner-text", miniChartData1);

        attachInfo(".mini-chart-container:nth-of-type(1) div.info-wrapper", miniChartData1);

        // Off Days 

        var miniChartData2 = [
                        randomScalingFactor(),
                        randomScalingFactor()
                    ];

        var miniChartConfig2 = buildDChartConfig(miniChartData2, 
                    "Days Remaining", 
                    "Days Taken", 
                    "#f13e39",
                    "#a2130c",
                    "Off Days",
                     false);

        attachChart("div.mini-chart-container:nth-of-type(2) canvas", miniChartConfig2);

        attachChartInnerLabel(".mini-chart-container:nth-of-type(2) .inner-text", miniChartData2);

        attachInfo(".mini-chart-container:nth-of-type(2) div.info-wrapper", miniChartData2);


        // Paternity Leave

        var miniChartData3 = [
                        randomScalingFactor(),
                        randomScalingFactor()
                    ];

        var miniChartConfig3 = buildDChartConfig(miniChartData3, 
                    "Days Remaining", 
                    "Days Taken", 
                    "#8dc73f", 
                    "#056839", 
                    "Paternity Leave",
                     false);

        attachChart("div.mini-chart-container:nth-of-type(3) canvas", miniChartConfig3);

        attachChartInnerLabel(".mini-chart-container:nth-of-type(3) .inner-text", miniChartData3);

        attachInfo(".mini-chart-container:nth-of-type(3) div.info-wrapper", miniChartData3);


      }

      // show scrollbar
      $("#chat-panel ul").mCustomScrollbar({
            scrollbarPosition : "inside",
            scrollInertia : 400
      });

      $('[data-toggle="popover').popover();
      $(".progress-bar").width("37" + '%');

});
