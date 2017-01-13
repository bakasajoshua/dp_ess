<html>
	<head>

		<link href="<?php echo base_url('assets/myplugins/bootstrap.min.css'); ?>" rel="stylesheet">
		<!-- <link href="<?php echo base_url('assets/myplugins/'); ?>" rel="stylesheet"> -->
	</head>
	<body>
		<input id="startDate" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
	</body>

	<script src="<?php echo base_url('assets/myplugins/jquery.min.js'); ?>" ></script> 
	<script src="<?php echo base_url('assets/js/moment/moment.js'); ?>" ></script>
	<script src="<?php echo base_url('assets/js/datepicker/daterangepicker.js'); ?>" ></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	
	<script>
	$(document).ready(function(){
		//Apply for Leave JS
		  $('#startDate').daterangepicker({
		    singleDatePicker: true,
		    locale: {
	            format: 'YYY/MMM/DD'
	        },
		    calender_style: "picker_4",
		    minDate: new Date(),
		    isInvalidDate: function(date) {
		      return (date.day() == 0 || date.day() == 6);
		    },
		  }, function(start, end, label) {
		    //console.log(start.toISOString(), end.toISOString(), label);
		  });
		  //Apply for Leave JS
	});
	</script>
</html>