<?php

defined('BASEPATH') or exit('No direct script access allowed');

class KonfigurasiTradeManagerController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_konfigurasi_trade_manager');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_konfigurasi_trade_manager->get_list();
		$data = [
			'title'      => APP_NAME . ' | Konfigurasi Trade Manager',
			'content'    => 'konfigurasi_trade_manager/main',
			'vitamin_js' => 'konfigurasi_trade_manager/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}

	public function add()
	{
		$tgl_obj     = new DateTime('now');
		$arr_package = $this->M_konfigurasi_trade_manager->get_list_package();
		$data = [
			'title'       => APP_NAME . ' | Tambah Konfigurasi Trade Manager',
			'content'     => 'konfigurasi_trade_manager/form',
			'vitamin_css' => 'konfigurasi_trade_manager/form_css',
			'vitamin_js'  => 'konfigurasi_trade_manager/form_js',
			'arr_package' => $arr_package,
			'tgl_obj'     => $tgl_obj,
		];
		$this->template->render($data);
	}

	public function detail_package()
	{
		$id = $this->input->get('id_package_trade_manager');

		$arr = $this->M_konfigurasi_trade_manager->get_list_package($id);

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
		$id                        = $this->input->post('id_package_trade_manager');
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
			'id_package_trade_manager'  => $id,
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
		$exec = $this->M_core->store('konfigurasi_trade_manager', $data);

		$return = [
			'code'    => 500,
			'message' => "Tambah Konfigurasi Trade Manager Gagal",
		];
		if ($exec) {
			$return = [
				'code'    => 200,
				'message' => "Tambah Konfigurasi Trade Manager Berhasil",
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
		$this->M_core->update('konfigurasi_trade_manager', $data, $where);

		redirect('trade_manager/konfigurasi');
	}
}
        
/* End of file  KonfigurasiTradeManagerController.php */
