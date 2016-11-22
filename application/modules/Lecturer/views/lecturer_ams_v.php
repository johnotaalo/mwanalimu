<div class="box box-default">
	<div class="box-header">
		<h3 class="box-title">AMS (<?php echo $unitDetails->unit_name; ?>)</h3>
	</div>
	<div class="box-body">
		<div class = "notes-section">
			<table class = "table table-bordered">
				<thead>
					<th>Student No.</th>
					<th>Student Name</th>
					<th>CAT 1</th>
					<th>CAT 2</th>
					<th>Assignment</th>
					<th>Group Work</th>
					<th>Edit</th>
				</thead>
				<tbody>
					<?= @$ams_table; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal" id = 'add-mark'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Add Mark</h4>
			</div>
			<div class="modal-body">
				<form method = "POST" action = "<?= @base_url('Lecturer/addStudentMark'); ?>">
					<div class="form-group">
						<label class = "label-control">Mark</label>
						<input type="text" name="student_mark" class="form-control" value = "" />
					</div>

					<input type="hidden" name = "action" />
					<input type="hidden" name="student_id" />
					<input type="hidden" name="type_id"/>
					<input type="hidden" name="unit_id" value = "<?= @$unit_id; ?>"/>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="add-mark-btn">Add Mark</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.mark-add').click(function(){
			$('#add-mark input[name="action"]').val("add");
			$('#add-mark input[name="student_id"]').val($(this).attr('data-student-id'));
			$('#add-mark input[name="type_id"]').val($(this).attr('data-type'));
			$('#add-mark').modal('show');
		});

		$('.mark-edit').click(function(){

			$('#add-mark input[name="action"]').val("edit");
			unit_id = $('#add-mark input[name="unit_id"]').val();
			student_id = $(this).attr('data-student-id');
			type = $(this).attr('data-type');

			$.get("<?= @base_url('Lecturer/getStudentMarks'); ?>" + "/" + student_id + "/" + unit_id + "/" + type, function(res){
				console.log(res.status);
				if(res.status === true)
				{
					mark = res.mark;
					$('input[name="student_mark"]').val(mark);
				}
			});
			$('#add-mark input[name="student_id"]').val($(this).attr('data-student-id'));
			$('#add-mark input[name="type_id"]').val($(this).attr('data-type'));
			$('#add-mark').modal('show');
		});

		$('#add-mark-btn').click(function(){
			$('#add-mark form').submit();
		});
	});
</script>