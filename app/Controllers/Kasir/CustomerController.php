<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    protected $customerModel;
   

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
       
    }

    public function saveCustomer()
    {
        $id_customer = $this->request->getVar('id_customer');
        $customer_name = $this->request->getVar('customer_name');
        $telp = $this->request->getVar('telp');
        $address = $this->request->getVar('address');
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        // Cek apakah ada data dengan nama customer yang sama
        $existingCustomer = $this->customerModel->where('customer_name', $customer_name)->first();

        if (!empty($id_customer)) {
            // Jika ID unit diberikan, coba cari data dengan ID unit yang sama
            $existingCustomerWithID = $this->customerModel->find($id_customer);

            if ($existingCustomerWithID) {
                // Jika data dengan ID unit yang ditemukan, lakukan proses update hanya jika ada perubahan
                if ($existingCustomer && $existingCustomerWithID['id_customer'] !== $existingCustomer['id_customer']) {
                    // Jika ada data dengan nama customer yang sama dan ID-nya tidak sama dengan data yang diubah
                    $response = [
                        'status' => 'error',
                        'message' => 'Nama customer tidak boleh sama.'
                    ];
                } else {
                    $dataSave = [
                        'customer_name' => $customer_name,
                        'telp' => $telp,
                        'address' => $address,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $this->customerModel->update($id_customer, $dataSave);

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
            if (!$existingCustomer) {
                $dataSave = [
                    'id_user' => $userId,
                    'customer_name' => $customer_name,
                    'telp' => $telp,
                    'address' => $address,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->customerModel->insert($dataSave)) {
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

    public function deleteCustomer($id)
    {
        $customer = $this->customerModel->find($id);

        if ($customer) {
            $this->customerModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }

}
