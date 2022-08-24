<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AdminManagementController extends CI_Controller
{
	protected $current_datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');

		$this->current_datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$data = [
			'title'      => APP_NAME . ' | Admin Management',
			'content'    => 'admin_management/main',
			'vitamin_js' => 'admin_management/main_js',
		];

		$where = [
			'deleted_at' => null,
			'deleted_by' => null,
		];
		$data['arr'] = $this->M_core->get('admin', 'id, email, name, role, is_active, updated_at', $where, 'id', 'desc');
		$this->template->render($data);
	}

	public function change_role()
	{
		$code = 500;
		$id   = $this->input->post('id');
		$role = $this->input->post('role');
		$updated_by = $this->session->userdata(SESI . 'id');

		$data  = [
			'role' => $role,
			'updated_at' => $this->current_datetime,
			'updated_by' => $updated_by,
		];
		$where = ['id'   => $id];
		$exec  = $this->M_core->update('admin', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function change_status()
	{
		$code      = 500;
		$id        = $this->input->post('id');
		$is_active = $this->input->post('is_active');
		$updated_by = $this->session->userdata(SESI . 'id');

		$data  = [
			'is_active' => $is_active,
			'updated_at' => $this->current_datetime,
			'updated_by' => $updated_by,
		];
		$where = ['id'   => $id];
		$exec  = $this->M_core->update('admin', $data, $where);

		if ($exec) {
			$code = 200;
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

	public function add_admin()
	{
		$email    = $this->input->post('email');
		$password = $this->input->post('password');
		$name     = $this->input->post('name');
		$role     = $this->input->post('role');
		$code     = 500;

		$check = $this->_check_email($email);

		if ($check == false) {
			$code = 404;
		} else {
			$data = [
				'email'      => $email,
				'password'   => password_hash(UYAH . $password, PASSWORD_BCRYPT),
				'name'       => $name,
				'role'       => $role,
				'is_active'  => 'yes',
				'created_at' => $this->current_datetime,
				'updated_at' => $this->current_datetime,
				'created_by' => $this->session->userdata(SESI . 'id'),
				'updated_by' => $this->session->userdata(SESI . 'id'),
			];

			$exec = $this->M_core->store('admin', $data);

			if ($exec) {
				$code = 200;
			}
		}

		echo json_encode(['code' => $code]);
	}

	public function delete_admin()
	{
		$code = 500;
		$id   = $this->input->post('id');

		$data = [
			'updated_at' => $this->current_datetime,
			'updated_by' => $this->session->userdata(SESI . 'id'),
			'deleted_at' => $this->current_datetime,
			'deleted_by' => $this->session->userdata(SESI . 'id'),
		];

		$where = ['id' => $id];

		$exec = $this->M_core->update('admin', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function _check_email($email)
	{
		$where = [
			'email'      => $email,
			'deleted_at' => null,
		];
		$count = $this->M_core->count('admin', $where);

		if ($count > 0) {
			return false;
		}

		return true;
	}
}
        
/* End of file AdminManagementController.php */
