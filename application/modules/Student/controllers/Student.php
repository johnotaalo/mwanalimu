<?php

class Student extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Student');
	}

	function index()
	{
		$data['student_table'] = $this->createStudentTable();
		$this->template->content_view = "Student/index";
		$this->template->call_admin_template($data);
	}

	function addStudent()
	{
		if(!$this->input->post())
		{
			$data = [];
			$this->template->content_view = 'Student/addStudent';
			$this->template->call_admin_template($data);
		}
		else
		{
			$new_admission_number = $this->createStudentNumber();

			$_POST['admission_number'] = $new_admission_number;
			$this->M_Student->addStudent($this->input->post());

			// Add Student User
			$this->load->module('User');

			$user_data = [
				'username'	=>	$new_admission_number,
				'password'	=>	md5('12345'),
				'user_type'	=>	'student'
			];

			$this->M_User->addUser($user_data);

			redirect(base_url() . 'Student');
		}
		
	}

	function getStudentDetails($student_id)
	{
		$student = $this->M_Student->findStudent($student_id);
		$response = [];
		if ($student) {
			$response['type'] = true;
			$response['details'] = [
				'phone_number'	=>	$student->student_phone_number,
				'email_address'	=>	$student->student_email_address
			];
		}else{
			$response['type'] = false;
			$response['message'] = "Could not find student";
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
	}

	function createStudentTable()
	{
		$students = $this->M_Student->getAllStudents();
		$students_table = "";
		if ($students) {
			foreach ($students as $student) {
				$students_table .= "<tr>";
				$students_table .= "<td>{$student->admission_number}</td>";
				$students_table .= "<td>{$student->student_first_name} {$student->student_last_name}</td>";
				$students_table .= "<td>{$student->student_phone_number}</td>";
				$students_table .= "<td>{$student->student_email_address}</td>";
				$students_table .= "<td><a href = '".base_url('Student/manageCourses')."/{$student->id}' class = 'label label-warning'>Manage Courses</a></td>";
				$students_table .= "</tr>";
			}
		}

		return $students_table;
	}

	function manageCourses($student_id)
	{
		$student_courses_table = "";
		$student_courses = $this->M_Student->getStudentCourses($student_id);

		if ($student_courses) {
			$counter = 1;
			foreach ($student_courses as $student_course) {
				$student_courses_table .= "<tr>";
				$student_courses_table .= "<td>{$counter}</td>";
				$student_courses_table .= "<td>{$student_course->course_name}</td>";
				$student_courses_table .= "</tr>";
				$counter++;
			}
		}
		$courses_table = "";

		$courses = $this->M_Student->getCourses($student_id);

		if ($courses) {
			$counter = 1;
			foreach ($courses as $course) {
				$courses_table .= "<tr>";
				$courses_table .= "<td>{$counter}</td>";
				$courses_table .= "<td>{$course->course_name}</td>";
				$courses_table .= "<td><a href = '".base_url('Student/enrollStudent/' . $student_id . '/' . $course->id)."' class = 'btn btn-sm btn-primary'>Enroll Student</a></td>";
				$courses_table .= "</tr>";
				$counter++;
			}
		}

		$data['student_courses_table'] = $student_courses_table;
		$data['courses_table'] = $courses_table;

		$this->template->content_view = 'Student/manage_courses_v';
		$this->template->call_admin_template($data);
	}

	function enrollStudent($student_id, $course_id)
	{
		$this->M_Student->addStudentCourse($student_id, $course_id);

		redirect(base_url('Student/manageCourses/' . $student_id));
	}

	function createStudentNumber()
	{
		$latestNumber = $this->M_Student->findLatestStudentNumber();
		$new_latest_Number = 70000;

		if ($latestNumber) {
			$new_latest_Number = $latestNumber + 1;
		}

		return $new_latest_Number;
	}

	function getStudentCoursesById($student_id)
	{

		$courses = $this->M_Student->findStudentCourses($student_id);

		$response = [];
		$counter = 1;
		if ($courses) {
			foreach ($courses as $course) {
				$response['result'][] = [
					'number'			=>	$counter,
					'course_id'			=>	$course->id,
					'course_name'		=>	$course->course_name,
					'course_joined'		=>	"Joined on " . date('dS F, Y', strtotime($course->created_at))
				];
				$counter++;
			}
		}
		else
		{
			$response['result'] = [];
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
	}

	function findCourseMates($student_id, $course_id)
	{
		$course_mates = $this->M_Student->findCourseMates($student_id, $course_id);
		$response = [];

		$response = [];

		if ($course_mates) {
			foreach ($course_mates as $course_mate) {
				$response[] = [
					'id'				=>	$course_mate->id,
					'admission_number'	=>	$course_mate->admission_number,
					'student_name'		=>	$course_mate->student_first_name . " " . $course_mate->student_last_name,
					'student_email'		=>	$course_mate->student_email_address,
					'student_photo'		=>	$course_mate->student_images 
				];
			}
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
	}

	function findStudentUnitsByCourse($student_id, $course_id)
	{
		$units = $this->M_Student->findStudentUnits($student_id, $course_id);

		$response = [];
		if ($units) {
			$response['status'] = true;
			foreach ($units as $unit) {
				$response['data'][] = [
					'unit_id'		=>	$unit->unit_id,
					'unit_name' 	=>	$unit->unit_name,
					'unit_code'		=>	$unit->unit_code,
					'lecturer_name'	=>	$unit->lecturer_name
				];
			}
		}else{
			$response['status'] = false;
			$response['message'] = "Could not find units done by you";
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
	}
}