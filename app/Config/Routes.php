<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Main\HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');

$routes->group('auth', function ($routes) {
    $routes->get('login', 'Main\AuthController::loginPage');
    $routes->post('login/ProcessGetIn', 'Main\AuthController::processLogin');
    $routes->get('logged_out', 'Main\AuthController::LogOut');
});

$routes->group('sibabad', function ($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('coa/index', 'Admin\ChartOfAccountController::index');
    $routes->get('profil-user', 'Admin\ProfilController::index');
    $routes->get('refund2', 'Admin\RefundController::refund');
    $routes->post('refund2', 'Admin\RefundController::refund');
    $routes->get('tukar', 'Admin\TukarController::tukar');
    $routes->post('tukar', 'Admin\TukarController::tukar');
});

$routes->group('sibabad/coa', function ($routes) { // Chart of Account
    $routes->post('saveCoaData', 'Admin\ChartOfAccountController::saveCoaData');
    $routes->get('getCoaData', 'Admin\ChartOfAccountController::getCoaData');
    $routes->get('deleteCoaData/(:any)', 'Admin\ChartOfAccountController::deleteCoaData/$1');
});

$routes->group('sibabad/direct_order', function ($routes) { // Pembelian langsung
    $routes->get('index', 'Admin\DirectOrderController::index');
    $routes->get('editDO/(:num)', 'Admin\DirectOrderController::editDO/$1');
    $routes->get('getDateRange', 'Admin\DirectOrderController::getDateRange');
    $routes->post('saveData', 'Admin\DirectOrderController::saveData');
    $routes->post('updateData/(:num)', 'Admin\DirectOrderController::updateData/$1');
    $routes->delete('deleteDO/(:num)', 'Admin\DirectOrderController::deleteDO/$1');
    $routes->delete('deleteDataDO/(:num)', 'Admin\DirectOrderController::deleteDataDO/$1');
    $routes->get('pdf/dompdf/(:num)', 'Admin\PdfController::dompdf/$1');
});

$routes->group('sibabad/pdf', function ($routes) { // Gudang
    $routes->get('dompdf/(:num)', 'Admin\PdfController::dompdf/$1');
    $routes->get('transaksipdf', 'Admin\PdfController::transaksipdf');
    $routes->get('transaksirekappdf', 'Admin\PdfController::transaksirekappdf');
    $routes->get('cetakBarcode/(:num)', 'Admin\PdfController::cetakBarcode/$1');
});

$routes->group('sibabad/recieve_order', function ($routes) { // Penerimaan Produk
    $routes->get('index', 'Admin\RecieveOrderController::index');
    $routes->get('editRO/(:num)', 'Admin\RecieveOrderController::editRO/$1');
    $routes->get('detailRO/(:num)', 'Admin\RecieveOrderController::detailRO/$1');
    $routes->get('tambahRO/(:num)', 'Admin\RecieveOrderController::tambahRO/$1');
    $routes->get('getDateRange', 'Admin\RecieveOrderController::getDateRange');
    $routes->post('saveData/(:num)', 'Admin\RecieveOrderController::saveData/$1');
    $routes->post('updateData/(:num)', 'Admin\RecieveOrderController::updateData/$1');
    $routes->delete('deleteRO/(:num)', 'Admin\RecieveOrderController::deleteRO/$1');
    // $routes->delete('deleteDataRO/(:num)', 'Admin\RecieveOrderController::deleteDataDO/$1');
});

$routes->group('sibabad/stock-product', function ($routes) { // Stok Produk Untuk Kasir 
    $routes->get('index', 'Admin\StockProductController::index');
    $routes->get('tambah', 'Admin\StockProductController::tambah');
    $routes->post('saveData', 'Admin\StockProductController::saveData');
    $routes->post('editData/(:num)', 'Admin\StockProductController::editData/$1');
    $routes->get('editProduct/(:num)', 'Admin\StockProductController::editProduct/$1');
    $routes->get('bukaBox/(:num)', 'Admin\StockProductController::bukaBox/$1');
    $routes->post('tambahPcs', 'Admin\StockProductController::tambahPcs');
    $routes->delete('deleteStock/(:num)', 'Admin\StockProductController::deleteStock/$1');
    $routes->get('getProductDetail/(:num)', 'Admin\StockProductController::getProductDetail/$1');
    $routes->get('editProduct/getHargaJual/(:num)', 'Admin\StockProductController::getHargaJual/$1');
    $routes->get('bukaBox/getHargaJual/(:num)', 'Admin\StockProductController::getHargaJual/$1');
});

