<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\UnitTypeModel;
use App\Models\DirectOrderProductModel;
use App\Models\RecieveOrderModel;

class RecieveProductController extends BaseController
{
    protected $productModel;
    protected $unitModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->unitModel = new UnitTypeModel();
        $this->directDetailModel = new DirectOrderProductModel();
        $this->recieveOrderModel = new RecieveOrderModel();
    }

    public function index()
    {
        $data['title'] = "SiBabad - Tambah Data Stok Produk";
        $data['product'] = $this->recieveOrderModel->findAll();
        $data['stock'] = $this->recieveOrderModel->findAll();
        return view('admin/body/stock/index-stock', $data);
    }

    public function saveData()
    {
        $pCode = $this->request->getVar('p_code');
        $pName = $this->request->getVar('p_name');
        $pUnitType = $this->request->getVar('p_unit_type');
        $pPrice = $this->request->getVar('p_price');
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();

        $validationRules =
            [
                'p_code' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama produk tidak boleh kosong.'
                    ],
                ],
                'p_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama produk tidak boleh kosong.'
                    ],
                ],
                'p_unit_type' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Satuan tidak boleh kosong.'
                    ],
                ],
                'p_price' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Satuan tidak boleh kosong.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $dataSave = [
                'id_user' => $userId,
                'p_code' => $pCode,
                'p_name' => $pName,
                'p_unit_type' => $pUnitType,
                'p_price' => $pPrice,
                'created_at' => date('Y:m:d H:i:s'),
                'updated_at' => date('Y:m:d H:i:s')
            ];

            $this->productModel->insert($dataSave);
            return redirect()->back()->withInput()->with('success', 'Data produk berhasil disimpan.');
        }
    }

    public function editProduct($id)
    {
        $data['title'] = "SiBabad - Edit data produk";
        $data['prod'] = $this->productModel->where('id_product', $id)->first();
        return view('admin/body/product/edit-product', $data);
    }

    public function editData($id)
    {
        $existingData = $this->productModel->find($id);
        $pCode = $this->request->getVar('p_code');
        $pName = $this->request->getVar('p_name');
        $pUnitType = $this->request->getVar('p_unit_type');
        $pPrice = $this->request->getVar('p_price');
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        if ($existingData) {
            $dataUpdate = [
                'id_user' => $userId,
                'p_code' => $pCode,
                'p_name' => $pName,
                'p_price' => $pPrice,
                'updated_at' => date('Y:m:d H:i:s')
            ];

            // Periksa apakah pUnitType ada yang dipilih
            if ($pUnitType !== null && $pUnitType !== '') {
                $dataUpdate['p_unit_type'] = $pUnitType;
            }

            if ($pPrice !== null && $pPrice !== '') {
                $dataUpdate['p_price'] = $pPrice;
            }

            $this->productModel->update($existingData['id_product'], $dataUpdate);
            session()->setFlashdata('update', 'Data berhasil diperbarui');
            return redirect()->to('sibabad/product/add-new');
        }
    }

    public function deleteProduct($id)
    {
        $productData = $this->productModel->find($id);

        if ($productData) {
            $this->productModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }

    public function saveUnitType()
    {
        $idUnit = $this->request->getVar('id_unit_type');
        $uName = trim($this->request->getVar('u_name'));
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        // Cek apakah ada data dengan nama satuan yang sama
        $existingUnit = $this->unitModel->where('u_name', $uName)->first();

        if (!empty($idUnit)) {
            // Jika ID unit diberikan, coba cari data dengan ID unit yang sama
            $existingUnitWithID = $this->unitModel->find($idUnit);

            if ($existingUnitWithID) {
                // Jika data dengan ID unit yang ditemukan, lakukan proses update hanya jika ada perubahan
                if ($existingUnit && $existingUnitWithID['id_unit_type'] !== $existingUnit['id_unit_type']) {
                    // Jika ada data dengan nama satuan yang sama dan ID-nya tidak sama dengan data yang diubah
                    $response = [
                        'status' => 'error',
                        'message' => 'Nama satuan tidak boleh sama.'
                    ];
                } else {
                    $dataSave = [
                        'u_name' => $uName,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $this->unitModel->update($idUnit, $dataSave);

                    $response = [
                        'status' => 'success',
                        'message' => 'Data berhasil diupdate.'
                    ];
                }
            } else {
                // Jika ID unit tidak ditemukan, tidak lakukan apa-apa atau tampilkan pesan error
                $response = [
                    'status' => 'error',
                    'message' => 'ID unit tidak ditemukan.'
                ];
            }
        } else {
            // Jika ID unit tidak diberikan, lakukan proses insert
            if (!$existingUnit) {
                $dataSave = [
                    'id_user' => $userId,
                    'u_name' => $uName,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->unitModel->insert($dataSave)) {
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

    public function deleteUnitType($id)
    {
        $unitType = $this->unitModel->find($id);

        if ($unitType) {
            $this->unitModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }

    //Penjualan Kasir
    
    public function barcode()
    {
        $keyword = $this->request->getGet('term', FILTER_SANITIZE_SPECIAL_CHARS);
        $data = $this->productModel->barcodeModel($keyword);
        $barcode = [];
        foreach ($data as $item) {
            array_push($barcode, [
                'label' => "{$item->barcode} - {$item->nama_item}",
                'value' => $item->barcode,
            ]);
        }

        return $this->response->setJSON($barcode);
    }


    public function detail()
    {
        $barcode = $this->request->getGet('barcode', FILTER_SANITIZE_SPECIAL_CHARS);
        $data = $this->itemModel->detailItem($barcode);
        if (!empty($data)) {
            return $this->response->setJSON($data);
        }
    }
}
