<?php
defined('BASEPATH') or exit('No direct script access allowed');

class L_admin
{

	protected $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('M_core', 'mcore');
		$this->ci->load->model('M_admin', 'madmin');
		$this->ci->load->helper(['cookie', 'string']);
	}

	public function render($data)
	{
		$cookies = get_cookie(KUE);

		if ($cookies) {
			$check_cookies = $this->check_cookies($cookies);
			if ($check_cookies === FALSE) {
				$this->reject();
				exit;
			}
		}

		$check_session = $this->check_session();
		if ($check_session === FALSE) {
			$this->reject();
			exit;
		}

		$this->reset_session();
		return $this->render_view($data);
	}

	protected function check_cookies($cookies)
	{
		$where = [
			'cookies'    => $cookies,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];
		$arr = $this->ci->mcore->get('admin', '*', $where);

		if ($arr->num_rows() == 1) {
			$cookies_db = $arr->row()->cookies;

			if ($cookies == $cookies_db) {
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	public function check_session()
	{
		$id            = $this->ci->session->userdata(SESI . 'id');
		$username      = $this->ci->session->userdata(SESI . 'username');
		$name          = $this->ci->session->userdata(SESI . 'name');
		$email         = $this->ci->session->userdata(SESI . 'email');
		$division_id   = $this->ci->session->userdata(SESI . 'division_id');
		$division_name = $this->ci->session->userdata(SESI . 'division_name');
		$role          = $this->ci->session->userdata(SESI . 'role');
		$is_active     = $this->ci->session->userdata(SESI . 'is_active');

		if ($id && $username && $name && $email && $division_id && $division_name && $role && $is_active) {
			if ($is_active == "yes") {
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	public function render_view($data)
	{
		if (file_exists(APPPATH . 'views/pages/admin/' . $data['content'] . '.php')) {
			$this->ci->load->view('layouts/admin/main', $data, FALSE);
		} else {
			show_404();
		}
	}

	public function reject($message = 'Sesi Berakhir')
	{
		$this->ci->session->set_flashdata('message', $message);
		redirect('logout');
	}

	protected function reset_session()
	{
		$id = $this->ci->session->userdata(SESI . 'id');
		$where = [
			'admins.id'         => $id,
			'admins.deleted_at' => null,
		];
		$arr = $this->ci->madmin->get($where);

		if ($arr->num_rows() == 0) {
			return $this->reject();
		}

		$username      = $arr->row()->username;
		$name          = $arr->row()->name;
		$email         = $arr->row()->email;
		$division_id   = $arr->row()->division_id;
		$division_name = $arr->row()->division_name;
		$role          = $arr->row()->role;
		$is_active     = $arr->row()->is_active;

		if ($is_active == "no") {
			return $this->reject("Akun Tidak Aktif");
		}

		$this->ci->session->set_userdata(SESI . 'id', $id);
		$this->ci->session->set_userdata(SESI . 'username', $username);
		$this->ci->session->set_userdata(SESI . 'name', $name);
		$this->ci->session->set_userdata(SESI . 'email', $email);
		$this->ci->session->set_userdata(SESI . 'division_id', $division_id);
		$this->ci->session->set_userdata(SESI . 'division_name', $division_name);
		$this->ci->session->set_userdata(SESI . 'role', $role);
		$this->ci->session->set_userdata(SESI . 'is_active', $is_active);

		return TRUE;
	}
}
                                                
/* End of file L_admin.php */
