<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\KeahlianModel;
use App\Models\UserModel;

class ProfilController extends BaseController
{
    protected $karyawanModel;
    protected $userModel;
    protected $keahlianModel;

    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel();
        $this->userModel     = new UserModel();
        $this->keahlianModel = new KeahlianModel();
    }

    public function index()
    {

        $data['title'] = "SiBabad - Dashboard Analytics";

        $userModel     = new UserModel();
        $karyawanModel = new KaryawanModel();

              $id_keahlian = 1;
              $id_user     = session('id_user');
        $data['prof']      = $this->karyawanModel->getKaryawanWithShiftByUserId($id_user);  // Mengubah cara mendapatkan data karyawan
        $data['kea']       = $this->keahlianModel->getKeahlianById($id_keahlian);
        $data['user']      = $userModel->getUserById($id_user);

        return view('kasir/body/profil/index-profil', $data);
    }

    public function saveProfil()
    {
        $karyawanData = $this->karyawanModel->getKaryawanByUserId(session('id_user'));

        if (!$karyawanData) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan');
            return redirect()->to('sibabad2/karyawan/index');
        }

        $nama   = trim($this->request->getVar('nama'));
        $noktp  = trim($this->request->getVar('noktp'));
        $alamat = trim($this->request->getVar('alamat'));
        $nohp   = trim($this->request->getVar('nohp'));
        date_default_timezone_set('Asia/Jakarta');

        // Dapatkan data karyawan berdasarkan ID
        $wData = $karyawanData;

        // Dapatkan nama foto lama
        $oldFoto = $wData['foto'];

        $dataUpdate = [
            'nama'       => $nama,
            'noktp'      => $noktp,
            'alamat'     => $alamat,
            'nohp'       => $nohp,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $foto = $this->request->getFile('foto');

        $folderPath = ROOTPATH . 'public/uploads/foto_karyawan/';

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaKaryawan = $this->request->getVar('nama');
            $noktp        = $this->request->getVar('noktp');

            $noktpLast3 = substr($noktp, -3);

            $newName = $namaKaryawan . '_' . $noktpLast3 . '_' . time() . '.' . $foto->getExtension();

            $foto->move($folderPath, $newName);

            // Periksa apakah ada foto lama yang perlu dihapus
            if ($oldFoto && $oldFoto !== $newName) {
                $oldFotoPath = ROOTPATH . 'public/uploads/foto_karyawan/' . $oldFoto;
                if (file_exists($oldFotoPath)) {
                    unlink($oldFotoPath);
                }
            }

            $dataUpdate['foto'] = $newName;
        } elseif (!$foto && $oldFoto) {
            // Jika tidak ada foto baru dan ada foto lama, gunakan foto lama
            $dataUpdate['foto'] = $oldFoto;
        }

        $this->karyawanModel->update($karyawanData['id_karyawan'], $dataUpdate);

        session()->setFlashdata('success', 'Data karyawan berhasil diperbarui');
        return redirect()->to('kasir/profil/index');
    }

}