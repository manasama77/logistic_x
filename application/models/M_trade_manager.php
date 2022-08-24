<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_trade_manager extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('floating_helper');
	}


	public function get_list()
	{
		$arr = $this->db
			->select([
				'member_trade_manager.invoice',
				'member_trade_manager.sequence',
				'member_trade_manager.payment_method',
				'member_trade_manager.id_member',
				'member_trade_manager.member_fullname',
				'member_trade_manager.member_user_id',
				'member_trade_manager.id_package',
				'member_trade_manager.id_konfigurasi',
				'member_trade_manager.package_code',
				'member_trade_manager.package_name',
				'member_trade_manager.receiver_wallet_address',
				'member_trade_manager.txn_id',
				'member_trade_manager.amount_1',
				'member_trade_manager.amount_2',
				'member_trade_manager.currency1',
				'member_trade_manager.currency2',
				'member_trade_manager.state',
				'member_trade_manager.timeout',
				'member_trade_manager.receive_amount',
				'member_trade_manager.qrcode_url',
				'member_trade_manager.status_url',
				'member_trade_manager.checkout_url',
				'member_trade_manager.expired_payment',
				'member_trade_manager.expired_package',
				'member_trade_manager.is_qualified',
				'member_trade_manager.is_royalty',
				'member_trade_manager.is_extend',
				'member_trade_manager.profit_per_month_percent',
				'member_trade_manager.profit_per_month_value',
				'member_trade_manager.profit_per_day_percentage',
				'member_trade_manager.profit_per_day_value',
				'member_trade_manager.share_self_percentage',
				'member_trade_manager.share_self_value',
				'member_trade_manager.share_upline_percentage',
				'member_trade_manager.share_upline_value',
				'member_trade_manager.share_company_percentage',
				'member_trade_manager.share_company_value',
				'member_trade_manager.created_at',
			])
			->from('member_trade_manager as member_trade_manager')
			->where('member_trade_manager.deleted_at', null)
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
				$created_at             = $key->created_at;
				$buyer_name             = $key->member_fullname;
				$buyer_user_id          = $key->member_user_id;
				$invoice                = $key->invoice;
				$package_name           = $key->package_name;
				$amount                 = check_float($key->amount_1);
				$profit_self_per_day    = check_float($key->share_self_value);
				$profit_upline_per_day  = check_float($key->share_upline_value);
				$profit_company_per_day = check_float($key->share_company_value);
				$expired_at             = $key->expired_package;
				$extend_mode            = $key->is_extend;
				$state                  = $key->state;

				if ($extend_mode == "auto") {
					$extend_mode_badge = '<badge class="badge badge-success">OTOMATIS</badge>';
				} else {
					$extend_mode_badge = '<badge class="badge badge-danger">MANUAL</badge>';
				}

				if ($state == "waiting payment") {
					$state_badge = '<badge class="badge badge-info">Menunggu Pembayaran</badge>';
				} elseif ($state == "pending") {
					$state_badge = '<badge class="badge badge-secondary">Verifikasi Pembayaran</badge>';
				} elseif ($state == "active") {
					$state_badge = '<badge class="badge badge-success">Aktif</badge>';
				} elseif ($state == "inactive") {
					$state_badge = '<badge class="badge badge-dark">Tidak Aktif</badge>';
				} elseif ($state == "cancel") {
					$state_badge = '<badge class="badge badge-warning">Cancel</badge>';
				} else {
					$state_badge = '<badge class="badge badge-danger">Kedaluwarsa</badge>';
				}

				$nested = [
					'created_at'             => $created_at,
					'buyer_name'             => $buyer_name,
					'buyer_user_id'          => $buyer_user_id,
					'invoice'                => $invoice,
					'package_name'           => $package_name,
					'amount'                 => $amount,
					'profit_self_per_day'    => $profit_self_per_day,
					'profit_upline_per_day'  => $profit_upline_per_day,
					'profit_company_per_day' => $profit_company_per_day,
					'expired_at'             => $expired_at,
					'extend_mode'            => $extend_mode,
					'extend_mode_badge'      => $extend_mode_badge,
					'state'                  => $state,
					'state_badge'            => $state_badge,
				];
				array_push($return, $nested);
			}
		}

		return $return;
	}
}
                        
/* End of file M_trade_manager.php */
