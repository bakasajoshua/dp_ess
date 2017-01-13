<!DOCTYPE html>
<html class="full" lang="en">
	<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the style.css file. -->

	<head>

	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>KIPPRA ESS</title>

	    <!-- Bootstrap Core CSS -->
	    <link href="<?php echo base_url('assets/css/lib/bootstrap.css'); ?>" rel="stylesheet" type="text/css">

	    <!-- Open Sans font -->
	    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

	    <!-- Custom CSS -->
	    <link href="<?php echo base_url('assets/css/style.min.css'); ?>" rel="stylesheet" type="text/css">

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->

	</head>
	<div class="container">
		<div class="ess-spinning-loader">
			<div>
				Loading...
			</div>
		</div>
	</div>
	
	<div class="container">
	    <div class="row">
	        <div class="col-sm-3" id='passwordPolicy' style="background-color: #fff; display: none; position:absolute;">
	            <div class="ess-panel">
	                <div class="ess-panel-header" style="background-color: #969696;">
	                    <h4><center>Password Policy</center></h4>
	                </div>
	                <div class="ess-panel-body">
	                    <span>
	                        <center>
	                            1) At least 8 characters<br/>
	                            2) At least 1 capital letter<br/>
	                            3) At least 1 small letter<br/>
	                            4) At least 1 digit <br/>
	                        </center>
	                    </span> 
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<?php //$this->load->view("Login/register_v"); ?>

<body class="dashboard" style="padding-top: 70px; background-color: #f3f3f5; overflow: visible;">

</body>

</html>
