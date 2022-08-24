<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{

	protected $datetime;
	protected $from;
	protected $from_alias;
	protected $ip_address;
	protected $user_agent;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_genuine_mail', null, 'genuine_mail');
		$this->load->helper(['cookie', 'string', 'otp_helper', 'domain_helper']);
		$this->load->model('M_admin');
		$this->load->model('M_log_send_email_admin');

		$this->datetime   = date('Y-m-d H:i:s');
		$this->from       = EMAIL_ADMIN;
		$this->from_alias = EMAIL_ALIAS;
		$this->ip_address = $this->input->ip_address();
		$this->user_agent = $this->input->user_agent();
	}

	public function index()
	{
		$cookies = get_cookie(KUE);

		if ($cookies != NULL) {
			$this->_check_cookies($cookies);
		} else {
			$check_session = $this->_check_session();
			if ($check_session === true) {
				redirect('dashboard');
			}

			$data = [
				'title' => APP_NAME . ' | Admin Sign In'
			];
			return $this->load->view('login', $data, FALSE);
		}
	}

	public function auth()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$remember = $this->input->post('remember');

		$where = [
			'username'   => $username,
			'deleted_at' => null,
		];
		$arr_user = $this->M_admin->get($where);

		if ($arr_user->num_rows() == 0) {
			$this->session->set_flashdata('username_value', $username);
			$this->session->set_flashdata('username_state', 'is-invalid');
			$this->session->set_flashdata('username_state_message', 'Username Tidak Ditemukan');
			return redirect('login');
		} elseif ($arr_user->row()->is_active === 'no') {
			$this->session->set_flashdata('username_value', $username);
			$this->session->set_flashdata('username_state', 'is-invalid');
			$this->session->set_flashdata('username_state_message', 'Akun Tidak Aktif');
			return redirect('login');
		} elseif (password_verify(UYAH . $password, $arr_user->row()->password) === false) {
			$this->session->set_flashdata('username_value', $username);
			$this->session->set_flashdata('username_state', 'is-valid');
			$this->session->set_flashdata('username_state_message', null);
			$this->session->set_flashdata('password_state', 'is-invalid');
			$this->session->set_flashdata('password_state_message', 'Password wrong!');
			return redirect('login');
		}

		$id            = $arr_user->row()->id;
		$username      = $arr_user->row()->username;
		$name          = $arr_user->row()->name;
		$email         = $arr_user->row()->email;
		$role          = $arr_user->row()->role;
		$division_id   = $arr_user->row()->division_id;
		$division_name = $arr_user->row()->division_name;
		$is_active     = $arr_user->row()->is_active;
		$cookies       = null;

		if ($remember) {
			$cookies = $this->_set_cookie();
		}

		$this->_set_session($id, $username, $name, $email, $division_id, $division_name, $role, $is_active, $cookies);
		$this->session->set_flashdata('first_login', 'Login Berhasil, Pastikan kamu menjaga password kamu dan jangan pernah berbagi dengan pengguna lain');
		return redirect('dashboard');
	}

	public function logout(): void
	{
		delete_cookie(KUE);
		$data = [
			SESI . 'id',
			SESI . 'username',
			SESI . 'name',
			SESI . 'email',
			SESI . 'division_id',
			SESI . 'division_name',
			SESI . 'role',
			SESI . 'is_active',
		];
		$this->session->unset_userdata($data);
		$this->session->set_flashdata('logout', 'Logout Berhasil');
		redirect('login');
	}

	protected function _check_cookies($cookies): void
	{
		$where_cookies = [
			'cookies'    => $cookies,
			'ip_address' => $this->ip_address,
			'user_agent' => $this->user_agent,
			'deleted_at' => null,
		];
		$check_cookies = $this->M_admin->get($where_cookies);

		if ($check_cookies->num_rows() == 1) {
			$id            = $check_cookies->row()->id;
			$username      = $check_cookies->row()->username;
			$name          = $check_cookies->row()->name;
			$email         = $check_cookies->row()->email;
			$division_id   = $check_cookies->row()->division_id;
			$division_name = $check_cookies->row()->division_name;
			$role          = $check_cookies->row()->role;
			$is_active     = $check_cookies->row()->is_active;

			if ($is_active == "no") {
				$this->session->set_flashdata('message', "Akun Tidak Aktif");
				redirect(site_url('logout'));
			}

			$this->_set_session($id, $username, $name, $email, $division_id, $division_name, $role, $is_active, $cookies);
			$this->session->set_flashdata('first_login', 'Login Berhasil, Pastikan kamu menjaga password kamu dan jangan pernah berbagi dengan pengguna lain');
			redirect('dashboard');
		} else {
			delete_cookie(KUE);
			redirect(site_url('logout'));
		}
	}

	protected function _set_cookie(): string
	{
		$key_cookies = random_string('alnum', 64);
		set_cookie(KUE, $key_cookies, 86400);
		return $key_cookies;
	}

	protected function _set_session($id, $username, $name, $email, $division_id, $division_name, $role, $is_active, $cookies): void
	{
		$this->session->set_userdata([
			SESI . 'id'            => $id,
			SESI . 'username'      => $username,
			SESI . 'name'          => $name,
			SESI . 'email'         => $email,
			SESI . 'division_id'   => $division_id,
			SESI . 'division_name' => $division_name,
			SESI . 'role'          => $role,
			SESI . 'is_active'     => $is_active,
		]);

		$data = [
			'cookies'    => $cookies,
			'ip_address' => $this->ip_address,
			'user_agent' => $this->user_agent,
			'updated_at' => $this->datetime,
			'updated_by' => $id,
		];
		$where = ['id' => $id];
		$this->M_core->update('admins', $data, $where);
	}

	protected function _check_session()
	{
		$id       = $this->session->userdata(SESI . 'id');
		$username = $this->session->userdata(SESI . 'username');

		if (!$id && !$username) {
			return false;
		}

		$where = [
			'id'         => $id,
			'username'   => $username,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];

		$count = $this->M_core->count('admins', $where);

		if ($count == 0) {
			return false;
		}

		return true;
	}
}
        
/* End of file LoginController.php */
