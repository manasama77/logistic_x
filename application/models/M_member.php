<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_member extends CI_Model
{

	public function get_list_member($id_member = null)
	{
		$this->db->select([
			'member.id',
			'member.email',
			'member.user_id',
			'member.id_card_number',
			'member.fullname',
			'member.phone_number',
			'member.address',
			'member.postal_code',
			'member.id_bank',
			'member.no_rekening',
			'member.id_upline',
			'member.country_code',
			'member.profile_picture',
			'member.is_active',
			'member.is_kyc',
			'member.created_at',
			'member.foto_ktp',
			'member.foto_pegang_ktp',

			'(SELECT upline.user_id from et_member as upline where upline.id = member.id_upline) as upline_user_id',
			'(SELECT upline.fullname from et_member as upline where upline.id = member.id_upline) as upline_fullname',
			'(SELECT upline.email from et_member as upline where upline.id = member.id_upline) as upline_email',
			'(SELECT count(*) from et_tree as downline where downline.lft > tree.lft and downline.rgt < tree.rgt) as count_downline',

			'member_balance.count_trade_manager',
			'member_balance.total_invest_trade_manager',
			'member_balance.count_crypto_asset',
			'member_balance.total_invest_crypto_asset',
			'member_balance.profit_paid',
			'member_balance.profit_unpaid',
			'member_balance.bonus',
			'member_balance.ratu',
			'(SELECT SUM(wd.amount_1) from et_member_withdraw as wd where wd.id_member = member.id and wd.source = "profit_paid" and wd.state = "success") as wd_profit',
			'(SELECT SUM(wd.amount_1) from et_member_withdraw as wd where wd.id_member = member.id and wd.source = "bonus" and wd.state = "success") as wd_bonus',
			'member_balance.total_omset',

			'bank.name as nama_bank',
		]);
		$this->db->from('member as member');
		$this->db->join('tree as tree', 'tree.id_member = member.id', 'left');
		$this->db->join('member_balance as member_balance', 'member_balance.id_member = member.id', 'left');
		$this->db->join('bank as bank', 'bank.id = member.id_bank', 'left');
		$this->db->where('member.deleted_at', null);
		$this->db->where('member.is_founder', 'no');

		if ($id_member != null) {
			$this->db->where('member.id', $id_member);
		}

		$this->db->order_by('member.id', 'desc');
		$query = $this->db->get();

		$return = [];

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$nested['id']                         = $key->id;
				$nested['email']                      = $key->email;
				$nested['user_id']                    = $key->user_id;
				$nested['id_card_number']             = $key->id_card_number;
				$nested['fullname']                   = $key->fullname;
				$nested['phone_number']               = $key->phone_number;
				$nested['address']                    = $key->address;
				$nested['postal_code']                = $key->postal_code;
				$nested['id_bank']                    = $key->id_bank;
				$nested['no_rekening']                = $key->no_rekening;
				$nested['id_upline']                  = $key->id_upline;
				$nested['country_code']               = $key->country_code;
				$nested['profile_picture']            = $key->profile_picture;
				$nested['is_active']                  = $key->is_active;
				$nested['is_kyc']                     = $key->is_kyc;
				$nested['created_at']                 = $key->created_at;
				$nested['upline_user_id']             = $key->upline_user_id;
				$nested['upline_fullname']            = $key->upline_fullname;
				$nested['upline_email']               = $key->upline_email;
				$nested['count_downline']             = check_float($key->count_downline);
				$nested['count_trade_manager']        = check_float($key->count_trade_manager);
				$nested['total_invest_trade_manager'] = check_float($key->total_invest_trade_manager);
				$nested['count_crypto_asset']         = check_float($key->count_crypto_asset);
				$nested['total_invest_crypto_asset']  = check_float($key->total_invest_crypto_asset);
				$nested['profit_paid']                = check_float($key->profit_paid);
				$nested['profit_unpaid']              = check_float($key->profit_unpaid);
				$nested['bonus']                      = check_float($key->bonus);
				$nested['ratu']                       = check_float($key->ratu);
				$nested['wd_profit']                  = check_float($key->wd_profit);
				$nested['wd_bonus']                   = check_float($key->wd_bonus);
				$nested['total_omset']                = check_float($key->total_omset);
				$nested['nama_bank']                  = $key->nama_bank;
				$nested['foto_ktp']                   = $key->foto_ktp;
				$nested['foto_pegang_ktp']            = $key->foto_pegang_ktp;

				array_push($return, $nested);
			}
		}

		return $return;
	}

	public function get_list_founder($id_member = null)
	{
		$this->db->select([
			'member.id',
			'member.email',
			'member.user_id',
			'member.id_card_number',
			'member.fullname',
			'member.phone_number',
			'member.address',
			'member.postal_code',
			'member.id_bank',
			'member.no_rekening',
			'member.id_upline',
			'member.country_code',
			'member.profile_picture',
			'member.is_active',
			'member.is_kyc',
			'member.created_at',
			'member.foto_ktp',
			'member.foto_pegang_ktp',

			'(SELECT count(*) from et_tree as downline where downline.lft > tree.lft and downline.rgt < tree.rgt) as count_downline',

			'member_balance.count_trade_manager',
			'member_balance.total_invest_trade_manager',
			'member_balance.count_crypto_asset',
			'member_balance.total_invest_crypto_asset',
			'member_balance.profit_paid',
			'member_balance.profit_unpaid',
			'member_balance.bonus',
			'member_balance.ratu',
			'member_balance.total_omset',

			'bank.name as nama_bank',
		]);
		$this->db->from('member as member');
		$this->db->join('tree as tree', 'tree.id_member = member.id', 'left');
		$this->db->join('member_balance as member_balance', 'member_balance.id_member = member.id', 'left');
		$this->db->join('bank as bank', 'bank.id = member.id_bank', 'left');
		$this->db->where('member.deleted_at', null);
		$this->db->where('member.is_founder', 'yes');

		if ($id_member != null) {
			$this->db->where('member.id', $id_member);
		}

		$this->db->order_by('member.id', 'desc');
		$query = $this->db->get();

		$return = [];

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$nested['id']                         = $key->id;
				$nested['email']                      = $key->email;
				$nested['user_id']                    = $key->user_id;
				$nested['id_card_number']             = $key->id_card_number;
				$nested['fullname']                   = $key->fullname;
				$nested['phone_number']               = $key->phone_number;
				$nested['address']                    = $key->address;
				$nested['postal_code']                = $key->postal_code;
				$nested['id_bank']                    = $key->id_bank;
				$nested['no_rekening']                = $key->no_rekening;
				$nested['id_upline']                  = $key->id_upline;
				$nested['country_code']               = $key->country_code;
				$nested['profile_picture']            = $key->profile_picture;
				$nested['is_active']                  = $key->is_active;
				$nested['is_kyc']                     = $key->is_kyc;
				$nested['created_at']                 = $key->created_at;
				$nested['count_downline']             = check_float($key->count_downline);
				$nested['count_trade_manager']        = check_float($key->count_trade_manager);
				$nested['total_invest_trade_manager'] = check_float($key->total_invest_trade_manager);
				$nested['count_crypto_asset']         = check_float($key->count_crypto_asset);
				$nested['total_invest_crypto_asset']  = check_float($key->total_invest_crypto_asset);
				$nested['profit_paid']                = check_float($key->profit_paid);
				$nested['profit_unpaid']              = check_float($key->profit_unpaid);
				$nested['bonus']                      = check_float($key->bonus);
				$nested['ratu']                       = check_float($key->ratu);
				$nested['total_omset']                = check_float($key->total_omset);
				$nested['nama_bank']                  = $key->nama_bank;
				$nested['foto_ktp']                   = $key->foto_ktp;
				$nested['foto_pegang_ktp']            = $key->foto_pegang_ktp;

				array_push($return, $nested);
			}
		}

		return $return;
	}

	public function get_data_member($id_member = null)
	{
		$this->db->select([
			'et_member.id',
			'et_member.email',
			'et_member.id_card_number',
			'et_member.fullname',
			'et_member.phone_number',
			'et_member.id_upline',
			'et_member.country_code',
			'et_member.profile_picture',
			'et_member.is_active',
			'et_member.ip_address',
			'et_member.user_agent',
			'et_member.created_at',
			'et_member_balance.total_invest_trade_manager',
			'et_member_balance.total_invest_crypto_asset',
		]);
		$this->db->from('member');
		$this->db->join('et_member_balance', 'et_member_balance.id_member = et_member.id', 'left');

		if ($id_member != null) {
			$this->db->where('member.id', $id_member);
		}

		$this->db->where('member.deleted_at', null);
		$this->db->order_by('member.id', 'desc');
		return $this->db->get();
	}

	public function cek_user_id($user_id)
	{
		$query = $this->db
			->select('*')
			->from('member as member')
			->where('user_id', $user_id)
			->where('deleted_at', null)
			->get();

		return $query->num_rows();
	}
}
                        
/* End of file M_member.php */
