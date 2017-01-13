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

	<!-- Custom CSS -->
	<link href="<?php echo base_url('assets/css/style.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/demo.min.css'); ?>" rel="stylesheet" type="text/css">
</head>

<body class="dashboard">

<div id="page">
	<header>
		<a id="menu_icon" href="#menu"><span class="box">
		<span class="box-inner"></span></span></a>
		<h1>KIPPRA <em>Employee Self Service</em></h1>
	</header>
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
	<script src="<?php echo base_url('assets/js/demo.js'); ?>" type="text/javascript"></script>
	
	<!-- DateJS -->
    <script src="<?php echo base_url('assets/DateJS/build/date.js'); ?>"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url('assets/js/jqueryuidatepicker/jquery-ui.min.js');?> "></script>
	<script>
	</script>
</body>	
</html>
