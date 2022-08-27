<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* START LOGIN */
$route['default_controller']   = 'LoginController';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;
$route['login']  = 'LoginController/index';
$route['auth']   = 'LoginController/auth';
$route['logout'] = 'LoginController/logout';
/* END LOGIN */

/* START DASHBOARD */
$route['dashboard'] = 'DashboardController/index';
/* END DASHBOARD */

/* START PROFILE */
$route['profile']                = 'ProfileController/index';
$route['setting_update']         = 'ProfileController/setting_update';
$route['check_current_password'] = 'ProfileController/check_current_password';
$route['update_password']        = 'ProfileController/update_password';
$route['reset_password']         = 'ProfileController/reset_password';
/* END PROFILE */

/* *********************************************************************************** START MANAGEMENT BARANG */
/// START MASTER BARANG
$route['management_barang/master_barang']               = 'MasterBarangController/index';
$route['management_barang/master_barang/add']           = 'MasterBarangController/add';
$route['management_barang/master_barang/store']         = 'MasterBarangController/store';
$route['management_barang/master_barang/edit/(:num)'] = 'MasterBarangController/edit/$1';
$route['management_barang/master_barang/update/(:num)'] = 'MasterBarangController/update/$1';
$route['management_barang/master_barang/destroy']       = 'MasterBarangController/destroy';
/// END MASTER BARANG

/// START SATUAN BARANG
$route['management_barang/satuan_barang']               = 'SatuanBarangController/index';
$route['management_barang/satuan_barang/store']         = 'SatuanBarangController/store';
$route['management_barang/satuan_barang/destroy']       = 'SatuanBarangController/destroy';
$route['management_barang/satuan_barang/update/(:num)'] = 'SatuanBarangController/update/$1';
/// END SATUAN BARANG

/// START KATEGORI BARANG
$route['management_barang/kategori_barang']               = 'KategoriBarangController/index';
$route['management_barang/kategori_barang/store']         = 'KategoriBarangController/store';
$route['management_barang/kategori_barang/destroy']       = 'KategoriBarangController/destroy';
$route['management_barang/kategori_barang/update/(:num)'] = 'KategoriBarangController/update/$1';
/// END KATEGORI BARANG

/// START MASTER LOKASI
$route['management_barang/master_lokasi']               = 'MasterLokasiController/index';
$route['management_barang/master_lokasi/store']         = 'MasterLokasiController/store';
$route['management_barang/master_lokasi/destroy']       = 'MasterLokasiController/destroy';
$route['management_barang/master_lokasi/update/(:num)'] = 'MasterLokasiController/update/$1';
/// END MASTER LOKASI

/// START MASTER SUPPLIER
$route['management_barang/master_supplier']               = 'MasterSupplierController/index';
$route['management_barang/master_supplier/store']         = 'MasterSupplierController/store';
$route['management_barang/master_supplier/destroy']       = 'MasterSupplierController/destroy';
$route['management_barang/master_supplier/update/(:num)'] = 'MasterSupplierController/update/$1';
/// END MASTER SUPPLIER
/* *********************************************************************************** END MANAGEMENT BARANG */

/* *********************************************************************************** START MANAGEMENT PENGGUNA */
/// START MASTER DIVISI
$route['management_pengguna/master_divisi']               = 'MasterDivisiController/index';
$route['management_pengguna/master_divisi/store']         = 'MasterDivisiController/store';
$route['management_pengguna/master_divisi/destroy']       = 'MasterDivisiController/destroy';
$route['management_pengguna/master_divisi/update/(:num)'] = 'MasterDivisiController/update/$1';
/// END MASTER DIVISI

/// START MASTER USER
$route['management_pengguna/master_user']                = 'MasterUserController/index';
$route['management_pengguna/master_user/store']          = 'MasterUserController/store';
$route['management_pengguna/master_user/reset_password'] = 'MasterUserController/reset_password';
$route['management_pengguna/master_user/destroy']        = 'MasterUserController/destroy';
$route['management_pengguna/master_user/change_status']  = 'MasterUserController/change_status';
/// END MASTER USER
/* *********************************************************************************** END MANAGEMENT PENGGUNA */