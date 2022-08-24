<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BonusRecruitmentController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_bonus_recruitment');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_bonus_recruitment->get_list();
		$data = [
			'title'      => APP_NAME . ' | Bonus Recruitment',
			'content'    => 'bonus_recruitment/main',
			'vitamin_js' => 'bonus_recruitment/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  BonusRecruitmentController.php */
