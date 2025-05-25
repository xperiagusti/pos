<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\KeahlianModel;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $karyawanModel;
    protected $keahlianModel;
    protected $userModel;

    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel();
        $this->keahlianModel = new KeahlianModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $id_keahlian = 1;
        $data['title'] = "SiBabad - Tambah Data Karyawan";
        $data['kea'] = $this->keahlianModel->getKeahlianById($id_keahlian);
        $data['karyawan'] = $this->karyawanModel->findAll();
        $data['user'] = $this->userModel->
            join('karyawan', 'user.id_user = karyawan.id_user', 'left')
            ->select('karyawan.*, karyawan.nama AS nama_karyawan')
            ->select('user.*, user.nama_lengkap AS nama_user')
            ->findAll();
        ///adminrolenya
        return view('admin/body/user/index-user', $data);
    }


    public function saveData()
    {
        $username = trim($this->request->getVar('username'));
        $email = trim($this->request->getVar('email'));
        $password = password_hash(trim($this->request->getVar('password')), PASSWORD_DEFAULT); // Hashing password
        $role = trim($this->request->getVar('role'));
        $is_verified = trim($this->request->getVar('is_verified'));
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();

        $validationRules = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ],
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email wajib diisi.'
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ],
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role wajib diisi.'
                ],
            ],
            'is_verified' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Verifikasi wajib diisi.'
                ],
            ],
        ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $dataSave = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'is_verified' => $is_verified,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->userModel->insert($dataSave);

            // Jika peran adalah 'Kasir', tambahkan data ke tabel karyawan
            if ($role === 'Kasir') {
                $karyawanData = [
                    'id_user' => $this->userModel->insertID() // Ambil ID baru dari user yang baru ditambahkan
                ];
                $this->karyawanModel->insert($karyawanData);
            }
            $user = $this->userModel->find(session()->get('id_user'));

            if ($user && $user['role'] !== 'Administrator') {
                return redirect()->to(base_url('auth/logged_out'));
            }

            session()->setFlashdata('success', 'Data gudang berhasil ditambahkan');
            return redirect()->to('sibabad/user/index');
        }
    }


    public function editData($id)
    {
        $username = trim($this->request->getVar('username'));
        $email = trim($this->request->getVar('email'));
        $password = password_hash(trim($this->request->getVar('password')), PASSWORD_DEFAULT); // Hashing password
        $role = trim($this->request->getVar('role'));
        $is_verified = trim($this->request->getVar('is_verified'));
        date_default_timezone_set('Asia/Jakarta');

        // Dapatkan data user berdasarkan ID
        $wData = $this->userModel->find($id);

        if (!$wData) {
            session()->setFlashdata('error', 'Data user tidak ditemukan');
            return redirect()->to('sibabad/user/index');
        }

        $dataUpdate = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'is_verified' => $is_verified,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->userModel->update($id, $dataUpdate);

        // Periksa apakah peran adalah 'Kasir'
        if ($role === 'Kasir') {
            $karyawanData = [
                'id_user' => $id // Gunakan ID dari pengguna yang diperbarui
                // ... (data karyawan lainnya)
            ];
            $this->karyawanModel->save($karyawanData); // Menggunakan save untuk update atau insert
        } else {
            // Jika peran bukan 'Kasir', hapus entri dari tabel karyawan
            $this->karyawanModel->where('id_user', $id)->delete();
        }

        ///adminrolenya

        session()->setFlashdata('success', 'Data user berhasil diperbarui');
        return redirect()->to('sibabad/user/index');
    }



    public function editView($id)
    {
        $userModel = new UserModel();

        $keahlianModel = new KeahlianModel();

        $id_keahlian = 1;
        $data['title'] = "SiBabad - Ubah Data User";
        $data['kea'] = $keahlianModel->getKeahlianById($id_keahlian);
        $data['user'] = $this->userModel->getUserById($id);

        ///adminrolenya

        return view('admin/body/user/edit-user', $data);
    }

    public function deleteUserData($id)
    {
        $wData = $this->userModel->find($id);

        if ($wData) {
            $this->userModel->delete($id);
            session()->setFlashdata('success-delete', 'Data gudang berhasil dihapus');
        } else {
            session()->setFlashdata('error-delete', 'Data gudang tidak ditemukan');
        }

        ///adminrolenya

        return redirect()->to('sibabad/user/index');
    }

}