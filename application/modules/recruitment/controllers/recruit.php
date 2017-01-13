<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruit extends MX_Controller {

	public function index()
	{	
		// echo "<pre>";
		// print_r($this->session->userdata);die;

		//$this->isLoggedIN();
		$data['content_view'] = "recruitment/recruit_v";
		$this->load->view('template/publicTemplate_v.php',$data);

	}
}