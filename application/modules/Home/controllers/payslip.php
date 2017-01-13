<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payslip extends MX_Controller {

	public function index()
	{	
		// echo "<pre>";
		// print_r($this->session->userdata);die;
		
		//check if user is logged in
		$this->isLoggedIN();
		//check if user is logged in

		$data['pendingRequests'] = $this->getPendingRequests();
		$data['PayslipPeriods'] = $this->getPayslipPeriods();
		$data['content_view'] = "Home/payslip_v";
		$this->load->view('template/template_v.php',$data);

	}

	public function logoutHome(){
		$this->logout();
	}

	public function getPaySlip(){
		$navInterfaceURL = navInterfaceURL;
		$PersonID = $this->session->userdata("PersonID");
		$period = $_POST['startDate'];
		$this->session->set_userdata(array("payslipStartDate"=>$period));
		

		// is cURL installed yet?
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
			        'action' => 'GETPAYSLIP',
			        'PersonID' => $PersonID,
			        'period' => $period
			    )
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			// Close request to clear up some resources
			curl_close($curl);
	    }
	    // print_r($period);die;
	    echo $resp;
		//$resp = json_decode($resp);

		//return $resp;
	}

	public function downloadPayslip(){
		$navInterfaceURL = navInterfaceURL;
		$period = $this->input->post('pdfPayslipDate');//$this->session->userdata("payslipStartDate");
		if($period == null){
			$newURL = base_url('home/payslip?e=1');
			header('Location: '.$newURL);
		}else{
			$PersonID = $this->session->userdata("PersonID");
			

			// is cURL installed yet?
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
				        'action' => 'GETPAYSLIP',
				        'PersonID' => $PersonID,
				        'period' => $period
				    )
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				// Close request to clear up some resources
				curl_close($curl);
		    }

		    $resp = json_decode($resp);
			
			if(empty($resp)){
				header("Location: ".base_url('Home?error=ntgen'));
			}else{
				$DescAmount = array();
		  		$DescAmountContainer = array();

		  		foreach ($resp as $key => $value) {
					$value = (array)$value;
					$payslipSet = $value['Payslip Set'];
					$lineNo = $value['Line No'];
					$Employee1 = $value['Employee1'];
					$periodName1 = $value['Period Name1'];

					$desc = $value['Description1'];
					$ammount = $value['Amount1'];

					$period = $value['Period'];
					$title= $value['Title1'];
					$dept = $value['Department1'];
					$empBranch1 = $value['EmpBranch1'];
					$bank1 = $value['Bank1'];
					$branch1 = $value['Branch1'];
					$Account1 = $value['Account1'];
					$PIN1 = $value['PIN1'];
					$NHIF1 = $value['NHIF1'];
					$NSSF1 = $value['NSSF1'];
					$Qty1 = $value['Qty1'];
					$Rate1 = $value['Rate1'];
					$Cumm1 = $value['Cumm1'];
					$Bal1 = $value['Bal1'];
					$NetPay1 = $value['NetPay1'];
					$payrollCode = $value['Payroll Code'];

					// if(strpos($desc, '------') !== false){
					// 	//do nothing
					// }else{
						//$ammount = wordwrap($ammount , 3 , ',' , true); 
						$ammount = number_format($ammount,2);
						$DescAmount['desc'] = $desc;
						$DescAmount['amount'] = $ammount;
						array_push($DescAmountContainer,$DescAmount);
					// }
					
				}
				// echo "<pre>";
				// print_r($DescAmountContainer);
				// die;
				$emplpyeeFName = $this->session->userdata('FirstName');
				$emplpyeeLName = $this->session->userdata('LastName');
				$PersonID = $this->session->userdata("PersonID");
				$date = date("d-m-Y");
				$time = date("h:i:sa");
				$signature = $date."  ".$time;
				
				$mpdf=new mPDF('c','A4','','' , 10 , 10 , 3 , 3 , 0 , 0); 

		 		$mpdf->showImageErrors = true;
				$mpdf->SetDisplayMode('fullpage');
				$mpdf->SetHeader('Generated|'.$signature.'|Page{PAGENO}');
				
				$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
				
				$userdetails = "<div style='width:100%; height:4em;'>";
				$userdetails .= "<div style='float:left; width:48%; height:auto;'>";
				$userdetails .= "<p style='padding:0px; margin:0px;'><strong>Payslip For:</strong> ".$periodName1."</p>";
				$userdetails .= "<p style='padding:0px; margin:0px;'><strong>Employee No.:</strong> ".$PersonID."</p>";
				$userdetails .= "<p style='padding:0px; margin:0px;'><strong>Employee Name:</strong> ".$emplpyeeFName." ".$emplpyeeLName."</p>";
				$userdetails .= "<p style='padding:0px; margin:0px;'><strong>Job Title:</strong> ".$title."</p>";
				$userdetails .= "</div>";
				$userdetails .= "<div style='float:right; width:48%;'>";
				$userdetails .= "<p style='padding:0px; margin:0px;'><strong>Employee PIN:</strong> ".$PIN1."</p>";
				$userdetails .= "<p style='padding:0px; margin:0px;'><strong>NSSF:</strong> ".$NSSF1."</p>";
				$userdetails .= "<p style='padding:0px; margin:0px;'><strong>NHIF:</strong> ".$NHIF1."</p>";
				$userdetails .= "</div>";
				$userdetails .= "<hr/></div>";
				
				
				$tpayslipTable = "<table autosize='1'>";
				//header
				$tpayslipTable .= "<tr>";
				// $tpayslipTable .= "<td style='width:1em;'></td>";
				$tpayslipTable .= "<td style='width:10em;'></td>";
				// $tpayslipTable .= "<td><center>Quantity/Interest</center></td>";
				// $tpayslipTable .= "<td><center>Rate/ <br/> Repayment</center></td>";
				$tpayslipTable .= "<td style='width:10em; text-align:right;'>Amount</td>";
				// $tpayslipTable .= "<td><center>Cumulative Contribution/<br/>Total Principle to Date</center></td>";
				// $tpayslipTable .= "<td><center>Outstanding Principle<br/> to Date<center></td>";
				$tpayslipTable .= "</tr>";
				//header

				//body
				$row = "";
		    	for($i=0;$i<sizeof($DescAmountContainer); $i++){	
		    		$row .= "<tr>";
		    		// $row .= "<td>".($i+1)."</td>";
		    		$row .= "<td>".$DescAmountContainer[$i]['desc']."</td>";
		    		// $row .= "<td></td>";
		    		// $row .= "<td></td>";
		    		if($DescAmountContainer[$i]['amount'] == 0){
		    			$row .= "<td></td>";
		    		}else{
		    		$row .= "<td style='text-align:right;'>". $DescAmountContainer[$i]['amount']."</td>";
		    		}
		    		// $row .= "<td></td>";
		    		// $row .= "<td></td>";
		    		$row .= "</tr>";
		    		//echo $row;
		    	}
		    	
				//body

				$tpayslipTable = $userdetails.$tpayslipTable.$row."</table>";
				// echo "Table here";
				// echo $tpayslipTable;die;

				$mpdf->SetFooter('Generated|'.$signature.'|Page{PAGENO}');
				$mpdf->WriteHTML($tpayslipTable);
				
				$mpdf->Output();
				// $mpdf->debug = true;
				// echo "downloaded payslip";
			}
			
		}
		die;
	}

	public function getPayslipPeriods(){
		$navInterfaceURL = navInterfaceURL;
		// is cURL installed yet?
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
			        'action' => 'GETPAYSLIPPERIODS'
			    )
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			// Close request to clear up some resources
			curl_close($curl);
	    }
	    $resp = json_decode($resp);
		return $resp;
	}
}