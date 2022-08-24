<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TransferController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_transfer');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_transfer->get_list();
		$data = [
			'title'      => APP_NAME . ' | Transfer',
			'content'    => 'transfer/main',
			'vitamin_js' => 'transfer/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  TransferController.php */
