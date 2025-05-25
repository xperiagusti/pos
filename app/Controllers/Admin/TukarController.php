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

class TukarController extends BaseController
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


    public function tukar()
    {
        $keahlianModel = new KeahlianModel();
        $id_keahlian   = 1;
        $id_user           = session('id_user');
        $data['title']     = "SiBabad - Tambah Data Tukar";
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

        return view('admin/body/sale/index-tukar', $data);
    }

    public function saveData()
    {
        $invoice = $this->request->getVar('invoice');
        $id_customer = $this->request->getVar('id_customer');
        
        $barcode = $this->request->getVar('barcode');
        $nama_item = $this->request->getVar('nama_item');
        $id_s_product = $this->request->getVar('id_s_product');

        $satuan_retur = $this->request->getVar('satuan_retur');
        $qty_retur = $this->request->getVar('qty_retur');

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
                    'total_price' => 0,
                    'final_price' => 0,
                    'tunai' => 0,
                    'return' => 0,
                    'jumlah' => $total_item,
                    'jenis' => '-',
                    'tipe' => 'Retur-tukar',
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
                        'item_price'    => 0,
                        'item_amount'   => $qty_retur[$i],
                        'item_discount' => 0,
                        'subtotal'      => 0,
                        'ip_address'    => $ipAddress,
                        'created_at'    => date("Y-m-d H:i:s"),
                        'updated_at'    => date("Y-m-d H:i:s"),
                    ];

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
            session()->setFlashdata('error-delete', 'Data Tukar gagal disimpan, anda harus memilih opsi satuan setidaknya 1');
            return redirect()->to('sibabad/tukar');
        }
        
    }

    public function cetakTransaksi($invoice)
    {
        $transaksi1 = $this->transactionModel->detailTransaksiJual($invoice);
        $transaksi2 = $this->transactionModel->detailTransaksiTukar($invoice);
        // jika id penjualan tidak ditemukan redirect ke halaman invoice dan tampilkan error
        if (empty($transaksi1) || empty($transaksi2) ) {
            return redirect()->to('/penjualan/invoice')->with('pesan', 'Invoice tidak ditemukan');
        }
        return view('admin/body/sale/cetak-termal-tukar', ['transaksi' => $transaksi1, 'tukar' => $transaksi2]);
    }

    


}