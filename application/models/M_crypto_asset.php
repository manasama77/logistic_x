<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_crypto_asset extends CI_Model
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
				'member_crypto_asset.invoice',
				'member_crypto_asset.sequence',
				'member_crypto_asset.payment_method',
				'member_crypto_asset.id_member',
				'member_crypto_asset.member_fullname',
				'member_crypto_asset.member_email',
				'member_crypto_asset.id_package',
				'member_crypto_asset.id_konfigurasi',
				'member_crypto_asset.package_code',
				'member_crypto_asset.package_name',
				'member_crypto_asset.receiver_wallet_address',
				'member_crypto_asset.txn_id',
				'member_crypto_asset.amount_1',
				'member_crypto_asset.amount_2',
				'member_crypto_asset.currency1',
				'member_crypto_asset.currency2',
				'member_crypto_asset.state',
				'member_crypto_asset.timeout',
				'member_crypto_asset.receive_amount',
				'member_crypto_asset.qrcode_url',
				'member_crypto_asset.status_url',
				'member_crypto_asset.checkout_url',
				'member_crypto_asset.expired_payment',
				'member_crypto_asset.expired_package',
				'member_crypto_asset.is_qualified',
				'member_crypto_asset.is_royalty',
				'member_crypto_asset.amount_profit',
				'member_crypto_asset.can_claim',
				'member_crypto_asset.profit_per_month_percent',
				'member_crypto_asset.profit_per_month_value',
				'member_crypto_asset.profit_per_day_percentage',
				'member_crypto_asset.profit_per_day_value',
				'member_crypto_asset.share_self_percentage',
				'member_crypto_asset.share_self_value',
				'member_crypto_asset.share_upline_percentage',
				'member_crypto_asset.share_upline_value',
				'member_crypto_asset.share_company_percentage',
				'member_crypto_asset.share_company_value',
				'member_crypto_asset.created_at',
			])
			->from('member_crypto_asset as member_crypto_asset')
			->where('member_crypto_asset.deleted_at', null)
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
				$created_at             = $key->created_at;
				$buyer_name             = $key->member_fullname;
				$buyer_email            = $key->member_email;
				$invoice                = $key->invoice;
				$package_name           = $key->package_name;
				$amount                 = check_float($key->amount_1);
				$profit_self_per_day    = check_float($key->share_self_value);
				$profit_upline_per_day  = check_float($key->share_upline_value);
				$profit_company_per_day = check_float($key->share_company_value);
				$amount_profit          = check_float($key->amount_profit);
				$expired_at             = $key->expired_package;
				$state                  = $key->state;

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
					'buyer_email'            => $buyer_email,
					'invoice'                => $invoice,
					'package_name'           => $package_name,
					'amount'                 => $amount,
					'profit_self_per_day'    => $profit_self_per_day,
					'profit_upline_per_day'  => $profit_upline_per_day,
					'profit_company_per_day' => $profit_company_per_day,
					'amount_profit'          => $amount_profit,
					'expired_at'             => $expired_at,
					'state'                  => $state,
					'state_badge'            => $state_badge,
				];
				array_push($return, $nested);
			}
		}

		return $return;
	}
}
                        
/* End of file M_crypto_asset.php */
