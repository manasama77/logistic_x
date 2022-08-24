<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ConvertController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_convert');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_convert->get_list();
		$data = [
			'title'      => APP_NAME . ' | Konversi',
			'content'    => 'convert/main',
			'vitamin_js' => 'convert/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  ConvertController.php */
