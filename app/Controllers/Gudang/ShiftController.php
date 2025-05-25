<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ShiftModel;
use App\Models\KeahlianModel;
use App\Models\UserModel;

class ShiftController extends BaseController
{
    protected $shiftModel;
    protected $keahlianModel;
    protected $userModel;

    public function __construct()
    {
        $this->shiftModel = new ShiftModel();
        $this->keahlianModel = new KeahlianModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $keahlianModel = new KeahlianModel();

        $id_keahlian = 1;
        $data['title'] = "SiBabad - Tambah Data Shift";
        $data['kea'] = $keahlianModel->getKeahlianById($id_keahlian);
        $data['shift'] = $this->shiftModel->findAll();
        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }

        return view('admin/body/shift/index-shift', $data);
    }

    public function saveData()
    {
        $nama = trim($this->request->getVar('nama'));
        $jam_mulai = trim($this->request->getVar('jam_mulai'));
        $jam_selesai = trim($this->request->getVar('jam_selesai'));
        $id_user = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();

        $validationRules =
            [
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Shift wajib diisi.'
                    ],
                ],
                'jam_mulai' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jam Mulai wajib diisi.'
                    ],
                ],
                'jam_selesai' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jam Selesai shift wajib diisi.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $dataSave = [
                'nama' => $nama,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'id_user' => $id_user,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->shiftModel->insert($dataSave);

            session()->setFlashdata('success', 'Data gudang berhasil ditambahkan');
            $user = $this->userModel->find(session()->get('id_user'));

            if ($user && $user['role'] !== 'Administrator') {
                return redirect()->to(base_url('auth/logged_out'));
            }

            return redirect()->to('sibabad/shift/index');
        }
    }

    public function editData($id)
    {
        $nama = trim($this->request->getVar('nama'));
        $jam_mulai = trim($this->request->getVar('jam_mulai'));
        $jam_selesai = trim($this->request->getVar('jam_selesai'));
        $id_user = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $wData = $this->shiftModel
            ->where('id_shift', $id)
            ->where('nama', $nama)
            ->where('jam_mulai', $jam_mulai)
            ->where('jam_selesai', $jam_selesai)
            ->first();

        if ($wData) {
            session()->setFlashdata('info', 'Tidak ada data yang diperbarui');
            return redirect()->to('sibabad/shift/index');
        } else {
            $dataUpdate = [
                'nama' => $nama,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'id_user' => $id_user,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->shiftModel->update($id, $dataUpdate);

            session()->setFlashdata('success', 'Data gudang berhasil diperbarui');
            $user = $this->userModel->find(session()->get('id_user'));

            if ($user && $user['role'] !== 'Administrator') {
                return redirect()->to(base_url('auth/logged_out'));
            }

            return redirect()->to('sibabad/shift/index');
        }
    }

    public function editView($id)
    {
        $keahlianModel = new KeahlianModel();

        $id_keahlian = 1;
        $data['title'] = "SiBabad - Ubah Data Shift";
        $data['kea'] = $keahlianModel->getKeahlianById($id_keahlian);
        $data['shift'] = $this->shiftModel->find($id);

        ///adminrolenya

        return view('admin/body/shift/edit-shift', $data);
    }

    public function deleteShiftData($id)
    {
        $wData = $this->shiftModel->find($id);

        if ($wData) {
            $this->shiftModel->delete($id);
            session()->setFlashdata('success-delete', 'Data shift berhasil dihapus');
        } else {
            session()->setFlashdata('error-delete', 'Data shift tidak ditemukan');
        }

        ///adminrolenya

        return redirect()->to('sibabad/shift/index');
    }
}