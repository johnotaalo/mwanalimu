<?php

class M_Lecturer extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function findLecturers()
	{
		$query = $this->db->get('tbl_lecturers');

		return $query->result();
	}

	function findLatestLecturerNumber()
	{
		$query = $this->db->query("SELECT MAX(lecturer_no) as lecturer_no FROM tbl_lecturers");

		return $query->row()->lecturer_no;
	}

	function addLecturer($data)
	{
		$this->db->insert('tbl_lecturers', $data);
	}

	function findLecturerUnits($lecturer_id)
	{
		$query = $this->db->query("SELECT c.id as course_id, c.course_name, u.* FROM tbl_units u JOIN tbl_courses c ON c.id = u.course_unit_id WHERE u.lecturer_id = {$lecturer_id}");

		return $query->result();
	}

	function getUnitDetails($unit_id)
	{
		$this->db->where('id', $unit_id);
		$query = $this->db->get('tbl_units');

		return $query->row();
	}

	function findUnitNotes($week_id, $unit_id, $lecturer_id)
	{
		$this->db->where([
				'week_id'		=>	$week_id,
				'unit_id'		=>	$unit_id,
				'lecturer_id'	=>	$lecturer_id
			]);

		$query = $this->db->get('tbl_unit_notes');

		return $query->result();
	}

	function addItem($postData)
	{
		$this->db->insert('tbl_unit_notes', $postData);
	}

	function findLecturerByID($id)
	{
		$this->db->where('id', $id);

		$query = $this->db->get('tbl_lecturers');

		return $query->row();
	}

	function findWeekByID($id)
	{
		$this->db->where('id', $id);

		$query = $this->db->get('tbl_weeks');

		return $query->row();
	}

	function findStudents($unit_id)
	{
		$sql = "SELECT sc.student_id FROM tbl_student_courses sc
		JOIN tbl_units u ON u.course_unit_id = sc.course_id
		WHERE u.id = {$unit_id}";

		return $this->db->query($sql)->result();
	}

	function addNotification($notificationData)
	{
		$this->db->insert_batch('tbl_notifications', $notificationData);
	}

	function findStudentMarks($student_id, $unit_id)
	{
		$this->db->where('student_id', $student_id);
		$this->db->where('unit_id', $unit_id);

		$query = $this->db->get('tbl_student_marks');

		return $query->row();
	}

	function findStudentsByUnitID($unit_id)
	{
		$sql = "SELECT s.* FROM tbl_students s
			JOIN tbl_student_courses sc ON sc.student_id = s.id
			JOIN tbl_courses c ON c.id = sc.course_id
			JOIN tbl_units u ON u.course_unit_id = c.id
			WHERE u.id = {$unit_id}";

		return $this->db->query($sql)->result();
	}
}