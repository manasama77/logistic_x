<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_convert extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('floating_helper');
	}


	public function get_list()
	{
		$query = $this->db
			->select([
				'member.user_id',
				'log_convert.source',
				'log_convert.amount_usdt',
				'log_convert.amount_ratu',
				'log_convert.rate',
				'log_convert.created_at',
			])
			->from('log_convert as log_convert')
			->join('member as member', 'member.id = log_convert.id_member', 'left')
			->get();

		$result = [];

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$user_id     = $key->user_id;
				$source      = $key->source;
				$amount_usdt = check_float($key->amount_usdt);
				$amount_ratu = check_float($key->amount_ratu);
				$rate        = check_float($key->rate);
				$created_at  = $key->created_at;

				$nested = [
					'user_id'     => $user_id,
					'source'      => ucwords($source),
					'amount_usdt' => $amount_usdt,
					'amount_ratu' => $amount_ratu,
					'rate'        => $rate,
					'created_at'  => $created_at,
				];

				array_push($result, $nested);
			}
		}

		return $result;
	}
}
                        
/* End of file M_convert.php */
