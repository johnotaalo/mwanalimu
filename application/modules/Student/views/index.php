<div class = "box box-primary">
	<div class = "box-header">
		<h3 class = "box-title">Students</h3>
		<div class="pull-right">
			<a href="<?= @base_url('Student/addStudent'); ?>" class = "btn btn-success"><i class = "fa fa-credit-card"></i> <span>Add Student</span></a>
		</div>
	</div>
	<div class = "box-body">
		<table class = "table table-bordered datatable">
			<thead>
				<th>Student No.</th>
				<th>Student Name</th>
				<th>Phone Number</th>
				<th>Email Address</th>
				<th>Actions</th>
			</thead>
			<tbody>
				<?= @$student_table; ?>
			</tbody>
		</table>
	</div>
</div>