<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WarehouseModel;
use App\Models\UserModel;

class WarehouseController extends BaseController
{
    protected $warehouseModel;
    protected $userModel;

    public function __construct()
    {
        $this->warehouseModel = new WarehouseModel();
        $this->userModel      = new UserModel();
    }

    public function index()
    {
        $data['title'] = "SiBabad - Tambah Data Gudang";
        $data['warehouse'] = $this->warehouseModel->findAll();

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/warehouse/index-warehouse', $data);
    }

    public function saveData()
    {
        $wName = trim($this->request->getVar('w_name'));
        $wAddress = trim($this->request->getVar('w_address'));
        $wPic = trim($this->request->getVar('w_pic'));
        $wPicContact = trim($this->request->getVar('w_pic_contact'));
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();

        $validationRules =
            [
                'w_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama gudang wajib diisi.'
                    ],
                ],
                'w_address' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat gudang wajib diisi.'
                    ],
                ],
                'w_pic' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama PIC wajib diisi.'
                    ],
                ],
                'w_pic_contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kontak PIC wajib diisi.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $dataSave = [
                'id_user' => $userId,
                'w_name' => $wName,
                'w_address' => $wAddress,
                'w_pic' => $wPic,
                'w_pic_contact' => $wPicContact,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->warehouseModel->insert($dataSave);

            session()->setFlashdata('success', 'Data gudang berhasil ditambahkan');
            return redirect()->to('sibabad/warehouse/index');
        }
    }

    public function editData($id)
    {
        $wName = trim($this->request->getVar('w_name'));
        $wAddress = trim($this->request->getVar('w_address'));
        $wPic = trim($this->request->getVar('w_pic'));
        $wPicContact = trim($this->request->getVar('w_pic_contact'));
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $wData = $this->warehouseModel->where('id_warehouse', $id)->where('w_name', $wName)
            ->where('w_address', $wAddress)
            ->where('w_pic', $wPic)
            ->where('w_pic_contact', $wPicContact)
            ->first();

        if ($wData) {
            session()->setFlashdata('info', 'Tidak ada data yang diperbarui');
            return redirect()->to('sibabad/warehouse/index');
        } else {
            $dataUpdate = [
                'id_user' => $userId,
                'w_name' => $wName,
                'w_address' => $wAddress,
                'w_pic' => $wPic,
                'w_pic_contact' => $wPicContact,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->warehouseModel->update($id, $dataUpdate);

            session()->setFlashdata('success', 'Data gudang berhasil diperbarui');
            return redirect()->to('sibabad/warehouse/index');
        }
    }

    public function editView($id)
    {
        $data['title'] = "SiBabad - Ubah Data Gudang";
        $data['wh'] = $this->warehouseModel->find($id);
        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/warehouse/edit-warehouse', $data);
    }

    public function deleteWarehouseData($id)
    {
        $wData = $this->warehouseModel->find($id);

        if ($wData) {
            $this->warehouseModel->delete($id);
            session()->setFlashdata('success-delete', 'Data gudang berhasil dihapus');
        } else {
            session()->setFlashdata('error-delete', 'Data gudang tidak ditemukan');
        }

        return redirect()->to('sibabad/warehouse/index');
    }
}
