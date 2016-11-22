<div class = "row">
	<div class="col-md-12">
		<div class = "box box-success with-border">
			<div class="box-header">
				<h2 class = "box-title">Add Course</h2>
			</div>
			<div class="box-body">
				<form method="POST" action="<?= @base_url('Courses/addCourse'); ?>">
					<div class = "form-group">
						<label class = "control-label">Course Code</label>
						<input type = "text" name = "course_code" class = "form-control" />
					</div>

					<div class = "form-group">
						<label class = "control-label">Course Name</label>
						<input type = "text" name = "course_name" class = "form-control" />
					</div>

					<button class = "btn btn-primary">Add Course</button>
				</form>
			</div>
		</div>
	</div>
</div>