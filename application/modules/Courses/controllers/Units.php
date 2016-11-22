<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Units extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(['M_Units', 'M_Courses']);
	}

	function index()
	{
		$data['units_table'] = $this->createUnitsTable();
		$this->template->page_title = 'Units';
		$this->template->page_description = "Manages your units";
		$this->template->content_view = 'Courses/units_v';

		$this->template->call_admin_template($data);
	}

	function addUnit()
	{
		if($this->input->post()){
			$insert_data = [];

			$insert_data['unit_code'] = $this->input->post('unit_code');
			$insert_data['unit_name'] = $this->input->post('unit_name');
			$insert_data['course_unit_id'] = $this->input->post('course_unit_id');
			$insert_data['lecturer_id']	=	$this->input->post('lecturer_id');

			$this->M_Units->addUnit($insert_data);

			redirect(base_url() . 'Courses/Units');
		}else{
			$data['courses_select'] = $this->createCoursesSelect();
			$data['lecturers_select'] = $this->createLecturersSelect();
			$this->template->page_title = "Add Unit";
			$this->template->page_description = "Add units to the system";
			$this->template->content_view = 'courses/add_unit_v';

			$this->template->call_admin_template($data);
		}
	}

	function createCoursesSelect()
	{
		$courses = $this->M_Courses->findCourses();
		$courses_select = '';
		if ($courses) {
			foreach ($courses as $course) {
				$courses_select .= "<option value = '{$course->id}'>{$course->course_name}</option>";
			}
		}

		return $courses_select;
	}

	function createUnitsTable()
	{
		$units = $this->M_Units->findUnits();

		$units_table = "";
		if ($units) {
			$counter = 1;
			foreach ($units as $unit) {
				$units_table .= "<tr>";
				$units_table .= "<td>{$counter}</td>";
				$units_table .= "<td>{$unit->unit_code}</td>";
				$units_table .= "<td>{$unit->unit_name}</td>";
				$units_table .= "<td>{$unit->course_name}</td>";
				$units_table .= "<td></td>";
				$units_table .= "</tr>";
			}
		}

		return $units_table;
	}

	function createLecturersSelect()
	{
		$this->load->module('Lecturer');

		$lecturers = $this->M_Lecturer->findLecturers();

		$lecturers_select = "";
		if ($lecturers) {
			foreach ($lecturers as $lecturer) {
				$lecturers_select .= "<option value = '{$lecturer->id}'>{$lecturer->lecturer_firstname} {$lecturer->lecturer_lastname}</option>";
			}
		}

		return $lecturers_select;
	}

	function getUnitLecturer($unit_id)
	{
		$lecturer = $this->M_Units->findUnitLecturer($unit_id);

		$response = [];
		if ($lecturer) {
			$response['lecturer_id'] = $lecturer->lecturer_id;
			$response['lecturer_name'] = $lecturer->lecturer_name;
			$image = ($lecturer->lecturer_image) ? $lecturer->lecturer_image : "";
			$response['lecturer_image'] = $image;
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	function getWeeksDetailsByUnit($unit_id)
	{
		$weeks_details = $this->M_Units->findWeeksDetailsByUnit($unit_id);

		$response = [];

		foreach ($weeks_details as $detail) {

			$last_updated = ($detail->last_updated) ? "Last Updated: " . date('dS F, Y \a\t\ H:i:s', strtotime($detail->last_updated)) : "No notes yet";
			$items = "No items";
			if($detail->items > 0 && $detail->items == 1):
				$items = $detail->items . " Item";
			elseif ($detail->items > 1) :
				$items = $detail->items . " Items";
			endif;
			$response[] = [
				'week_id'		=>	$detail->week_id,
				'week_name'		=>	$detail->week_name,
				'last_updated'	=>	$last_updated,
				'items'			=>	$items
			];
		}
		

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	function getUnitFiles($week_id, $unit_id)
	{
		$unit_files = $this->M_Units->findUnitFiles($week_id, $unit_id);

		$response = [];

		if ($unit_files) {
			$response['status'] = true;
			foreach ($unit_files as $file) {
				$response['files'][] = [
					'id'			=>	$file->id,
					'title'			=>	$file->item_title,
					'description'	=>	$file->item_description,
					'type'			=>	$file->type,
					'mimeType'		=>	$file->mimeType,
					'url'			=>	$file->file_location,
					'file_size'		=>	$file->fileSize,
					'file_name'		=>	$file->file_name,
					'created_at'	=>	date('dS F, Y H:i:s', strtotime($file->created_at))
				];
			}
		}else{
			$response['status'] = false;
			$response['message'] = "There are no notes or items for this unit in this week";
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}