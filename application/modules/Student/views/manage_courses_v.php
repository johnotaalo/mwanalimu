<div class = "box box-default">
	<div class = "box-header">
		<h3 class = "box-title">Manage Courses</h3>
	</div>
	<div class = "box-body">
		<div class = "row">
			<div class = "col-md-6">
				<h3>Student's Courses</h3>
				<table class = "table table-bordered datatable">
					<thead>
						<th>#</th>
						<th>Course Name</th>
					</thead>
					<tbody>
						<?= @$student_courses_table; ?>
					</tbody>
				</table>
			</div>
			<div class = "col-md-6">
				<h3>Enroll Student To Another Course</h3>
				<table class = "table table-bordered datatable">
					<thead>
						<th>#</th>
						<th>Course Name</th>
						<th>Enroll</th>
					</thead>
					<tbody>
						<?= @$courses_table; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>