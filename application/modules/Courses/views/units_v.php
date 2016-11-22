<div class = "row">
	<div class="col-md-12">
		<div class = "box box-success with-border">
			<div class="box-header">
				<h2 class = "box-title">Units List</h2>
			</div>
			<div class="box-body">
				<div class = "row">
					<div class = "col-md-12">
						<div class = "pull-right">
							<a href="<?= @base_url('Courses/Units/addUnit');  ?>" class = "btn btn-success"><i class = "fa fa-credit-card"></i> Add Unit</a>
						</div>
					</div>
				</div>
				<table class = "table table-bordered datatable">
					<thead>
						<th>#</th>
						<th>Unit Code</th>
						<th>Unit Name</th>
						<th>Course</th>
						<th>Actions</th>
					</thead>
					<tbody>
						<?= @$units_table; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>