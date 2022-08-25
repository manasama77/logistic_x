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
		$where = ['id' => $this->session->userdata(SESI . 'id')];
		$arr = $this->M_core->get('admins', 'username, email, name, division_id, phone', $where);

		$data = [
			'title'      => APP_NAME . ' | Profil',
			'content'    => 'profil/main',
			'vitamin_js' => 'profil/main_js',
			'arr'        => $arr,
		];


		$this->template->render($data);
	}

	public function setting_update()
	{
		$code  = 500;
		$id    = $this->session->userdata(SESI . 'id');
		$name  = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');

		$data  = [
			'name'  => $name,
			'email' => $email,
			'phone' => $phone,
		];
		$where = ['id' => $id];
		$exec  = $this->M_core->update('admins', $data, $where);

		$this->session->set_userdata(SESI . 'name', $name);
		$this->session->set_userdata(SESI . 'email', $email);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function check_current_password()
	{
		$id               = $this->session->userdata(SESI . 'id');
		$current_password = $this->input->post('current_password');
		$code             = 500;

		$where = [
			'id'         => $id,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];
		$exec = $this->M_core->get('admins', 'password', $where);

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
		$id           = $this->session->userdata(SESI . 'id');
		$new_password = $this->input->post('new_password');

		$data = [
			'password'   => password_hash(UYAH . $new_password, PASSWORD_BCRYPT),
			'updated_at' => $this->current_datetime
		];

		$where = ['id' => $id];

		$exec = $this->M_core->update('admins', $data, $where);

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
