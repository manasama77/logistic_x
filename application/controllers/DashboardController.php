<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
	protected $date;
	protected $datetime;
	protected $from;
	protected $from_alias;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_dashboard');
		$this->load->helper('floating_helper');

		$this->date       = date('Y-m-d');
		$this->datetime   = date('Y-m-d H:i:s');
		$this->from       = EMAIL_ADMIN;
		$this->from_alias = EMAIL_ALIAS;
	}


	public function index()
	{
		$card = $this->_card();

		$data = [
			'title'      => APP_NAME . ' | Dashboard',
			'content'    => 'dashboard/main',
			'vitamin_js' => 'dashboard/main_js',
			'card'       => $card,
		];
		$this->template->render($data);
	}

	protected function _card()
	{
		return true;
	}
}
        
/* End of file DashboardController.php */
