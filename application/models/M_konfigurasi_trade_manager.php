<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_konfigurasi_trade_manager extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('floating_helper');
	}

	public function get_list_package($id = null)
	{
		if ($id != null) {
			$this->db->where('id', $id);
		}

		$arr = $this->db
			->select([
				'package_trade_manager.id',
				'package_trade_manager.code',
				'package_trade_manager.name',
				'package_trade_manager.amount',
				'package_trade_manager.contract_duration',
			])
			->from('package_trade_manager as package_trade_manager')
			->order_by('package_trade_manager.sequence')
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
				$id     = $key->id;
				$code   = $key->code;
				$name   = $key->name;
				$amount = $key->amount;
				$contract_duration = $key->contract_duration;

				$nested = compact([
					'id',
					'code',
					'name',
					'amount',
					'contract_duration',
				]);
				array_push($return, $nested);
			}
		}

		return $return;
	}

	public function get_list()
	{
		$arr = $this->db
			->select([
				'konfigurasi_trade_manager.tanggal_aktif',
				'konfigurasi_trade_manager.id',
				'package_trade_manager.code',
				'package_trade_manager.name',
				'package_trade_manager.amount',
				'konfigurasi_trade_manager.profit_per_month_percent',
				'konfigurasi_trade_manager.profit_per_month_value',
				'konfigurasi_trade_manager.profit_per_day_percentage',
				'konfigurasi_trade_manager.profit_per_day_value',
				'package_trade_manager.contract_duration',
				'konfigurasi_trade_manager.share_self_percentage',
				'konfigurasi_trade_manager.share_self_value',
				'konfigurasi_trade_manager.share_upline_percentage',
				'konfigurasi_trade_manager.share_upline_value',
				'konfigurasi_trade_manager.share_company_percentage',
				'konfigurasi_trade_manager.share_company_value',
				'package_trade_manager.logo',
				'package_trade_manager.sequence',
				'konfigurasi_trade_manager.is_active',
				'konfigurasi_trade_manager.created_at',
				'konfigurasi_trade_manager.updated_at',
				'konfigurasi_trade_manager.deleted_at',
			])
			->from('konfigurasi_trade_manager as konfigurasi_trade_manager')
			->join('package_trade_manager as package_trade_manager', 'package_trade_manager.id = konfigurasi_trade_manager.id_package_trade_manager', 'left')
			->order_by('package_trade_manager.sequence')
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
				$tanggal_aktif             = $key->tanggal_aktif;
				$id                        = $key->id;
				$code                      = $key->code;
				$name                      = $key->name;
				$amount                    = check_float($key->amount);
				$profit_per_month_percent  = check_float($key->profit_per_month_percent);
				$profit_per_month_value    = check_float($key->profit_per_month_value);
				$profit_per_day_percentage = check_float($key->profit_per_day_percentage);
				$profit_per_day_value      = check_float($key->profit_per_day_value);
				$contract_duration         = $key->contract_duration;
				$share_self_percentage     = check_float($key->share_self_percentage);
				$share_self_value          = check_float($key->share_self_value);
				$share_upline_percentage   = check_float($key->share_upline_percentage);
				$share_upline_value        = check_float($key->share_upline_value);
				$share_company_percentage  = check_float($key->share_company_percentage);
				$share_company_value       = check_float($key->share_company_value);
				$logo                      = $key->logo;
				$sequence                  = $key->sequence;
				$is_active                 = $key->is_active;
				$created_at                = $key->created_at;
				$updated_at                = $key->updated_at;
				$deleted_at                = $key->deleted_at;

				if ($is_active == "yes") {
					$is_active_badge = '<span class="badge badge-success">Aktif</span>';
				} else {
					$is_active_badge = '<span class="badge badge-danger">Tidak Aktif</span>';
				}

				$nested = compact([
					'tanggal_aktif',
					'id',
					'code',
					'name',
					'amount',
					'profit_per_month_percent',
					'profit_per_month_value',
					'profit_per_day_percentage',
					'profit_per_day_value',
					'contract_duration',
					'share_self_percentage',
					'share_self_value',
					'share_upline_percentage',
					'share_upline_value',
					'share_company_percentage',
					'share_company_value',
					'logo',
					'sequence',
					'is_active',
					'is_active_badge',
					'created_at',
					'updated_at',
					'deleted_at',
				]);
				array_push($return, $nested);
			}
		}

		return $return;
	}
}
                        
/* End of file M_konfigurasi_trade_manager.php */
