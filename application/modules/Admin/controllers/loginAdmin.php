<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginAdmin extends MX_Controller {
    public function index()
	{	
		// echo "<pre>";
		// print_r($this->session->userdata);die;

		//$this->isLoggedIN();
		$data['content_view'] = "admin/login_v";
		$this->load->view('template/loginTemplate_v.php',$data);

	}

	public function loginUser(){
		$navInterfaceURL = navInterfaceURL;
		$user = $_POST["user"];
		$personID = $_POST["personID"];
		$pass = $_POST["password"];
		$pass = sha1($pass);


		//check if password change has been done
		$tempPass = $this->checkPasswordChangeRequest($personID);
		$tempPass = json_decode($tempPass);
		$firstTimeLogin = $this->firstTimeLoginCheck($personID);
		$firstTimeLogin = json_decode($firstTimeLogin);
		$firstTimeLoginstatus = $firstTimeLogin[0];
		$firstTimeLoginstatus = $firstTimeLoginstatus->firstLogin;

		if(!empty($tempPass[0]->tempPass)){
			$response = '{"status": "2"}';
		}else if($firstTimeLoginstatus != NULL){
			$response = '{"status": "3"}';
		}else{
			//login
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
				        'action' => 'LOGIN_ADMIN_USER',
				        'essUser' =>  $user,
				        'personID' => $personID,
				        'password' => $pass
				    )
				));
				// Send the request & save response to $resp

				$result = curl_exec($curl);
				// Close request to clear up some resources
				curl_close($curl);
			}
			$result = json_decode($result);
			$result = array($result);
			if(isset($result[0]->FirstName)){
				$FirstName = $result[0]->FirstName;
				$MiddleName = $result[0]->MiddleName;
				$LastName = $result[0]->LastName;
				$Email = $result[0]->Email;
				$Nationality = $result[0]->Nationality;
				$DOB = $result[0]->DOB;
				$Title = $result[0]->Title;
				$Mobile = $result[0]->Mobile;
				$Address = $result[0]->Address;
				$LeaveGroupCode = $result[0]->LeaveGroupCode;
				// $ApprovalGroupCode = $result[0]->ApprovalGroupCode;
				$DateOfJoining = $result[0]->DateOfJoining;
				$ApproverPersonID = $result[0]->ApproverPersonID;
				$picture = $result[0]->picture;
				$accessCode = $result[0]->accessCode;

				if($accessCode == 'KA' || $accessCode == 'SA'){
					$newdata = array(
						'PersonID'=>$personID,
				        'FirstName' => $FirstName,
				        'username' => $MiddleName,
				        'LastName' => $LastName,
				        'Email'=> $Email,
				        'Nationality'=> $Nationality,
				        'DOB' => $DOB,
				        'Title' => $Title,
				        'Mobile' => $Mobile,
				        'Address' => $Address,
				        'LeaveGroupCode' => $LeaveGroupCode,
				        'ApprovalGroupCode' => $ApprovalGroupCode,
				        'DateOfJoining' => $DateOfJoining,
				        'ApproverPersonID' => $ApproverPersonID,
				        'picture' => $picture,
				        'adminlogInStatus' => TRUE
					);
					$this->session->set_userdata($newdata);	
					$response = '{"message": "Logged In","status": "0"}';
				}else{
					$response = '{"message": "You are not cleared to access this part of the system.","status": "1"}';
				}
			}else{
				$response = '{"message": "Invalid Credentials. <br/> Register using your employee ID to login.","status": "1"}';
			}
		}
		echo $response;
	}
}