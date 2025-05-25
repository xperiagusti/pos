<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\KasModel;

class KasController extends BaseController
{
    protected $kasModel;


    public function __construct()
    {
        $this->kasModel = new KasModel();
    }

    public function index()
    {

    }

    public function saveKas()
    {
        $id_kas    = $this->request->getVar('id_kas');
        $kode      = $this->request->getVar('kas_kode');
        $kas_name  = $this->request->getVar('kas_name');
        $kas_total = $this->request->getVar('kas_total', FILTER_SANITIZE_NUMBER_INT);
        $tipe      = $this->request->getVar('kas_tipe');
        $userId    = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        // Cek apakah ada data dengan nama kas yang sama
        $existingKas = $this->kasModel->where('kode', $kode)->first();

        if (!empty($id_kas)) {
            // Jika ID unit diberikan, coba cari data dengan ID unit yang sama
            $existingKasWithID = $this->kasModel->find($id_kas);

            if ($existingKasWithID) {
                // Jika data dengan ID unit yang ditemukan, lakukan proses update hanya jika ada perubahan
                if ($existingKas && $existingKasWithID['id_kas'] !== $existingKas['id_kas']) {
                    // Jika ada data dengan nama kas yang sama dan ID-nya tidak sama dengan data yang diubah
                    $response = [
                        'status'  => 'error',
                        'message' => 'Nama kas tidak boleh sama.'
                    ];
                } else {
                    $dataSave = [
                        'kas_name'   => $kas_name,
                        'kode'       => $kode,
                        'kas_total'  => $kas_total,
                        'tipe'       => $tipe,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $this->kasModel->update($id_kas, $dataSave);

                    $response = [
                        'status'  => 'success',
                        'message' => 'Data berhasil diupdate.'
                    ];
                }
            } else {
                // Jika ID unit tidak ditemukan, tidak lakukan apa-apa atau tampilkan pesan error
                $response = [
                    'status'  => 'error',
                    'message' => 'ID Kas tidak ditemukan.'
                ];
            }
        } else {
            // Jika ID unit tidak diberikan, lakukan proses insert
            if (!$existingKas) {
                $dataSave = [
                    'id_user'    => $userId,
                    'kas_name'   => $kas_name,
                    'kode'       => $kode,
                    'kas_total'  => $kas_total,
                    'tipe'       => $tipe,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->kasModel->insert($dataSave)) {
                    $response = [
                        'status'  => 'success',
                        'message' => 'Data berhasil disimpan.'
                    ];
                } else {
                    $response = [
                        'status'  => 'error',
                        'message' => 'Gagal menyimpan data kas. Silakan hubungi Administrator.'
                    ];
                }
            } else {
                // Jika ada data dengan nama kas yang sama
                $response = [
                    'status'  => 'error',
                    'message' => 'Nama kas tidak boleh sama.'
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function deletekas($id)
    {
        $kas = $this->kasModel->find($id);

        if ($kas) {
            $this->kasModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }

}