$routes->group('sibabad/transaction-sale', function ($routes) { // Transaksi Penjualan Kasir 
    $routes->get('index', 'Admin\TransactionSaleController::index');
    $routes->post('index', 'Admin\TransactionSaleController::index');
    $routes->get('detailTransaksi/(:num)', 'Admin\TransactionSaleController::detailTransaksi/$1');
    $routes->get('cetakTransaksi/(:num)', 'Admin\TransactionSaleController::cetakTransaksi/$1');
});

$routes->group('sibabad/product', function ($routes) { // Produk
    $routes->get('add-new', 'Admin\ProductController::index');
    $routes->post('saveData', 'Admin\ProductController::saveData');
    $routes->post('saveUnitType', 'Admin\ProductController::saveUnitType');
    $routes->post('editData/(:num)', 'Admin\ProductController::editData/$1');
    $routes->get('editProduct/(:num)', 'Admin\ProductController::editProduct/$1'); // View edit produk
    $routes->delete('deleteProduct/(:num)', 'Admin\ProductController::deleteProduct/$1');
    $routes->delete('deleteUnitType/(:num)', 'Admin\ProductController::deleteUnitType/$1');
});

$routes->group('sibabad/customer', function ($routes) { // Produk
    $routes->post('saveCustomer', 'Admin\CustomerController::saveCustomer');
    $routes->delete('deleteCustomer/(:num)', 'Admin\CustomerController::deleteCustomer/$1');
});

$routes->group('sibabad/kas', function ($routes) { // Produk
    $routes->post('saveKas', 'Admin\KasController::saveKas');
    $routes->delete('deleteKas/(:num)', 'Admin\KasController::deleteKas/$1');
});

$routes->group('sibabad2/kas', function ($routes) { // Produk
    $routes->post('saveKas', 'Kasir\KasController::saveKas');
    $routes->delete('deleteKas/(:num)', 'Kasir\KasController::deleteKas/$1');
});

$routes->group('sibabad/konversi', function ($routes) { // Produk
    $routes->post('saveKonversi', 'Admin\ConvertController::saveKonversi');
    $routes->delete('deleteKonversi/(:num)', 'Admin\ConvertController::deleteKonversi/$1');
});

$routes->group('sibabad/reports', function ($routes) { // Transaksi Harian
    $routes->get('daily', 'Admin\DailyTransaction::index');
});

$routes->group('sibabad/sale', function ($routes) { // Penjualan Kasir
    $routes->get('index', 'Admin\SaleController::index');
    $routes->get('transaksi_harian', 'Admin\SaleController::transaksi_harian');
    $routes->get('detailTransaksi/(:num)', 'Admin\SaleController::detailTransaksi/$1');
    $routes->get('keranjang', 'Admin\SaleController::keranjang');
    $routes->get('barcode', 'Admin\SaleController::barcode');
    $routes->get('detail', 'Admin\SaleController::detail');
    $routes->get('cekStok', 'Admin\SaleController::cekStok');
    $routes->get('cekHarga', 'Admin\SaleController::cekHarga');
    $routes->get('cekLevel', 'Admin\SaleController::cekLevel');
    $routes->post('tambahKeranjang', 'Admin\SaleController::tambahKeranjang');
    $routes->post('hapusItem', 'Admin\SaleController::hapusItem');
    $routes->post('ubahItem', 'Admin\SaleController::ubahItem');
    $routes->get('hapusTransaksi', 'Admin\SaleController::hapusTransaksi');
    $routes->post('bayarTransaksi', 'Admin\SaleController::bayarTransaksi');
    $routes->get('cetakTransaksi/(:num)', 'Admin\SaleController::cetakTransaksi/$1');
});

$routes->group('sibabad/tukar', function ($routes) { // Refund
    $routes->get('index', 'Admin\TukarController::index');
    $routes->post('saveData', 'Admin\TukarController::saveData');
    $routes->get('cetakTransaksi/(:any)', 'Admin\TukarController::cetakTransaksi/$1');
});

$routes->group('sibabad/refund', function ($routes) { // Refund
    $routes->get('index', 'Admin\RefundController::index');
    $routes->post('saveData', 'Admin\RefundController::saveData');
    $routes->get('cetakTransaksi/(:any)', 'Admin\RefundController::cetakTransaksi/$1');
});

