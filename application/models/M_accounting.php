<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_accounting extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('floating_helper');
	}


	public function get_list_penjualan()
	{
		$total_omzet   = 0;
		$total_expired = 0;
		$sisa_piutang  = 0;
		$data_active   = [];
		$data_inactive = [];

		$sql_1 = "
		SELECT
			tm.created_at,
			member_tm.fullname,
			member_tm.user_id,
			'tm' AS jenis,
			tm.package_name,
			tm.amount_1 AS investasi 
		FROM
			et_member_trade_manager AS tm
			LEFT JOIN et_member AS member_tm ON member_tm.id = tm.id_member 
		WHERE
			tm.state = 'active' UNION
		SELECT
			ca.created_at,
			member_ca.fullname,
			member_ca.user_id,
			'ca' AS jenis,
			ca.package_name,
			ca.amount_1 AS investasi 
		FROM
			et_member_crypto_asset AS ca
			LEFT JOIN et_member AS member_ca ON member_ca.id = ca.id_member 
		WHERE
			ca.state = 'active' 
		ORDER BY
			created_at DESC
		";

		$query_1 = $this->db->query($sql_1);


		foreach ($query_1->result() as $key) {
			$created_at   = $key->created_at;
			$fullname     = $key->fullname;
			$user_id      = $key->user_id;
			$jenis        = $key->jenis;
			$package_name = $key->package_name;
			$investasi    = $key->investasi;

			$nested = [
				'created_at'   => $created_at,
				'fullname'     => $fullname,
				'user_id'      => $user_id,
				'jenis'        => $jenis,
				'package_name' => $package_name,
				'investasi'    => check_float($investasi),
			];

			array_push($data_active, $nested);

			$total_omzet += $key->investasi;
		}

		$sql_2 = "
		SELECT
			tm.created_at,
			member_tm.fullname,
			member_tm.user_id,
			'tm' AS jenis,
			tm.package_name,
			tm.amount_1 AS investasi 
		FROM
			et_member_trade_manager AS tm
			LEFT JOIN et_member AS member_tm ON member_tm.id = tm.id_member 
		WHERE
			tm.state = 'expired' UNION
		SELECT
			ca.created_at,
			member_ca.fullname,
			member_ca.user_id,
			'ca' AS jenis,
			ca.package_name,
			ca.amount_1 AS investasi 
		FROM
			et_member_crypto_asset AS ca
			LEFT JOIN et_member AS member_ca ON member_ca.id = ca.id_member 
		WHERE
			ca.state = 'expired' 
		ORDER BY
			created_at DESC
		";

		$query_2 = $this->db->query($sql_2);

		foreach ($query_2->result() as $key) {
			$created_at   = $key->created_at;
			$fullname     = $key->fullname;
			$user_id      = $key->user_id;
			$jenis        = $key->jenis;
			$package_name = $key->package_name;
			$investasi    = check_float($key->investasi);

			$nested = [
				'created_at'   => $created_at,
				'fullname'     => $fullname,
				'user_id'      => $user_id,
				'jenis'        => $jenis,
				'package_name' => $package_name,
				'investasi'    => $investasi,
			];

			array_push($data_inactive, $nested);

			$total_expired += $key->investasi;
		}

		$sisa_piutang = $total_omzet - $total_expired;

		$return = [
			'data_active'   => $data_active,
			'data_inactive' => $data_inactive,
			'total_omzet'   => check_float($total_omzet),
			'total_expired' => check_float($total_expired),
			'sisa_piutang'  => check_float($sisa_piutang),
		];

		return $return;
	}

	public function get_list_profit()
	{
		$sum_profit   = 0;
		$sum_wd       = 0;
		$sisa_piutang = 0;
		$data_paket   = [];

		$sql = "
		SELECT
			member.fullname,
			member.user_id,
			( balance.total_invest_trade_manager + balance.total_invest_crypto_asset ) AS investasi,
			( balance.profit_unpaid + balance.profit_paid ) AS total_profit,
			( sum( withdraw.amount_1 ) ) AS total_wd,
			( ( balance.profit_unpaid + balance.profit_paid ) - sum( withdraw.amount_1 ) ) AS sisa_piutang 
		FROM
			et_member_balance AS balance
			LEFT JOIN et_member AS member ON member.id = balance.id_member
			LEFT JOIN et_member_withdraw AS withdraw ON 
				withdraw.id_member = balance.id_member 
				AND withdraw.source = 'profit_paid' 
				AND withdraw.state = 'success' 
		GROUP BY
			member.id 
		ORDER BY
			member.fullname ASC
		";

		$query = $this->db->query($sql);


		foreach ($query->result() as $key) {
			$fullname     = $key->fullname;
			$user_id      = $key->user_id;
			$investasi    = $key->investasi;
			$total_profit = $key->total_profit;
			$total_wd     = $key->total_wd;
			$sisa_piutang = $key->sisa_piutang;

			$nested = [
				'fullname'     => $fullname,
				'user_id'      => $user_id,
				'investasi'    => check_float($investasi),
				'total_profit' => check_float($total_profit),
				'total_wd'     => check_float($total_wd),
				'sisa_piutang' => check_float($sisa_piutang),
			];

			array_push($data_paket, $nested);

			$sum_profit += $key->total_profit;
			$sum_wd     += $key->total_wd;
		}

		$sisa_piutang = $sum_profit - $sum_wd;

		$return = [
			'data_paket'   => $data_paket,
			'sum_profit'   => check_float($sum_profit),
			'sum_wd'       => check_float($sum_wd),
			'sisa_piutang' => check_float($sisa_piutang),
		];

		return $return;
	}

	public function get_list_bonus()
	{
		$sum_bonus    = 0;
		$sum_wd       = 0;
		$sisa_piutang = 0;
		$data_paket   = [];

		$sql = "
		SELECT
			member.fullname,
			member.user_id,
			( balance.total_invest_trade_manager + balance.total_invest_crypto_asset ) AS investasi,
			balance.bonus AS total_bonus,
			( SELECT sum( recruitment.bonus_amount ) FROM et_log_bonus_recruitment AS recruitment WHERE recruitment.id_member = balance.id_member ) AS bonus_recruitment,
			( SELECT sum( ql.bonus_amount ) FROM et_log_bonus_qualification_level AS ql WHERE ql.id_member = balance.id_member ) AS bonus_ql,
			( SELECT sum( royalty.bonus_amount ) FROM et_log_bonus_royalty AS royalty WHERE royalty.id_member = balance.id_member ) AS bonus_royalty,
			( sum( withdraw.amount_1 ) ) AS total_wd,
			( balance.bonus - sum( withdraw.amount_1 ) ) AS sisa_piutang 
		FROM
			et_member_balance AS balance
			LEFT JOIN et_member AS member ON member.id = balance.id_member
			LEFT JOIN et_member_withdraw AS withdraw ON withdraw.id_member = balance.id_member 
			AND withdraw.source = 'profit_paid' 
			AND withdraw.state = 'success' 
		GROUP BY
			member.id 
		ORDER BY
			member.fullname ASC
		";

		$query = $this->db->query($sql);


		foreach ($query->result() as $key) {
			$fullname          = $key->fullname;
			$user_id           = $key->user_id;
			$investasi         = $key->investasi;
			$total_bonus       = $key->total_bonus;
			$bonus_recruitment = $key->bonus_recruitment;
			$bonus_ql          = $key->bonus_ql;
			$bonus_royalty     = $key->bonus_royalty;
			$total_wd          = $key->total_wd;
			$sisa_piutang      = $key->sisa_piutang;

			$nested = [
				'fullname'          => $fullname,
				'user_id'           => $user_id,
				'investasi'         => check_float($investasi),
				'total_bonus'       => check_float($total_bonus),
				'bonus_recruitment' => check_float($bonus_recruitment),
				'bonus_ql'          => check_float($bonus_ql),
				'bonus_royalty'     => check_float($bonus_royalty),
				'total_wd'          => check_float($total_wd),
				'sisa_piutang'      => check_float($sisa_piutang),
			];

			array_push($data_paket, $nested);

			$sum_bonus += $key->total_bonus;
			$sum_wd    += $key->total_wd;
		}

		$sisa_piutang = $sum_bonus - $sum_wd;

		$return = [
			'data_paket'   => $data_paket,
			'sum_bonus'    => check_float($sum_bonus),
			'sum_wd'       => check_float($sum_wd),
			'sisa_piutang' => check_float($sisa_piutang),
		];

		return $return;
	}

	public function get_list_reward()
	{
		$sum_reward      = 0;
		$sum_terbayarkan = 0;
		$sisa_piutang    = 0;
		$data_reward     = [];

		$reward_1_text = "Laptop";
		$reward_2_text = "Honda PCX";
		$reward_3_text = "Livina All New";
		$reward_4_text = "Pajero Sport";
		$reward_5_text = "Rumah Idaman";

		$reward_1_price = 700;
		$reward_2_price = 2100;
		$reward_3_price = 17250;
		$reward_4_price = 38000;
		$reward_5_price = 70000;

		$sql = "
		SELECT
			member.fullname,
			member.user_id,
			reward.reward_1,
			reward.reward_1_done,
			reward.reward_2,
			reward.reward_2_done,
			reward.reward_3,
			reward.reward_3_done,
			reward.reward_4,
			reward.reward_4_done,
			reward.reward_5,
			reward.reward_5_done 
		FROM
			et_member_reward AS reward
			LEFT JOIN et_member AS member ON member.id = reward.id_member
		";

		$query = $this->db->query($sql);

		foreach ($query->result() as $key) {
			$fullname      = $key->fullname;
			$user_id       = $key->user_id;
			$reward_1      = $key->reward_1;
			$reward_1_done = $key->reward_1_done;
			$reward_2      = $key->reward_2;
			$reward_2_done = $key->reward_2_done;
			$reward_3      = $key->reward_3;
			$reward_3_done = $key->reward_3_done;
			$reward_4      = $key->reward_4;
			$reward_4_done = $key->reward_4_done;
			$reward_5      = $key->reward_5;
			$reward_5_done = $key->reward_5_done;

			if ($reward_1 == "yes") {
				$reward       = $reward_1_text;
				$price        = check_float($reward_1_price);
				$terbayarkan  = 0;

				if ($reward_1_done == "yes") {
					$terbayarkan = $price;
				}

				$sisa_piutang = check_float($reward_1_price - $terbayarkan);

				$nested = [
					'reward'       => $reward,
					'price'        => $price,
					'terbayarkan'  => $terbayarkan,
					'sisa_piutang' => $sisa_piutang,
				];

				array_push($data_reward, $nested);
				$sum_reward      += $reward_1_price;
				$sum_terbayarkan += $terbayarkan;
			}

			if ($reward_2 == "yes") {
				$reward       = $reward_2_text;
				$price        = check_float($reward_2_price);
				$terbayarkan  = 0;

				if ($reward_2_done == "yes") {
					$terbayarkan = $price;
				}

				$sisa_piutang = check_float($reward_2_price - $terbayarkan);

				$nested = [
					'reward'       => $reward,
					'price'        => $price,
					'terbayarkan'  => $terbayarkan,
					'sisa_piutang' => $sisa_piutang,
				];

				array_push($data_reward, $nested);
				$sum_reward      += $reward_2_price;
				$sum_terbayarkan += $terbayarkan;
			}

			if ($reward_3 == "yes") {
				$reward       = $reward_3_text;
				$price        = check_float($reward_3_price);
				$terbayarkan  = 0;

				if ($reward_3_done == "yes") {
					$terbayarkan = $price;
				}

				$sisa_piutang = check_float($reward_3_price - $terbayarkan);

				$nested = [
					'reward'       => $reward,
					'price'        => $price,
					'terbayarkan'  => $terbayarkan,
					'sisa_piutang' => $sisa_piutang,
				];

				array_push($data_reward, $nested);
				$sum_reward      += $reward_3_price;
				$sum_terbayarkan += $terbayarkan;
			}

			if ($reward_4 == "yes") {
				$reward       = $reward_4_text;
				$price        = check_float($reward_4_price);
				$terbayarkan  = 0;

				if ($reward_4_done == "yes") {
					$terbayarkan = $price;
				}

				$sisa_piutang = check_float($reward_4_price - $terbayarkan);

				$nested = [
					'reward'       => $reward,
					'price'        => $price,
					'terbayarkan'  => $terbayarkan,
					'sisa_piutang' => $sisa_piutang,
				];

				array_push($data_reward, $nested);
				$sum_reward      += $reward_4_price;
				$sum_terbayarkan += $terbayarkan;
			}

			if ($reward_5 == "yes") {
				$reward       = $reward_5_text;
				$price        = check_float($reward_5_price);
				$terbayarkan  = 0;

				if ($reward_5_done == "yes") {
					$terbayarkan = $price;
				}

				$sisa_piutang = check_float($reward_5_price - $terbayarkan);

				$nested = [
					'reward'       => $reward,
					'price'        => $price,
					'terbayarkan'  => $terbayarkan,
					'sisa_piutang' => $sisa_piutang,
				];

				array_push($data_reward, $nested);
				$sum_reward      += $reward_5_price;
				$sum_terbayarkan += $terbayarkan;
			}
		}

		$sisa_piutang = $sum_reward - $sum_terbayarkan;

		$return = [
			'data_reward'     => $data_reward,
			'sum_reward'      => check_float($sum_reward),
			'sum_terbayarkan' => check_float($sum_terbayarkan),
			'sisa_piutang'    => check_float($sisa_piutang),
		];

		return $return;
	}
}
                        
/* End of file M_accounting.php */
