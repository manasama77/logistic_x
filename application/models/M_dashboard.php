<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
	protected $date;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('floating_helper');

		$this->date = date('Y-m-d');
	}


	public function get_total_investment()
	{
		$query = $this->db
			->select([
				'SUM( et_member_balance.total_invest_trade_manager ) AS sum_total_invest_trade_manager',
				'SUM( et_member_balance.count_trade_manager ) AS sum_count_trade_manager',
				'SUM( et_member_balance.total_invest_crypto_asset ) AS sum_total_invest_crypto_asset',
				'SUM( et_member_balance.count_crypto_asset ) AS sum_count_crypto_asset',
			])
			->from('et_member')
			->join('et_member_balance', 'et_member_balance.id_member = et_member.id', 'left')
			->where('et_member.is_active', 'yes')
			->where('et_member.deleted_at', null)
			->where('et_member_balance.deleted_at', null)
			->get();

		if ($query->num_rows() == 0) {
			$return = [
				'sum_total_invest_trade_manager' => 0,
				'sum_total_invest_crypto_asset'  => 0,
				'sum_count_trade_manager'        => 0,
				'sum_count_crypto_asset'         => 0,
			];
		} else {
			$sum_total_invest_trade_manager = $query->row()->sum_total_invest_trade_manager;
			$sum_total_invest_crypto_asset  = $query->row()->sum_total_invest_crypto_asset;
			$total_investment               = $sum_total_invest_trade_manager + $sum_total_invest_crypto_asset;
			$sum_count_trade_manager        = $query->row()->sum_count_trade_manager;
			$sum_count_crypto_asset         = $query->row()->sum_count_crypto_asset;
			$return = [
				'sum_total_invest_trade_manager' => check_float($sum_total_invest_trade_manager),
				'sum_total_invest_crypto_asset'  => check_float($sum_total_invest_crypto_asset),
				'total_investment'               => check_float($total_investment),
				'sum_count_trade_manager'        => check_float($sum_count_trade_manager),
				'sum_count_crypto_asset'         => check_float($sum_count_crypto_asset),
			];
		}

		return $return;
	}

	public function get_total_investment_today()
	{
		$arr_tm = $this->db
			->select([
				'SUM( amount_1 ) as sum_amount_usd',
				'COUNT( amount_1 ) as count',
			])
			->from('member_trade_manager')
			->where('deleted_at', null)
			->where('state', 'active')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_tm->num_rows() == 0) {
			$return['trade_manager'] = 0;
			$return['count_trade_manager'] = 0;
		} else {
			$return['trade_manager']       = check_float($arr_tm->row()->sum_amount_usd);
			$return['count_trade_manager'] = check_float($arr_tm->row()->count);
		}

		$arr_ca = $this->db
			->select([
				'SUM( amount_1 ) as sum_amount_usd',
				'COUNT( amount_1 ) as count',
			])
			->from('member_crypto_asset')
			->where('deleted_at', null)
			->where('state', 'active')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_ca->num_rows() == 0) {
			$return['crypto_asset'] = 0;
			$return['count_crypto_asset'] = 0;
		} else {
			$return['crypto_asset']       = check_float($arr_ca->row()->sum_amount_usd);
			$return['count_crypto_asset'] = check_float($arr_ca->row()->count);
		}

		return $return;
	}

	public function get_total_withdraw()
	{
		$arr_profit_usdt = $this->db
			->select([
				'SUM( amount_1 ) as sum_usdt'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'profit')
			->where('state', 'success')
			->get();

		if ($arr_profit_usdt->num_rows() == 0) {
			$return['sum_wd_profit_usdt'] = 0;
		} else {
			$return['sum_wd_profit_usdt'] = check_float($arr_profit_usdt->row()->sum_usdt);
		}

		$arr_profit_bnb = $this->db
			->select([
				'SUM( amount_2 ) as sum_bnb'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'profit')
			->where('state', 'success')
			->where('currency_2', 'BNB.BSC')
			->get();

		if ($arr_profit_bnb->num_rows() == 0) {
			$return['sum_wd_profit_bnb'] = 0;
		} else {
			$return['sum_wd_profit_bnb'] = check_float($arr_profit_bnb->row()->sum_bnb);
		}

		$arr_profit_trx = $this->db
			->select([
				'SUM( amount_2 ) as sum_trx'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'profit')
			->where('state', 'success')
			->where('currency_2', 'TRX')
			->get();

		if ($arr_profit_trx->num_rows() == 0) {
			$return['sum_wd_profit_trx'] = 0;
		} else {
			$return['sum_wd_profit_trx'] = check_float($arr_profit_trx->row()->sum_trx);
		}

		$arr_profit_ltct = $this->db
			->select([
				'SUM( amount_2 ) as sum_ltct'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'profit')
			->where('state', 'success')
			->where('currency_2', 'LTCT')
			->get();

		if ($arr_profit_ltct->num_rows() == 0) {
			$return['sum_wd_profit_ltct'] = 0;
		} else {
			$return['sum_wd_profit_ltct'] = check_float($arr_profit_ltct->row()->sum_ltct);
		}

		$arr_bonus_usdt = $this->db
			->select([
				'SUM( amount_1 ) as sum_usdt'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'bonus')
			->where('state', 'success')
			->get();

		if ($arr_bonus_usdt->num_rows() == 0) {
			$return['sum_wd_bonus_usdt'] = 0;
		} else {
			$return['sum_wd_bonus_usdt'] = check_float($arr_bonus_usdt->row()->sum_usdt);
		}

		$arr_bonus_bnb = $this->db
			->select([
				'SUM( amount_2 ) as sum_bnb'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'bonus')
			->where('state', 'success')
			->where('currency_2', 'BNB.BSC')
			->get();

		if ($arr_bonus_bnb->num_rows() == 0) {
			$return['sum_wd_bonus_bnb'] = 0;
		} else {
			$return['sum_wd_bonus_bnb'] = check_float($arr_bonus_bnb->row()->sum_bnb);
		}

		$arr_bonus_trx = $this->db
			->select([
				'SUM( amount_2 ) as sum_trx'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'bonus')
			->where('state', 'success')
			->where('currency_2', 'TRX')
			->get();

		if ($arr_bonus_trx->num_rows() == 0) {
			$return['sum_wd_bonus_trx'] = 0;
		} else {
			$return['sum_wd_bonus_trx'] = check_float($arr_bonus_trx->row()->sum_trx);
		}

		$arr_bonus_ltct = $this->db
			->select([
				'SUM( amount_2 ) as sum_ltct'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'bonus')
			->where('state', 'success')
			->where('currency_2', 'LTCT')
			->get();

		if ($arr_bonus_ltct->num_rows() == 0) {
			$return['sum_wd_bonus_ltct'] = 0;
		} else {
			$return['sum_wd_bonus_ltct'] = check_float($arr_bonus_ltct->row()->sum_ltct);
		}

		return $return;
	}

	public function get_today_withdraw()
	{
		$arr_profit_usdt = $this->db
			->select([
				'SUM( amount_1 ) as sum_usdt'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'profit')
			->where('state', 'success')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_profit_usdt->num_rows() == 0) {
			$return['sum_wd_profit_usdt'] = 0;
		} else {
			$return['sum_wd_profit_usdt'] = check_float($arr_profit_usdt->row()->sum_usdt);
		}

		$arr_profit_bnb = $this->db
			->select([
				'SUM( amount_2 ) as sum_bnb'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'profit')
			->where('state', 'success')
			->where('currency_2', 'BNB.BSC')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_profit_bnb->num_rows() == 0) {
			$return['sum_wd_profit_bnb'] = 0;
		} else {
			$return['sum_wd_profit_bnb'] = check_float($arr_profit_bnb->row()->sum_bnb);
		}

		$arr_profit_trx = $this->db
			->select([
				'SUM( amount_2 ) as sum_trx'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'profit')
			->where('state', 'success')
			->where('currency_2', 'TRX')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_profit_trx->num_rows() == 0) {
			$return['sum_wd_profit_trx'] = 0;
		} else {
			$return['sum_wd_profit_trx'] = check_float($arr_profit_trx->row()->sum_trx);
		}

		$arr_profit_ltct = $this->db
			->select([
				'SUM( amount_2 ) as sum_ltct'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'profit')
			->where('state', 'success')
			->where('currency_2', 'LTCT')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_profit_ltct->num_rows() == 0) {
			$return['sum_wd_profit_ltct'] = 0;
		} else {
			$return['sum_wd_profit_ltct'] = check_float($arr_profit_ltct->row()->sum_ltct);
		}

		$arr_bonus_usdt = $this->db
			->select([
				'SUM( amount_1 ) as sum_usdt'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'bonus')
			->where('state', 'success')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_bonus_usdt->num_rows() == 0) {
			$return['sum_wd_bonus_usdt'] = 0;
		} else {
			$return['sum_wd_bonus_usdt'] = check_float($arr_bonus_usdt->row()->sum_usdt);
		}

		$arr_bonus_bnb = $this->db
			->select([
				'SUM( amount_2 ) as sum_bnb'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'bonus')
			->where('state', 'success')
			->where('currency_2', 'BNB.BSC')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_bonus_bnb->num_rows() == 0) {
			$return['sum_wd_bonus_bnb'] = 0;
		} else {
			$return['sum_wd_bonus_bnb'] = check_float($arr_bonus_bnb->row()->sum_bnb);
		}

		$arr_bonus_trx = $this->db
			->select([
				'SUM( amount_2 ) as sum_trx'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'bonus')
			->where('state', 'success')
			->where('currency_2', 'TRX')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_bonus_trx->num_rows() == 0) {
			$return['sum_wd_bonus_trx'] = 0;
		} else {
			$return['sum_wd_bonus_trx'] = check_float($arr_bonus_trx->row()->sum_trx);
		}

		$arr_bonus_ltct = $this->db
			->select([
				'SUM( amount_2 ) as sum_ltct'
			])
			->from('member_withdraw')
			->where('deleted_at', null)
			->where('source', 'bonus')
			->where('state', 'success')
			->where('currency_2', 'LTCT')
			->where('DATE(created_at)', $this->date)
			->get();

		if ($arr_bonus_ltct->num_rows() == 0) {
			$return['sum_wd_bonus_ltct'] = 0;
		} else {
			$return['sum_wd_bonus_ltct'] = check_float($arr_bonus_ltct->row()->sum_ltct);
		}

		return $return;
	}

	public function get_total_member()
	{
		$member_active   = $this->db->from('member')->where('is_active', 'yes')->get()->num_rows();
		$member_inactive = $this->db->from('member')->where('is_active', 'no')->get()->num_rows();
		$member_deleted  = $this->db->from('member')->where('deleted_at !=', null)->get()->num_rows();
		$total_member    = $member_active + $member_inactive + $member_deleted;

		$return = [
			'member_active'   => check_float($member_active),
			'member_inactive' => check_float($member_inactive),
			'member_deleted'  => check_float($member_deleted),
			'total_member'    => check_float($total_member),
		];

		return $return;
	}

	public function get_latest_member($limit = NULL)
	{
		if ($limit) {
			$this->db->limit($limit);
		}

		$query = $this->db
			->select([
				'tree.lft',
				'tree.rgt',
				'tree.depth',
				'member.id',
				'member.user_id',
				'member.profile_picture',
				'member.fullname',
				'member.email',
				'member.phone_number',
				'( SELECT upline.user_id FROM et_member AS upline WHERE upline.id = member.id ) AS upline_user_id',
				'( SELECT upline.fullname FROM et_member AS upline WHERE upline.id = member.id ) AS upline_fullname',
				'( SELECT upline.email FROM et_member AS upline WHERE upline.id = member.id ) AS upline_email',
				'balance.total_omset',
				'( SELECT count(*) FROM et_tree AS downline WHERE downline.lft > tree.lft AND downline.rgt < tree.rgt ) AS total_downline ',
			])
			->from('et_tree AS tree')
			->join('et_member AS member', 'member.id = tree.id_member', 'left')
			->join('et_member_balance AS balance', 'balance.id_member = tree.id_member', 'left')
			->where('member.deleted_at', null)
			->order_by('member.created_at', 'DESC')
			->get();

		if ($query->num_rows() == 0) {
			return [];
		}

		$return = [];
		$i      = 0;
		foreach ($query->result() as $key) {
			$lft                     = $key->lft;
			$rgt                     = $key->rgt;
			$depth                   = $key->depth;
			$id                      = $key->id;
			$user_id                 = $key->user_id;
			$email                   = $key->email;
			$profile_picture         = base_url() . 'public/img/pp/default_avatar.svg';
			$fullname                = $key->fullname;
			$user_id                 = $key->user_id;
			$phone_number            = $key->phone_number;
			$upline_user_id          = $key->upline_user_id;
			$upline_fullname         = $key->upline_fullname;
			$upline_email            = $key->upline_email;
			$total_omset             = $key->total_omset;
			$total_downline          = $key->total_downline;
			$total_omset_formated    = check_float($key->total_omset);
			$total_downline_formated = check_float($key->total_downline);

			$return[$i++] = compact([
				'lft',
				'rgt',
				'depth',
				'id',
				'user_id',
				'profile_picture',
				'user_id',
				'fullname',
				'email',
				'phone_number',
				'upline_fullname',
				'upline_email',
				'upline_user_id',
				'total_omset',
				'total_downline',
				'total_omset_formated',
				'total_downline_formated',
			]);
		}
		return $return;
	}

	public function get_total_profit_bonus_member()
	{
		$arr = $this->db
			->select([
				'SUM( balance.profit_paid ) as sum_profit_paid',
				'SUM( balance.profit_unpaid ) as sum_profit_unpaid',
				'SUM( balance.ratu ) as sum_ratu',
				'SUM( balance.bonus ) as sum_bonus',
			])
			->from('member as member')
			->join('member_balance as balance', 'balance.id_member = member.id', 'left')
			->where('member.deleted_at', null)
			->where('member.is_active', 'yes')
			->get();

		$sum_profit_paid   = check_float($arr->row()->sum_profit_paid);
		$sum_profit_unpaid = check_float($arr->row()->sum_profit_unpaid);
		$sum_ratu          = check_float($arr->row()->sum_ratu);
		$sum_bonus         = check_float($arr->row()->sum_bonus);

		$return = compact('sum_profit_paid', 'sum_profit_unpaid', 'sum_ratu', 'sum_bonus');
		return $return;
	}

	public function get_latest_downline($id_member, $depth = null, $limit = null)
	{
		$this->db->select("
			member.id,
			member.user_id,
			member.profile_picture,
			member.fullname,
			member.email,
			member.phone_number,
			( SELECT upline.user_id FROM et_member AS upline WHERE upline.id = member.id_upline ) AS user_id_upline,
			( SELECT upline.fullname FROM et_member AS upline WHERE upline.id = member.id_upline ) AS fullname_upline,
			( SELECT upline.email FROM et_member AS upline WHERE upline.id = member.id_upline ) AS email_upline,
			( tree.depth - ( SELECT self_tree.depth FROM et_tree AS self_tree WHERE self_tree.id_member = '$id_member' ) ) AS generation,
			balance.self_omset,
			balance.downline_omset,
			balance.total_omset,
			(
			SELECT
				count(*) 
			FROM
				et_member AS downline
				LEFT JOIN et_tree AS downline_tree ON downline_tree.id_member = downline.id 
			WHERE
				downline_tree.lft > tree.lft 
				AND downline_tree.rgt < tree.rgt 
				AND downline.is_active = 'yes' 
				AND downline.deleted_at IS NULL 
			) AS total_downline
		", false);
		$this->db->from('et_member AS member');
		$this->db->join('et_tree AS tree', 'tree.id_member = member.id', 'left');
		$this->db->join('et_member_balance AS balance', 'balance.id_member = member.id', 'left');
		$this->db->where('member.is_active', 'yes');
		$this->db->where('member.deleted_at', null);
		$this->db->where(
			'tree.lft >',
			"(SELECT lft FROM et_tree AS self_tree WHERE self_tree.id_member = '$id_member')",
			false
		);
		$this->db->where(
			'tree.rgt <',
			"(SELECT rgt FROM et_tree AS self_tree WHERE self_tree.id_member = '$id_member')",
			false
		);

		if ($depth != null) {
			$this->db->where('tree.depth', $depth);
		}

		$this->db->order_by('member.created_at', 'DESC');

		if ($limit != null) {
			$this->db->limit($limit);
		}

		$query = $this->db->get();

		$result = [];
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$id              = $key->id;
				$user_id         = $key->user_id;
				$profile_picture = ($key->profile_picture == NULL) ? base_url() . 'public/img/pp/default_avatar.svg' : base_url() . "public/img/pp/$key->profile_picture";
				$fullname        = $key->fullname;
				$email           = $key->email;
				$phone_number    = $key->phone_number;
				$user_id_upline  = $key->user_id_upline;
				$fullname_upline = $key->fullname_upline;
				$email_upline    = $key->email_upline;
				$generation      = $key->generation;
				$self_omset      = check_float($key->self_omset);
				$downline_omset  = check_float($key->downline_omset);
				$total_omset     = check_float($key->total_omset);
				$total_downline  = check_float($key->total_downline);

				$nested = [
					'id'              => $id,
					'user_id'         => $user_id,
					'profile_picture' => $profile_picture,
					'fullname'        => $fullname,
					'email'           => $email,
					'phone_number'    => $phone_number,
					'user_id_upline'  => $user_id_upline,
					'fullname_upline' => $fullname_upline,
					'email_upline'    => $email_upline,
					'generation'      => $generation,
					'self_omset'      => $self_omset,
					'downline_omset'  => $downline_omset,
					'total_omset'     => $total_omset,
					'total_downline'  => $total_downline,
				];
				array_push($result, $nested);
			}
		}

		return $result;
	}
}
                        
/* End of file M_dashboard.php */
