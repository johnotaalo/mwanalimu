<div class = "box box-success">
	<div class = "box-header">
		<h3 class="box-title">
			Add a new Student
		</h3>
	</div>
	<div class="box-body">
		<form method="POST" action = "<?php echo base_url(); ?>Student/addStudent">
			<div class = "form-group">
				<label for = "student_first_name">First Name</label>
				<input type = "text" class = "form-control" name = "student_first_name" id = "student_first_name" />
			</div>

			<div class = "form-group">
				<label for = "student_last_name">Last Name</label>
				<input type = "text" class = "form-control" name = "student_last_name" id = "student_last_name" />
			</div>

			<div class = "form-group">
				<label for = "student_other_names">Other Names</label>
				<input type = "text" class = "form-control" name = "student_other_name" id = "student_other_names" />
			</div>

			<div class = "form-group">
				<label for = "student_phone_number">Phone Number</label>
				<input type = "text" class = "form-control" name = "student_phone_number" id = "student_phone_number" />
			</div>

			<div class = "form-group">
				<label for = "student_email_address">Email Address</label>
				<input type = "text" class = "form-control" name = "student_email_address" id = "student_email_address" />
			</div>
			<div class="form-group">
				<button class = "btn btn-success">Add Student</button>
			</div>
		</form>
	</div>
</div>