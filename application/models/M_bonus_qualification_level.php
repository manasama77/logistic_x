<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_bonus_qualification_level extends CI_Model
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
				'bonus_qualification_level.created_at',
				'member.fullname as fullname_member',
				'member.user_id as user_id_member',
				'downline.fullname as fullname_downline',
				'downline.user_id as user_id_downline',
				'bonus_qualification_level.type_package',
				'bonus_qualification_level.invoice',
				'bonus_qualification_level.package_name',
				'bonus_qualification_level.package_amount',
				'bonus_qualification_level.description',
			])
			->from('log_bonus_qualification_level as bonus_qualification_level')
			->join('member as member', 'member.id = bonus_qualification_level.id_member')
			->join('member as downline', 'downline.id = bonus_qualification_level.id_downline')
			->order_by('bonus_qualification_level.created_at', 'desc')
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
				$created_at        = $key->created_at;
				$fullname_member   = $key->fullname_member;
				$user_id_member    = $key->user_id_member;
				$fullname_downline = $key->fullname_downline;
				$user_id_downline  = $key->user_id_downline;
				$type_package      = $key->type_package;
				$invoice           = $key->invoice;
				$package_name      = $key->package_name;
				$bonus             = check_float($key->package_amount);
				$description       = $key->description;

				$nested = [
					'created_at'        => $created_at,
					'fullname_member'   => $fullname_member,
					'user_id_member'    => $user_id_member,
					'fullname_downline' => $fullname_downline,
					'user_id_downline'  => $user_id_downline,
					'type_package'      => $type_package,
					'invoice'           => $invoice,
					'package_name'      => $package_name,
					'bonus'             => $bonus,
					'description'       => $description,
				];
				array_push($return, $nested);
			}
		}

		return $return;
	}
}
                        
/* End of file M_bonus_qualification_level.php */
