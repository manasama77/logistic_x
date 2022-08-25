<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller']   = 'LoginController';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']  = 'LoginController/index';
$route['auth']   = 'LoginController/auth';
$route['logout'] = 'LoginController/logout';

$route['dashboard'] = 'DashboardController/index';


$route['profile']                = 'ProfileController/index';
$route['setting_update']         = 'ProfileController/setting_update';
$route['check_current_password'] = 'ProfileController/check_current_password';
$route['update_password']        = 'ProfileController/update_password';
$route['reset_password']         = 'ProfileController/reset_password';


$route['management_barang/master_lokasi']               = 'MasterLokasiController/index';
$route['management_barang/master_lokasi/store']         = 'MasterLokasiController/store';
$route['management_barang/master_lokasi/destroy']       = 'MasterLokasiController/destroy';
$route['management_barang/master_lokasi/update/(:num)'] = 'MasterLokasiController/update/$1';


$route['management_pengguna/master_divisi']               = 'MasterDivisiController/index';
$route['management_pengguna/master_divisi/store']         = 'MasterDivisiController/store';
$route['management_pengguna/master_divisi/destroy']       = 'MasterDivisiController/destroy';
$route['management_pengguna/master_divisi/update/(:num)'] = 'MasterDivisiController/update/$1';

$route['management_pengguna/master_user']                = 'MasterUserController/index';
$route['management_pengguna/master_user/store']          = 'MasterUserController/store';
$route['management_pengguna/master_user/reset_password'] = 'MasterUserController/reset_password';
$route['management_pengguna/master_user/destroy']        = 'MasterUserController/destroy';
$route['management_pengguna/master_user/change_status']  = 'MasterUserController/change_status';
