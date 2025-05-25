<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;

use App\Libraries\Keranjang;
use App\Models\CustomerModel;
use App\Models\SaleModel;
use App\Models\TransactionModel;
use App\Models\StockProductModel;


class TransactionSaleController extends BaseController {
    protected $customerModel;
    protected $saleModel;
    protected $transaction;

    public function __construct() {
        $this->customerModel = new CustomerModel();
        $this->saleModel = new SaleModel();
        $this->transaction      = new TransactionModel();
        $this->stockModel = new StockProductModel();
        $this->transactionModel = new TransactionModel();
        
        helper('form');
    }

    public function index() {
        $date['waktu_start'] = $this->request->getVar('waktu_start');
        $date['waktu_end'] = $this->request->getVar('waktu_end');
        $data = [
            'title'     => 'SiBabad - Transaksi Penjualan',
            'transaksi' => $this->saleModel->transaksiPenjualan($date),
            'date' => $date
        ];
        return view('kasir/body/transaction-sale/transaction-index', $data);
    }

    public function detailTransaksi($id) {
        $data = [
            'title'     => 'SiBabad - Transaksi Penjualan',
            'transaksi' => $this->transactionModel->detailTransaksi($id),
        ];
        return view('kasir/body/transaction-sale/transaction-detail', $data);
    }


    public function cetakTransaksi($id) {
        $transaksi = $this->transactionModel->detailTransaksi($id);
        // jika id penjualan tidak ditemukan redirect ke halaman invoice dan tampilkan error
        if (empty($transaksi)) {
            return redirect()->to('/penjualan/invoice')->with('pesan', 'Invoice tidak ditemukan');
        }
        return view('kasir/body/sale/cetak-termal', ['transaksi' => $transaksi]);
    }

    
}