$routes->group('sibabad/courier', function ($routes) { // Data Kurir
    $routes->get('index', 'Admin\CourierController::index');
    $routes->post('saveKurir', 'Admin\CourierController::saveKurir');
    $routes->delete('deleteKurir/(:num)', 'Admin\CourierController::deleteKurir/$1');
});

$routes->group('sibabad/supplier', function ($routes) { // Data Supplier
    $routes->get('index', 'Admin\SupplierController::index');
    $routes->post('saveData', 'Admin\SupplierController::saveData');
    $routes->get('getDataSupplier', 'Admin\SupplierController::getDataSupplier');
    $routes->get('editData/(:num)', 'Admin\SupplierController::editSupplier/$1');
    $routes->delete('deleteSupplier/(:num)', 'Admin\SupplierController::deleteSupplier/$1');
});

$routes->group('sibabad/journal', function ($routes) {
    $routes->get('input-transaction', 'Admin\JournalController::inputTransaction');
    $routes->get('edit-transaction/(:num)', 'Admin\JournalController::editTransaction/$1');
    $routes->get('reports', 'Admin\JournalController::getReports');
    $routes->get('search?search=(:any)', 'Admin\JournalController::searchJournal');
    $routes->post('postTypeIn', 'Admin\JournalController::addJournalIn'); // Insert data nama jurnal dari modal
    $routes->get('getTypeIn', 'Admin\JournalController::getTypeIn'); // Mendapatkan data nama jurnal pemasukkan
    $routes->post('saveJournal', 'Admin\JournalController::saveJournal');
    $routes->post('updateJournal/(:any)', 'Admin\JournalController::updateJournal/$1');
    $routes->delete('deleteDetailJournal/(:num)', 'Admin\JournalController::deleteDetailJournal/$1');
    $routes->delete('deleteJournal/(:num)', 'Admin\JournalController::deleteJournal/$1');
});

$routes->group('sibabad/warehouse', function ($routes) { // Gudang
    $routes->get('index', 'Admin\WarehouseController::index');
    $routes->post('saveData', 'Admin\WarehouseController::saveData');
    $routes->get('deleteWarehouseData/(:num)', 'Admin\WarehouseController::deleteWarehouseData/$1');
    $routes->post('editData/(:num)', 'Admin\WarehouseController::editData/$1');
    $routes->get('editView/(:num)', 'Admin\WarehouseController::editView/$1');
});

$routes->group('sibabad/user', function ($routes) { // Gudang
    $routes->get('index', 'Admin\UserController::index');
    $routes->post('saveData', 'Admin\UserController::saveData');
    $routes->get('deleteUserData/(:num)', 'Admin\UserController::deleteUserData/$1');
    $routes->post('editData/(:num)', 'Admin\UserController::editData/$1');
    $routes->get('editView/(:num)', 'Admin\UserController::editView/$1');
});

$routes->group('sibabad/shift', function ($routes) { // Shift
    $routes->get('index', 'Admin\ShiftController::index');
    $routes->post('saveData', 'Admin\ShiftController::saveData');
    $routes->get('deleteShiftData/(:num)', 'Admin\ShiftController::deleteShiftData/$1');
    $routes->post('editData/(:num)', 'Admin\ShiftController::editData/$1');
    $routes->get('editView/(:num)', 'Admin\ShiftController::editView/$1');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->post('profil/saveProfil', 'ProfilController::saveProfil');
    $routes->post('profil/biodataProfil', 'ProfilController::biodataProfil');
    $routes->post('profil/sosialProfil', 'ProfilController::sosialProfil');
    $routes->post('profil/sosialProfil', 'ProfilController::sosialProfil');
    $routes->post('profil/keahlianProfil', 'ProfilController::keahlianProfil');
    $routes->post('profil/userProfil', 'ProfilController::userProfil');
    $routes->get('profil/index', 'ProfilController::index');
});

$routes->group('sibabad/karyawan', function ($routes) { // Karyawan
    $routes->get('index', 'Admin\KaryawanController::index');
    $routes->post('saveData', 'Admin\KaryawanController::saveData');
    $routes->get('deleteKaryawanData/(:num)', 'Admin\KaryawanController::deleteKaryawanData/$1');
    $routes->post('editData/(:num)', 'Admin\KaryawanController::editData/$1');
    $routes->get('editView/(:num)', 'Admin\KaryawanController::editView/$1');
});

