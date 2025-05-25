<?php

namespace App\Controllers\Gudang;

use App\Controllers\BaseController;
use App\Models\COAModel;
use App\Models\DirectOrderModel;
use App\Models\DirectOrderProductModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Models\CourierModel;
use CodeIgniter\API\ResponseTrait;

class DirectOrderController extends BaseController
{
    protected $supplierModel;
    protected $productModel;
    protected $directModel;
    protected $directDetailModel;
    protected $coaModel;
    protected $courierModel;

    use ResponseTrait;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
        $this->productModel = new ProductModel();
        $this->directModel = new DirectOrderModel();
        $this->directDetailModel = new DirectOrderProductModel();
        $this->coaModel = new COAModel();
        $this->courierModel = new CourierModel();
    }

    public function index()
    {
        $data['title'] = "SiBabad - Laporan Pembelian Langsung";

        $data['sups']     = $this->supplierModel->findAll();
        $data['couriers'] = $this->courierModel->findAll();
        $data['prods']    = $this->productModel->findAll();
        $data['cek']      = $this->productModel->getProductsAndSuppliers();
        $data['coa']      = $this->coaModel->findAll();

        $reportOrder = $this->directDetailModel->joinDO();
        $rowspanData = [];

        foreach ($reportOrder as $index => $report) {
            if (!isset($rowspanData[$report->do_date])) {
                $rowspanData[$report->do_date] = [
                    'rowspan_date'       => 0,
                    'rowspan_date_index' => $index,
                ];
            }
            if (!isset($rowspanData[$report->do_code])) {
                $rowspanData[$report->do_code] = [
                    'rowspan_code'       => 0,
                    'rowspan_code_index' => $index,
                ];
            }

            $rowspanData[$report->do_date]['rowspan_date']++;
            $rowspanData[$report->do_code]['rowspan_code']++;
        }

        foreach ($reportOrder as $index => $report) {
            $report->rowspan_date       = $rowspanData[$report->do_date]['rowspan_date'];
            $report->rowspan_date_index = $rowspanData[$report->do_date]['rowspan_date_index'];
            $report->rowspan_code       = $rowspanData[$report->do_code]['rowspan_code'];
            $report->rowspan_code_index = $rowspanData[$report->do_code]['rowspan_code_index'];
        }

        $data['logOrder']        = $reportOrder;
        $data['reportOrderJson'] = json_encode($reportOrder);

        // echo json_encode($data['logOrder'], JSON_PRETTY_PRINT);
        // die;

        return view('gudang/body/direct-order/index-do', $data);
    }

    public function saveData()
    {
        $dDate     = $this->request->getVar('do_date');
        $dCode     = trim($this->request->getVar('do_code'));
        $dSupplier = $this->request->getVar('id_supplier');
        $idProduct = $this->request->getVar('id_product');
        $idCoa     = $this->request->getVar('id_coa');
        $dQty      = $this->request->getVar('dop_qty');
        $dTotal    = $this->request->getVar('dop_total', FILTER_SANITIZE_NUMBER_INT);
        $dTotal    = str_replace(".", "", $dTotal);
        $dStatus   = $this->request->getVar('dop_status');
        $dShipment = $this->request->getVar('do_shipment');
        $dCourier  = $this->request->getVar('do_courier');
        // $pPrice = $this->request->getVar('p_price');
        $pPrice = $this->request->getVar('p_price');
        $pPrice = str_replace(".", "", $pPrice);


        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation      = \Config\Services::validation();
        $validationRules = 
            [
                'do_date' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Tanggal wajib diisi.'
                    ],
                ],
                'do_code' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Kode pembelian wajib diisi.'
                    ],
                ],
                'id_supplier' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Supplier wajib dipilih.'
                    ],
                ],
                'id_product' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Data produk harus dipilih.'
                    ],
                ],
                'id_coa' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Metode bayar wajib dipilih.'
                    ],
                ],
                'dop_qty' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Kuantiti produk wajib dimasukkan.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $doSave = 
                [
                    'do_date'     => $dDate,
                    'do_code'     => $dCode,
                    'do_shipment' => $dShipment,
                    'do_courier'  => $dCourier,
                    'do_status'   => 0
                ];

            $this->directModel->insert($doSave);
            $getID = $this->directModel->getInsertID();

            $detailDO = [];

            for ($i = 0; $i < count($idProduct); $i++) {
                $detailDO[] = [
                    'id_do'       => $getID,
                    'id_user'     => $userId,
                    'id_supplier' => $dSupplier,
                    'id_product'  => $idProduct[$i],
                    'id_coa'      => $idCoa,
                    'dop_price'   => $pPrice[$i],
                    'dop_qty'     => $dQty[$i],
                    'dop_total'   => $dTotal[$i],
                    'dop_status'  => $dStatus,
                    'created_at'  => date('Y:m:d H:i:s'),
                    'updated_at'  => date('Y:m:d H:i:s')
                ];
            }

            $this->directDetailModel->insertBatch($detailDO);

            for ($i = 0; $i < count($idProduct); $i++) {
                $existingProduct = $this->productModel->find($idProduct[$i]);

                if ($existingProduct && $existingProduct['p_price'] != $pPrice[$i]) {
                    // Jika produk sudah ada dan harga berubah, update harga
                    $this->productModel->update($idProduct[$i], [
                        'p_price'    => $pPrice[$i],
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            session()->setFlashdata('success', 'Data pembelian berhasil disimpan');
            return redirect()->to('sibabad3/direct_order/index');
        }
    }

    public function updateData($id)
    {
        $dDate     = $this->request->getVar('do_date');
        $dCode     = trim($this->request->getVar('do_code'));
        $dSupplier = $this->request->getVar('id_supplier');
        $idProduct = $this->request->getVar('id_product');
        $idCoa     = $this->request->getVar('id_coa');
        $dQty      = $this->request->getVar('dop_qty');
        $dTotal    = $this->request->getVar('dop_total', FILTER_SANITIZE_NUMBER_INT);
        $dTotal    = str_replace(".", "", $dTotal);
        $dShipment = $this->request->getVar('do_shipment');
        $dCourier  = $this->request->getVar('do_courier');
        $userId    = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $doUpdate = [
            'do_date'     => $dDate,
            'do_code'     => $dCode,
            'do_shipment' => $dShipment,
            'do_courier'  => $dCourier
        ];

        $this->directModel->update($id, $doUpdate);

        $getID = $id;

        $detailDO = [];

        for ($i = 0; $i < count($idProduct); $i++) {
            // Periksa apakah produk sudah ada dalam database berdasarkan ID produk
            $existingProduct = $this->directDetailModel->where('id_do', $getID)
                ->where('id_product', $idProduct[$i])
                ->first();

            if ($existingProduct) {
                // Jika produk sudah ada, update data yang sudah ada
                $this->directDetailModel->update($existingProduct['id_do'], [
                    'id_user'     => $userId,
                    'id_supplier' => $dSupplier,
                    'id_coa'      => $idCoa,
                    'dop_qty'     => $dQty[$i],
                    'dop_total'   => $dTotal[$i],
                    'updated_at'  => date('Y-m-d H:i:s')
                ]);
            } else {
                // Jika produk belum ada, tambahkan produk baru
                $detailDO[] = [
                    'id_do'       => $getID,
                    'id_user'     => $userId,
                    'id_supplier' => $dSupplier,
                    'id_coa'      => $idCoa,
                    'id_product'  => $idProduct[$i],
                    'dop_qty'     => $dQty[$i],
                    'dop_total'   => $dTotal[$i],
                    'updated_at'  => date('Y-m-d H:i:s')
                ];
            }
        }

        if (!empty($detailDO)) {
            $this->directDetailModel->insertBatch($detailDO);
        }

        session()->setFlashdata('success', 'Data pembelian berhasil diperbarui');
        return redirect()->to('sibabad3/direct_order/index');
    }

    public function getDateRange()
    {
        $dateFrom = $this->request->getGet('dateFrom');
        $dateTo = $this->request->getGet('dateTo');

        $data = $this->directDetailModel->joinDOByDate($dateFrom, $dateTo);

        return $this->response->setJSON($data);
    }

    public function editDO($id)
    {
        $data['title']    = "SiBabad - Edit Laporan Pembelian";
        $data['getDO']    = $this->directDetailModel->joinDOToEdit($id);
        $data['sups']     = $this->supplierModel->findAll();
        $data['prods']    = $this->productModel->findAll();
        $data['coa']      = $this->coaModel->findAll();
        $data['couriers'] = $this->courierModel->findAll();

        $reportOrder = $this->directDetailModel->joinDO();
        $rowspanData = [];

        foreach ($reportOrder as $index => $report) {
            if (!isset($rowspanData[$report->do_date])) {
                $rowspanData[$report->do_date] = [
                    'rowspan_date'       => 0,
                    'rowspan_date_index' => $index,
                ];
            }
            if (!isset($rowspanData[$report->do_code])) {
                $rowspanData[$report->do_code] = [
                    'rowspan_code'       => 0,
                    'rowspan_code_index' => $index,
                ];
            }

            $rowspanData[$report->do_date]['rowspan_date']++;
            $rowspanData[$report->do_code]['rowspan_code']++;
        }

        foreach ($reportOrder as $index => $report) {
            $report->rowspan_date       = $rowspanData[$report->do_date]['rowspan_date'];
            $report->rowspan_date_index = $rowspanData[$report->do_date]['rowspan_date_index'];
            $report->rowspan_code       = $rowspanData[$report->do_code]['rowspan_code'];
            $report->rowspan_code_index = $rowspanData[$report->do_code]['rowspan_code_index'];
        }

        $data['logOrder']        = $reportOrder;
        $data['reportOrderJson'] = json_encode($reportOrder);

        return view('gudang/body/direct-order/edit-do', $data);
    }

    public function deleteDO($id)
    {
        $productData = $this->directDetailModel->find($id);

        if ($productData) {
            $this->directDetailModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }

    public function deleteDataDO($id)
    {
        $productData = $this->directModel->find($id);

        if ($productData) {
            $this->directModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }


    public function saveKurir()
    {
        $id_courier = $this->request->getVar('id_courier');
        $c_name = trim($this->request->getVar('c_name'));
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        // Cek apakah ada data dengan nama satuan yang sama
        $existingUnit = $this->courierModel->where('c_name', $c_name)->first();

        if (!empty($id_courier)) {
            // Jika ID unit diberikan, coba cari data dengan ID unit yang sama
            $existingUnitWithID = $this->courierModel->find($id_courier);

            if ($existingUnitWithID) {
                // Jika data dengan ID unit yang ditemukan, lakukan proses update hanya jika ada perubahan
                if ($existingUnit && $existingUnitWithID['id_courier'] !== $existingUnit['id_courier']) {
                    // Jika ada data dengan nama satuan yang sama dan ID-nya tidak sama dengan data yang diubah
                    $response = [
                        'status' => 'error',
                        'message' => 'Nama kurir tidak boleh sama.'
                    ];
                } else {
                    $dataSave = [
                        'c_name' => $c_name,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $this->courierModel->update($id_courier, $dataSave);

                    $response = [
                        'status' => 'success',
                        'message' => 'Data berhasil diupdate.'
                    ];
                }
            } else {
                // Jika ID unit tidak ditemukan, tidak lakukan apa-apa atau tampilkan pesan error
                $response = [
                    'status' => 'error',
                    'message' => 'ID Kurir tidak ditemukan.'
                ];
            }
        } else {
            // Jika ID unit tidak diberikan, lakukan proses insert
            if (!$existingUnit) {
                $dataSave = [
                    'id_user' => $userId,
                    'c_name' => $c_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->courierModel->insert($dataSave)) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Data berhasil disimpan.'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Gagal menyimpan data satuan. Silakan hubungi Administrator.'
                    ];
                }
            } else {
                // Jika ada data dengan nama satuan yang sama
                $response = [
                    'status' => 'error',
                    'message' => 'Nama satuan tidak boleh sama.'
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function deleteKurir($id)
    {
        $kurir = $this->courierModel->find($id);

        if ($kurir) {
            $this->courierModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }
}
