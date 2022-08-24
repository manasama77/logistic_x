<?php

defined('BASEPATH') or exit('No direct script access allowed');

class KonfigurasiAplikasi extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');

		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_core->get('app_config', '*', null);
		$data = [
			'title'      => APP_NAME . ' | Konfigurasi Aplikasi',
			'content'    => 'konfigurasi_aplikasi/main',
			'vitamin_js' => 'konfigurasi_aplikasi/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}

	public function update()
	{
		$data['email_admin_1']        = strtolower(trim($this->input->post('email_admin_1')));
		$data['email_alias_1']        = strtolower(trim($this->input->post('email_alias_1')));
		$data['wa_admin_1']           = $this->input->post('wa_admin_1');
		$data['email_admin_2']        = strtolower(trim($this->input->post('email_admin_2')));
		$data['email_alias_2']        = strtolower(trim($this->input->post('email_alias_2')));
		$data['wa_admin_2']           = $this->input->post('wa_admin_2');
		$data['limit_withdraw']       = $this->input->post('limit_withdraw');
		$data['bonus_sponsor']        = $this->input->post('bonus_sponsor');
		$data['bonus_ql']             = $this->input->post('bonus_ql');
		$data['bonus_g2']             = $this->input->post('bonus_g2');
		$data['bonus_g3_g7']          = $this->input->post('bonus_g3_g7');
		$data['bonus_g8_g11']         = $this->input->post('bonus_g8_g11');
		$data['potongan_wd_external'] = $this->input->post('potongan_wd_external');
		$data['potongan_swap']        = $this->input->post('potongan_swap');
		$data['potongan_wd_internal'] = $this->input->post('potongan_wd_internal');
		$data['potongan_transfer']    = $this->input->post('potongan_transfer');
		$data['rate_usdt_ratu']       = $this->input->post('rate_usdt_ratu');

		$exec = $this->M_core->update('app_config', $data, ['id' => 1]);

		if (!$exec) {
			return show_error("Update Konfigurasi Aplikasi Gagal, silahkan coba kembali");
		}

		$this->session->set_flashdata('success', "Update Konfigurasi Aplikasi Berhasil");
		redirect('konfigurasi/aplikasi');
	}
}
        
/* End of file  KonfigurasiAplikasi.php */
