<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\COAModel;
use App\Models\UserModel;

class ChartOfAccountController extends BaseController
{
    protected $coaModel;
    protected $userModel;

    public function __construct()
    {
        $this->coaModel = new COAModel();
        $this->userModel     = new UserModel();
    }

    public function index()
    {
        $data['title'] = "SiBabad - Charts of Account";
        $data['coaGet'] = $this->coaModel->findAll();

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }

        return view('admin/body/coa/coa-index', $data);
    }

    public function saveCoaData()
    {
        $coaName = $this->request->getPost('coa_name');
        $coaCode = $this->request->getPost('coa_code');
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();

        $validationRules =
            [
                'coa_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama akun wajib diisi.'
                    ],
                ],
                'coa_code' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom kode akun wajib diisi.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $existingCoa = $this->coaModel->where('coa_code', $coaCode)
                ->orWhere('coa_name', $coaName)->first();

            if ($existingCoa) {
                $dataUpdate =
                    [
                        'coa_name' => $coaName,
                        'coa_code' => $coaCode
                    ];
                $this->coaModel->update($existingCoa['id_coa'], $dataUpdate);
                session()->setFlashdata('success', 'Kode akun berhasil diperbarui.');
                return redirect()->to('sibabad/coa/index');
            } else {
                $dataSave =
                    [
                        'coa_name' => $coaName,
                        'coa_code' => $coaCode
                    ];

                $this->coaModel->insert($dataSave);
                session()->setFlashdata('success', 'Kode akun berhasil ditambahkan.');
                return redirect()->to('sibabad/coa/index');
            }
        }
    }

    public function deleteCoaData($id)
    {
        // Cari data yang ingin dihapus berdasarkan ID atau kondisi yang sesuai
        $coa = $this->coaModel->find($id);

        if ($coa) {
            // Jika data ditemukan, hapus data
            $this->coaModel->delete($id);
            session()->setFlashdata('success-delete', 'Data berhasil dihapus.');
        } else {
            // Jika data tidak ditemukan, tampilkan pesan error
            session()->setFlashdata('error-delete', 'Data tidak ditemukan.');
        }

        return redirect()->to('sibabad/coa/index');
    }
}
