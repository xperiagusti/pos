<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConvertUnitModel;

class ConvertController extends BaseController
{
    protected $ConvertUnitModel;
   

    public function __construct()
    {
        $this->ConvertUnitModel = new ConvertUnitModel();
    }

    public function index()
    {
       
    }

    public function saveKonversi()
    {
        $id_c_unit = $this->request->getVar('id_c_unit');
        $s_barcode = $this->request->getVar('s_barcode');
        $level_1 = $this->request->getVar('level_1');
        $level_2 = $this->request->getVar('level_2');
        $level_3 = $this->request->getVar('level_3');
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        // Cek apakah ada data dengan nama customer yang sama
        $existingConvert = $this->ConvertUnitModel->where('s_barcode', $s_barcode)->first();

        if (!empty($id_c_unit)) {
            // Jika ID unit diberikan, coba cari data dengan ID unit yang sama
            $existingConvertWithID = $this->ConvertUnitModel->find($id_c_unit);

            if ($existingConvertWithID) {
                // Jika data dengan ID unit yang ditemukan, lakukan proses update hanya jika ada perubahan
                if ($existingConvert && $existingConvertWithID['id_c_unit'] !== $existingConvert['id_c_unit']) {
                    // Jika ada data dengan nama customer yang sama dan ID-nya tidak sama dengan data yang diubah
                    $response = [
                        'status' => 'error',
                        'message' => 'Nama customer tidak boleh sama.'
                    ];
                } else {
                    $dataSave = [
                        's_barcode' => $s_barcode,
                        'level_1' => $level_1,
                        'level_2' => $level_2,
                        'level_3' => $level_3,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    $this->ConvertUnitModel->update($id_c_unit, $dataSave);

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
            if (!$existingConvert) {
                $dataSave = [
                    'id_user' => $userId,
                    's_barcode' => $s_barcode,
                    'level_1' => $level_1,
                    'level_2' => $level_2,
                    'level_3' => $level_3,
                    'created_at' => date('Y-m-d H:i:s')
                    
                ];

                if ($this->ConvertUnitModel->insert($dataSave)) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Data berhasil disimpan.'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Gagal menyimpan data customer. Silakan hubungi Administrator.'
                    ];
                }
            } else {
                // Jika ada data dengan nama customer yang sama
                $response = [
                    'status' => 'error',
                    'message' => 'Nama customer tidak boleh sama.'
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function deleteKonversi($id)
    {
        $customer = $this->ConvertUnitModel->find($id);

        if ($customer) {
            $this->ConvertUnitModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }

}
