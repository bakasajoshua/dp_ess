<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MX_Controller {

	public function index()
	{	
		// $this->load->view("Login/login_v");
		$this->load->view("Login/test_v");
	}
}