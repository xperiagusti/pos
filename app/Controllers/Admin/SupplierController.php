<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use App\Models\UserModel;

class SupplierController extends BaseController
{
    protected $supplierModel;
    protected $userModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
        $this->userModel     = new UserModel();
    }

    public function index()
    {
        $data['title'] = "SiBabad - Tambah Data Supplier";
        $supplierData = $this->supplierModel->findAll();
        $data['sups'] = $supplierData;

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }

        return view('admin/body/supplier/index-supplier', $data);
    }

    public function saveData()
    {
        $sName = $this->request->getVar('s_name');
        $sPabx = $this->request->getVar('s_pabx');
        $sEmail = $this->request->getVar('s_email');
        $sPIC = $this->request->getVar('s_pic');
        $PicContact = $this->request->getVar('s_pic_contact');
        $sType = $this->request->getVar('s_type');
        $sNation = $this->request->getVar('s_nation');
        $sProvince = $this->request->getVar('s_province');
        $sCity = $this->request->getVar('s_city');
        $sDistrict = $this->request->getVar('s_district');
        $sSubDistrict = $this->request->getVar('s_subdistrict');
        $sAddress = $this->request->getVar('s_address');
        $sZipCode = $this->request->getVar('s_zip_code');
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();
        $validationRules =
            [
                's_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Supplier tidak boleh kosong.'
                    ],
                ],
                's_pic' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama PIC/ Penanggung Jawab tidak boleh kosong.'
                    ],
                ],
                's_pic_contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kontak PIC/ Penanggung Jawab tidak boleh kosong.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $idSupplier = $this->request->getVar('id_supplier');
            $existingSupplier = $this->supplierModel->where('id_supplier', $idSupplier)->first();

            if ($existingSupplier) {
                $dataUpdate = [
                    's_name' => $sName,
                    's_pabx' => $sPabx,
                    's_email' => $sEmail,
                    's_pic' => $sPIC,
                    's_pic_contact' => $PicContact,
                    'updated_at' => date('Y-m-d H:i:s') // Updated timestamp should be set here
                ];

                // Only update the fields if they are not empty
                if (!empty($sType)) {
                    $dataUpdate['s_type'] = $sType;
                } else {
                    $dataUpdate['s_type'] = $existingSupplier['s_type'];
                }
                if (!empty($sNation)) {
                    $dataUpdate['s_nation'] = $sNation;
                } else {
                    $dataUpdate['s_nation'] = $existingSupplier['s_nation'];
                }
                if (!empty($sProvince)) {
                    $dataUpdate['s_province'] = $sProvince;
                } else {
                    $dataUpdate['s_province'] = $existingSupplier['s_province'];
                }
                if (!empty($sCity)) {
                    $dataUpdate['s_city'] = $sCity;
                } else {
                    $dataUpdate['s_city'] = $existingSupplier['s_city'];
                }
                if (!empty($sDistrict)) {
                    $dataUpdate['s_district'] = $sDistrict;
                } else {
                    $dataUpdate['s_district'] = $existingSupplier['s_district'];
                }
                if (!empty($sSubDistrict)) {
                    $dataUpdate['s_subdistrict'] = $sSubDistrict;
                } else {
                    $dataUpdate['s_subdistrict'] = $existingSupplier['s_subdistrict'];
                }
                if (!empty($sAddress)) {
                    $dataUpdate['s_address'] = $sAddress;
                } else {
                    $dataUpdate['s_address'] = $existingSupplier['s_address'];
                }
                if (!empty($sZipCode)) {
                    $dataUpdate['s_zip_code'] = $sZipCode;
                } else {
                    $dataUpdate['s_zip_code'] = $existingSupplier['s_zip_code'];
                }

                $this->supplierModel->update($existingSupplier['id_supplier'], $dataUpdate);

                session()->setFlashdata('update', 'Data berhasil diperbarui');
                return redirect()->to('sibabad/supplier/index');
            } else {
                $dataSave =
                    [
                        'id_user' => $userId,
                        's_name' => $sName,
                        's_pabx' => $sPabx,
                        's_email' => $sEmail,
                        's_pic' => $sPIC,
                        's_pic_contact' => $PicContact,
                        's_type' => $sType,
                        's_nation' => $sNation,
                        's_province' => $sProvince,
                        's_city' => $sCity,
                        's_district' => $sDistrict,
                        's_subdistrict' => $sSubDistrict,
                        's_address' => $sAddress,
                        's_zip_code' => $sZipCode,
                        'created_at' => date('Y:m:d H:i:s'),
                        'updated_at' => date('Y:m:d H:i:s')
                    ];

                $this->supplierModel->insert($dataSave);

                session()->setFlashdata('success', 'Data berhasil disimpan');
                return redirect()->back()->withInput()->with('success', 'Data berhasil ditambahkan');
            }
        }
    }

    public function getDataSupplier()
    {
        $supplierData = $this->supplierModel->findAll();

        return $this->response->setJSON($supplierData);
    }

    public function editSupplier($idSupplier)
    {
        $data['title'] = "SiBabad - Edit Supplier";
        $findSupplier = $this->supplierModel->find($idSupplier);
        $data['sups'] = $findSupplier;

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        
        return view('admin/body/supplier/edit-supplier', $data);
    }

    public function deleteSupplier($id)
    {
        $detailData = $this->supplierModel->find($id);

        if ($detailData) {
            $this->supplierModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }
}
