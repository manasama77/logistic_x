<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller']   = 'LoginController';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']  = 'LoginController/index';
$route['auth']   = 'LoginController/auth';
$route['logout'] = 'LoginController/logout';

$route['dashboard']                 = 'DashboardController/index';

$route['profile']                = 'ProfileController/index';
$route['setting_update']         = 'ProfileController/setting_update';
$route['check_current_password'] = 'ProfileController/check_current_password';
$route['update_password']        = 'ProfileController/update_password';
$route['reset_password']         = 'ProfileController/reset_password';

$route['management_pengguna/master_divisi']               = 'MasterDivisiController/index';
$route['management_pengguna/master_divisi/store']         = 'MasterDivisiController/store';
$route['management_pengguna/master_divisi/destroy']       = 'MasterDivisiController/destroy';
$route['management_pengguna/master_divisi/update/(:num)'] = 'MasterDivisiController/update/$1';

$route['trade_manager/index']                        = 'TradeManagerController/index';
$route['trade_manager/profit']                        = 'ProfitTradeManagerController/index';
$route['trade_manager/konfigurasi']                    = 'KonfigurasiTradeManagerController/index';
$route['trade_manager/konfigurasi/add']                = 'KonfigurasiTradeManagerController/add';
$route['trade_manager/konfigurasi/detail_package']    = 'KonfigurasiTradeManagerController/detail_package';
$route['trade_manager/konfigurasi/store']            = 'KonfigurasiTradeManagerController/store';
$route['trade_manager/konfigurasi/destroy/(:any)']    = 'KonfigurasiTradeManagerController/destroy/$1';

$route['crypto_asset/index']                          = 'CryptoAssetController/index';
$route['crypto_asset/profit']                         = 'ProfitCryptoAssetController/index';
$route['crypto_asset/konfigurasi']                    = 'KonfigurasiCryptoAssetController/index';
$route['crypto_asset/konfigurasi/add']                = 'KonfigurasiCryptoAssetController/add';
$route['crypto_asset/konfigurasi/detail_package']     = 'KonfigurasiCryptoAssetController/detail_package';
$route['crypto_asset/konfigurasi/store']              = 'KonfigurasiCryptoAssetController/store';
$route['crypto_asset/konfigurasi/destryoy/(:any)']     = 'KonfigurasiCryptoAssetController/destroy/$1';

$route['bonus/recruitment']          = 'BonusRecruitmentController/index';
$route['bonus/qualification_leader'] = 'BonusQLController/index';
$route['bonus/royalty']              = 'BonusRoyaltyController/index';
$route['bonus/reward']               = 'BonusRewardController/index';
$route['bonus/reward/change_status'] = 'BonusRewardController/change_status';

$route['withdraw'] = 'WithdrawController/index';

$route['convert/index'] = 'ConvertController/index';

$route['transfer/index'] = 'TransferController/index';

$route['member_management']               = 'MemberController/index';
$route['member_management/store']         = 'MemberController/store';
$route['member_management/change_status'] = 'MemberController/change_status';
$route['member/data_kyc']                 = 'MemberController/data_kyc';
$route['member/terima_kyc']               = 'MemberController/terima_kyc';
$route['member/tolak_kyc']                = 'MemberController/tolak_kyc';

$route['founder']               = 'FounderController/index';
$route['founder/store']         = 'FounderController/store';
$route['founder/change_status'] = 'FounderController/change_status';
$route['founder/data_kyc']      = 'FounderController/data_kyc';

$route['admin_management'] = 'AdminManagementController/index';
$route['change_role']      = 'AdminManagementController/change_role';
$route['change_status']    = 'AdminManagementController/change_status';
$route['add_admin']        = 'AdminManagementController/add_admin';
$route['delete_admin']     = 'AdminManagementController/delete_admin';


$route['accounting/profit']    = 'AccountingPenjualanController/profit';
$route['accounting/bonus']     = 'AccountingPenjualanController/bonus';
$route['accounting/reward']    = 'AccountingPenjualanController/reward';
$route['accounting/rekap']     = 'AccountingPenjualanController/rekap';

$route['konfigurasi/aplikasi']        = 'KonfigurasiAplikasi/index';
$route['konfigurasi/aplikasi/update'] = 'KonfigurasiAplikasi/update';

// $route['init']                               = 'Init/init';
// $route['base64']                             = 'Init/base64';
// $route['send_email']                         = 'SendEmail';
// $route['coinpayment/get_basic_info']         = 'CoinPayment/get_basic_info';
// $route['coinpayment/rates']                  = 'CoinPayment/rates';
// $route['coinpayment/create_transaction']     = 'CoinPayment/create_transaction';
// $route['coinpayment/callback_address']       = 'CoinPayment/callback_address';
// $route['coinpayment/get_tx_info']            = 'CoinPayment/get_tx_info';
// $route['coinpayment/get_tx_ids']             = 'CoinPayment/get_tx_ids';
// $route['coinpayment/balances']               = 'CoinPayment/balances';
// $route['coinpayment/create_transfer']        = 'CoinPayment/create_transfer';
// $route['coinpayment/create_withdrawal']      = 'CoinPayment/create_withdrawal';
// $route['coinpayment/cancel_withdrawal']      = 'CoinPayment/cancel_withdrawal';
// $route['coinpayment/convert']                = 'CoinPayment/convert';
// $route['coinpayment/convert_limits']         = 'CoinPayment/convert_limits';
// $route['coinpayment/get_withdrawal_history'] = 'CoinPayment/get_withdrawal_history';
// $route['coinpayment/get_withdrawal_info']    = 'CoinPayment/get_withdrawal_info';

// $route['coinpayment/ipn'] = 'CoinPayment/ipn';
// $route['coinpayment/success'] = 'CoinPayment/success';
// $route['coinpayment/cancel'] = 'CoinPayment/cancel';

// $route['test/founder/add'] = 'TestController/insert_founder';
// $route['test/downline/add'] = 'TestController/insert_downline';
// $route['test/member/count_downline'] = 'TestController/count_downline';
// $route['test/member/show_tree'] = 'TestController/show_tree';
// $route['test/member/show_tree_attr'] = 'TestController/show_tree_attr';
