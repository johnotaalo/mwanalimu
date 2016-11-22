<?php

class User extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_User');
	}

	function login()
	{
		$number = $this->input->post('username');
		$password = $this->input->post('password');
		$response = [];

		$user = [];
		if ($number && $password) {
			// $user['name'] = "Chrispine Otaalo";
			$user = $this->M_User->findUserByUsername($number);

			if ($user) {
				$hashed_password = md5($password);

				if ($user->password == $hashed_password) {
					$response['type'] = true;

					$this->load->module('Student');

					$student_details = $this->M_Student->findStudentByAdmissionNumber($number);

					if(!$student_details)
					{
						$response['type'] = false;
						$response['message'] = "There was a problem logging you in! Contact your administrator";
					}
					else
					{
						$response['type'] = true;
						$user_data['user_id'] = $number;
						$user_data['id'] = $student_details->id;
						$user_data['name'] = $student_details->student_first_name . " " . $student_details->student_last_name;
						$user_data['email'] = $student_details->student_email_address;
						$user_data['photo'] = $student_details->student_images;
						$user_data['phone_number'] = $student_details->student_phone_number;
						$user_data['admission_number'] = $student_details->admission_number;
						$user_data['type'] = $user->user_type;
						$user_data['authToken'] = md5(date('now'));
						$response['result'] = $user_data;
					}
				}
				else{
					$response['type'] = false;
					$response['message'] = "Username or password is wrong";
				}
			}
			else
			{
				$response['type'] = false;
				$response['message'] = "Username or password is wrong";
			}
		}
		else{
			$response['type'] = false;
			$response['message'] = "There was an error logging you in";
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
	}
}