<div class = "row">
	<div class="col-md-12">
		<div class = "box box-success with-border">
			<div class="box-header">
				<h2 class = "box-title">Add Unit</h2>
			</div>
			<div class="box-body">
				<form method="POST" action="<?= @base_url('Courses/Units/addUnit'); ?>">
					<div class = "form-group">
						<label class = "control-label">Unit Code</label>
						<input type = "text" name = "unit_code" class = "form-control" />
					</div>

					<div class = "form-group">
						<label class = "control-label">Unit Name</label>
						<input type = "text" name = "unit_name" class = "form-control" />
					</div>

					<div class = "form-group">
						<label class = "control-label">Course</label>
						<select name = "course_unit_id" class = "form-control">
							<?= @$courses_select; ?>
						</select>
					</div>

					<div class = "form-group">
						<label class  = "control-label">Lecturer</label>
						<select name = "lecturer_id" class = "form-control">
							<?= @$lecturers_select; ?>
						</select>
					</div>

					<button class = "btn btn-primary">Add Unit</button>
				</form>
			</div>
		</div>
	</div>
</div>