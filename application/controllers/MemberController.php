<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MemberController extends CI_Controller
{

	protected $datetime;
	protected $from;
	protected $from_alias;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->library('Nested_set', null, 'Nested_set');
		$this->load->helper(['cookie', 'string', 'otp_helper', 'domain_helper', 'floating_helper']);
		$this->load->model('M_member');
		$this->load->model('M_log_send_email_admin');

		$this->datetime   = date('Y-m-d H:i:s');
		$this->from       = EMAIL_ADMIN;
		$this->from_alias = EMAIL_ALIAS;

		$this->Nested_set->setControlParams('tree', 'lft', 'rgt', 'id', 'id_upline', 'email');
		$this->Nested_set->setPrimaryKeyColumn('id_member');
	}

	public function index()
	{
		$arr_member = $this->_get_member();

		$data = [
			'title'      => APP_NAME . ' | Member',
			'content'    => 'member/main',
			'vitamin_js' => 'member/main_js',
			'arr_member' => $arr_member,
		];
		$this->template->render($data);
	}

	protected function _get_member()
	{
		$arr_member = $this->M_member->get_list_member();
		return $arr_member;
	}

	public function store()
	{
		$this->db->trans_begin();

		$email           = $this->input->post('email');
		$password        = $this->input->post('password');
		$verify_password = $this->input->post('verify_password');
		$id_card_number  = $this->input->post('id_card_number');
		$fullname        = $this->input->post('fullname');
		$phone_number    = $this->input->post('phone_number');

		$check = $this->M_core->count('member', ['id_card_number' => $id_card_number]);

		if ($check >= 1) {
			echo json_encode(['code' => '400', 'msg' => 'ID Card Number already registered']);
			exit;
		}

		$check = $this->M_core->count('member', ['email' => $email]);

		if ($check >= 1) {
			echo json_encode(['code' => '400', 'msg' => 'Email already registered']);
			exit;
		}

		if ($verify_password != $password) {
			echo json_encode(['code' => '400', 'msg' => 'Password & Verify Password Different']);
			exit;
		}

		$data = [
			'email'                => $email,
			'password'             => password_hash(UYAH . $password, PASSWORD_BCRYPT),
			'id_card_number'       => $id_card_number,
			'fullname'             => $fullname,
			'phone_number'         => $phone_number,
			'id_upline'            => null,
			'country_code'         => null,
			'profile_picture'      => null,
			'otp'                  => null,
			'is_active'            => 'no',
			'activation_code'      => null,
			'forgot_password_code' => null,
			'is_founder'           => 'yes',
			'cookies'              => null,
			'ip_address'           => null,
			'user_agent'           => null,
			'created_at'           => $this->datetime,
			'updated_at'           => $this->datetime,
			'deleted_at'           => null,
		];

		$exec = $this->M_core->store_uuid('member', $data);

		if (!$exec) {
			$this->db->trans_rollback();
			echo json_encode(['code' => '500', 'msg' => 'Cannot Connect to Database, please check your connection!']);
			exit;
		}

		$where     = ['email' => $email];
		$arr       = $this->M_core->get('member', 'id', $where);
		$id_member = $arr->row()->id;

		$data = [
			'id_member'                  => $id_member,
			'total_invest_trade_manager' => 0,
			'count_trade_manager'        => 0,
			'total_invest_crypto_asset'  => 0,
			'count_crypto_asset'         => 0,
			'profit'                     => 0,
			'bonus'                      => 0,
			'created_at'                 => $this->datetime,
			'updated_at'                 => $this->datetime,
			'deleted_at'                 => null,
		];

		$exec = $this->M_core->store_uuid('member_balance', $data);

		if (!$exec) {
			$this->db->trans_rollback();
			echo json_encode(['code' => '500', 'msg' => 'Cannot Connect to Database, please check your connection!']);
			exit;
		}

		$add_tree_founder = $this->_add_tree_founder($id_member, $email);

		if ($this->Nested_set->checkIsValidNode($add_tree_founder) == FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['code' => '500', 'msg' => 'Cannot Connect to Database, please check your connection!']);
			exit;
		}

		$check = $this->_send_email_activation($id_member, $email);

		if ($check == "no") {
			$this->db->trans_rollback();
			echo json_encode(['code' => '500', 'msg' => 'Cannot Send Email, Please check your email Address']);
			exit;
		}

		$this->db->trans_commit();
		echo json_encode(['code' => '200', 'msg' => 'Add Founder Success, Please inform Founder to check email']);
	}

	public function _add_tree_founder($id_member, $email)
	{
		$data_hie = [
			'id_member' => $id_member,
			'email'     => $email,
			'depth'     => 0,
		];
		return $this->Nested_set->initialiseRoot($data_hie);
	}

	public function _send_email_activation($id, $to)
	{
		$subject = APP_NAME . " | Account Activation";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$activation_code         = hash('sha1', UYAH . $to . $this->datetime);
		$data['email']           = $to;
		$data['activation_code'] = $activation_code;

		$message = $this->load->view('emails/activation_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_core->update('member', ['activation_code' => $activation_code], ['id' => $id]);
		$this->M_log_send_email_admin->write_log($to, $subject, $message, $is_success);
	}

	public function _tree_count_downline($id_member)
	{
		$where_member = ['id_member' => $id_member];
		$data_member  = $this->Nested_set->getNodeWhere($where_member);

		return $this->Nested_set->getNumberOfChildren($data_member);
	}

	public function change_status()
	{
		$code       = 500;
		$id         = $this->input->post('id');
		$is_active  = $this->input->post('is_active');

		$data  = [
			'is_active'  => $is_active,
			'updated_at' => $this->datetime,
		];
		$where = ['id' => $id];
		$exec  = $this->M_core->update('member', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function data_kyc()
	{
		header('Content-Type: application/json');

		$id_member  = $this->input->get('id_member');
		$arr_member = $this->M_member->get_list_member($id_member);

		if (!$arr_member) {
			echo json_encode([
				'code'       => 500,
				'msg'        => "Data KYC Member Tidak Ditemukan",
				'arr_member' => null,
			]);
			exit;
		}
		echo json_encode([
			'code'       => 200,
			'msg'        => null,
			'arr_member' => $arr_member,
		]);
	}

	public function terima_kyc()
	{
		$this->db->trans_begin();

		$id_member = $this->input->post('id_member');
		$data      = ['is_kyc' => 'yes'];
		$where     = ['id'     => $id_member];
		$exec = $this->M_core->update('member', $data, $where);

		if (!$exec) {
			$this->db->trans_rollback();

			echo json_encode([
				'code' => 500,
				'msg'  => "Proses KYC Gagal, silahkan coba kembali",
			]);
			exit;
		}

		$email = $this->M_core->get('member', 'email', ['id' => $id_member])->row()->email;
		$send_email = $this->_send_notif_kyc_success($email);

		if ($send_email == false) {
			$this->db->trans_rollback();

			echo json_encode([
				'code' => 500,
				'msg'  => "Proses Kirim Email Gagal, silahkan coba kembali",
			]);
			exit;
		}

		$this->db->trans_commit();
		echo json_encode([
			'code' => 200,
			'msg'  => "Proses Terima KYC Berhasil",
		]);
	}

	protected function _send_notif_kyc_success($to)
	{
		$subject = APP_NAME . " | Proses KYC Berhasil";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$message = $this->load->view('emails/kyc_success', null, TRUE);
		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_admin->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	public function tolak_kyc()
	{
		$this->db->trans_begin();

		$id_member = $this->input->post('id_member');

		$arr_foto = $this->M_core->get('member', 'foto_ktp, foto_pegang_ktp', ['id' => $id_member]);

		$foto_ktp        = $arr_foto->row()->foto_ktp;
		$foto_pegang_ktp = $arr_foto->row()->foto_pegang_ktp;

		if ($foto_ktp != null) {
			unlink(MEMBER_PATH . "/protected/ktp/" . $foto_ktp);
		}

		if ($foto_pegang_ktp != null) {
			unlink(MEMBER_PATH . "/protected/member/" . $foto_pegang_ktp);
		}

		$alasan    = trim($this->input->post('alasan'));
		$data      = [
			'is_kyc'          => 'no',
			'id_card_number'  => null,
			'address'         => null,
			'postal_code'     => null,
			'id_bank'         => null,
			'no_rekening'     => null,
			'foto_ktp'        => null,
			'foto_pegang_ktp' => null,
			'alasan'          => $alasan,
		];
		$where = ['id' => $id_member];
		$exec  = $this->M_core->update('member', $data, $where);

		if (!$exec) {
			$this->db->trans_rollback();

			echo json_encode([
				'code' => 500,
				'msg'  => "Proses KYC Gagal, silahkan coba kembali",
			]);
			exit;
		}

		$email = $this->M_core->get('member', 'email', ['id' => $id_member])->row()->email;
		$send_email = $this->_send_notif_kyc_reject($email, $alasan);

		if ($send_email == false) {
			$this->db->trans_rollback();

			echo json_encode([
				'code' => 500,
				'msg'  => "Proses Kirim Email Gagal, silahkan coba kembali",
			]);
			exit;
		}

		$this->db->trans_commit();
		echo json_encode([
			'code' => 200,
			'msg'  => "Proses Tolak KYC",
		]);
	}

	protected function _send_notif_kyc_reject($to, $alasan)
	{
		$subject = APP_NAME . " | Proses KYC Ditolak";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data['alasan'] = $alasan;
		$message = $this->load->view('emails/kyc_failed', $data, TRUE);
		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_admin->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}
}
        
/* End of file MemberController.php */
