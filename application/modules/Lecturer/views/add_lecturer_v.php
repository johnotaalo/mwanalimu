<div class = "row">
	<div class="col-md-12">
		<div class = "box box-success with-border">
			<div class="box-header">
				<h2 class = "box-title">Lecturers</h2>
			</div>
			<div class="box-body">
				<form method="POST" action = "<?= @base_url('Lecturer/addLecturer'); ?>">
					<div class="form-group">
						<label class = "control-label">First Name</label>
						<input type="text" name="lecturer_firstname" class = "form-control" required/>
					</div>

					<div class="form-group">
						<label class = "control-label">Last Name</label>
						<input type="text" name="lecturer_lastname" class = "form-control" required/>
					</div>

					<div class="form-group">
						<label class = "control-label">Other Names</label>
						<input type="text" name="lecturer_othernames" class = "form-control" required/>
					</div>

					<div class="form-group">
						<label class = "control-label">Phone Number</label>
						<input type="text" name="lecturer_phonenumber" class = "form-control" required/>
					</div>

					<div class="form-group">
						<label class = "control-label">Email Address</label>
						<input type="email" name="lecturer_emailaddress" class = "form-control" required/>
					</div>

					<button class = "btn btn-success">Add Lecturer</button>
				</form>
			</div>
		</div>
	</div>
</div>