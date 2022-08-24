<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProfitTradeManagerController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_profit_trade_manager');

		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_profit_trade_manager->get_list();
		$data = [
			'title'      => APP_NAME . ' | Profit Trade Manager',
			'content'    => 'profit_trade_manager/main',
			'vitamin_js' => 'profit_trade_manager/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  ProfitTradeManagerController.php */
