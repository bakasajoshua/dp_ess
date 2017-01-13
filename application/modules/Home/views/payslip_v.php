<main>
	<div class="container-fluid main-content-nav">
	  	<div class="btn-group ess-split-dropdown-button-ol">
		  	<button class="btn btn-default" type="button"><a href="<?php echo base_url('home/help'); ?>" style="color:#fff; text-decoration: none;">Actions</a></button>
		  	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
		  	<span class="caret"></span></button>
		  	<ul class="dropdown-menu dropdown-menu-right">
		  		<a href="<?php echo base_url('home/help'); ?>" style="text-decoration: none;">
				  	<li><i class="fa fa-handshake"></i>Help</li>
				</a>
				<a href="<?php echo base_url('home/help'); ?>" style="text-decoration: none;">
				  	<li><i class="fa fa-download"></i> Download PDF</li>
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
					<h2>Payslip</h2>
				</div>

				<!-- <div id="emplyeepayslipDetails">
				</div> -->
				<div class="ess-panel-body">
					<center> 
						<div id="error" style="padding:0%;">
							<em style="padding:0%;">Error:</em>
							<p style="padding: 0%">The Username or Password is incorrect.</p>
						</div>
					</center>
					<select id="payslipStartdate" class="form-control">
						<option>Select a Period</option>
	                    <?php
	                        $option = "";
	                        foreach ($PayslipPeriods as $key => $value) {
	                          $value = (array)$value;
	                          $option =  "<option>".$value['Period']."</option>";
	                          echo $option;
	                        }
	                    ?>
					</select> 
					<div id="emplyeepayslipDetails">
						<div id="my-ordered-list-panel" class="ess-full-colour-panel col-sm-5" style="margin-left: 5%;">
							<span id="employeeName">Period: September 2016</span>
							<ul>
								<li id="employeeID">Employee ID: KP/003</li>
								<li id="empoyeeTitle">Job Title: Developer</li>
								<li id="employeeBank">Bank: Co-op</li>
								<li id="employeeBranch">Branch: Bunyala Rd</li>
							</ul>
						</div>
						<div id="my-ordered-list-panel" class="ess-full-colour-panel col-sm-5" style="margin-left: 5%;">
							<span id="period">Period: September 2016</span>
							<ul>
								<li id="employeeAccNo">Account No.: 3454435</li>
								<li id="employeeNHIF">NHIF No.: 23423</li>
								<li id="employeeNSSF">NSSF No.: 456456456</li>
								<li id="employeeKRA">KRA PIN No.: 24368SD45</li>
							</ul>
						</div>
					</div>
					<div style="clear:both; margin-bottom: 5%;"></div>
					
					<div class="ess-panel">
						<div class="ess-panel-body">
							<!-- Table -->
							<div class="ess-table" id="paySlipTable2">
							</div>
						</div>
					</div>

					<hr/>
					<form  action="<?php echo base_url('Home/Payslip/downloadPayslip'); ?>" method="POST" target="_blank">
						<input type="hidden" id="pdfPayslipDate" name="pdfPayslipDate">
                        <input type="submit" value="PDF" class="btn btn-primary pull-right" >
					</form>
					<div style="clear:both;"></div>
				</div>
			</div>
		</div>
	</div>
</main>