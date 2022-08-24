<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WithdrawController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_withdraw');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_withdraw->get_list();
		$data = [
			'title'      => APP_NAME . ' | Withdraw',
			'content'    => 'withdraw/main',
			'vitamin_js' => 'withdraw/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  WithdrawController.php */
