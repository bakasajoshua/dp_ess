<div class="row" style="margin-top: 3em;">
	<div id="demo-form" class="ess-full-colour-panel col-sm-6 col-sm-offset-3">
		<h2>Job Application</h2>
		<form>
			<div class="form-group ess-textbox-ul-top-label">
				<label for="example_textbox3">First name</label>
				<input id="example_textbox3" placeholder="First name (Required)" type="text">
			</div>
			<div class="form-group ess-textbox-ul-top-label">
				<label for="example_textbox3">Last name</label>
				<input id="example_textbox3" placeholder="Last name (Required)" type="text">
			</div>
			<div class="btn-group btn-group-vertical ess-radio" data-toggle="buttons" style="width: 100px;">
				<label class="btn active">
				<input checked name="gender1" type="radio"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span>&nbsp;Male</span>
				</label><label class="btn">
				<input name="gender1" type="radio"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span>&nbsp;Female</span>
				</label></div>
			<div class="form-group ess-textbox-ul-left-label">
				<label class="col-sm-3" for="example_textbox4">National ID</label>
				<div class="col-sm-9">
					<input id="example_textbox4" placeholder="National ID Number (Required)" type="email">
				</div>
				<div class="clearfix">
				</div>
			</div>
			<p class="text-left">How would you prefer to be contacted?</p>
			<div class="form-group ess-select">
				<label for="sel1">Select contact method:</label>
				<select id="sel1" class="form-control">
				<option>Email</option>
				<option>Phone number</option>
				</select> </div>
			<div class="form-group ess-textbox-ul-left-label">
				<label class="col-sm-3" for="example_textbox4">Contact Details</label>
				<div class="col-sm-9">
					<input id="example_textbox4" placeholder="Please enter contact details">
				</div>
				<div class="clearfix">
				</div>
			</div>
			<div class="ess-file-input text-center">
				<input id="cv" data-multiple-caption="{count} files selected" multiple name="file" type="file" />
				<label for="cv"><span>Upload your CV</span></label> </div>
			<p>Complete application?</p>
			<div class="ess-positive-negative-button-pair primary">
				<div>
					<button class="btn btn-primary" style="width: 70px" type="submit">
					Yes</button>
					<button class="btn btn-primary" style="width: 70px" type="submit">
					No</button></div>
			</div>
		</form>
	</div>
</div>