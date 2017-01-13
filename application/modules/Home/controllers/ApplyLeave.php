<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApplyLeave extends MX_Controller {

	public function index()
	{	
		// echo "<pre>";
		// print_r($this->session->userdata);die;

		//check if user is logged in
		$this->isLoggedIN();
		//check if user is logged in

		$data['causeOfAbsence'] = $this->getEntitlements();
		$data['pendingRequests'] = $this->getPendingRequests();
		$data['content_view'] = "Home/ApplyLeave_v";
		$this->load->view('template/template_v.php',$data);
	}
	
	public function getEntitlements(){
		$personID = $this->session->userdata('PersonID');
		$LeaveGroupCode = $this->session->userdata('LeaveGroupCode');
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
			        'action' => 'GETENTITLEMENTS',
			        'PersonID' => $personID,
			       	'LeaveGroupCode'=> $LeaveGroupCode
			    )
			));
			// Send the request & save response to $resp
			$result = curl_exec($curl);
			
			// Close request to clear up some resources
			curl_close($curl);
		}
		return(json_encode($result));
	}

	public function getHolidaysInMnD(){
		$holidaysAvailable = $this->getHolidays();
		echo $holidaysAvailable;
		// $holidaysAvailable = json_decode($holidaysAvailable);
		// print_r($holidaysAvailable[0]->holidayDate);
	}
	public function logoutHome(){
		$this->logout();
	}
}