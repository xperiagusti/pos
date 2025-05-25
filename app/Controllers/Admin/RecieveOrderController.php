<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\COAModel;
use App\Models\DirectOrderModel;
use App\Models\DirectOrderProductModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Models\RecieveOrderProductModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class RecieveOrderController extends BaseController
{
    protected $supplierModel;
    protected $productModel;
    protected $directModel;
    protected $directDetailModel;
    protected $recieveOrderModel;
    protected $coaModel;
    protected $userModel;

    use ResponseTrait;

    public function __construct()
    {
        $this->supplierModel     = new SupplierModel();
        $this->productModel      = new ProductModel();
        $this->directModel       = new DirectOrderModel();
        $this->directDetailModel = new DirectOrderProductModel();
        $this->recieveOrderModel = new RecieveOrderProductModel();
        $this->coaModel          = new COAModel();
        $this->userModel         = new UserModel();
    }

    public function index()
    {
        $data['title'] = "SiBabad - Laporan Penerimaan Barang";

        $data['recieveOrder'] = $this->directModel->joinSupplier();


        $reportOrder = $this->directDetailModel->joinDOforRO();
        $rowspanData = [];

        foreach ($reportOrder as $index => $report) {
            if (!isset($rowspanData[$report->do_date])) {
                $rowspanData[$report->do_date] = [
                    'rowspan_date'       => 0,
                    'rowspan_date_index' => $index,
                ];
            }
            if (!isset($rowspanData[$report->do_code])) {
                $rowspanData[$report->do_code] = [
                    'rowspan_code'       => 0,
                    'rowspan_code_index' => $index,
                ];
            }

            $rowspanData[$report->do_date]['rowspan_date']++;
            $rowspanData[$report->do_code]['rowspan_code']++;
        }

        foreach ($reportOrder as $index => $report) {
            $report->rowspan_date       = $rowspanData[$report->do_date]['rowspan_date'];
            $report->rowspan_date_index = $rowspanData[$report->do_date]['rowspan_date_index'];
            $report->rowspan_code       = $rowspanData[$report->do_code]['rowspan_code'];
            $report->rowspan_code_index = $rowspanData[$report->do_code]['rowspan_code_index'];
        }

        $data['logOrder']        = $reportOrder;
        $data['reportOrderJson'] = json_encode($reportOrder);

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }

        return view('admin/body/recieve-order/index-ro', $data);
    }

    public function saveData($id)
    {

        $dStatus   = $this->request->getVar('do_status');
        $idProduct = $this->request->getVar('id_product');
        $doId      = $this->request->getVar('id_do_product');
        $ro_return = $this->request->getVar('ro_product_return');
        $ro_keep   = $this->request->getVar('ro_product_keep');

        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation      = \Config\Services::validation();
        $validationRules = 
            [
                'ro_product_keep' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Jumlah Produk Return wajib diisi.'
                    ],
                ],
                'ro_product_return' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Jumlah Produk Simpan wajib diisi.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {

            if($dStatus == '1')
            {
                $this->directModel->update($id, [
                    'do_status'  => $dStatus,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
    
                $detailRO = [];
    
                for ($i = 0; $i < count($doId); $i++) {
                    $detailRO[] = [
                        'id_do'             => $id,
                        'id_do_products'    => $doId[$i],
                        'id_product'        => $idProduct[$i],
                        'ro_product_return' => $ro_return[$i],
                        'ro_product_keep'   => $ro_keep[$i],
                        'id_user'           => $userId,
                        'created_at'        => date('Y:m:d H:i:s'),
                        'updated_at'        => date('Y:m:d H:i:s')
                    ];
                }
    
                $this->recieveOrderModel->insertBatch($detailRO);
                return redirect()->to('sibabad/recieve_order/index')->withInput()->with('success', 'Data Penerimaan Barang berhasil ditambahkan.');
            }
            else
            {
                return redirect()->to('sibabad/recieve_order/index')->withInput()->with('error-delete', 'Data Penerimaan Barang belum ditambahkan.');
            }
           
        }
    }

    public function updateData($id)
    {

        $idDoP     = $this->request->getVar('id_do_product');
        $idProduct = $this->request->getVar('id_product');
        $ro_return = $this->request->getVar('ro_product_return');
        $ro_keep   = $this->request->getVar('ro_product_keep');
        $userId    = session('id_user');
        date_default_timezone_set('Asia/Jakarta');
        $getID           = $id;
        $dataToUpdate    = [];
        $validation      = \Config\Services::validation();
        $validationRules = 
            [
                'ro_product_keep' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Jumlah Produk Return wajib diisi.'
                    ],
                ],
                'ro_product_return' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Jumlah Produk Simpan wajib diisi.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } 
        else 
        {
            $dataToUpdate = [];
            for ($i = 0; $i < count($idProduct); $i++) {
                $dataToUpdate[] = [
                    'id_do_products'    => $idDoP[$i],
                    'ro_product_return' => $ro_return[$i],
                    'ro_product_keep'   => $ro_keep[$i],
                    'id_user'           => $userId,
                    'updated_at'        => date('Y-m-d H:i:s')
                ];

                
            }
            $this->recieveOrderModel->updateBatch($dataToUpdate, 'id_do_products');
            return redirect()->to('sibabad/recieve_order/index')->withInput()->with('success', 'Data Penerimaan Barang berhasil diperbarui.');
        }
    }

    public function getDateRange()
    {
        $dateFrom = $this->request->getGet('dateFrom');
        $dateTo   = $this->request->getGet('dateTo');

        $data = $this->directDetailModel->joinDOByDate($dateFrom, $dateTo);

        return $this->response->setJSON($data);
    }

    public function tambahRO($id)
    {
        $data['title'] = "SiBabad - Tambah Laporan Penerimaan";
        $data['getRO'] = $this->directDetailModel->joinROToAdd($id);
        return view('admin/body/recieve-order/tambah-ro', $data);
    }

    public function detailRO($id)
    {
        $data['title'] = "SiBabad - Edit Laporan Penerimaan " . $id;
        $data['dapat'] = $this->recieveOrderModel->detailRO($id);
        return view('admin/body/recieve-order/detail-ro', $data);
    }

    public function editRO($id)
    {
        $data['title'] = "SiBabad - Edit Laporan Penerimaan " . $id;
        $data['getRO'] = $this->recieveOrderModel->EditRO($id);
        return view('admin/body/recieve-order/edit-ro', $data);
    }

    public function deleteRO($id)
    {

        $productData = $this->recieveOrderModel->where('id_do', $id)->get()->getRow();
              
        if ($productData) {
            $this->recieveOrderModel->where('id_do', $id)->delete();
            $this->directModel->update($id, ['do_status' => 0]);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }
    
        return $this->response->setJSON($response);
    }

    public function deleteDataDO($id)
    {
        $productData = $this->directModel->find($id);

        if ($productData) {
            $this->directModel->delete($id);
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }
}
