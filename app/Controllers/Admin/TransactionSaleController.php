<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Libraries\Keranjang;
use App\Models\CustomerModel;
use App\Models\SaleModel;
use App\Models\TransactionModel;
use App\Models\StockProductModel;
use App\Models\UserModel;
use App\Models\KasModel;


class TransactionSaleController extends BaseController {
    protected $customerModel;
    protected $saleModel;
    protected $transaction;
    protected $userModel;
    protected $kasModel;

    public function __construct() {
        $this->customerModel    = new CustomerModel();
        $this->saleModel        = new SaleModel();
        $this->transaction      = new TransactionModel();
        $this->stockModel       = new StockProductModel();
        $this->transactionModel = new TransactionModel();
        $this->userModel        = new UserModel();
        $this->kasModel        = new KasModel();
        
        helper('form');
    }

    public function index() {
        $date['waktu_start'] = $this->request->getVar('waktu_start');
        $date['waktu_end']   = $this->request->getVar('waktu_end');
        $date['tipe']   = $this->request->getVar('tipe');
              $data          = [
            'title'             => 'SiBabad - Transaksi Penjualan',
            'transaksi'         => $this->saleModel->rekapTransaksi($date),
            'date'              => $date,
            'total_income'      => $this->saleModel->total_income($date),
            'total_sale_retur'  => $this->saleModel->total_sale_retur($date),
            'total_kas'  => $this->kasModel->total_kas($date),
            'total_transaction' => count($this->saleModel->total_transaction($date))
        ];

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/transaction-sale/transaction-index', $data);
    }

    public function detailTransaksi($id) {
        $data = [
            'title'     => 'SiBabad - Transaksi Penjualan',
            'transaksi' => $this->transactionModel->detailTransaksi($id),
        ];

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/transaction-sale/transaction-detail', $data);
    }


    public function cetakTransaksi($id) {
        $transaksi = $this->transactionModel->detailTransaksi($id);
        // jika id penjualan tidak ditemukan redirect ke halaman invoice dan tampilkan error
        if (empty($transaksi)) {
            return redirect()->to('/penjualan/invoice')->with('pesan', 'Invoice tidak ditemukan');
        }
        return view('admin/body/sale/cetak-termal', ['transaksi' => $transaksi]);
    }

    
}