$routes->group('sibabad2', function ($routes) {
    $routes->get('/', 'Kasir\SaleController::index');
    $routes->post('kasir/sale/akhiriShift', 'Kasir\SaleController::akhiriShift');
    $routes->post('kasir/sale/mulaiShift', 'Kasir\SaleController::mulaiShift');
    $routes->get('profil-user', 'Kasir\ProfilController::index');
    $routes->get('refund2', 'Kasir\RefundController::refund');
    $routes->post('refund2', 'Kasir\RefundController::refund');
    $routes->get('tukar', 'Kasir\TukarController::tukar');
    $routes->post('tukar', 'Kasir\TukarController::tukar');
    $routes->get('editView/(:num)', 'Kasir\RefundController::editView/$1');
    $routes->get('getTransaksiByInvoice/(:segment)', 'Kasir\RefundController::getTransaksiByInvoice/$1');
    $routes->get('getConvertUnit', 'Kasir\RefundController::getConvertUnit');
});

$routes->group('sibabad2/tukar', function ($routes) { // Refund
    $routes->get('index', 'Kasir\TukarController::index');
    $routes->post('saveData', 'Kasir\TukarController::saveData');
    $routes->get('cetakTransaksi/(:any)', 'Kasir\TukarController::cetakTransaksi/$1');
});
   

$routes->group('sibabad2/refund', function ($routes) { // Refund
    $routes->get('index', 'Kasir\RefundController::index');
    $routes->post('saveData', 'Kasir\RefundController::saveData');
    $routes->get('cetakTransaksi/(:any)', 'Kasir\RefundController::cetakTransaksi/$1');
});

$routes->group('sibabad2/sale', function ($routes) { // Penjualan Kasir
    $routes->get('index', 'Kasir\SaleController::index');
    $routes->get('detailTransaksi/(:num)', 'Kasir\SaleController::detailTransaksi/$1');
    $routes->get('keranjang', 'Kasir\SaleController::keranjang');
    $routes->get('barcode', 'Kasir\SaleController::barcode');
    $routes->get('detail', 'Kasir\SaleController::detail');
    $routes->get('cekStok', 'Kasir\SaleController::cekStok');
    $routes->get('cekHarga', 'Kasir\SaleController::cekHarga');
    $routes->get('cekLevel', 'Kasir\SaleController::cekLevel');
    $routes->post('tambahKeranjang', 'Kasir\SaleController::tambahKeranjang');
    $routes->post('hapusItem', 'Kasir\SaleController::hapusItem');
    $routes->post('ubahItem', 'Kasir\SaleController::ubahItem');
    $routes->get('hapusTransaksi', 'Kasir\SaleController::hapusTransaksi');
    $routes->post('bayarTransaksi', 'Kasir\SaleController::bayarTransaksi');
    $routes->get('cetakTransaksi/(:num)', 'Kasir\SaleController::cetakTransaksi/$1');
    $routes->get('profil-user', 'Kasir\ProfilController::index');

});

$routes->group('sibabad2/transaction-sale', function ($routes) { // Transaksi Penjualan Kasir 
    $routes->get('index', 'Kasir\TransactionSaleController::index');
    $routes->post('index', 'Kasir\TransactionSaleController::index');
    $routes->get('detailTransaksi/(:num)', 'Kasir\TransactionSaleController::detailTransaksi/$1');
    $routes->get('cetakTransaksi/(:num)', 'Kasir\TransactionSaleController::cetakTransaksi/$1');
});

$routes->group('sibabad2/customer', function ($routes) { // Produk
    $routes->post('saveCustomer', 'Kasir\CustomerController::saveCustomer');
    $routes->delete('deleteCustomer/(:num)', 'Kasir\CustomerController::deleteCustomer/$1');
});

$routes->group('kasir', ['namespace' => 'App\Controllers\Kasir'], function ($routes) {
    $routes->post('profil/saveProfil', 'ProfilController::saveProfil');
    $routes->get('profil/index', 'ProfilController::index');
});

$routes->group('gudang', ['namespace' => 'App\Controllers\Gudang'], function ($routes) {
    $routes->post('profil/saveProfil', 'ProfilController::saveProfil');
    $routes->get('profil/index', 'ProfilController::index');
});

