<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BonusQLController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_bonus_qualification_level');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_bonus_qualification_level->get_list();
		$data = [
			'title'      => APP_NAME . ' | Bonus Qualification Leader',
			'content'    => 'bonus_qualification_level/main',
			'vitamin_js' => 'bonus_qualification_level/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  BonusQLController.php */
