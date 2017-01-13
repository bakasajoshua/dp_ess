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
	<div class="overlay">
        <img src="<?php echo base_url('assets/img/ring-alt.gif');?>" style=" display:block;margin:auto; padding-top: 25%;">
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

	<?php $this->load->view($content_view); ?>
	
	<!-- jQuery -->
	<script src="<?php echo base_url('assets/js/lib/jquery.js'); ?>" type="text/javascript"></script>

	<!-- jRespond -->
	<script src="<?php echo base_url('assets/js/lib/jrespond.js'); ?>" type="text/javascript"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="<?php echo base_url('assets/js/lib/bootstrap.js'); ?>" type="text/javascript"></script>

	<!-- Redirect URLS -->
	<script>
	$(document).ready(function(){
		//hide notification box
		window.hideNotificationBox = function() {
			$("#ajaxLoader").hide();
			setTimeout(function(){
				$("#error").css({"padding-top":"50px","visibility":"hidden"})
				$("#error").html("<em></em>");
			},6000)
		}
		//hide notification box

		//hide spinner
		$(".overlay").hide();
		//hide spinner

		//validate password to ensure criteria is met
		window.validatePassword = function($password) {
        	var patt = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);

        	var res = patt.test($password);
        	return res;
    	}
    	//checks for special characters in passwords
		window.checkForSpecialCharacters = function($pass){
			$specialCharacterRegEx = new RegExp(/[$-/:-?{-~!"^_`\[\]]/);
		    $specialCharacterCheck = $specialCharacterRegEx.test($pass);
		    return $specialCharacterCheck;
		}
		//checks for special characters in passwords
    	//validate password to ensure criteria is met

		//Used on login page
		$dashboardURL = "<?php echo base_url('home'); ?>";
		//Used on login page

		//used on register page
		$rerouteToLoginUrl = "<?php echo base_url('Login') ?>";
		//used on register page
	});
	</script>
	<!-- Redirect URLS -->

	<!--CONTROLS Jquery Scripts -->	
	<script src="<?php echo base_url('assets/jqueryScripts/login.js'); ?>" type="text/javascript"></script><!--Login page-->
	<script src="<?php echo base_url('assets/jqueryScripts/register.js'); ?>" type="text/javascript"></script><!--register page-->
	<script src="<?php echo base_url('assets/jqueryScripts/adminLogin.js'); ?>" type="text/javascript"></script><!--adminLogin page-->
	<script src="<?php echo base_url('assets/jqueryScripts/forgotPassForm.js'); ?>" type="text/javascript"></script><!--forgotPass page-->
	<!--CONTROLS Jquery Scripts -->

	<!-- URL Definitions -->
	<script>
		$regiUrl = "<?php echo base_url('login/register/registerUser') ?>";
		$loginUrl = "<?php echo base_url('login/login/loginUser') ?>";
		$adminLoginUrl = "<?php echo base_url('admin/loginAdmin/loginUser') ?>";
		$adminPageRedirectURL = "<?php echo base_url('admin/adminDash') ?>";
	</script>
	<!-- URL Definitions -->
</html>
