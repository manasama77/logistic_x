<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProfileController extends CI_Controller
{
	protected $current_datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');

		$this->current_datetime = date('Y-m-d H: i: s');
	}

	public function index()
	{
		$data = [
			'title'      => APP_NAME . ' | Profile',
			'content'    => 'profile/main',
			'vitamin_js' => 'profile/main_js',
		];

		$where = [
			'email' => $this->session->userdata(SESI . 'email')
		];
		$data['arr'] = $this->M_core->get('admin', 'email, name', $where);
		$this->template->render($data);
	}

	public function setting_update()
	{
		$code  = 500;
		$email = $this->session->userdata(SESI . 'email');
		$name  = $this->input->post('name');

		$data  = ['name'  => $name];
		$where = ['email' => $email];
		$exec  = $this->M_core->update('admin', $data, $where);

		$this->session->set_userdata(SESI . 'name', $name);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function check_current_password()
	{
		$email            = $this->session->userdata(SESI . 'email');
		$current_password = $this->input->post('current_password');
		$code             = 500;

		$where = [
			'email'      => $email,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];
		$exec = $this->M_core->get('admin', 'password', $where);

		if ($exec) {
			if ($exec->num_rows() == 1) {
				if (password_verify(UYAH . $current_password, $exec->row()->password)) {
					$code = 200;
				} else {
					$code = 404;
				}
			}
		}

		echo json_encode(['code' => $code]);
	}

	public function update_password()
	{
		$code         = 500;
		$email        = $this->session->userdata(SESI . 'email');
		$new_password = $this->input->post('new_password');

		$data = [
			'password'   => password_hash(UYAH . $new_password, PASSWORD_BCRYPT),
			'updated_at' => $this->current_datetime
		];

		$where = ['email' => $email];

		$exec = $this->M_core->update('admin', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function reset_password()
	{
		$code           = 500;
		$id             = $this->input->post('id');
		$password_reset = $this->input->post('password_reset');

		$data = [
			'password'   => password_hash(UYAH . $password_reset, PASSWORD_BCRYPT),
			'updated_at' => $this->current_datetime
		];

		$where = ['id' => $id];

		$exec = $this->M_core->update('admin', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}
}
        
/* End of file ProfileController.php */
