<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\KeahlianModel;
use App\Models\ShiftModel;
use App\Models\UserModel;

class KaryawanController extends BaseController
{
    protected $karyawanModel;
    protected $keahlianModel;
    protected $shiftModel;
    protected $userModel;

    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel();
        $this->keahlianModel = new KeahlianModel();
        $this->shiftModel    = new ShiftModel();
        $this->userModel     = new UserModel();
    }

    public function index()
    {
              $id_keahlian = 1;
        $data['title']     = "SiBabad - Tambah Data Karyawan";
        $data['kea']       = $this->keahlianModel->getKeahlianById($id_keahlian);
        $data['karyawan']  = $this->karyawanModel
            ->join('shift', 'karyawan.jam_selesai = shift.jam_selesai', 'left')
            ->join('user', 'karyawan.id_user = user.id_user', 'left')
            ->select('karyawan.*, shift.nama AS nama_shift') // Menggunakan alias 'nama_shift' untuk kolom 'nama'
            ->select('karyawan.*, user.role')
            ->findAll();
        $data['shift'] = $this->shiftModel->findAll();

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/karyawan/index-karyawan', $data);
    }

    public function saveData()
    {
        $nama        = trim($this->request->getVar('nama'));
        $noktp       = trim($this->request->getVar('noktp'));
        $alamat      = trim($this->request->getVar('alamat'));
        $nohp        = trim($this->request->getVar('nohp'));
        $jam_selesai = trim($this->request->getVar('jam_selesai'));
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();

        $validationRules = [
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama karyawan wajib diisi.'
                ],
            ],
            'noktp' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nomor KTP karyawan wajib diisi.'
                ],
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Alamat wajib diisi.'
                ],
            ],
            'nohp' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kontak wajib diisi.'
                ],
            ],
            'jam_selesai' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Shift wajib diisi.'
                ],
            ],
            'foto' => [
                'rules'  => 'max_size[foto,10240]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 1MB.',
                    'mime_in'  => 'Berkas harus berupa gambar dengan format: jpg, jpeg, png.'
                ],
            ],

        ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $foto = $this->request->getFile('foto');

            $folderPath = ROOTPATH . 'public/uploads/foto_karyawan/';

            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            if ($foto->isValid() && !$foto->hasMoved()) {
                $namaKaryawan = $this->request->getVar('nama');   // Dapatkan nama karyawan dari request
                $noktp        = $this->request->getVar('noktp');

                // Ambil hanya 3 angka terakhir dari noktp
                $noktpLast3 = substr($noktp, -3);

                $newName = $namaKaryawan . '_' . $noktpLast3 . '_' . time() . '.' . $foto->getExtension();  // Ubah nama file

                $foto->move($folderPath, $newName);
            }

            // Menyiapkan $dataSave dengan informasi karyawan
            $dataSave = [
                'nama'        => $nama,
                'noktp'       => $noktp,
                'alamat'      => $alamat,
                'nohp'        => $nohp,
                'jam_selesai' => $jam_selesai,
                'foto'        => isset($newName) ? $newName : null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ];

            if ($this->karyawanModel->insert($dataSave)) {
                session()->setFlashdata('success', 'Data karyawan berhasil ditambahkan');
                return redirect()->to('sibabad/karyawan/index');
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data.');
                return redirect()->back()->withInput();
            }
        }
    }

    public function editData($id)
    {
        $nama        = trim($this->request->getVar('nama'));
        $noktp       = trim($this->request->getVar('noktp'));
        $alamat      = trim($this->request->getVar('alamat'));
        $nohp        = trim($this->request->getVar('nohp'));
        $jam_selesai = trim($this->request->getVar('jam_selesai'));
        date_default_timezone_set('Asia/Jakarta');

        // Dapatkan data karyawan berdasarkan ID
        $wData = $this->karyawanModel->find($id);

        if (!$wData) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan');
            return redirect()->to('sibabad/karyawan/index');
        }

        // Dapatkan nama foto lama
        $oldFoto = $wData['foto'];

        // Tambahkan kondisi untuk jam_selesai
        if ($jam_selesai == 0) {
            $jam_selesai = $wData['jam_selesai'];  // Gunakan jam_selesai dari data sebelumnya
        }

        $dataUpdate = [
            'nama'        => $nama,
            'noktp'       => $noktp,
            'alamat'      => $alamat,
            'nohp'        => $nohp,
            'jam_selesai' => $jam_selesai,
            // Gunakan nilai baru atau dari data sebelumnya
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $foto = $this->request->getFile('foto');

        $folderPath = ROOTPATH . 'public/uploads/foto_karyawan/';

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        if ($foto->isValid() && !$foto->hasMoved()) {
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
        } elseif (!$foto->isValid() && $oldFoto) {
            // Jika tidak ada foto baru dan ada foto lama, gunakan foto lama
            $dataUpdate['foto'] = $oldFoto;
        }

        $this->karyawanModel->update($id, $dataUpdate);

        session()->setFlashdata('success', 'Data karyawan berhasil diperbarui');
        return redirect()->to('sibabad/karyawan/index');
    }

    public function editView($id)
    {
        $shiftModel = new ShiftModel();

        $keahlianModel = new KeahlianModel();

              $id_keahlian = 1;
              $id_user     = session('id_user');
        $data['title']     = "SiBabad - Ubah Data Karyawan";
        $data['kea']       = $keahlianModel->getKeahlianById($id_keahlian);
        $data['karyawan']  = $this->karyawanModel->find($id);
        $data['aaa']       = $this->karyawanModel->getKaryawanShift($id_user);
        $data['shift']     = $this->shiftModel->findAll();

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }

        return view('admin/body/karyawan/edit-karyawan', $data);
    }

    public function deleteKaryawanData($id)
    {
        $wData = $this->karyawanModel->find($id);

        if ($wData) {
            // Hapus foto dari server
            $folderPath = ROOTPATH . 'public/uploads/foto_karyawan/';
            $fotoName   = $wData['foto'];

            if ($fotoName && is_file($folderPath . $fotoName)) {
                unlink($folderPath . $fotoName);
            }

            // Hapus data dari database
            $this->karyawanModel->delete($id);

            session()->setFlashdata('success-delete', 'Data karyawan berhasil dihapus');
        } else {
            session()->setFlashdata('error-delete', 'Data karyawan tidak ditemukan');
        }

        ///adminrolenya

        return redirect()->to('sibabad/karyawan/index');
    }


}