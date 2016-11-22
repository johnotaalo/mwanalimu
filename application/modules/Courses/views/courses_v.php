<div class = "row">
	<div class = "col-md-12">
		<div class="box">
			<div class = "box-header">
				<h3 class = "box-title">Course List</h3>
			</div>
			<div class = "box-body">
				<div class = "row">
					<div class = "col-md-12">
						<div class = "pull-right">
							<a href="<?= @base_url('Courses/addCourse');  ?>" class = "btn btn-success"><i class = "fa fa-credit-card"></i> Add Course</a>
						</div>
					</div>
				</div>
				<span class = "clearfix"></span>
				<div class = "row">
					<div class = "col-md-12" style = "margin-top:10px;">
						<div class = "table-responsive">
							<table class = "table table-bordered datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Course Code</th>
										<th>Course Name</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php echo $courses_table; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>