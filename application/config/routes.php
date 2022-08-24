<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller']   = 'LoginController';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']  = 'LoginController/index';
$route['auth']   = 'LoginController/auth';
$route['logout'] = 'LoginController/logout';

$route['dashboard'] = 'DashboardController/index';

$route['management_pengguna/master_divisi']               = 'MasterDivisiController/index';
$route['management_pengguna/master_divisi/store']         = 'MasterDivisiController/store';
$route['management_pengguna/master_divisi/destroy']       = 'MasterDivisiController/destroy';
$route['management_pengguna/master_divisi/update/(:num)'] = 'MasterDivisiController/update/$1';







$route['profile']                = 'ProfileController/index';
$route['setting_update']         = 'ProfileController/setting_update';
$route['check_current_password'] = 'ProfileController/check_current_password';
$route['update_password']        = 'ProfileController/update_password';
$route['reset_password']         = 'ProfileController/reset_password';



$route['admin_management'] = 'AdminManagementController/index';
$route['change_role']      = 'AdminManagementController/change_role';
$route['change_status']    = 'AdminManagementController/change_status';
$route['add_admin']        = 'AdminManagementController/add_admin';
$route['delete_admin']     = 'AdminManagementController/delete_admin';
