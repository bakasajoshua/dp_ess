$(document).ready(function() {

      // Breakpoints to be used with the jRespond library
      var jRes = jRespond([
            {
                  label: 'login-signup-fixed',
                  enter: 0,
                  exit: 479
            },
            {
                  label: 'wpsmall',
                  enter: 0,
                  exit: 600
            },
            {
                  label: 'handheld',
                  enter: 601,
                  exit: 767
            },{
                  label: 'tablet',
                  enter: 768,
                  exit: 979
            },{
                  label: 'laptop',
                  enter: 980,
                  exit: 1199
            },{
                  label: 'desktop',
                  enter: 1200,
                  exit: 10000
            }
      ]);

      var fixed;

      // Determine if the login and sign up panels are fixed to the bottom due to the screen size being small
      jRes.addFunc({
            breakpoint: ['login-signup-fixed'],
            enter: function(){
                  fixed = true;
            },
            exit: function(){
                  fixed = false;
            }
      });

      // Check if we are in either the login or sign up page and the panels are fixed to the bottom
      // If they are, we change the position to absolute when the soft keyboard shows up. 
      // This is due to buggy implementation of "position: fixed" by the mobile browsers
      if(($("div.login").length || $("div.sign_up").length) && (fixed)) {

            if('ontouchstart' in window) {

                  $(document)
                  .on("focus", "input", function(){

                        $("div.login").css("position", "absolute");
                        $("div.sign_up").css("position", "absolute");

                  })
                  .on("blur", "input", function(){

                        $("div.login").css();
                        $("div.sign_up").css();

                  });

            }

      }

      

      // Show scrollbar
      $(".mmenu-content").mCustomScrollbar({
            scrollbarPosition : "inside",
            scrollInertia : 400
      });

      $(".ess-table").mCustomScrollbar({
            scrollbarPosition : "inside",
            scrollInertia : 400,
            axis: "x"
      });

      // Activate the mmenu plugin with the necessary extensions
      if($("#menu").length) {

            $("#menu").mmenu({
                  classes: "custom-width",
            	"extensions" : [ "theme-dark", "widescreen", "pagedim-black", "custom-width" ],
            	"navbar" : {
            		"add" : false
            	}
            });

            var mmenu_api = $("#menu").data("mmenu");

            mmenu_api.bind("opened", function(){
            	setTimeout(function(){
            		$("#menu_icon").addClass("is-active");
            	}, 100);
            });

            mmenu_api.bind("closed", function(){
            	setTimeout(function(){
            		$("#menu_icon").removeClass("is-active");
            	}, 100);
            });

            // Allow sub menu dropdowns via arrow click
            $("i.fa-angle-up, i.fa-angle-down").on("click", function(e){

                  var subList = $(this).parentsUntil( "li.active" ).parent().find("ul.second-level");

                  $(this).toggleClass("fa-angle-up fa-angle-down");


                  subList.toggleClass("show");

            });
      }

      // Handle the file input control
      $('.ess-file-input input').each( function(){
        var $input   = $(this),
          $label   = $input.next('label'),
          labelVal = $label.html();

          // Change the text on the label to either show the filename or the number of files for multiple files
        $input.on('change', function(e){
          var fileName = '';

          if(this.files && this.files.length > 1)
            fileName = (this.getAttribute( 'data-multiple-caption') || '').replace('{count}', this.files.length);
          else if(e.target.value)
            fileName = e.target.value.split('\\').pop();

          if( fileName )
            $label.find('span').html( fileName );
          else
            $label.html(labelVal);
        });

      });

   });

/** 
* Build the doughnut chart config. This has the chart settings.
*
* @param data Array of data you want to display in the chart. Should be 2 in size.
* @param labelCW The label of the data you want on the clockwise side.
* @param labelCCW The label of the data you want on the counterclockwise side.
* @param colorCW The color you want in the chart on the clockwise side.
* @param colorCCW The color you want in the chart on the counterclockwise side.
* @param chartLabel The name of the entire chart.
* @param tooltipsEnabled Enable or disable tooltips on mouseover on the chart
*/

function buildDChartConfig(data, labelCW, labelCCW, colorCW, colorCCW, chartLabel, tooltipsEnabled) {

      if(typeof tooltipsEnabled === "undefined" || tooltipsEnabled === null) {
            tooltipsEnabled = true;
      }
      
    // Settings for the chart
        return {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: [
                        colorCW,
                        colorCCW
                    ],
                    label: chartLabel
                }],
                labels: [
                    labelCW,
                    labelCCW
                ]
            },
            options: {
                tooltips: {
                  enabled: tooltipsEnabled
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                elements: {
                    arc: {
                        borderWidth: 0
                    }
                },
                cutoutPercentage: 80
            }
        };
}

/**
* Attach the chart to the canvas specified by the selector.
*
* @param canvasSelector The CSS selector for the canvas where the doughnut chart should be drawn.
* @param chartConfig The chart settings returned by buildDChartConfig
*/
function attachChart(canvasSelector, chartConfig){
          // Get the chart's context
          var ctx = $(canvasSelector);

          // Create the Doughnut Chart
          var chart = new Chart(ctx, chartConfig);
}

/**
* Draw the inner label of the chart
*
* @param The selector pointing to the chart's inner label. This should end with .inner-text
* @param The data from the chart
*/
function attachChartInnerLabel(innerLabelSelector, data){

      $(innerLabelSelector).find("span:first-of-type").text(data[0] + data[1]);

}

/**
* Add the chart information to the "labels" on the side of the chart
*
* @param The selector pointing to the "labels" on the side of the chart. This should end with .info-wrapper
* @param  The data from the chart
*/
function attachInfo(infoSelector, data){

      $(infoSelector).find("dd:first-of-type").text(data[1]);

      $(infoSelector).find("dd:last-of-type").text(data[0]);

}