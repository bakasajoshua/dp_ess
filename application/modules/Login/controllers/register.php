<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MX_Controller {

	public function index()
	{	
		// $this->load->view("Login/login_v");
		$data['content_view'] = "Login/register_v";
		$this->load->view('template/loginTemplate_v.php',$data);
	}

	public function registerUser(){
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$personID = $_POST['navCode'];
		$pass = sha1($pass);

		$existenceInNav = $this->checkUniqueUserNAV($personID);
    	$existenceInNav = json_decode($existenceInNav);
    	// print_r($existenceInNav);die;
    	$userexistenceInNav = $existenceInNav[0]->ResponseID;
    	$userEmail = $existenceInNav[0]->Email;

    	$existenceINESSDB = $this->checkExistenceInESSDB($personID);
    	$existenceINESSDB = json_decode($existenceINESSDB);

    	foreach ($existenceINESSDB as $key => $value) {
			$result = (array)$value;
			$existenceINESSDB = $result["ResponseID"];
		}
		if($userexistenceInNav != 0){
			$response['message'] = "You're ID is not recognized by the system.";
			$response['status'] = '1';
		}else if($existenceINESSDB == 0){
			$response['message'] = "You are a registered user. Proceed to Login.";
			$response['status'] = '0';
		}else if(strcasecmp("email not available",$userEmail) == 0){
			$response['message'] = "The system does not have your email address. <br/> Can't complete registration.";
			$response['status'] = '2';
		}else{
			$firstTimeLoiginID = mt_rand(1000,1000000);
    		// Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => navInterfaceURL,
			    CURLOPT_USERAGENT => 'ESSDP',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => array(
			        'action' => 'REGISTER_USER',
			        'essUser' =>  $user,
			        'personID' => $personID,
			        'password' => $pass,
			        'firstTimeLoiginID' => $firstTimeLoiginID
			    )
			));
			// Send the request & save response to $resp

			$result = curl_exec($curl);
			
			if($result == "Inserted"){
				$resp = $this->sendregisteremail($firstTimeLoiginID,$userEmail);
				$resp = json_decode($resp);

				$status = $resp->status;
				if($status == 0){
					$response['message'] = "Successfully Registered. An email was sent to you for account verification.";
					$response['status'] = 3;
				}else{
					$response['message'] = "Successfully Registered. An error occured while sending your verification email. <br/> Consult system admin.";
					$response['status'] = 3;
				}
			}else{
				$response = '{"message": "Registration Failed. Please try again later","status": "0"}';
			}
			// Close request to clear up some resources
			curl_close($curl);
		}
		echo json_encode($response);
	}

	public function sendregisteremail($firstTimeLoiginID,$userEmail){
		$fisttimeloginCode = $firstTimeLoiginID;
		$email = $userEmail;
		
		$FName = "KIPPRA";
		$LName = "ESS";
		$emailContent = $this->getSpecificEmailTemplate(1);//get registration email from DB
		
		$emailContent = json_decode($emailContent);
		foreach ($emailContent as $key => $value) {				
		    $row = "";
		    $i++;
		    $value = (array)$value;
		    
		    $emailID = $value['emailID'];
		    $reasonForSending = $value['reasonForSending'];
		    $emailContent = $value['emailContent'];
		    $emailContent = str_replace('"','',$emailContent);
		    $emailFooter = $value['emailFooter'];
		    $subject = $value['subject'];
		}
		
		$finalMessage = $emailContent."<br/><br/>";
		$finalMessage .= "FIRST TIME LOGIN CODE: <strong>".$fisttimeloginCode."</strong> <br/><br/>";
		$finalMessage .= $emailFooter;
		
		$From = "kipprahr@kippra.or.ke";
		$to = $email;

		$resp = $this->phpMailerSendMail($FName, $LName, $subject=$subject, $finalMessage, $From, $to);
		return $resp;
	}
}