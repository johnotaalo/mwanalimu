<?php

class Template extends MX_Controller
{
	public $page_title, $page_description, $content_view;
	function __construct()
	{
		parent::__construct();
	}

	function call_admin_template($data = NULL)
	{
		$data['page_title'] = $this->page_title;
		$data['page_description'] = $this->page_description;
		$data['content_view'] = ($this->content_view) ? $this->content_view : $data['content_view'];

		$this->load->view('Template/admin_template_v', $data);
	}

	function call_lecturer_template($data = NULL)
	{
		$data['page_title'] = $this->page_title;
		$data['page_description'] = $this->page_description;
		$data['content_view'] = ($this->content_view) ? $this->content_view : $data['content_view'];

		$this->load->view('Template/lecturer_template_v', $data);
	}
}