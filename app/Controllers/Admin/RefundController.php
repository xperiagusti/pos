<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ShiftModel;
use App\Models\KeahlianModel;
use App\Models\UserModel;
use App\Models\KaryawanModel;
use App\Models\TransactionModel;
use App\Models\SaleModel;
use App\Models\UnitTypeModel;
use App\Models\TukarModel;
use App\Models\StockProductModel;

class RefundController extends BaseController
{
    protected $shiftModel;
    protected $keahlianModel;
    protected $userModel;
    protected $karyawanModel;
    protected $transactionModel;
    protected $saleModel;
    protected $unittypeModel;
    protected $tukarModel;
    protected $StockProductModel;

    public function __construct()
    {
        $this->karyawanModel    = new KaryawanModel();
        $this->shiftModel       = new ShiftModel();
        $this->keahlianModel    = new KeahlianModel();
        $this->userModel        = new UserModel();
        $this->transactionModel = new TransactionModel();
        $this->saleModel        = new SaleModel();
        $this->unittypeModel    = new UnitTypeModel();
        $this->tukarModel       = new TukarModel();
        $this->StockProductModel       = new StockProductModel();
    }

    public function index()
    {
        $keahlianModel = new KeahlianModel();

        $id_keahlian = 1;
        $id_user     = session('id_user');
        $data['title']     = "SiBabad - Tambah Data Shift";
        $data['kea']       = $keahlianModel->getKeahlianById($id_keahlian);
        $data['prof']      = $this->karyawanModel->getKaryawanWithShiftByUserId($id_user);
        $data['unitTypes'] = $this->unittypeModel->findAll();
        // Mendapatkan search term dari form
        $searchTerm = $this->request->getVar('search');
        if ($searchTerm) {
            $data['transaksi'] = $this->transactionModel->detailTransaks2($searchTerm);
        } else {
            $data['transaksi'] = $this->transactionModel->detailTransaksi();
        }
        return view('admin/body/refund/index-shift', $data);
    }


    public function refund()
    {
        $keahlianModel = new KeahlianModel();
        $id_keahlian   = 1;
        $id_user           = session('id_user');
        $data['title']     = "SiBabad - Tambah Data Refund";
        $data['kea']       = $keahlianModel->getKeahlianById($id_keahlian);
        $data['prof']      = $this->karyawanModel->getKaryawanWithShiftByUserId($id_user);
        $data['unitTypes'] = $this->unittypeModel->findAll();

        // Mendapatkan search term dari form
        $data['search'] = $this->request->getVar('search');

        if ($data['search']) {
            $data['transaksi'] = $this->transactionModel->detailTransaks2($data['search']);
        } else {
            $data['transaksi'] = $this->transactionModel->detailTransaks2(1);
        }

        return view('admin/body/sale/index-refund', $data);
    }


    public function saveData()
    {
        $invoice = $this->request->getVar('invoice');
        $id_customer = $this->request->getVar('id_customer');
        
        $barcode = $this->request->getVar('barcode');
        $nama_item = $this->request->getVar('nama_item');
        $id_s_product = $this->request->getVar('id_s_product');

        $satuan_retur = $this->request->getVar('satuan_retur');
        $harga_item_retur = $this->request->getVar('harga_item_retur');
        $qty_retur = $this->request->getVar('qty_retur');
        $subtotal_item_retur = $this->request->getVar('subtotal_item_retur');

        $level_1_plus = $this->request->getVar('level_1_plus');
        $level_2_plus = $this->request->getVar('level_2_plus');
        $level_3_plus = $this->request->getVar('level_3_plus');

        $subtotal_retur = $this->request->getVar('subtotal_retur');
        $total_retur = $this->request->getVar('total_retur');
        $total_item = $this->request->getVar('total_item');

        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');
        $ipAddress = $this->request->getIPAddress();


            $countNonEmptySatuanRetur = 0;
                
            for ($i = 0; $i < count($satuan_retur); $i++) {

                if (!empty($satuan_retur[$i])) {
                    $existingProduct = $this->StockProductModel->cari_ids_product($barcode[$i], $nama_item[$i], $satuan_retur[$i]);
                    
                    if ($existingProduct) {
                        $idSProducts[] = $existingProduct['id_s_product'];
                    } else {
                        $idSProducts[] = $id_s_product[$i];
                    }
            
                    $countNonEmptySatuanRetur++;
                }
            
            }

            if($countNonEmptySatuanRetur > 0)
            {

                $doSave =
                [
                    'invoice' => $invoice,
                    'id_customer' => $id_customer,
                    'total_price' => $subtotal_retur,
                    'final_price' => $total_retur,
                    'tunai' => $total_retur,
                    'return' => 0,
                    'jumlah' => $total_item,
                    'jenis' => 'Tunai',
                    'tipe' => 'Retur-refund',
                    'date' => date('Y-m-d'),
                    'id_user' => $userId,
                    'ip_address' => $ipAddress,
                    'created_at'  => date("Y-m-d H:i:s"),
                    'updated_at'  => date("Y-m-d H:i:s")
                ];

                $this->saleModel->insert($doSave);
                $getID = $this->saleModel->getInsertID();

                $detailItem = [];

                for ($i = 0; $i < $countNonEmptySatuanRetur; $i++) {
                    $detailItem[] = [
                        'id_sale'       => $getID,
                        'id_s_product'  => $idSProducts[$i],
                        'item_price'    => $harga_item_retur[$i],
                        'item_amount'   => $qty_retur[$i],
                        'item_discount' => 0,
                        'subtotal'      => $subtotal_item_retur[$i],
                        'ip_address'    => $ipAddress,
                        'created_at'    => date("Y-m-d H:i:s"),
                        'updated_at'    => date("Y-m-d H:i:s"),
                    ];

                    if ($level_1_plus[$i] !== 'Infinity') {
                        $this->StockProductModel->addStock($nama_item[$i], 1, $level_1_plus[$i], $barcode[$i]);
                    }
                    if ($level_2_plus[$i] !== 'Infinity') {
                        $this->StockProductModel->addStock($nama_item[$i], 2, $level_2_plus[$i], $barcode[$i]);
                    }
                    if ($level_3_plus[$i] !== 'Infinity') {
                        $this->StockProductModel->addStock($nama_item[$i], 3, $level_3_plus[$i], $barcode[$i]);
                    }
                }

                $result = $this->transactionModel->insertBatch($detailItem);


                if ($result) {
                    $respon = [
                        'status'      => true,
                        'pesan'       => 'Transaksi berhasil.',
                        'invoice' =>  $invoice,
                    ];
                } else {
                    $respon = [
                        'status' => false,
                        'pesan'  => 'Transaksi gagal',
                    ];
                }

                return $this->response->setJSON($respon);
        }
        else
        {
            session()->setFlashdata('error-delete', 'Data Retur gagal disimpan, anda harus memilih opsi satuan setidaknya 1');
            return redirect()->to('sibabad/refund2');
        }
        
    }

    public function cetakTransaksi($invoice)
    {
        $transaksi1 = $this->transactionModel->detailTransaksiJual($invoice);
        $transaksi2 = $this->transactionModel->detailTransaksiRefund($invoice);
        // jika id penjualan tidak ditemukan redirect ke halaman invoice dan tampilkan error
        if (empty($transaksi1) || empty($transaksi2) ) {
            return redirect()->to('/penjualan/invoice')->with('pesan', 'Invoice tidak ditemukan');
        }
        return view('admin/body/sale/cetak-termal-refund', ['transaksi' => $transaksi1, 'refund' => $transaksi2]);
    }

    


}