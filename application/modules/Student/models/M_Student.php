<?php

defined("BASEPATH") or exit("No direct access script allowed");

class M_Student extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function findStudentByAdmissionNumber($admission_no)
	{
		$this->db->where('admission_number', $admission_no);
		$query = $this->db->get('tbl_students');

		return $query->row();
	}

	function getAllStudents()
	{
		$query = $this->db->get('tbl_students');

		return $query->result();
	}

	function getStudentCourses($student_id)
	{
		$sql = "SELECT c.course_name, c.id as course_id FROM tbl_student_courses sc
		JOIN tbl_courses c ON sc.course_id = c.id
		WHERE sc.student_id = {$student_id}";

		$query = $this->db->query($sql);

		return $query->result();
	}

	function getCourses($student_id)
	{
		$sql = "SELECT * FROM tbl_courses WHERE id NOT IN (SELECT course_id FROM tbl_student_courses WHERE student_id = {$student_id})";

		$query = $this->db->query($sql);

		return $query->result();
	}

	function addStudentCourse($student_id, $course_id)
	{
		$insert_data = [
			'student_id'	=>	$student_id,
			'course_id'		=>	$course_id
		];

		$this->db->insert('tbl_student_courses', $insert_data);
	}

	function addStudent($insert_data)
	{
		$this->db->insert('tbl_students', $insert_data);
	}

	function findLatestStudentNumber()
	{
		$sql = "SELECT MAX(admission_number) as adm_no FROM tbl_students";

		$query = $this->db->query($sql);

		return $query->row()->adm_no;
	}

	function findStudentCourses($student_id)
	{
		$sql = "SELECT c.id, c.course_name, sc.created_at FROM tbl_courses c
		JOIN tbl_student_courses sc ON sc.course_id = c.id
		WHERE sc.student_id = {$student_id}";

		$query = $this->db->query($sql);

		return $query->result();
	}

	function findCourseMates($student_id, $course_id)
	{
		$sql = "SELECT s.* FROM tbl_students s
		JOIN tbl_student_courses sc ON sc.student_id = s.id
		WHERE sc.course_id = {$course_id}
		AND sc.student_id != {$student_id}
		ORDER BY s.student_first_name ASC";

		$query = $this->db->query($sql);

		return $query->result();
	}

	function findStudent($student_id)
	{
		$this->db->where('id', $student_id);
		$query = $this->db->get('tbl_students');

		return $query->row();
	}

	function findStudentUnits($student_id, $course_id)
	{
		$sql = "SELECT CONCAT(l.lecturer_firstname, ' ', l.lecturer_lastname) as lecturer_name, u.unit_name, u.unit_code, u.id as unit_id FROM tbl_units u
		JOIN tbl_lecturers l ON l.id = u.lecturer_id
		JOIN tbl_courses c ON c.id = u.course_unit_id
		JOIN tbl_student_courses sc ON sc.course_id = c.id
		WHERE sc.student_id = {$student_id} AND sc.course_id = {$course_id}";

		return $this->db->query($sql)->result();
	}
}