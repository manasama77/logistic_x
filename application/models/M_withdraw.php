<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_withdraw extends CI_Model
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
				'member_withdraw.created_at',
				'member.fullname',
				'member.email',
				'member_withdraw.invoice',
				'member_withdraw.source',
				'member_withdraw.amount_1',
				'member_withdraw.amount_2',
				'member_withdraw.currency_2',
				'member_withdraw.wallet_address',
				'member_withdraw.tx_id',
				'member_withdraw.state',
			])
			->from('member_withdraw as member_withdraw')
			->join('member as member', 'member.id = member_withdraw.id_member', 'left')
			->where('member_withdraw.deleted_at', null)
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
				$created_at     = $key->created_at;
				$fullname       = $key->fullname;
				$email          = $key->email;
				$invoice        = $key->invoice;
				$source         = $key->source;
				$amount_1       = check_float($key->amount_1);
				$amount_2       = check_float($key->amount_2);
				$currency_2     = $key->currency_2;
				$wallet_address = $key->wallet_address;
				$tx_id          = $key->tx_id;
				$state          = $key->state;

				$nested = [
					'created_at'     => $created_at,
					'fullname'       => $fullname,
					'email'          => $email,
					'invoice'        => $invoice,
					'source'         => $source,
					'amount_1'       => $amount_1,
					'amount_2'       => $amount_2,
					'currency_2'     => $currency_2,
					'wallet_address' => $wallet_address,
					'tx_id'          => $tx_id,
					'state'          => $state,
				];
				array_push($return, $nested);
			}
		}

		return $return;
	}
}
                        
/* End of file M_withdraw.php */
