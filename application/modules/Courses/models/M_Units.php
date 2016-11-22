<?php

class M_Units extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addUnit($data)
	{
		$this->db->insert('tbl_units', $data);
	}

	function findUnits()
	{
		$query = $this->db->query('SELECT c.id as course_id, c.course_name, u.* FROM tbl_units u
			JOIN tbl_courses c ON c.id = u.course_unit_id');

		return $query->result();
	}

	function findUnitLecturer($unit_id)
	{
		$sql = "SELECT l.id as lecturer_id, CONCAT(l.lecturer_firstname, ' ', l.lecturer_lastname) as lecturer_name, l.lecturer_image FROM tbl_lecturers l
		JOIN tbl_units u ON u.lecturer_id = l.id
		WHERE u.id = {$unit_id}";

		return $this->db->query($sql)->row();
	}

	function findWeeksDetailsByUnit($unit_id)
	{
		$sql = "SELECT w.id as week_id, w.week as week_name,count(un.id) as items, MAX(un.created_at) as last_updated FROM tbl_unit_notes un
		RIGHT JOIN tbl_weeks w ON w.id = un.week_id AND un.unit_id = {$unit_id}
		GROUP BY w.id";

		return $this->db->query($sql)->result();
	}

	function findUnitFiles($week_id, $unit_id)
	{
		$this->db->where([
				'week_id'	=>	$week_id,
				'unit_id'	=>	$unit_id
			]);

		$query = $this->db->get('tbl_unit_notes');

		return $query->result();
	}
}