$routes->group('sibabad3', function ($routes) {
    $routes->get('/', 'Gudang\DashboardController::index');
    $routes->get('coa/index', 'Gudang\ChartOfAccountController::index');
    $routes->get('profil-user', 'Gudang\ProfilController::index');
});

$routes->group('sibabad3/product', function ($routes) { // Produk
    $routes->get('add-new', 'Gudang\ProductController::index');
    $routes->post('saveData', 'Gudang\ProductController::saveData');
    $routes->post('saveUnitType', 'Gudang\ProductController::saveUnitType');
    $routes->post('editData/(:num)', 'Gudang\ProductController::editData/$1');
    $routes->get('editProduct/(:num)', 'Gudang\ProductController::editProduct/$1'); 
    $routes->delete('deleteProduct/(:num)', 'Gudang\ProductController::deleteProduct/$1');
    $routes->delete('deleteUnitType/(:num)', 'Gudang\ProductController::deleteUnitType/$1');
});

$routes->group('sibabad3/direct_order', function ($routes) { // Pembelian langsung
    $routes->get('index', 'Gudang\DirectOrderController::index');
    $routes->get('editDO/(:num)', 'Gudang\DirectOrderController::editDO/$1');
    $routes->get('getDateRange', 'Gudang\DirectOrderController::getDateRange');
    $routes->post('saveData', 'Gudang\DirectOrderController::saveData');
    $routes->post('updateData/(:num)', 'Gudang\DirectOrderController::updateData/$1');
    $routes->delete('deleteDO/(:num)', 'Gudang\DirectOrderController::deleteDO/$1');
    $routes->delete('deleteDataDO/(:num)', 'Gudang\DirectOrderController::deleteDataDO/$1');
    $routes->get('pdf/dompdf/(:num)', 'Gudang\PdfController::dompdf/$1');
});

$routes->group('sibabad3/recieve_order', function ($routes) { // Penerimaan Produk
    $routes->get('index', 'Gudang\RecieveOrderController::index');
    $routes->get('editRO/(:num)', 'Gudang\RecieveOrderController::editRO/$1');
    $routes->get('detailRO/(:num)', 'Gudang\RecieveOrderController::detailRO/$1');
    $routes->get('tambahRO/(:num)', 'Gudang\RecieveOrderController::tambahRO/$1');
    $routes->get('getDateRange', 'Gudang\RecieveOrderController::getDateRange');
    $routes->post('saveData/(:num)', 'Gudang\RecieveOrderController::saveData/$1');
    $routes->post('updateData/(:num)', 'Gudang\RecieveOrderController::updateData/$1');
    $routes->delete('deleteRO/(:num)', 'Gudang\RecieveOrderController::deleteRO/$1');
    // $routes->delete('deleteDataRO/(:num)', 'Admin\RecieveOrderController::deleteDataDO/$1');
});

$routes->group('sibabad3/stock-product', function ($routes) { // Stok Produk Untuk Kasir 
    $routes->get('index', 'Gudang\StockProductController::index');
    $routes->get('tambah', 'Gudang\StockProductController::tambah');
    $routes->post('saveData', 'Gudang\StockProductController::saveData');
    $routes->post('editData/(:num)', 'Gudang\StockProductController::editData/$1');
    $routes->get('editProduct/(:num)', 'Gudang\StockProductController::editProduct/$1');
    $routes->get('bukaBox/(:num)', 'Gudang\StockProductController::bukaBox/$1');
    $routes->post('tambahPcs', 'Gudang\StockProductController::tambahPcs');
    $routes->delete('deleteStock/(:num)', 'Gudang\StockProductController::deleteStock/$1');
    $routes->get('getProductDetail/(:num)', 'Gudang\StockProductController::getProductDetail/$1');
    $routes->get('editProduct/getHargaJual/(:num)', 'Gudang\StockProductController::getHargaJual/$1');
    $routes->get('bukaBox/getHargaJual/(:num)', 'Gudang\StockProductController::getHargaJual/$1');
});

$routes->group('sibabad3/pdf', function ($routes) { // Gudang
    $routes->get('dompdf/(:num)', 'Gudang\PdfController::dompdf/$1');
    $routes->get('transaksipdf', 'Gudang\PdfController::transaksipdf');
    $routes->get('cetakBarcode/(:num)', 'Gudang\PdfController::cetakBarcode/$1');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}