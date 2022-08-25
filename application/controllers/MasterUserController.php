<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MasterUserController extends CI_Controller
{
	protected $current_datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_admin');

		$this->current_datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$where = [
			'deleted_at' => null,
			'deleted_by' => null,
		];
		$arr = $this->M_admin->get($where);

		$division = $this->M_core->get('divisions', '*', null, 'name', 'asc');

		$data = [
			'title'      => APP_NAME . ' | Master User',
			'content'    => 'management_pengguna/master_user/main',
			'vitamin_js' => 'management_pengguna/master_user/main_js',
			'arr'        => $arr,
			'division'   => $division,
		];
		$this->template->render($data);
	}

	public function store()
	{
		$username    = strtolower($this->input->post('username'));
		$password    = $this->input->post('password');
		$name        = $this->input->post('name');
		$phone       = $this->input->post('phone');
		$email       = $this->input->post('email');
		$division_id = $this->input->post('division_id');
		$role        = $this->input->post('role');
		$code        = 500;

		$check = $this->_check_username($username);

		if ($check == false) {
			$code = 404;
		} else {
			$data = [
				'username'    => $username,
				'password'    => password_hash(UYAH . $password, PASSWORD_BCRYPT),
				'email'       => $email,
				'name'        => $name,
				'role'        => $role,
				'phone'       => $phone,
				'division_id' => $division_id,
				'is_active'   => 'yes',
				'created_at'  => $this->current_datetime,
				'updated_at'  => $this->current_datetime,
				'created_by'  => $this->session->userdata(SESI . 'id'),
				'updated_by'  => $this->session->userdata(SESI . 'id'),
			];

			$exec = $this->M_core->store('admins', $data);

			if ($exec) {
				$code = 200;
			}
		}

		echo json_encode(['code' => $code]);
	}

	public function reset_password()
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

	public function destroy()
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
		$exec = $this->M_core->update('admins', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function _check_username($username)
	{
		$where = [
			'username'   => strtolower($username),
			'deleted_at' => null,
		];
		$count = $this->M_core->count('admins', $where);

		if ($count > 0) {
			return false;
		}

		return true;
	}

	public function change_status()
	{
		$code       = 500;
		$id         = $this->input->post('id');
		$is_active  = $this->input->post('is_active');
		$updated_by = $this->session->userdata(SESI . 'id');

		$data  = [
			'is_active'  => $is_active,
			'updated_at' => $this->current_datetime,
			'updated_by' => $updated_by,
		];
		$where = ['id' => $id];
		$exec  = $this->M_core->update('admins', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}
}
        
/* End of file MasterUserController.php */
