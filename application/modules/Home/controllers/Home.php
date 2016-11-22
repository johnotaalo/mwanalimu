<?php

class Home extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->template->page_title = 'Home Page';
		$this->template->page_description = 'This is the home page';
		$data['content_view'] = 'Home/home_v';
		$this->template->call_admin_template($data);
	}
}