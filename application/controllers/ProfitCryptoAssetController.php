<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProfitCryptoAssetController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->model('M_profit_crypto_asset');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$arr = $this->M_profit_crypto_asset->get_list();
		$data = [
			'title'      => APP_NAME . ' | Profit Crypto Asset',
			'content'    => 'profit_crypto_asset/main',
			'vitamin_js' => 'profit_crypto_asset/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  ProfitCryptoAssetController.php */
