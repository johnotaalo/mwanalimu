<!DOCTYPE html>
<html>
<head>
	<title>Choose Lecturer</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
</head>
<body>
	<div class = "container">
		<div class = "jumbotron">
			<div class = "page-header">
				<h1>Start Lecturer Session</h1>
			</div>
			<form method="POST" action="<?php echo base_url('Lecturer/StartLecturerSession');?>">
				<div class = "form-group">
					<label for = "lecturer" class = "control-label">Choose a Lecturer</label>
					<select name = "lecturer_id" id = "lecturers" class = "form-control"></select>
				</div>

				<button class = "btn btn-success">Start Session</button>
			</form>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#lecturers').select2({
				data	: 	<?= @$lecturersJSON; ?>
			});
		});
	</script>
</body>
</html>