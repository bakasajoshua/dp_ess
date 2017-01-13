<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class forgotpass extends MX_Controller {

	public function index()
	{	
		$data['content_view'] = "Login/forgotpass";
		$this->load->view('template/loginTemplate_v.php',$data);

	}

	public function logoutHome(){
		$this->logout();
	}
}