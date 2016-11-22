<?php

class Courses extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('M_Courses');
	}

	function index()
	{
		$data['courses_table'] = $this->createCoursesTable();
		$this->template->page_title = 'Courses';
		$this->template->page_description = "Manages your courses";
		$this->template->content_view = 'Courses/courses_v';

		$this->template->call_admin_template($data);
	}

	function createCoursesTable()
	{
		$courses = $this->M_Courses->findCourses();

		$courses_table = "";
		if ($courses) {
			$counter = 1;
			foreach ($courses as $course) {
				$courses_table .= "<tr>";
				$courses_table .= "<td>{$counter}</td>";
				$courses_table .= "<td>{$course->course_code}</td>";
				$courses_table .= "<td>{$course->course_name}</td>";
				$courses_table .= "<td><a href = '".base_url("Courses/viewStudents/{$course->id}")."' class = 'btn btn-sm btn-warning'>View Students</a></td>";
				$courses_table .= "</tr>";

				$counter++;
			}
		}

		return $courses_table;
	}

	function addCourse()
	{
		if ($this->input->post()) {
			$insertData = array();

			$insertData['course_code'] = $this->input->post('course_code');
			$insertData['course_name'] = $this->input->post('course_name');

			$inserted = $this->M_Courses->addCourse($insertData);

			if ($inserted) {
				redirect(base_url() . 'Courses');
			}
		}else{
			$this->template->page_title = "Add Course";
			$this->template->page_description = "Add courses to the system";
			$this->template->content_view = "courses/add_course_v";

			$this->template->call_admin_template();
		}
	}

	function viewStudents($course_id)
	{}
}