<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BonusRewardController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_bonus_reward');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_bonus_reward->get_list();

		$data = [
			'title'      => APP_NAME . ' | Bonus Recruitment',
			'content'    => 'bonus_reward/main',
			'vitamin_js' => 'bonus_reward/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}

	public function change_status()
	{
		$id   = $this->input->post('id');
		$type = $this->input->post('type');

		$data  = ['reward_' . $type . '_done' => 'yes'];
		$where = ['id_member' => $id];
		$this->M_core->update('member_reward', $data, $where);

		echo json_encode(['code' => 200]);
	}
}
        
/* End of file  BonusRewardController.php */
