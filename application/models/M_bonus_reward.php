<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_bonus_reward extends CI_Model
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
				'member.id',
				'member.user_id',
				'member.fullname',
				'member.email',
				'reward.reward_1',
				'reward.reward_1_date',
				'reward.reward_1_done',
				'reward.reward_2',
				'reward.reward_2_date',
				'reward.reward_2_done',
				'reward.reward_3',
				'reward.reward_3_date',
				'reward.reward_3_done',
				'reward.reward_4',
				'reward.reward_4_date',
				'reward.reward_4_done',
				'reward.reward_5',
				'reward.reward_5_date',
				'reward.reward_5_done'
			])
			->from('member_reward AS reward')
			->join('member as member', 'member.id = reward.id_member')
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
				$id            = $key->id;
				$user_id       = $key->user_id;
				$fullname      = $key->fullname;
				$email         = $key->email;
				$reward_1      = $key->reward_1;
				$reward_1_date = $key->reward_1_date;
				$reward_1_done = $key->reward_1_done;
				$reward_2      = $key->reward_2;
				$reward_2_date = $key->reward_2_date;
				$reward_2_done = $key->reward_2_done;
				$reward_3      = $key->reward_3;
				$reward_3_date = $key->reward_3_date;
				$reward_3_done = $key->reward_3_done;
				$reward_4      = $key->reward_4;
				$reward_4_date = $key->reward_4_date;
				$reward_4_done = $key->reward_4_done;
				$reward_5      = $key->reward_5;
				$reward_5_date = $key->reward_5_date;
				$reward_5_done = $key->reward_5_done;

				if ($reward_1 == "yes") {
					$nested = [
						'id'           => $id,
						'user_id'      => $user_id,
						'fullname'     => $fullname,
						'email'        => $email,
						'reward_date'  => $reward_1_date,
						'reward_done'  => $reward_1_done,
						'reward_badge' => $this->_craft_badge($reward_1_done, $id, $fullname, 1),
						'reward_type'  => 1,
					];
					array_push($return, $nested);
				}

				if ($reward_2 == "yes") {
					$nested = [
						'id'           => $id,
						'user_id'      => $user_id,
						'fullname'     => $fullname,
						'email'        => $email,
						'reward_date'  => $reward_2_date,
						'reward_done'  => $reward_2_done,
						'reward_badge' => $this->_craft_badge($reward_2_done, $id, $fullname, 2),
						'reward_type'  => 2,
					];
					array_push($return, $nested);
				}

				if ($reward_3 == "yes") {
					$nested = [
						'id'           => $id,
						'user_id'      => $user_id,
						'fullname'     => $fullname,
						'email'        => $email,
						'reward_date'  => $reward_3_date,
						'reward_done'  => $reward_3_done,
						'reward_badge' => $this->_craft_badge($reward_3_done, $id, $fullname, 3),
						'reward_type'  => 3,
					];
					array_push($return, $nested);
				}

				if ($reward_4 == "yes") {
					$nested = [
						'id'           => $id,
						'user_id'      => $user_id,
						'fullname'     => $fullname,
						'email'        => $email,
						'reward_date'  => $reward_4_date,
						'reward_done'  => $reward_4_done,
						'reward_badge' => $this->_craft_badge($reward_4_done, $id, $fullname, 4),
						'reward_type'  => 4,
					];
					array_push($return, $nested);
				}

				if ($reward_5 == "yes") {
					$nested = [
						'id'           => $id,
						'user_id'      => $user_id,
						'fullname'     => $fullname,
						'email'        => $email,
						'reward_date'  => $reward_5_date,
						'reward_done'  => $reward_5_done,
						'reward_badge' => $this->_craft_badge($reward_5_done, $id, $fullname, 5),
						'reward_type'  => 5,
					];
					array_push($return, $nested);
				}
			}
		}

		return $return;
	}

	protected function _craft_badge($status, $id, $fullname, $reward_type)
	{
		if ($status == "yes") {
			$return = '<span class="badge badge-success">Complete</span>';
		} else {
			$return = '<span class="badge badge-warning" style="cursor: pointer;" onclick="changeStatus(\'' . $id . '\', \'' . $fullname . '\', \'' . $reward_type . '\')">Pending</span>';
		}

		return $return;
	}
}
                        
/* End of file M_bonus_reward.php */
