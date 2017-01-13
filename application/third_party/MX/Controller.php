<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';
/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
	}
	
	public function __get($class) 
	{
		return CI::$APP->$class;
	}

	//CHECK IF USER IS LOGGED IN
	public function isLoggedIN(){
		$logInStatus = $this->session->userdata('logged_in');
		if($logInStatus == 1){//1 for true
			//prevent from seeing login page
		}else{
			//force to view login page
			$loginUrl = base_url('Login');
			header('Location: '.$loginUrl);
		}
	}	
	//CHECK IF USER IS LOGGED IN

	//CHECK IF SYSTEM ADMIN IS LOGGED IN
	public function isAdminLoggedIN(){
		$adminlogInStatus = $this->session->userdata('adminlogInStatus');
		if($adminlogInStatus == 1){//1 for true
			//prevent from seeing login page
		}else{
			//force to view login page
			$loginUrl = base_url('admin/adminLogin');
			header('Location: '.$loginUrl);
		}
	}	
	//CHECK IF SYSTEM ADMIN IS LOGGED IN

	//get system master data
	public function getmasterData(){
		if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }else{
		    // Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => navInterfaceURL,
			    CURLOPT_USERAGENT => 'ESSDP',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => array(
			        'action' => 'GETMASTERDATA'
			    )
			));
			// Send the request & save response to $resp
			$result = curl_exec($curl);
			
			// Close request to clear up some resources
			curl_close($curl);
		}
		return $result;
	}
	//get system master data

	//Checks if the person ID exists as an employee in NAV
	public function checkUniqueUserNAV($personID){
		// is cURL installed yet?
	    if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }
	    // Get cURL resource
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => navInterfaceURL,
		    CURLOPT_USERAGENT => 'ESSDP',
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => array(
		        'action' => 'checkUniqueUserNAV',
		        'personID' => $personID
		    )
		));
		// Send the request & save response to $resp
		$result = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);
		return $result;
	}
	//Checks if the person ID exists as an employee in NAV

	//get holidays for the current year
	public function getHolidays(){
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => navInterfaceURL,
		    CURLOPT_USERAGENT => 'ESSDP',
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => array(
		        'action' => 'GETHOLIDAYS',
		        'year' => date('Y')
		    )
		));
		// Send the request & save response to $resp
		$result = curl_exec($curl);
		
		// Close request to clear up some resources
		curl_close($curl);

		return $result;
	}
	//get holidays for the current year
	
	//checks if the person ID exists as a user on the ESS
	public function checkExistenceInESSDB($personID){
		// is cURL installed yet?
	    if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }
	    // Get cURL resource
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => navInterfaceURL,
		    CURLOPT_USERAGENT => 'ESSDP',
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => array(
		        'action' => 'checkExistenceInESSDB',
		        'personID' => $personID
		    )
		));
		// Send the request & save response to $resp
		$result = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);
		return $result;
	}
	//checks if the person ID exists as a user on the ESS

	public function getUserDetails($personID){
		if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }else{
		    // Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => navInterfaceURL,
			    CURLOPT_USERAGENT => 'ESSDP',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => array(
			        'action' => 'checkUniqueUserNAV',
			        'personID' => $personID
			    )
			));
			$result = curl_exec($curl);
			curl_close($curl);
		}
		$res = json_decode($result);
		// $fname = $res['FName'];
		$response['fname'] = $res[0]->FName;
		$response['lname'] = $res[0]->LName;
		$response['email'] = $res[0]->Email;
		return json_encode($response);
	}

	//get requisitions to approve
	// public function getRequisitions(){
	// 	$personID = $this->session->userdata('PersonID');

	// 	$navInterfaceURL = navInterfaceURL;
	// 	if (!function_exists('curl_init')){
	//         die('Sorry cURL is not installed!');
	//     }else{
	// 	    // Get cURL resource
	// 		$curl = curl_init();
	// 		// Set some options - we are passing in a useragent too here
	// 		curl_setopt_array($curl, array(
	// 		    CURLOPT_RETURNTRANSFER => 1,
	// 		    CURLOPT_URL => $navInterfaceURL,
	// 		    CURLOPT_USERAGENT => 'ESSDP',
	// 		    CURLOPT_POST => 1,
	// 		    CURLOPT_POSTFIELDS => array(
	// 		        'action' => 'GETPENDINGREQUISITIONS',
	// 		        'PersonID' => $personID
	// 		    )
	// 		));
	// 		// Send the request & save response to $resp
	// 		$result = curl_exec($curl);
			
	// 		// Close request to clear up some resources
	// 		curl_close($curl);
	// 	}
	// 	//print_r($result);
	// 	return $result;
	// }
	//get requisitions to approve

	// get pending request
	public function getPendingRequests(){
		$personID = $this->session->userdata('PersonID');

		if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }else{
		    // Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => navInterfaceURL,
			    CURLOPT_USERAGENT => 'ESSDP',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => array(
			        'action' => 'GETPENDINGREQUESTS',
			        'PersonID' => $personID
			    )
			));
			// Send the request & save response to $resp
			$result = curl_exec($curl);
			
			// Close request to clear up some resources
			curl_close($curl);
		}
		// print_r($result);
		return $result;
	}
	// get pending request

	//check if the user has requested for a password change
	public function checkPasswordChangeRequest($personID){
		// is cURL installed yet?
	    if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }
	    // Get cURL resource
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => navInterfaceURL,
		    CURLOPT_USERAGENT => 'ESSDP',
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => array(
		        'action' => 'passwordChange',
		        'personID' => $personID
		    )
		));
		// Send the request & save response to $resp
		$result = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);
		return $result;
	}
	//check if the user has requested for a password change

	//check if it is the users first time to login 
	public function firstTimeLoginCheck($personID){
		// is cURL installed yet?
	    if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }
	    // Get cURL resource
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => navInterfaceURL,
		    CURLOPT_USERAGENT => 'ESSDP',
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => array(
		        'action' => 'firstTimeLoginCheck',
		        'empNo' => $personID
		    )
		));
		// Send the request & save response to $resp
		$result = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);
		return $result;
	}
	//check if it is the users first time to login 

	//get a specific template
	public function getSpecificEmailTemplate($emailID){
		if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }else{
			$curl = curl_init();
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => navInterfaceURL,
			    CURLOPT_USERAGENT => 'ESSDP',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => array(
			        'action' => 'GETSPECIFICEMAILTEMPLATE',
			        'emailID' =>$emailID
			    )
			));
			$result = curl_exec($curl);
			curl_close($curl);
			return $result;
		}
	}
	//get a specific template

	//get all email templates
	public function getEmailTemplates(){
		if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }else{
			$curl = curl_init();
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => navInterfaceURL,
			    CURLOPT_USERAGENT => 'ESSDP',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => array(
			        'action' => 'GETEMAILTEMPLATES'
			    )
			));
			$result = curl_exec($curl);
			curl_close($curl);
			return $result;
		}
	}
	//get all email templates

	public function getSpecificmasterData2($ID){
		$navInterfaceURL = navInterfaceURL;
		if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }else{
		    // Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => $navInterfaceURL,
			    CURLOPT_USERAGENT => 'ESSDP',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => array(
			        'action' => 'GETSPECIFICMASTERDATA',
			        'dataID' => $ID
			    )
			));
			// Send the request & save response to $resp
			$result = curl_exec($curl);
			
			// Close request to clear up some resources
			curl_close($curl);
		}
		return $result;
	}



	//send Mail
		public function phpMailerSendMail($FName, $LName, $subject, $Message, $From, $to){
		//SMTP needs accurate times, and the PHP time zone MUST be set
		//This should be done in your php.ini, but this is how to do it if you don't have access to that
		date_default_timezone_set('Etc/UTC');

		//Create a new PHPMailer instance
		$mail = new PHPMailer;

		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;

		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';

		//Set the hostname of the mail server
		//$mail->Host = 'mail.kippra.or.ke';//within kippra domain
		$mail->Host = 'smtp.gmail.com';//used to test gmail
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		//$mail->Port = 25;
		$mail->Port = 465;

		//Set the encryption system to use - ssl (deprecated) or tls
		//$mail->SMTPSecure = 'tsl';
		$mail->SMTPSecure = 'ssl';

		//Whether to use SMTP authentication
		//$mail->SMTPAuth = false;
		$mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail
		//$mail->Username = "kipprahr@kippra.or.ke";
		$mail->Username = "kippraess@gmail.com";

		//Password to use for SMTP authentication
		//$mail->Password = "Treasury123";
		$mail->Password = "abc123**";

		//Set who the message is to be sent from
		$mail->setFrom($From, $FName." ".$LName);

		//Set an alternative reply-to address
		$mail->addReplyTo($From, $FName." ".$LName);

		//Set who the message is to be sent to
		if( is_array($to) == 1){
			$approver = $to['approver'];
			$applier = $to['applier'];
			$mail->addAddress($applier, 'NAV ESS Support');
			$mail->AddCC($approver, 'Line Manager');
		}else{
			$mail->addAddress($to, 'NAV ESS Support');
		}
		
		// if(strcasecmp($subject, "Password Reset") == 0 || strcasecmp($subject, "Successfully Registered") == 0 || strcasecmp($subject, "Employee Requisitions") == 0 ||  strcasecmp($subject, "Pending Leave Approval") == 0 || strcasecmp($subject, "Leaev Approved") == 0 ){

		// }else{
		// 	//$mail->AddCC('navsupport@dataposit.co.ke', 'NAV SUPPORT');
		// }

		//Set the subject line
		$mail->Subject = $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		// file_get_contents('contents.html'), dirname(__FILE__)
		$mail->msgHTML($Message);

		//Replace the plain text body with one created manually
		// $mail->AltBody = 'This is a plain-text message body';

		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
		    // echo "Mailer Error: " . $mail->ErrorInfo;
		    $resp['message'] = "Mailer Error: " . $mail->ErrorInfo;
		    $resp['status'] = 1;	
		} else {
		    $resp['message'] = "Mail sent";
		    $resp['status'] = 0;	
		}
		return json_encode($resp);
	}
	//send Mail


	//Logout
	public function logout(){
		$this->session->sess_destroy();
		$loginUrl = base_url('Login');
		header('Location: '.$loginUrl);
	}
	//Logout
	
}