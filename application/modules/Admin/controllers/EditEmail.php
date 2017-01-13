<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class editEmail extends MX_Controller {

	public function index()
	{	
		// echo "<pre>";
		// print_r($this->session->userdata);die;

		$this->$this->isAdminLoggedIN();

		$data['content_view'] = "admin/edit_email_v";
		$this->load->view('template/template_v.php',$data);

	}

	public function logoutHome(){
		$this->logout();
	}


	public function getUniqueEmailTemplate($emailID){
		if($emailID == null || $emailID == undefined){
			$data['emailTemplates'] = $this->getEmailTemplates();
			$data['content_view'] = "admin/admin_dash_v";
			$this->load->view('template/template_v.php',$data);
		}else{
			$result = $this->getSpecificEmailTemplate($emailID);

			$data['content_view'] = "admin/edit_email_v";
			$data['specificEmailTemplate'] = $result;
			$this->load->view('template/template_v.php',$data);
		}
	}

	public function getUniqueEmailTemplateForDisplay(){
		$emailID = $_POST['emailID'];
		$result = $this->getSpecificEmailTemplate($emailID);
		
		echo $result;
	}


	public function updateSpecifiEmailTemplate(){
		$emailContent = trim($_POST['emailContent']," ");	
		$emailSubject = trim($_POST['newSubject'], " ");
		$emailID = $_POST['emailID'];
		$emailFooter = trim($_POST['emailFooter']," ");

		
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
			        'action' => 'UPDATESPECIFICEMAILTEMPLATE',
			        'emailID' =>$emailID,
			        'subject'=> $emailSubject,
			        'emailContent'=> $emailContent,
			        'emailFooter' =>$emailFooter
			    )
			));
			$result = curl_exec($curl);
			curl_close($curl);
		}
		echo($result);
	}
}