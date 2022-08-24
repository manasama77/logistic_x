<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_konfigurasi_crypto_asset extends CI_Model
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
				'package_crypto_asset.id',
				'package_crypto_asset.code',
				'package_crypto_asset.name',
				'package_crypto_asset.amount',
				'package_crypto_asset.contract_duration',
			])
			->from('package_crypto_asset as package_crypto_asset')
			->order_by('package_crypto_asset.sequence')
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
				'konfigurasi_crypto_asset.id',
				'package_crypto_asset.code',
				'package_crypto_asset.name',
				'package_crypto_asset.amount',
				'konfigurasi_crypto_asset.profit_per_month_percent',
				'konfigurasi_crypto_asset.profit_per_month_value',
				'konfigurasi_crypto_asset.profit_per_day_percentage',
				'konfigurasi_crypto_asset.profit_per_day_value',
				'package_crypto_asset.contract_duration',
				'konfigurasi_crypto_asset.share_self_percentage',
				'konfigurasi_crypto_asset.share_self_value',
				'konfigurasi_crypto_asset.share_upline_percentage',
				'konfigurasi_crypto_asset.share_upline_value',
				'konfigurasi_crypto_asset.share_company_percentage',
				'konfigurasi_crypto_asset.share_company_value',
				'package_crypto_asset.logo',
				'package_crypto_asset.sequence',
				'konfigurasi_crypto_asset.is_active',
				'konfigurasi_crypto_asset.tanggal_aktif',
				'konfigurasi_crypto_asset.created_at',
				'konfigurasi_crypto_asset.updated_at',
				'konfigurasi_crypto_asset.deleted_at',
			])
			->from('konfigurasi_crypto_asset as konfigurasi_crypto_asset')
			->join('package_crypto_asset as package_crypto_asset', 'package_crypto_asset.id = konfigurasi_crypto_asset.id_package_crypto_asset', 'left')
			->where('konfigurasi_crypto_asset.deleted_at', null)
			->order_by('package_crypto_asset.sequence')
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
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
				$tanggal_aktif             = $key->tanggal_aktif;
				$created_at                = $key->created_at;
				$updated_at                = $key->updated_at;
				$deleted_at                = $key->deleted_at;

				if ($is_active == "yes") {
					$is_active_badge = '<span class="badge badge-success">Aktif</span>';
				} else {
					$is_active_badge = '<span class="badge badge-danger">Tidak Aktif</span>';
				}

				$nested = compact([
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
					'tanggal_aktif',
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
                        
/* End of file M_konfigurasi_crypto_asset.php */
