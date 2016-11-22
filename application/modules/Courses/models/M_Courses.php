<?php

defined("BASEPATH") or exit("No direct script access allowed");

class M_Courses extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function findCourses()
	{
		$query = $this->db->get("tbl_courses");

		return $query->result();
	}

	function addCourse($data)
	{
		$query = $this->db->insert("tbl_courses", $data);

		return $query;
	}

	function findCourseById($course_id)
	{
		$this->db->where('id', $course_id);

		$query = $this->db->get('tbl_courses');

		return $query->row();
	}
}