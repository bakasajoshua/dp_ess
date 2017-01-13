<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="" name="description">
	<meta content="" name="author">
	<title>DataposIT ESS</title>
	<!-- Bootstrap Core CSS -->
	<link href="<?php echo base_url('assets/css/lib/bootstrap.css'); ?>" rel="stylesheet" type="text/css">
	<!-- FontAwesome CSS -->
	<link href="<?php echo base_url('assets/css/lib/font-awesome.css'); ?>" rel="stylesheet" type="text/css">
	<!-- Custom Scrollbar CSS -->
	<link href="<?php echo base_url('assets/css/lib/mcustomscrollbar.css'); ?>" rel="stylesheet" type="text/css">
	<!-- Mmenu CSS -->
	<link href="<?php echo base_url('assets/css/lib/mmenu.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/lib/mmenu-themes.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/lib/mmenu-widescreen.css'); ?>" media="all and (min-width: 900px)" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/lib/mmenu-pagedim.css'); ?>" rel="stylesheet" type="text/css">
	<!-- jQueryUI calendar -->
	<link href="<?php echo base_url('assets/js/jqueryuidatepicker/jquery-ui.min.css'); ?>" rel="stylesheet" type="text/css">
	<!-- jQueryUI calendar -->
	<!--Datatables -->
	<link href="<?php echo base_url('assets/datatables/media/css/dataTables.jqueryui.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/datatables/media/css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
	<!--Datatables -->
	<!-- Custom CSS -->
	<link href="<?php echo base_url('assets/css/style.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/demo.min.css'); ?>" rel="stylesheet" type="text/css">
	<style>
        .overlay{
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 1000px;
          z-index: 10;
          background-color: rgba(0,0,0,0.5); /*dim the background*/
        }
    </style>
</head>

<body class="dashboard">

<div id="page">
	<nav id="menu">
		<div class="mmenu-content">
			<div id="employee_card">
				<h2>Admin Menu</h2>
			</div>
			<div class="clearfix">
			</div>
			
			<ul class="mm-nolistview first-level">
				<li class="active">
					<span>
						<a href="#">Email Management</a>
						<i aria-hidden="true" class="fa fa-angle-right"></i>
					</span>
				</li>
				<li>
					<span>
						<a href="#">Work Calendar</a>
						<i aria-hidden="true" class="fa fa-angle-right"></i>
					</span>
				</li>
				<li>
					<span>
						<a href="#">Master Data</a>
						<i aria-hidden="true" class="fa fa-angle-right"></i>
					</span>
				</li>
				<li>
					<span>
						<a href="<?php echo base_url('home/logoutHome'); ?>">Logout</a>
						<i aria-hidden="true" class="fa fa-angle-right"></i>
					</span>
				</li>
			</ul>
		</div>
	</nav>

	<header>
		<a id="menu_icon" href="#menu"><span class="box">
		<span class="box-inner"></span></span></a>
		<h1>KIPPRA <em>ESS Admin Panel</em></h1>
	</header>
	<div class="overlay">
	    <img src="<?php echo base_url('assets/img/ring-alt.gif');?>" style=" display:block;margin:auto; padding-top: 25%;">
	</div>
	<div class="dashboard" id="ajaxLoader" style=" position: absolute; z-index: 10000000; width:100%; height:1000px; background-color: rgba(0,0,0,0.5); display: none;">
		<div class="ess-spinning-loader" style="position: absolute; left: 46%; margin-top:25%;">
			<div style="color:#fff;">
				Loading...
			</div>
		</div>
	</div>
	<?php $this->load->view($content_view); ?>


	 </div>

	<!-- jQuery -->
	<script src="<?php echo base_url('assets/js/lib/jquery.js'); ?>" type="text/javascript"></script>
	<!-- Custom Scrollbar -->
	<script src="<?php echo base_url('assets/js/lib/mcustomscrollbar.js'); ?>" type="text/javascript"></script>
	<!-- Mmenu -->
	<script src="<?php echo base_url('assets/js/lib/mmenu.js'); ?>" type="text/javascript"></script>
	<!-- Chart.js -->
	<script src="<?php echo base_url('assets/js/lib/chart.js'); ?>" type="text/javascript"></script>
	<!-- jRespond -->
	<script src="<?php echo base_url('assets/js/lib/jrespond.js'); ?>" type="text/javascript"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="<?php echo base_url('assets/js/lib/bootstrap.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/theme.js'); ?>" type="text/javascript"></script>
	<!-- DateJS -->
    <script src="<?php echo base_url('assets/DateJS/build/date.js'); ?>"></script>
    <!-- DateJS -->
    <!--Datatables-->
	<script src="<?php echo base_url('assets/datatables/media/js/jquery.dataTables.min.js'); ?> " type="text/javascript"></script>
	<script src="<?php echo base_url('assets/datatables/media/js/dataTables.bootstrap.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/datatables/media/js/dataTables.jqueryui.min.js'); ?> " type="text/javascript"></script>
	<!--Datatables-->

	<!-- Calendar -->
	<!-- <script src="<?php echo base_url('assets/js/moment/moment.js');?> "></script>
    <script src="<?php echo base_url('assets/js/datepicker/daterangepicker.js');?> "></script> -->

    <script src="<?php echo base_url('assets/js/jqueryuidatepicker/jquery-ui.min.js');?> "></script>

	<!-- Custom Scripts-->
	<script src="<?php echo base_url('assets/jqueryScripts/admin_emailManagement.js');?> "></script>	
	<!-- Custom Scripts-->

	<script>
		//Global Admin Variable declaration
		$empName = "<?php echo $this->session->userdata('FirstName'). " ".$this->session->userdata('LastName') ?>";

		$getSpecificEmailForDisplayURL = "<?php echo base_url('admin/editEmail/getUniqueEmailTemplateForDisplay'); ?>";
		//Global Admin Variable declaration

        //hide spinner
		$(".overlay").hide();
		//hide spinner

        //hide notification box
        window.hideNotificationBox = function() {
			setTimeout(function(){
				$("#error").css({"padding-top":"13px","visibility":"hidden"})
	            $("#ajaxLoader").hide();
			},6000)
		}
		//hide notification box

		$(document).ready(function() {
		    $('#example').DataTable({
		    	"bLengthChange": false
		    });
		});
	</script>
</body>		
</html>
