<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends MX_Controller {

	public function index()
	{	
		// echo "<pre>";
		// print_r($this->session->userdata);die;

		//check if user is logged in
		$this->isLoggedIN();
		//check if user is logged in
		
		// $data['pendingRequests'] = $this->getPendingRequests();
		$data['content_view'] = "Home/help_v";
		$this->load->view('template/template_v.php',$data);

	}

	public function logoutHome(){
		$this->logout();
	}
}