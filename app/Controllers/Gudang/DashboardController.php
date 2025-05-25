<?php

namespace App\Controllers\Gudang;

use App\Controllers\BaseController;
use App\Models\SaleModel;
use App\Models\TransactionModel;
use App\Models\StockProductModel;
use App\Models\UserModel;
use App\Models\CustomerModel;
use App\Models\SupplierModel;
use App\Models\DirectOrderProductModel;


class DashboardController extends BaseController
{

    protected $userModel;
    protected $saleModel;
    public function __construct() {
        $this->saleModel         = new SaleModel();
        $this->stockModel        = new StockProductModel();
        $this->transactionModel  = new TransactionModel();
        $this->userModel         = new UserModel();
        $this->customerModel     = new CustomerModel();
        $this->supplierModel     = new SupplierModel();
        $this->directDetailModel = new DirectOrderProductModel();

        
        
        helper('form');
    }

    public function index()
    {
        $data['title']            = "SiBabad - Dashboard Analytics";
        $data['users']            = "SiBabad - Dashboard Analytics";
        $date['waktu_start']      = $this->request->getVar('waktu_start');
        $date['waktu_end']        = $this->request->getVar('waktu_end');
              $user               = $this->userModel->findAll();
              $customer           = $this->customerModel->findAll();
              $supplier           = $this->supplierModel->findAll();
              $stockp             = $this->stockModel->findAll();
              $sale               = $this->saleModel->findAll();
        $data['users']            = count($user);
        $data['customers']        = count($customer);
        $data['suppliers']        = count($supplier);
        $data['stock']            = count($stockp);
        $data['sales']            = count($sale);
        $data['total_po']         = $this->directDetailModel->totalPO();
        $data['total_income']     = $this->saleModel->total_income($date);
        $data['total_sale_retur'] = $this->saleModel->total_sale_retur($date);
        $data['p_hari']           = $this->saleModel->penjualanHarian();
        $data['p_minggu']         = $this->saleModel->penjualanMingguan();
        $data['p_bulan']          = $this->saleModel->penjualanBulanan();
        $data['produkTerlaris']   = $this->saleModel->produkTerlaris();
        $data['rekapProduk']      = $this->stockModel->rekapProduk();
        return view('gudang/index', $data);
    }
}
