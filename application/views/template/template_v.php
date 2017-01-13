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
	<nav id="menu">
		<div class="mmenu-content">
			<!-- Employee Card -->
			<div id="employee_card">
				<h2>Employee Card</h2>
				<dl>
					<dt>Name</dt>
					<dd>Kinoti</dd>
					<dt>Title</dt>
					<dd>Finance and Investment Manager</dd>
					<dt>Nationality</dt>
					<!-- <dd>Kenyan</dd>
					<dt>Age</dt>
					<dd></dd>
					<dt>Address</dt>
					<dd></dd>
					<dt>Mobile</dt>
					<dd></dd>
					<dt>Email</dt> -->
					<dd></dd>
				</dl>
			</div>
			<!-- END Employee Card -->

			<div class="clearfix">
			</div>
			<hr>

			<ul class="mm-nolistview first-level">
			<!-- DASHBOARD -->
			<?php
				if (strpos($content_view, 'index_v') !== false) {
			?>
			<a href="<?php echo base_url('home'); ?>">
				<li class="active">
					<span>
						Dashboard
					</span>
				</li>
			</a>
			<?php
				}else{
			?>
			<a href="<?php echo base_url('home'); ?>">
				<li>
					<span>
						Dashboard
						<i aria-hidden="true" class="fa fa-angle-right"></i>
					</span>
				</li>
			</a>
			<?php
				}
			?>
			<!-- DASHBOARD -->

			<!-- PAYSLIP -->
			<?php
				if (strpos($content_view, 'payslip_v') !== false) {
			?>
			<a href="<?php echo base_url('home/payslip'); ?>">
				<li class="active">
					<span>
						Payslip
					</span>
				</li>
			</a>
			<?php
				}else{
			?>
			<a href="<?php echo base_url('home/payslip'); ?>">
				<li>
					<span>
						Payslip
						<i aria-hidden="true" class="fa fa-angle-right"></i>
					</span>
				</li>
			</a>
			<?php
				}
			?>
			<!-- PAYSLIP -->
			
			<!-- LEAVE MANAGEMENT -->
			<?php
				if(strpos($content_view, 'ApplyLeave_v') !== false || strpos($content_view, 'approveLeave_v') !== false || strpos($content_view, 'history_v') !== false) {
			?>
				<a href="#">
					<li class="active">
						<span>
							<a href="#" style="color: #fff;" >Leave Management</a>
							<i aria-hidden="true" class="fa fa-angle-down"></i>
						</span>
						<ul class="Vertical mm-nolistview second-level show">
							<!-- leave history -->
							<?php 
								if(strpos($content_view, 'history_v') !== false){
							?>
								<a href="<?php echo base_url('home/history'); ?>">
									<li class="active">
										Leave History
									</li>
								</a>
							<?php
								}else{
							?>
								<a href="<?php echo base_url('home/history'); ?>">
									<li>
										Leave History
									</li>
								</a>
							<?php
								}
							?>
							<!-- leave history -->

							<!-- leave application -->
							<?php 
								if(strpos($content_view, 'ApplyLeave_v') !== false){
							?>
								<a href="<?php echo base_url('home/applyleave'); ?>">
									<li class="active">
										Leave Application
									</li>
								</a>
							<?php
								}else{
							?>
								<a href="<?php echo base_url('home/applyleave'); ?>">
									<li>
										Leave Application
									</li>
								</a>
							<?php
								}
							?>
							<!-- leave approval -->
							<?php
		                        $pendingRequests = json_decode($pendingRequests);
		                        $i = 0;
		                        foreach ($pendingRequests as $key => $value) {
		                            $value = (array)$value;
		                            $finalApproversID = $value['FinalApproversID'];
		                            $linemanagerApproversID = $value['ApproversID'];
		                            $Leavestatus = $value['status'];
		                            $personID = $this->session->userdata('PersonID');

		                            if(strcasecmp($personID, $finalApproversID) == 0){
		                                if($Leavestatus == 'PENDING FINAL APPROVAL'){
		                                    $i++;
		                                }
		                            }else if(strcasecmp($personID, $linemanagerApproversID) == 0){
		                                if($Leavestatus == 'LEAVE RECEIVED'){
		                                    $i++;
		                                }
		                            }
		                        }
		                        if($i > 0){
		                  	?>
		                      	<a href="<?php echo base_url('home/approveleave'); ?>">
									<li class="active">
										Leave Approval
									</li>
								 </a>
		                  	<?php
		                        }
		                    ?>

							<?php 
								// if(strpos($content_view, 'approveLeave_v') !== false){
							?>
							<!-- <a href="<?php echo base_url('home/approveleave'); ?>">
								<li class="active">
									Leave Approval
								</li>
							 </a>-->
							<?php
								// }else{
							?>
							<!-- <a href="<?php echo base_url('home/approveleave'); ?>">
								<li>
									Leave Approval
								</li>
							</a> -->
							<?php
								//}
							?>
						</ul>
					</li>
				</a>
			<?php 
				}else{
			?>
				<a href="#">
					<li>
						<span>
							<a href="#">Leave Management</a>
							<i aria-hidden="true" class="fa fa-angle-down"></i>
						</span>
						<ul class="Vertical mm-nolistview second-level">
							<a href="<?php echo base_url('home/history'); ?>">
								<li class="active">
									Leave History
								</li>
							</a>
							<a href="<?php echo base_url('home/applyleave'); ?>">
								<li>
									Leave Application
								</li>
							</a>
							<a href="<?php echo base_url('home/approveleave'); ?>">
								<li>
									Leave Approval
								</li>
							</a>
						</ul>
					</li>
				</a>
			<?php
				}
			?>
			<!-- LEAVE MANAGEMENT -->
			</ul>

			<hr><a id="logout" href="<?php echo base_url('login'); ?>">Logout</a>
			<p class="menu-footer">Powered by DataposIT</p>
		</div>
	</nav>

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
	
	<!-- DateJS -->
    <script src="<?php echo base_url('assets/DateJS/build/date.js'); ?>"></script>
    <!-- DateJS -->

	<!-- Calendar -->
	<!-- <script src="<?php echo base_url('assets/js/moment/moment.js');?> "></script>
    <script src="<?php echo base_url('assets/js/datepicker/daterangepicker.js');?> "></script> -->

    <script src="<?php echo base_url('assets/js/jqueryuidatepicker/jquery-ui.min.js');?> "></script>

    <!-- jQueryUI calendar -->
    <script></script>
    <!-- jQueryUI calendar -->

	<!-- Calendar -->

	<!-- Custom Scripts-->
	<script src="<?php echo base_url('assets/jqueryScripts/payslip.js');?> "></script>
	<?php	
	if(strpos($content_view, 'Home/index_v') !== false){
	?>
		<script src="<?php echo base_url('assets/jqueryScripts/dashboard.js');?> "></script>
	<?php
	}else{}
	?>	
	
	<!-- Custom Scripts-->
	<script>
		//payslip
        $getpayslipUrl = "<?php echo base_url('Home/Payslip/getPaySlip')?>";
        //payslip

        //dashboard
        $getEntitlementsURL = "<?php echo base_url('home/home/getEntitlements'); ?>";
        //dashboard

        //apply Leave
        $getHolidays = "<?php echo base_url('home/applyLeave/getHolidaysInMnD');?>";
        //apply Leave
        $empName = "<?php echo $this->session->userdata('FirstName'). " ".$this->session->userdata('LastName') ?>";

        //hide notification box
        window.hideNotificationBox = function() {
			setTimeout(function(){
				$("#error").css({"padding-top":"13px","visibility":"hidden"})
	            $("#ajaxLoader").hide();
			},6000)
		}
		//hide notification box
	</script>
</body>	
<script src="<?php echo base_url('assets/jqueryScripts/applyLeave.js'); ?>"></script>
	
</html>
