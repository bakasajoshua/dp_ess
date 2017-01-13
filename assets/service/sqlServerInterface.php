<?php
	// $webServiceUrl = 'http://www.essdp.com:8080/Service.svc?wsdl';
	$webServiceUrl = 'http://www.essdp2.com:8094/Service.svc?wsdl';//dev on .31
	
	if(isset($_POST['action'])){
		$action = $_POST['action'];

		if($action == "REGISTER_USER"){
			$personID = $_POST['personID'];
			$essUser = $_POST['essUser'];
			$password = $_POST['password'];
			$firstTimeLoiginID = $_POST['firstTimeLoiginID'];

			$client = new SoapClient($webServiceUrl);
			try {
				$res = $client->registerUser(array(
												"essUser"=>$essUser,
												"personID"=>$personID,
												"password"=>$password,
												'firstTimeLoiginID' => $firstTimeLoiginID
												)
											);
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "Error: {$e->faultstring}";
			}
			
			$resp = (array)$res;
			$resp = $resp["registerUserResult"];
			
			echo $resp;
		}else if($action == "LOGIN_USER"){
			$personID = $_POST['personID'];
			$essUser = $_POST['essUser'];
			$password = $_POST['password'];
			// print_r($personID." ".$essUser." ".$password);die;
			$client = new SoapClient($webServiceUrl);
			try {
				$res = $client->loginUser(array(
												"essUser"=>$essUser,
												"personID"=>$personID,
												"password"=>$password
												)
											);
				
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "Error: {$e->faultstring}";
			}
			
			$result = json_decode($res->loginUserResult);
			$response = array();
			foreach ($result as $key => $value) {
				$result = (array)$value;
				if(isset($result["Error"])){
					$response["error"] = $result["Error"];
				}else{
					//$error = "No error";
					$FirstName = $result["FirstName"];
					$MiddleName = $result["MiddleName"];
					$LastName = $result["LastName"];
					$Email = $result["Email"];
					$Nationality = $result["Nationality"];
					$DOB = $result["DOB"];
					$Title = $result["Title"];
					$Mobile = $result["Mobile"];
					$Address = $result["Address"];
					$status = $result["Status"];
					$LeaveGroupCode = $result["LeaveGroupCode"];
					$DateOfJoining = $result["DateOfJoining"];
					$ApproverPersonID = $result["ApproversID"];
					$FinalApproversID = $result["FinalApproversID"];
					$picture = $result["Picture"];

					//$response = '{"personID": '.$personID.',"username": '.$uname.'}';
					$response["FirstName"] = $FirstName;
					$response["MiddleName"] = $MiddleName;
					$response["LastName"] = $LastName;
					$response["Email"] = $Email;
					$response["Nationality"] = $Nationality;
					$response["DOB"] = $DOB;
					$response["Title"] = $Title;
					$response["Mobile"] = $Mobile;
					$response["Address"] = $Address;
					$response["status"] = $status;
					$response["LeaveGroupCode"] = $LeaveGroupCode;
					$response["DateOfJoining"] = $DateOfJoining;
					$response["ApproverPersonID"] = $ApproverPersonID;
					$response["FinalApproversID"] = $FinalApproversID;
					$response["picture"] = $picture;
				}
			}

			echo json_encode($response);
		}else if($action == "checkUniqueUserNAV"){
			$personID = $_POST["personID"];
			$client = new SoapClient($webServiceUrl);
			try {
				$res = $client->checkUniqueUserNAV(array(
												"personID"=>$personID
												)
											);
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			$result = json_decode($res->checkUniqueUserNAVResult);
			echo json_encode($result);
		}else if($action == "checkExistenceInESSDB"){
			$personID = $_POST["personID"];

			$client = new SoapClient($webServiceUrl);
			try {
				$res = $client->checkExistenceInESSDB(array(
												"personID"=>$personID
												)
											);
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			$result = json_decode($res->checkExistenceInESSDBResult);
			echo json_encode($result);
		}else if($action == "SUMBITAPPLICATION"){
			$client = new SoapClient($webServiceUrl);
			$PersonID = $_POST['PersonID'];
			$FromDate = $_POST['FromDate'];
			$ToDate = $_POST['ToDate'];
			$CauseOfAbsence = $_POST['CauseOfAbsence'];
			$NoOfDays = $_POST['NoOfDays'];
			// $Comment = $_POST['Comment'];
			$ApproverPersonID = $_POST['ApproversPersonID'];
			$FinalApproversPersonID = $_POST['FinalApproversPersonID'];
			$year = $_POST['year'];
			$daysRemaining = $_POST['daysRemaining'];
			$leaveGroupCode = $_POST['leaveGroupCode'];
			$status = $_POST['status'];
			$totalDaysApplied = $_POST['totalDaysApplied'];
			
			try {
				$res = $client->submitLeaveRequest(array(
													"PersonID"=>$PersonID,
													"FromDate" => $FromDate,
													"ToDate" => $ToDate,
													"CauseOfAbsence" => $CauseOfAbsence,
													"NoOfDays" => $NoOfDays,
													// "Comment" => $Comment,//[Comments]
													"ApproversPersonID" => $ApproverPersonID,
													"FinalApproversPersonID" => $FinalApproversPersonID,
													"Year"=> $year,
													"daysRemaining" => $daysRemaining,
													"leaveGroupCode" => $leaveGroupCode,
													"status" => $status,
													"totalDaysApplied" => $totalDaysApplied
													)
												);
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			$result = $res->submitLeaveRequestResult;
			echo $result;
		}else if($action == "GETPENDINGREQUESTS"){
			$client = new SoapClient($webServiceUrl);
			$ApproversPersonID = $_POST['PersonID'];
			try {
				$res = $client->getPendingRequests(array(
												"ApproversPersonID"=>$ApproversPersonID
												)
											);
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "{$e->faultstring}";
			}
			// print_r($res);die;
			$result = $res->getPendingRequestsResult;
			echo($result);
		}else if($action == "APPROVEREQUEST"){
			$client = new SoapClient($webServiceUrl);
			$RequestID = $_POST['RequestID'];
			$comment = $_POST['comment'];
			$status = $_POST['status'];

			try {
				$res = $client->approveRequest(array(
												"RequestID"=>$RequestID,
												"comment"=>$comment,
												"status"=>$status
												)
											);
			} catch (SoapFault $e) {
			    $res = "{$e->faultstring}";
			}
			
			$result = $res->approveRequestResult;
			echo $result;
		}else if($action == "GETUSERLEAVEAPPLICATIONS"){
			$client = new SoapClient($webServiceUrl);
			$PersonID = $_POST['PersonID'];

			try {
				$res = $client->getUserLeaveApplication(array(
												"PersonID"=>$PersonID
												)
											);
			} catch (SoapFault $e) {
			    $res = "{$e->faultstring}";
			}			
			$result = $res->getUserLeaveApplicationResult;
			echo($result);
		}else if($action == "GETPAYSLIP"){
			$client = new SoapClient($webServiceUrl);
			$PersonID = $_POST['PersonID'];
			$period = $_POST['period'];
			try {
				$res = $client->getCurrentMonthSlip(array(
												"PersonID"=> $PersonID,
												"period" => $period
												)
											);
			} catch (SoapFault $e) {
			    $res = "{$e->faultstring}";
			}
			$result = $res->getCurrentMonthSlipResult;
			echo($result);
		}else if($action == "DENYREQUEST"){
			$client = new SoapClient($webServiceUrl);
			$RequestID = $_POST['RequestID'];
			$rejectReason = $_POST['rejectReason'];

			try {
				$res = $client->denyApproval(array(
												"RequestID"=> $RequestID,
												"Comment" => $rejectReason
												)
											);
			} catch (SoapFault $e) {
			    $res = "{$e->faultstring}";
			}
			$result = $res->denyApprovalResult;
			echo($result);
		}else if($action == "GETPAYSLIPPERIODS"){
			$client = new SoapClient($webServiceUrl);			
			try {
				$res = $client->getPayslipPeriod();
			} catch (SoapFault $e) {
			    $res = "{$e->faultstring}";
			}
			$result = $res->getPayslipPeriodResult;
			echo($result);
		}else if($action == "saveTempPass"){
			$client = new SoapClient($webServiceUrl);
			$personID = $_POST['personID'];
			$tempPass = $_POST['tempPass'];

			try {
				$res = $client->saveTempPass(array(
												"PersonID"=> $personID,
												"tempPass" => $tempPass
												)
											);
				// print_r($res);die;
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "{$e->faultstring}";
			}
			// print_r($res);die;
			$result = $res->saveTempPassResult;
			echo($result);
		}else if($action == "passwordChange"){
			$personID = $_POST["personID"];
			$client = new SoapClient($webServiceUrl);
			try {
				$res = $client->checkPasswordChange(array(
												"PersonID"=>$personID
												)
											);
				//print_r($res);die;
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "Error: {$e->faultstring}";
			}
			$result = json_decode($res->checkPasswordChangeResult);
			echo json_encode($result);
		}else if($action == "CHECKRESETCODE"){
			$client = new SoapClient($webServiceUrl);
			$empNo = $_POST['empNo'];
			$resetCode = $_POST['resetCode'];
			try {
				$res = $client->checkResetPassword(array(
												"empNo"=>$empNo,
												"resetCode"=>$resetCode
												)
											);
				//print_r($res);die;
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "Error: {$e->faultstring}";
			}
			$result = json_decode($res->checkResetPasswordResult);
			echo json_encode($result);
		}else if($action == "UPDATENEWPASS"){
			$client = new SoapClient($webServiceUrl);
			$empNo = $_POST['empNo'];
			$newpass = $_POST['newpass'];
			try {
				$res = $client->updateNewPassword(array(
												"empNo"=>$empNo,
												"newpass"=>$newpass
												)
											);
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "Error: {$e->faultstring}";
			}
			
			$result = $res->updateNewPasswordResult;
			echo $result;
		}else if($action == "firstTimeLoginCheck"){
			$client = new SoapClient($webServiceUrl);
			$empNo = $_POST['empNo'];
			try {
				$res = $client->firstTimeLoginCheck(array(
												"PersonID"=>$empNo
												)
											);
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "Error: {$e->faultstring}";
			}
			echo($res->firstTimeLoginCheckResult);
		}else if($action == "FTLOGIN_USER"){
			$personID = $_POST['personID'];
			$essUser = $_POST['essUser'];
			$password = $_POST['password'];
			$ftlcode = $_POST['ftlcode'];
			
			$client = new SoapClient($webServiceUrl);
			try {
				$res = $client->ftloginUser(array(
												"essUser"=>$essUser,
												"personID"=>$personID,
												"password"=>$password,
												"ftloginCode"=>$ftlcode
												)
											);
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			
			echo json_encode($res->ftloginUserResult);			
		}else if($action == "MAKEREQUISITION"){
			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET

			// $client = new SoapClient($webServiceUrl);
			// $items = $_POST['items'];
		 //    $qty = $_POST['qty'];
		 //    $empID = $_POST['empID'];
		 //    $requestDate = $_POST['requestDate'];
		 //    $ApproverPersonID = $_POST['ApproverPersonID'];
		    
			// try {
			// 	$res = $client->makeRequisition(array(
			// 									"items"=>$items,
			// 									"qty"=>$qty,
			// 									"empID"=> $empID,
			// 									"ApproverPersonID" =>$ApproverPersonID,
			// 									"requestDate"=> $requestDate
			// 								));
			// } catch (SoapFault $e) {
			//     $res = "Error: {$e->faultstring}";
			// }
			// echo($res->makeRequisitionResult);

			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET
		}else if($action == "GETITEMLIST"){
			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET

			// $client = new SoapClient($webServiceUrl);
			// try {
			// 	$res = $client->getItemList();
			// } catch (SoapFault $e) {
			//     $res = "Error: {$e->faultstring}";
			// }
			// echo $res->getItemListResult;

			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET
		}else if($action == "GETPENDINGREQUISITIONS"){
			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET

			// $client = new SoapClient($webServiceUrl);

		 //    $PersonID = $_POST['PersonID'];
			// try {
			// 	$res = $client->getPendingRequisitions(array(
			// 									"PersonID"=>$PersonID
			// 								));
			// } catch (SoapFault $e) {
			// 	//$res = 3;
			//     $res = "Error: {$e->faultstring}";
			// }
			// // print_r($res);
			// echo($res->getPendingRequisitionsResult);

			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET
		}else if($action == "APPROVEREQUISITION"){
			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET

			// $client = new SoapClient($webServiceUrl);
			// $requestersID = $_POST['PersonID'];
			// $item = $_POST['item'];
			// $qty = $_POST['qty'];
			// $dateRequested = $_POST['dateRequested'];
			// $comment =$_POST['comment'];
			// $approvalDate = $_POST['approvalDate'];
			// $requisitionID = $_POST['requisitionID'];			        
			
			// try {
			// 	$res = $client->approveRequisition(
			// 			array(
			// 					"item"=>$item,
			// 					"qty"=>$qty,
			// 					"dateRequested"=>$dateRequested,
			// 					"requisitionID"=>$requisitionID,
			// 					"requestersID"=>$requestersID,
			// 					"comment"=>$comment,
			// 					"approvalDate"=>$approvalDate
			// 				)
			// 		);
			// } catch (SoapFault $e) {
			// 	//$res = 3;
			//     $res = "Error: {$e->faultstring}";
			// }
			// // print_r($res);
			// echo $res->approveRequisitionResult;

			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET
		}else if($action == "GETUSERREQUISITIONS"){
			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET

			// $client = new SoapClient($webServiceUrl);
			// $PersonID = $_POST['PersonID'];

			// try {
			// 	$res = $client->getUserRequisitionHistory(array(
			// 									"PersonID"=>$PersonID
			// 									)
			// 								);
			// } catch (SoapFault $e) {
			//     $res = "{$e->faultstring}";
			// }
			// $result = $res->getUserRequisitionHistoryResult;
			// echo($result);

			//THIS FUNCTION HAS NOT BEEN IMPLEMENTED YET
		}else if($action == "GETEMAILTEMPLATES"){

			$client = new SoapClient($webServiceUrl);

			try {
				$res = $client->getEmailTemplates();
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}	
			echo $res->getEmailTemplatesResult;
		}else if($action == "GETSPECIFICEMAILTEMPLATE"){
			$client = new SoapClient($webServiceUrl);
			$emailID = $_POST['emailID'];

			try {
				$res = $client->getSpecificEmailTemplate(array("emailID"=>$emailID));
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			echo $res->getSpecificEmailTemplateResult;
		}else if($action == "UPDATESPECIFICEMAILTEMPLATE"){
			$client = new SoapClient($webServiceUrl);
			$emailID = $_POST['emailID'];
			$subject = $_POST['subject'];
			$emailContent = $_POST['emailContent'];
			$emailFooter = $_POST['emailFooter'];
			
			try {
				$res = $client->updateSpecificEmailTemplate(array(
													"emailID"=>$emailID,
													"emailContent"=>$emailContent,
													"emailSubject"=>$subject,
													"emailFooter"=>$emailFooter
													));
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			echo $res->updateSpecificEmailTemplateResult;			
		}else if($action == "LOGIN_ADMIN_USER"){
			$client = new SoapClient($webServiceUrl);
			$essUser = $_POST['essUser'];
			$personID = $_POST['personID'];
			$password = $_POST['password'];

			try {
				$res = $client->loginAdmin(array(
											"essUser"=>$essUser,
											"personID"=>$personID,
											"password"=>$password
											));
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			$result = json_decode($res->loginAdminResult);

			$response = array();
			foreach ($result as $key => $value) {
				$result = (array)$value;
				if(isset($result["Error"])){
					$response["error"] = $result["Error"];
				}else{
					//$error = "No error";
					$FirstName = $result["FirstName"];
					$MiddleName = $result["MiddleName"];
					$LastName = $result["LastName"];
					$Email = $result["Email"];
					$Nationality = $result["Nationality"];
					$DOB = $result["DOB"];
					$Title = $result["Title"];
					$Mobile = $result["Mobile"];
					$Address = $result["Address"];
					$LeaveGroupCode = $result["LeaveGroupCode"];
					$DateOfJoining = $result["DateOfJoining"];
					$picture = $result["Picture"];
					$accessCode = $result['accessCode'];

					$response["FirstName"] = $FirstName;
					$response["MiddleName"] = $MiddleName;
					$response["LastName"] = $LastName;
					$response["Email"] = $Email;
					$response["Nationality"] = $Nationality;
					$response["DOB"] = $DOB;
					$response["Title"] = $Title;
					$response["Mobile"] = $Mobile;
					$response["Address"] = $Address;
					$response["LeaveGroupCode"] = $LeaveGroupCode;
					$response["DateOfJoining"] = $DateOfJoining;
					$response["picture"] = $picture;
					$response["accessCode"] = $accessCode;
				}
			}

			echo json_encode($response);
		}else if($action == "GETENTITLEMENTS"){
			$client = new SoapClient($webServiceUrl);

			$PersonID = $_POST['PersonID'];
			$LeaveGroupCode = $_POST['LeaveGroupCode'];
			$year = date('Y');

			
			try {
				$res = $client->getEntitlements(array(
											"PersonID"=>$PersonID,
											"LeaveGroupCode"=>$LeaveGroupCode,
											"LeaveYear"=> $year
											));
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "Error: {$e->faultstring}";
			}
			echo $res->getEntitlementsResult;
		}else if($action == "GETMASTERDATA"){
			$client = new SoapClient($webServiceUrl);
			
			try {
				$res = $client->getmasterData();
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			echo($res->getmasterDataResult);
		}else if($action  == 'GETSPECIFICMASTERDATA'){
			$ID = $_POST['dataID'];
			$client = new SoapClient($webServiceUrl);
			
			try {
				$res = $client->getSpecificmasterData(array(
												'masterDataID'=>$ID
											));
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}

			echo($res->getSpecificmasterDataResult);	
		}else if($action == "GETLEAVEREQUESTFROMNAV"){
			$client = new SoapClient($webServiceUrl);
			$personID = $_POST['personID'];
			$COA = $_POST['COA'];
			
			try {
				$res = $client->getLeaveRequestFromNAV(array(
												'personID'=>$personID,
												'COA' => $COA,
												'leaveYear' => date('Y')
											));
			} catch (SoapFault $e) {
			    $res = "Error: {$e->faultstring}";
			}
			echo($res->getLeaveRequestFromNAVResult);				
		}else if($action == "GETLEAVEAPPLICATIONDETAILS"){
			$RQID = $_POST['RequestID'];
			$client = new SoapClient($webServiceUrl);
			
			try {
				$res = $client->getLeaveApplicationDetails(array(
												'RequestID'=>$RQID
											));
			} catch (SoapFault $e) {
				//$res = 3;
			    $res = "Error: {$e->faultstring}";
			}
			echo($res->getLeaveApplicationDetailsResult);		
		}else if($action == "UPDATESPECIFICMASTERDATA"){
			$datavalue = $_POST['dataValue'];
			$dataObjID = $_POST['dataObjID'];
			
			$client = new SoapClient($webServiceUrl);
			try {
				$res = $client->updateSpecificMasterData(array(
												'dataValue'=>$datavalue,
												'dataObjID'=>$dataObjID
											));
			} catch (SoapFault $e) {				
			    $res = "Error: {$e->faultstring}";
			}
			echo($res->updateSpecificMasterDataResult);		
		}else if($action == "VALIDATESTARTDATE"){
			$startDate = $_POST['startDate'];
			$personID = $_POST['PersonID'];
			$year = $_POST['Year'];
			$endDate = $_POST['endDate'];

			$client = new SoapClient($webServiceUrl);
			try {
				$res = $client->validateStartDate(array(
												'startDate'=>$startDate,
												'Year'=>$year,
												'endDate'=>$endDate,
												'PersonID'=>$personID
											));
			} catch (SoapFault $e) {				
			    $res = "Error: {$e->faultstring}";
			}
			echo ($res->validateStartDateResult);
		}else{}
	}else{
		echo "Invalid Query";
	}

?>
