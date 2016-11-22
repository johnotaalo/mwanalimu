<style type="text/css">
	.notes-section
	{
		padding: 20px;
	}

	.week-item
	{
		border-bottom: 1px solid grey;
		padding: 5px;
	}

	.week-item-title
	{
		font-size: 24px;
	}

	.week-item-notes
	{
		border-radius: 10px;
		border: 1px dashed grey;
		padding: 20px 15px;
	}
</style>
<div class="box box-default">
	<div class="box-header">
		<h3 class="box-title">E-Learning (<?php echo $unitDetails->unit_name; ?>)</h3>
	</div>
	<div class="box-body">
		<div class = "notes-section">
			<?= @$notes_section; ?>
		</div>
	</div>
</div>

<div class="modal" id = 'add-notes-item'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Add Item</h4>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?php echo base_url('Lecturer/addItem/' . $unitDetails->id); ?>" enctype = "multipart/form-data">
					<div class="form-group">
						<label class="control-label">Type of Item</label>
						<select class = "form-control" name = "item_type">
							<option value = "file">File</option>
							<option value = "link">Link</option>
						</select>
					</div>
					<div class="form-group">
						<label class="control-label">Item Title</label>
						<input type="text" name="item_title" class = "form-control">
					</div>
					<div class="form-group">
						<label class="control-label">Item Description</label>
						<textarea name="item_description" class = "form-control" rows = "12"></textarea>
					</div>
					<div class="form-group" id = "file">
						<label class="control-label">File..</label>
						<input type="file" name="item_file" class = "form-control">
					</div>
					<input type="hidden" name="week-id" value = "">
					<div class = "form-group" id = "url">
						<label class="control-label">Item URL</label>
						<input type="text" name="item_url" class = "form-control">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="add-item">Add Item</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#url input[name="item_url"]').attr('disabled', 'disabled');
		$('#url').hide();

		$('select[name="item_type"]').change(function(){
			value = $(this).val();
			if (value == "file"){
				$('#url input[name="item_url"]').attr('disabled', 'disabled');
				$('#url').hide();
				$('#file input[name="item_file"]').removeAttr('disabled');
				$('#file').show();
			}else{
				$('#file input[name="item_file"]').attr('disabled', 'disabled');
				$('#file').hide();
				$('#url input[name="item_url"]').removeAttr('disabled');
				$('#url').show();
			}
		});
	});
	$('.week-item-a').click(function(e){
		e.preventDefault();
		var week_id = $(this).attr('data-week-id');

		$('.modal form input[name="week-id"]').val(week_id);
		$('#add-notes-item').modal('show');
	});

	$('#add-item').click(function(){
		$('.modal form').submit();
	});
</script>