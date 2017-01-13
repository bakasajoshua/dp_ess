<main>
	<div class="container-fluid main-content-nav">
	  	<div class="btn-group ess-split-dropdown-button-ol">
		  	<button class="btn btn-default" type="button"><a href="<?php echo base_url('home/help'); ?>" style="color:#fff; text-decoration: none;">Help</a></button>
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
					<h2>Leave Application</h2>
				</div>
				<div class="ess-panel-body" style="background-color: #f3f3f5; width: 70%; margin-left: auto; margin-right: auto;">
					<div>
						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">
								Select a leave type:
							</label>
							<div class="col-sm-9">
								<select id="sel1" class="form-control">
									<?php
		                            	$options = "";
		                                $causeOfAbsence = json_decode($causeOfAbsence);
		                                $causeOfAbsence = json_decode($causeOfAbsence);
		                                foreach ($causeOfAbsence as $key => $value) {
		                                	$value = (array)$value;
		                                  	if($value['daysAvaliable'] == NULL || $value['daysAvaliable'] == ""){
		                                    	$options .= "<option value='".$value['totalEntitlementForPayment']."k".$value['entitlementCode']."'>".$value['entitlementCode']."</option>";
		                                  	}else{
		                                      	$options .= "<option value='".$value['daysAvaliable']."k".$value['entitlementCode']."'>".$value['entitlementCode']."</option>";
		                                  	}
		                                }
		                                echo $options;
		                            ?>
								</select> 
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>

					<div>
						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">
								Start Date:
							</label>
							<div class="col-sm-9">
								<input id="startDate" placeholder="Start date" type="text" required>
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>

					<div>
						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">
								End Date:
							</label>
							<div class="col-sm-9">
								<input id="endDate" placeholder="End Date" type="text" required>
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>

					<div>
						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">
								Days Available:
							</label>
							<div class="col-sm-9">
								<input id="example_textbox4" placeholder="Days Available" type="number">
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>

					<div>
						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">
								Apply for:
							</label>
							<div class="col-sm-7">
								<input id="example_textbox4" placeholder="Apply for" type="number">
							</div>
							<label class="col-sm-2" for="example_textbox4">
								Days
							</label>
						</div>
						<div class="clearfix">
						</div>
					</div>

					<div>
						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">
								Report Back On:
							</label>
							<div class="col-sm-9">
								<input id="endDate" placeholder="Report Back On" type="text" required>
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>

					<div>
						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">
								Days Remaining:
							</label>
							<div class="col-sm-9">
								<input id="example_textbox4" placeholder="Select a start date" type="number">
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>

					<div class="ess-positive-negative-button-pair success">
						<div>
							<button class="btn btn-success" style="width: 100px" type="submit">
								Submit
							</button>
							<button class="btn btn-success" style="width: 100px" type="submit">
								Reset
							</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>