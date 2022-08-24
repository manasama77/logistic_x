<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BonusRoyaltyController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_bonus_royalty');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_bonus_royalty->get_list();
		$data = [
			'title'      => APP_NAME . ' | Bonus Royalty',
			'content'    => 'bonus_royalty/main',
			'vitamin_js' => 'bonus_royalty/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  BonusRoyaltyController.php */
