<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_transfer extends CI_Model
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
				'from_member.user_id AS `from`',
				'to_member.user_id AS `to`',
				'log_transfer.amount',
				'log_transfer.created_at'
			])
			->from('log_transfer as log_transfer')
			->join('member AS from_member', 'from_member.id = log_transfer.`from`', 'left')
			->join('member AS to_member', 'to_member.id = log_transfer.`to`', 'left')
			->get();

		$result = [];

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$from       = $key->from;
				$to         = $key->to;
				$amount     = check_float($key->amount);
				$created_at = $key->created_at;

				$nested = [
					'from'       => $from,
					'to'         => $to,
					'amount'     => $amount,
					'created_at' => $created_at,
				];

				array_push($result, $nested);
			}
		}

		return $result;
	}
}
                        
/* End of file M_transfer.php */
