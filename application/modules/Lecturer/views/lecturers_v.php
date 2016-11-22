<div class = "row">
	<div class="col-md-12">
		<div class = "box box-success with-border">
			<div class="box-header">
				<h2 class = "box-title">Lecturers</h2>
			</div>
			<div class="box-body">
				<div class = "row">
					<div class = "col-md-12">
						<div class = "pull-right">
							<a href="<?= @base_url('Lecturer/addLecturer');  ?>" class = "btn btn-success"><i class = "fa fa-credit-card"></i> Add Lecturer</a>
						</div>
					</div>
				</div>
				<table class = "table table-bordered datatable">
					<thead>
						<th>Lecturer No.</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone Number</th>
						<th>Email Address</th>
						<th>Actions</th>
					</thead>
					<tbody>
						<?= @$lecturers_table; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>