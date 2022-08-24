<?php

defined('BASEPATH') or exit('No direct script access allowed');

class KonfigurasiCryptoAssetController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_konfigurasi_crypto_asset');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_konfigurasi_crypto_asset->get_list();
		$data = [
			'title'      => APP_NAME . ' | Konfigurasi Crypto Asset',
			'content'    => 'konfigurasi_crypto_asset/main',
			'vitamin_js' => 'konfigurasi_crypto_asset/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}

	public function add()
	{
		$tgl_obj     = new DateTime('now');
		$arr_package = $this->M_konfigurasi_crypto_asset->get_list_package();
		$data = [
			'title'       => APP_NAME . ' | Tambah Konfigurasi Crypto Asset',
			'content'     => 'konfigurasi_crypto_asset/form',
			'vitamin_css' => 'konfigurasi_crypto_asset/form_css',
			'vitamin_js'  => 'konfigurasi_crypto_asset/form_js',
			'arr_package' => $arr_package,
			'tgl_obj'     => $tgl_obj,
		];
		$this->template->render($data);
	}

	public function detail_package()
	{
		$id = $this->input->get('id_package_crypto_asset');

		$arr = $this->M_konfigurasi_crypto_asset->get_list_package($id);

		$return = [
			'code'    => 500,
			'message' => 'Gagal mendapatkan Data Paket',
			'data' => [],
		];
		if ($arr) {
			$return = [
				'code'    => 200,
				'message' => 200,
				'data'    => $arr
			];
		}

		echo json_encode($return);
	}

	public function store()
	{
		$id                        = $this->input->post('id_package_crypto_asset');
		$tanggal_aktif             = $this->input->post('tanggal_aktif');
		$profit_per_month_percent  = $this->input->post('profit_per_month_percent');
		$profit_per_month_value    = $this->input->post('profit_per_month_value');
		$profit_per_day_percentage = $this->input->post('profit_per_day_percentage');
		$profit_per_day_value      = $this->input->post('profit_per_day_value');
		$share_self_percentage     = $this->input->post('share_self_percentage');
		$share_self_value          = $this->input->post('share_self_value');
		$share_upline_percentage   = $this->input->post('share_upline_percentage');
		$share_upline_value        = $this->input->post('share_upline_value');
		$share_company_percentage  = $this->input->post('share_company_percentage');
		$share_company_value       = $this->input->post('share_company_value');
		$is_active                 = "no";
		$created_at                = $this->datetime;
		$updated_at                = $this->datetime;
		$deleted_at                = null;

		$data = [
			'id_package_crypto_asset'  => $id,
			'tanggal_aktif'             => $tanggal_aktif,
			'profit_per_month_percent'  => $profit_per_month_percent,
			'profit_per_month_value'    => $profit_per_month_value,
			'profit_per_day_percentage' => $profit_per_day_percentage,
			'profit_per_day_value'      => $profit_per_day_value,
			'share_self_percentage'     => $share_self_percentage,
			'share_self_value'          => $share_self_value,
			'share_upline_percentage'   => $share_upline_percentage,
			'share_upline_value'        => $share_upline_value,
			'share_company_percentage'  => $share_company_percentage,
			'share_company_value'       => $share_company_value,
			'is_active'                 => $is_active,
			'created_at'                => $created_at,
			'updated_at'                => $updated_at,
			'deleted_at'                => $deleted_at,
		];
		$exec = $this->M_core->store('konfigurasi_crypto_asset', $data);

		$return = [
			'code'    => 500,
			'message' => "Tambah Konfigurasi Crypto Asset Gagal",
		];
		if ($exec) {
			$return = [
				'code'    => 200,
				'message' => "Tambah Konfigurasi Crypto Asset Berhasil",
			];
		}

		echo json_encode($return);
	}

	public function destroy($id = null)
	{
		if ($id == null) {
			return show_404();
		}

		$data = ['deleted_at' => $this->datetime];
		$where = [
			'id' => $id,
			'is_active' => 'no',
		];
		$this->M_core->update('konfigurasi_crypto_asset', $data, $where);

		redirect('crypto_asset/konfigurasi');
	}
}
        
/* End of file  KonfigurasiCryptoAssetController.php */
