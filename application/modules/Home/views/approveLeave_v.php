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
					<h2>Respond to Leave Requests</h2>
				</div>

				<div class="ess-panel-body">
					<div class="ess-panel">
						<div class="ess-panel-body">
							<!-- Table -->
							<div class="ess-table">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Request ID</th>
											<th>Emp ID</th>
											<th>Name</th>
											<th>Leave Type</th>
											<th>Start Date</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tr>
										<td>Banana</td>
										<td>Pineapple</td>
										<td>Peach</td>
										<td>Car</td>
										<td>Aeroplane</td>
										<td>Avocado</td>
										<td>Orange</td>
										<td data-toggle="modal" data-target="#myModal">Action</td>
									</tr>
									<tr>
										<td>Desk</td>
										<td>Chair</td>
										<td>Pencil</td>
										<td>Car</td>
										<td>Aeroplane</td>
										<td>Chalk</td>
										<td>Eraser</td>
										<td data-toggle="modal" data-target="#myModal">Action</td>
									</tr>
									<tr>
										<td>Bicycle</td>
										<td>Car</td>
										<td>Aeroplane</td>
										<td>Car</td>
										<td>Aeroplane</td>
										<td>Ship</td>
										<td>Train</td>
										<td  data-toggle="modal" data-target="#myModal">Action</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="container">
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
		    
		    	<!-- Modal content-->
		      	<div class="modal-content">
		        	<div class="modal-header">
		          		<button type="button" class="close" data-dismiss="modal">&times;</button>
		          		<h4 class="modal-title">Action</h4>
		        	</div>
		        	<div class="modal-body">
			        	<center>
			        		<p id="error" style="padding: 5% 0% 0% 0%;"><em>Error:</em> The Username or Password is incorrect.</p>
			        	</center>
		          		<div class="ess-panel-body">
			          		<div class="form-group ess-textbox-ul-left-label">
								<label class="col-sm-3" for="example_textbox4">Provide a comment (Optional):</label>
								<div class="col-sm-9">
									<textarea rows="20" cols="47" class="ess-textbox-ul" style="height: 10em; border:solid;"> </textarea>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
		        	</div>
		        	<div class="modal-footer">
		        		<!-- <button class="btn btn-success ess-button" type="submit">Respond</button> -->
		        		<div class="ess-positive-negative-button-pair success">
							<div>
								<button class="btn btn-success" style="width: 100px" type="submit">
									Approve
								</button>
								<button class="btn btn-success"  style="width: 100px" type="submit">
									Deny
								</button>
							</div>
						</div>
		        	</div>
		      	</div>
		    </div>
		</div>
		  
	</div>
</main>