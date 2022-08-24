<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CryptoAssetController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_crypto_asset');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_crypto_asset->get_list();
		$data = [
			'title'      => APP_NAME . ' | Crypto Asset',
			'content'    => 'crypto_asset/main',
			'vitamin_js' => 'crypto_asset/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  CryptoAssetController.php */
