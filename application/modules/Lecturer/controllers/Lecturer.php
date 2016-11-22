<?php

class Lecturer extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Lecturer');
	}

	function index()
	{
		$data['lecturers_table'] = $this->createLecturersTable();
		$this->template->page_title = 'Lecturers';
		$this->template->page_description = "Manages your Lecturers";
		$this->template->content_view = 'Lecturer/lecturers_v';

		$this->template->call_admin_template($data);
	}

	function createLecturersTable()
	{
		$lecturers = $this->M_Lecturer->findLecturers();

		$lecturers_table = "";

		if ($lecturers) {
			foreach ($lecturers as $lecturer) {
				$lecturers_table .= "<tr>";
				$lecturers_table .= "<td>{$lecturer->lecturer_no}</td>";
				$lecturers_table .= "<td>{$lecturer->lecturer_firstname}</td>";
				$lecturers_table .= "<td>{$lecturer->lecturer_lastname}</td>";
				$lecturers_table .= "<td>{$lecturer->lecturer_phonenumber}</td>";
				$lecturers_table .= "<td>{$lecturer->lecturer_emailaddress}</td>";
				$lecturers_table .= "<td></td>";
				$lecturers_table .= "</tr>";
			}
		}

		return $lecturers_table;
	}

	function addLecturer(){
		if ($this->input->post()) {
			$insert_data['lecturer_no']				=	$this->createLecturerNumber();
			$insert_data['lecturer_firstname']		=	$this->input->post('lecturer_firstname');
			$insert_data['lecturer_lastname']		=	$this->input->post('lecturer_lastname');
			$insert_data['lecturer_othernames']		=	$this->input->post('lecturer_othernames');
			$insert_data['lecturer_phonenumber']	=	$this->input->post('lecturer_phonenumber');
			$insert_data['lecturer_emailaddress']	=	$this->input->post('lecturer_emailaddress');

			$this->M_Lecturer->addLecturer($insert_data);

			$this->load->module('User');

			$user_data = [
				'username'	=>	$insert_data['lecturer_no'],
				'password'	=>	md5('12345'),
				'user_type'	=>	'lecturer'
			];

			$this->M_User->addUser($user_data);

			redirect(base_url() . 'Lecturer');
		}else{
			$this->template->page_title = "Add Lecturer";
			$this->template->page_description = "Add lecturers to the system";
			$this->template->content_view = "Lecturer/add_lecturer_v";
			$this->template->call_admin_template();
		}
	}

	function createLecturerNumber()
	{
		$latestNo = $this->M_Lecturer->findLatestLecturerNumber();
		$created_lecturer_number = "";
		if ($latestNo) {
			$new_number = (int)$latestNo + 1;

			$created_lecturer_number = str_pad($new_number, 5, "0", STR_PAD_LEFT);
		}
		else{
			$latest_number = 1000;
			$created_lecturer_number = str_pad($latest_number, 5, "0", STR_PAD_LEFT);
		}

		return $created_lecturer_number;
	}

	function lecturerChoose()
	{
		$data['lecturers'] = [];

		$lecturers = $this->M_Lecturer->findLecturers();

		if ($lecturers) {
			foreach ($lecturers as $lecturer) {
				$data['lecturers'][] = [
					'id'	=>	$lecturer->id,
					'text'	=>	$lecturer->lecturer_firstname . " " . $lecturer->lecturer_lastname
				];
			}
		}

		$data['lecturersJSON'] = json_encode($data['lecturers'], JSON_NUMERIC_CHECK);
		$this->load->view('Lecturer/choose_lecturer_v', $data);
	}
	function lecturerhome()
	{
		if ($this->session->userdata('lecturer_id')) {
			$lecturer_units = $this->createLecturerUnitsTable($this->session->userdata('lecturer_id'));
			$data['lecturer_units'] = $lecturer_units;
			$this->template->page_title = "ELearning";
			$this->template->page_description = "Manage notes for your units";
			$this->template->content_view = "Lecturer/lecturer_index";
			$this->template->call_lecturer_template($data);
		}else{
			redirect(base_url('Lecturer/lecturerChoose'));
		}
		
	}

	function StartLecturerSession()
	{
		$user_data = [
			'lecturer_id'	=>	$this->input->post('lecturer_id')
		];
		
		$this->session->set_userdata( $user_data );

		redirect(base_url('Lecturer/lecturerhome'));
	}

	function createLecturerUnitsTable($lecturer_id)
	{
		$units = $this->M_Lecturer->findLecturerUnits($lecturer_id);

		$lecturer_units_table = "";
		if ($units) {
			$counter = 1;
			foreach ($units as $unit) {
				$lecturer_units_table .= "<tr>";
				$lecturer_units_table .= "<td>{$counter}</td>";
				$lecturer_units_table .= "<td>{$unit->unit_name}</td>";
				$lecturer_units_table .= "<td>{$unit->course_name}</td>";
				$lecturer_units_table .= "<td><a class = 'btn btn-success btn-sm' href = '".base_url('Lecturer/elearning/' . $unit->id)."'>E-Learning</a> | <a class = 'btn btn-success btn-sm' href = '".base_url('Lecturer/ams/' . $unit->id)."'>AMS</a></td>";
				$lecturer_units_table .= "</tr>";
				$counter++;
			}
		}

		return $lecturer_units_table;
	}
	function elearning($unit_id)
	{
		$unitDetails = $this->M_Lecturer->getUnitDetails($unit_id);

		$data['unitDetails'] = $unitDetails;
		$data['notes_section'] = $this->createNotesSection($unit_id);
		$this->template->page_title = "ELearning";
		$this->template->page_description = "Manage notes for your units";
		$this->template->content_view = "Lecturer/lecturer_e_learning_v";
		$this->template->call_lecturer_template($data);
	}

	function ams($unit_id){
		$unitDetails = $this->M_Lecturer->getUnitDetails($unit_id);

		$data['unit_id'] = $unit_id;
		$data['unitDetails'] = $unitDetails;
		$data['ams_table'] = $this->createAMSTable($unit_id);
		$this->template->page_title = "AMS";
		$this->template->page_description = "Manage student marks";
		$this->template->content_view = "Lecturer/lecturer_ams_v";
		$this->template->call_lecturer_template($data);
	}

	function createAMSTable($unit_id)
	{
		$students = $this->M_Lecturer->findStudentsByUnitID($unit_id);

		$ams_table = "";
		if($students){
			foreach ($students as $student) {
				$ams_table .= "<tr>";
				$ams_table .= "<td>{$student->admission_number}</td>";
				$ams_table .= "<td>{$student->student_first_name} {$student->student_last_name}</td>";

				$student_marks = $this->M_Lecturer->findStudentMarks($student->id, $unit_id);
				if($student_marks)
				{
					$ams_table .= "<td>{$student_marks->cat_1} <a data-student-id = '{$student->id}' data-type = 'cat_1' class = 'mark-edit btn btn-warning btn-small'>Edit</a></td>";
					$ams_table .= "<td>{$student_marks->cat_2} <a data-student-id = '{$student->id}' data-type = 'cat_2' class = 'mark-edit btn btn-warning btn-small'>Edit</a></td>";
					$ams_table .= "<td>{$student_marks->assignment} <a data-student-id = '{$student->id}' data-type = 'assignment' class = 'mark-edit btn btn-warning btn-small'>Edit</a></td>";
					$ams_table .= "<td>{$student_marks->group_work} <a data-student-id = '{$student->id}' data-type = 'group_work' class = 'mark-edit btn btn-warning btn-small'>Edit</a></td>";
				}else{
					$ams_table .= "<td><a class = 'mark-add btn btn-success btn-small' data-student-id = '{$student->id}' data-type = 'cat_1'>Add</a></td>";
					$ams_table .= "<td><a class = 'mark-add btn btn-success btn-small' data-student-id = '{$student->id}' data-type = 'cat_2'>Add</a></td>";
					$ams_table .= "<td><a class = 'mark-add btn btn-success btn-small' data-student-id = '{$student->id}' data-type = 'assignment'>Add</a></td>";
					$ams_table .= "<td><a class = 'mark-add btn btn-success btn-small' data-student-id = '{$student->id}' data-type = 'group_work'>Add</a></td>";
				}
				
				$ams_table .= "<td></td>";
				$ams_table .= "</tr>";
			}
		}

		return $ams_table;
	}

	function getStudentMarks($student_id, $unit_id, $type_id)
	{
		$student_marks = $this->M_Lecturer->findStudentMarks($student_id, $unit_id);

		$response = [];
		if ($student_marks) {
			$response['status'] = true;
			$response['mark'] = $student_marks->$type_id;
		}else{
			$response['status'] = true;
			$response['mark'] = "";
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	function addStudentMark()
	{
		$action = $this->input->post('action');

		$postData = [
			$this->input->post('type_id')	=>	$this->input->post('student_mark'),
			'student_id'	=>	$this->input->post('student_id'),
			'unit_id'		=>	$this->input->post('unit_id')
		];

		if ($action == "add") {
			$this->db->insert('tbl_student_marks', $postData);
		}elseif($action == "edit"){
			$this->db->where('student_id',	$this->input->post('student_id'));
			$this->db->where('unit_id',	$this->input->post('unit_id'));

			unset($postData['student_id']);
			unset($postData['unit_id']);

			$this->db->update('tbl_student_marks', $postData);
		}

		redirect('Lecturer/ams/' . $this->input->post('unit_id'));
	}
	function createNotesSection($unit_id)
	{
		$unitDetails = $this->M_Lecturer->getUnitDetails($unit_id);

		$notes_section = "";
		if ($unitDetails) {
			$weeks = $this->db->get('tbl_weeks')->result();

			foreach ($weeks as $week) {
				$unit_notes = $this->M_Lecturer->findUnitNotes($week->id, $unit_id, $this->session->userdata('lecturer_id'));
				$notes_section .= "<div class = 'week-item'>";
				$notes_section .= "<span class = 'week-item-title'>{$week->week}</span><a href = '#' class = 'week-item-a pull-right' data-week-id = '{$week->id}'><i class = 'fa fa-plus'></i></a>";
				$notes_section .= "<div class = 'week-item-notes'>";
				if ($unit_notes) {
					foreach ($unit_notes as $note) {
						$notes_section .= "<div>
							<a href = '{$note->file_location}'>{$note->item_title}</a>
						</div>";
					}
				}else{
					$notes_section .= "There are no notes for this week";
				}
				$notes_section .= "</div>";
				$notes_section .= "</div>";
			}
		}

		return $notes_section;
	}

	function addItem($unit_id)
	{
		$file_location = $mimeType = $fileSize = "";
		if (isset($_FILES['item_file'])) {
			$config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'pdf|docx|doc|ppt|pptx|zip|rar|gif|jpg|png';
			$config['max_size']             = 10000;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('item_file')) {
				echo "<pre>";print_r($this->upload->display_errors());die;
			}else{
				$upload_data = $this->upload->data();
				$mimeType = $upload_data['file_type'];
				$fileSize = $upload_data['file_size'];
				$fileName = $upload_data['file_name'];
				$file_location = base_url('uploads/' . $upload_data['file_name']);
			}
		}
		if (isset($_POST['item_url'])) {
			$file_location = $this->input->post('item_url');
		}


		$postData = [
			'type'				=>	$this->input->post('item_type'),
			'week_id'			=>	$this->input->post('week-id'),
			'item_title'		=>	$this->input->post('item_title'),
			'item_description'	=>	$this->input->post('item_description'),
			'mimeType'			=>	$mimeType,
			'file_location'		=>	$file_location,
			'fileSize'			=>	$fileSize,
			'file_name'			=>	$fileName,
			'lecturer_id'		=>	$this->session->userdata('lecturer_id'),
			'unit_id'			=>	$unit_id
		];

		$this->M_Lecturer->addItem($postData);

		// Add to notifications table
		$lecturer_details = $this->M_Lecturer->findLecturerByID($this->session->userdata('lecturer_id'));
		$week_details = $this->M_Lecturer->findWeekByID($postData['week_id']);
		$unitDetails = $this->M_Lecturer->getUnitDetails($unit_id);

		$notification_message = "{$lecturer_details->lecturer_firstname} {$lecturer_details->lecturer_lastname} has just uploaded something on {$week_details->week} for {$unitDetails->unit_name}";

		$students_in_course = $this->M_Lecturer->findStudents($unit_id);

		$notificationData = [];
		foreach ($students_in_course as $student) {
			$notificationData[] = [
				'from_id'	=>	$this->session->userdata('lecturer_id'),
				'to_id'		=>	$student->student_id,
				'message'	=>	$notification_message
			];
		}
		$this->M_Lecturer->addNotification($notificationData);

		redirect('Lecturer/elearning/' . $unit_id);
	}

	function findStudentMarks($student_id, $unit_id)
	{
		$student_marks = $this->M_Lecturer->findStudentMarks($student_id, $unit_id);

		$response = [];

		if ($student_marks) {
			$response[] = [
				"text"	=>	"CAT 1",
				"value"	=>	$student_marks->cat_1
			];
			$response[] = [
				"text"	=>	"CAT 2",
				"value"	=>	$student_marks->cat_2
				];
			$response[] = ["text" => "Assignment", "value"	=>	$student_marks->assignment];
			$response[] = ["text" => "Group Work", "value"	=>	$student_marks->group_work];
		}else{
			$response[] = [
				"text"	=>	"CAT 1",
				"value"	=>	"Not added"
			];
			$response[] = [
				"text"	=>	"CAT 2",
				"value"	=>	"Not added"
				];
			$response[] = ["text" => "Assignment", "value"	=>	"Not added"];
			$response[] = ["text" => "Group Work", "value"	=>	"Not added"];
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}