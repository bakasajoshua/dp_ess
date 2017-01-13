<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adminDash extends MX_Controller {

	public function index()
	{	
		// echo "<pre>";
		// print_r($this->session->userdata);die;
		$this->isAdminLoggedIN();
		$data['emailTemplates'] = $this->getEmailTemplates();
		// $data['holidays'] = $this->getHolidays();
		$data['content_view'] = "admin/admin_dash_v";
		// $data['content_view'] = "template/adminTemplate_v.php";
		$this->load->view('template/adminTemplate_v.php',$data);

	}

	public function logoutHome(){
		$this->logout();
	}
}