<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CourierModel;
use CodeIgniter\API\ResponseTrait;

class CourierController extends BaseController
{
    protected $courierModel;

    use ResponseTrait;

    public function __construct()
    {
        $this->courierModel = new CourierModel();
    }

    public function index()
    {

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
