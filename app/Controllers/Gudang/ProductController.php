<?php

namespace App\Controllers\Gudang;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\UnitTypeModel;
use App\Models\UserModel;
use App\Models\KaryawanModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $unitModel;
    protected $userModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->unitModel = new UnitTypeModel();
        $this->userModel = new UserModel();
        $this->karyawanModel = new KaryawanModel();
    }

    public function index()
    {
        $data['title']    = "SiBabad - Tambah data produk";
        $data['prods']    = $this->productModel->findAll();
        $data['units']    = $this->unitModel->findAll();
              $id_user    = session('id_user');
        $data['prof']     = $this->karyawanModel->getKaryawanWithShiftByUserId($id_user);
        // $data['url_foto'] = get_foto_karyawan($id_user);

        return view('gudang/body/product/index-product', $data);
    }

    public function saveData()
    {
        // Ambil data dari form
        $p_name = $this->request->getVar('p_name');
        $pUnitType = $this->request->getVar('p_unit_type');
        $pPrice = $this->request->getVar('p_price', FILTER_SANITIZE_NUMBER_INT);
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        // Validasi form
        $validation = \Config\Services::validation();
        $validationRules = [
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
            // Get the inserted ID
            $insertedId = $this->productModel->insertAndGetId([
                'id_user' => $userId,
                'p_name' => $p_name,
                'p_unit_type' => $pUnitType,
                'p_price' => $pPrice,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Generate new p_code with KODE_(id_product)
            $newPCode = 'KODE_' . $insertedId;

            // Update p_code for the inserted product
            $this->productModel->where('id_product', $insertedId)->set(['p_code' => $newPCode])->update();

            return redirect()->back()->withInput()->with('success', 'Data produk berhasil disimpan.');
        }
    }

    public function editProduct($id)
    {
        $data['title'] = "SiBabad - Edit data produk";
        $data['prod'] = $this->productModel->where('id_product', $id)->first();
        $data['units'] = $this->unitModel->findAll();

        // $user = $this->userModel->find(session()->get('id_user'));

        // if ($user && $user['role'] !== 'Gudang') {
        //     session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        //     return redirect()->to(base_url('auth/logged_out'));
        // }
        return view('gudang/body/product/edit-product', $data);
    }

    public function editData($id)
    {
        $existingData = $this->productModel->find($id);
        $pCode = $this->request->getVar('p_code');
        $pName = $this->request->getVar('p_name');
        $pUnitType = $this->request->getVar('p_unit_type');
        $pPrice = $this->request->getVar('p_price', FILTER_SANITIZE_NUMBER_INT);
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
        $level = $this->request->getVar('level');
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
                        'level' => $level,
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
                    'level' => $level,
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