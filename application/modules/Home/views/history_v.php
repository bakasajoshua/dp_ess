<main>
	<div class="container-fluid main-content-nav">
	  	<div class="btn-group ess-split-dropdown-button-ol">
		  	<button class="btn btn-default" type="button"><a href="<?php echo base_url('home/help'); ?>" style="color:#fff; text-decoration: none;">Actions</a></button>
		  	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
		  	<span class="caret"></span></button>
		  	<ul class="dropdown-menu dropdown-menu-right">
		  		<a href="<?php echo base_url('home/help'); ?>" style="text-decoration: none;">
				  	<li>Help</li>
				</a>
				<a href="<?php echo base_url('home/logoutHome'); ?>" style="text-decoration: none;">
				  	<li><i class="fa fa-handshake"></i>Logout</li>
				</a>
			</ul>
		</div>
	</div>
	<div class="clearfix">
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="ess-panel">
				<div class="ess-panel-header">
					<h2>Leave History</h2>
				</div>

				<div class="ess-panel">
						<div class="ess-panel-body">
							<!-- Table -->
							<div class="ess-table">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
                                              <th>Leave Type</th>
                                              <th>Days Applied</th>
                                              <th>Start Date</th>
                                              <th>End Date</th>
                                              <th>Request Status</th>
                                              <th>Comment</th>
										</tr>
									</thead>
									<tbody>
									<?php
                                        function split_on($string, $num) {
                                            $length = strlen($string);
                                            $output[0] = substr($string, 0, $num);
                                            $output[1] = substr($string, $num, $length );
                                            return $output;
                                        }
                                        $i = 0;
                                        $userLeaveApplications = json_decode($userLeaveApplications);
                                        // print_r($userLeaveApplications);die;
                                        // pendingRequests
                                        foreach ($userLeaveApplications as $key => $value){
                                            $row = "";
                                            $value = (array)$value;
                                            $i++;
                                            //format to date
                                            $to = str_replace("/","",$value['ToDate']);
                                            $to = substr($to, 0, strpos($to, " "));

                                            if(strlen($to) == 7){
                                                $to = str_split($to,2);
                                                $month = $to[0];
                                                $day = str_split($to[1],1);
                                                $actualday = $day[0];
                                                $year = $day[1]."".$to[2]."".$to[3];
                                                $humanReadableToDate = $actualday."-".$month."-".$year;
                                            }else{
                                                $year = substr($to,4,5);
                                                $day = substr($to,2,2);
                                                $month = substr($to,0,2);
                                                $humanReadableToDate = $day."-".$month."-".$year;
                                            }
                                            //format to date
                                            //format from date
                                            $from = str_replace("/","",$value['FromDate']);
                                            $from = substr($from, 0, strpos($from, " "));
                                            if(strlen($from) == 7){
                                                $From = str_split($from,2);
                                                $month = $From[0];
                                                $day = str_split($From[1],1);
                                                $actualday = $day[0];
                                                $year = $day[1]."".$From[2]."".$From[3];
                                                $humanReadableFromDate = $actualday."-".$month."-".$year;
                                            }else{
                                                $year = substr($from,4,5);
                                                $month = substr($from,2,2);
                                                $day = substr($from,0,2);
                                                $humanReadableFromDate = $day."-".$month."-".$year;
                                            }
                                            //format from date

                                            $row .= "<tr>";
                                            $row .= "<td scope='row'>".$i."</td>";
                                            $row .= "<td>".$value['AbsenceCode']."</td>";
                                            $row .= "<td>".$value['AbsentDaysApplied']."</td>";
                                            $row .= "<td>".$humanReadableFromDate."</td>";
                                            $row .= "<td>".$humanReadableToDate."</td>";
                                            $row .= "<td>".$value['status']."</td>";
                                            if($value['Comment'] == ""){
                                                $row .= "<td>Awaiting response</td>";
                                            }else{
                                                $row .= "<td>".$value['Comment']."</td>";
                                            }
                                            $row .= "</tr>";
                                            echo $row;
                                        }
                                    ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
</main>