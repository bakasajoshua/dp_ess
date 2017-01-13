<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MX_Controller {

	public function index()
	{	
		// echo "<pre>";
		// print_r($this->session->userdata);die;

		// $this->isLoggedIN();

		// $data['pendingRequests'] = $this->getPendingRequests();
		// $data['content_view'] = "Home/test_v";
		$this->load->view("Home/test_v");

	}

	public function logoutHome(){
		$this->logout();
	}
}