<main>
	<div class="container-fluid main-content-nav">
	  	<div class="btn-group ess-split-dropdown-button-ol">
		  	<button class="btn btn-default" type="button"><a href="<?php echo base_url('home/help'); ?>" style="color:#fff; text-decoration: none;">Actions</a></button>
		  	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
		  	<span class="caret"></span></button>
		  	<ul class="dropdown-menu dropdown-menu-right">
		  		<!-- <a href="<?php //echo base_url('home/help'); ?>" style="text-decoration: none;">
				  	<li>Help</li>
				</a> -->
				<a href="<?php echo base_url('home/logoutHome'); ?>" style="text-decoration: none;">
				  	<li><i class="fa fa-handshake"></i>Logout</li>
				</a>
			</ul>
		</div>
	</div>
	<div class="clearfix">
	</div>
	<div class="row">
		<!-- Annual Leave -->
		<div class="main-chart-container col-xs-12">
			<div class="col-sm-2">
				<div class="info-wrapper">
					<h2>Annual Leave</h2>
					<dl>
						<dt>Days Taken</dt>
						<dd></dd>
						<dt>Days Remaining</dt>
						<dd></dd>
					</dl>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="chart-wrapper">
					<canvas>
					</canvas>
					<div class="inner-text">
						<span></span><span>Days</span> </div>
				</div>
			</div>
		</div>
		<!-- END Annual Leave -->
	</div>
	<hr>

	<div class="row">
		<!-- Sick Leave -->
		<div class="mini-chart-container col-sm-4">
			<div class="col-sm-5">
				<div class="chart-wrapper">
					<canvas>
					</canvas>
					<div class="inner-text">
						<span></span><span>Days</span> </div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="info-wrapper">
					<h2>Sick Leave</h2>
					<dl>
						<dt>Days Taken</dt>
						<dd></dd>
						<dt>Days Remaining</dt>
						<dd></dd>
					</dl>
				</div>
			</div>
		</div>
		<!-- END Sick Leave -->
		<!-- Off Days -->
		<div class="mini-chart-container col-sm-4">
			<div class="col-sm-5">
				<div class="chart-wrapper">
					<canvas>
					</canvas>
					<div class="inner-text">
						<span></span><span>Days</span> </div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="info-wrapper">
					<h2>Off Days</h2>
					<dl>
						<dt>Days Taken</dt>
						<dd></dd>
						<dt>Days Remaining</dt>
						<dd></dd>
					</dl>
				</div>
			</div>
		</div>
		<!-- END Off Days -->
		<!-- Paternity Leave -->
		<div class="mini-chart-container col-sm-4">
			<div class="col-sm-5">
				<div class="chart-wrapper">
					<canvas>
					</canvas>
					<div class="inner-text">
						<span></span><span>Days</span> </div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="info-wrapper">
					<h2>Paternity Leave</h2>
					<dl>
						<dt>Days Taken</dt>
						<dd></dd>
						<dt>Days Remaining</dt>
						<dd></dd>
					</dl>
				</div>
			</div>
		</div>
		<!-- END Paternity Leave -->
	</div>
</main>
  