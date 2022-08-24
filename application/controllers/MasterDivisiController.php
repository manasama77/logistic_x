<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MasterDivisiController extends CI_Controller
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
		$arr = $this->M_core->get('divisions', '*', null, 'id', 'asc');
		$data = [
			'title'      => APP_NAME . ' | Master Divisi',
			'content'    => 'management_pengguna/master_divisi/main',
			'vitamin_js' => 'management_pengguna/master_divisi/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}

	public function store()
	{
		$data = ['name' => $this->input->post('name')];
		$exec = $this->M_core->store('divisions', $data);

		$code    = 500;
		$message = "Tambah Data Gagal";
		if ($exec) {
			$code    = 200;
			$message = "Tambah Data Berhasil";
		}

		echo json_encode([
			'code'    => $code,
			'message' => $message,
		]);
	}

	public function destroy()
	{
		$where = ['id' => $this->input->post('id')];
		$exec = $this->M_core->delete('divisions', $where);

		$code    = 500;
		$message = "Delete Data Gagal";
		if ($exec) {
			$code    = 200;
			$message = "Delete Data Berhasil";
		}

		echo json_encode([
			'code'    => $code,
			'message' => $message,
		]);
	}

	public function update($id)
	{
		$where = ['id' => $id];
		$data = ['name' => $this->input->post('name')];
		$exec = $this->M_core->update('divisions', $data, $where);

		$code    = 500;
		$message = "Update Data Gagal";
		if ($exec) {
			$code    = 200;
			$message = "Update Data Berhasil";
		}

		echo json_encode([
			'code'    => $code,
			'message' => $message,
		]);
	}

	public function rekap()
	{
		$arr_penjualan = $this->M_accounting->get_list_penjualan();
		$arr_profit    = $this->M_accounting->get_list_profit();
		$arr_bonus     = $this->M_accounting->get_list_bonus();
		$arr_reward    = $this->M_accounting->get_list_reward();

		$data['total_omzet_penjualan']   = $arr_penjualan['total_omzet'];
		$data['total_expired_penjualan'] = $arr_penjualan['total_expired'];
		$data['sisa_piutang_penjualan']  = $arr_penjualan['sisa_piutang'];

		$data['sum_profit']          = $arr_profit['sum_profit'];
		$data['sum_wd_profit']       = $arr_profit['sum_wd'];
		$data['sisa_piutang_profit'] = $arr_profit['sisa_piutang'];

		$data['sum_bonus']          = $arr_bonus['sum_bonus'];
		$data['sum_wd_bonus']       = $arr_bonus['sum_wd'];
		$data['sisa_piutang_bonus'] = $arr_bonus['sisa_piutang'];

		$data['sum_reward']             = $arr_reward['sum_reward'];
		$data['sum_terbayarkan_reward'] = $arr_reward['sum_terbayarkan'];
		$data['sisa_piutang_reward']    = $arr_reward['sisa_piutang'];

		$data = [
			'title'      => APP_NAME . ' | Accounting Rekap',
			'content'    => 'accounting/rekap/main',
			'vitamin_js' => 'accounting/rekap/main_js',
			'data'       => $data,
		];
		$this->template->render($data);
	}
}
        
/* End of file  MasterDivisiController.php */
