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
	<div class="col-sm-12">
		<div class="row" style="margin-right: auto; margin-left: auto; width: 50%;">
			<div class="ess-panel">
				<div class="ess-panel-header">
					<h2>Request for help</h2>
				</div>
				<div class="ess-panel-body" style="background-color: #f3f3f5;">
					<div>
						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">To</label>
							<div class="col-sm-9">
								<input id="example_textbox4" placeholder="samplerecepient@gmail.com" type="email">
							</div>
						</div>

						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">From:</label>
							<div class="col-sm-9">
								<input id="example_textbox4" placeholder="samplesender@gmail.com" type="email">
							</div>
						</div>

						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">Subject:</label>
							<div class="col-sm-9">
								<input id="example_textbox4" placeholder="sample subject" type="text">
							</div>
						</div>

						<div class="form-group ess-textbox-ul-left-label">
							<label class="col-sm-3" for="example_textbox4">Message:</label>
							<div class="col-sm-9">
								<textarea rows="20" cols="47" class="ess-textbox-ul" style="height: 10em;"> </textarea>
							</div>
						</div>

						<div class="ess-positive-negative-button-pair success">
							<div>
								<button class="btn btn-success" style="width: 100px" type="submit">
								<span class="glyphicon glyphicon-send"></span>
									Submit
								</button>
								<button class="btn btn-success" style="width: 100px" type="submit">
									Reset
								</button>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>

					<!-- <div>
						<h3 class="item-title"></h3>
						<textarea rows="4" cols="50" class="ess-textbox-ul"> </textarea>
					</div> -->					
				</div>
			</div>
		</div>
	</div>
</main>