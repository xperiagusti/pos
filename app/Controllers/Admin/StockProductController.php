<?php

namespace App\Controllers\Admin;

use App\Libraries\Keranjang;
use App\Controllers\BaseController;
use App\Models\DirectOrderModel;
use App\Models\DirectOrderProductModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Models\StockProductModel;
use App\Models\RecieveOrderProductModel;
use App\Models\UnitTypeModel;
use App\Models\ConvertUnitModel;
use App\Models\UserModel;


class StockProductController extends BaseController
{
    protected $productModel;
    protected $unitModel;
    protected $recieveOrderModel;
    protected $saleModel;
    protected $transactionModel;
    protected $ConvertUnitModel;
    protected $userModel;

    public function __construct()
    {
        $this->supplierModel     = new SupplierModel();
        $this->productModel      = new ProductModel();
        $this->unitModel         = new UnitTypeModel();
        $this->directModel       = new DirectOrderModel();
        $this->directDetailModel = new DirectOrderProductModel();
        $this->stockModel        = new StockProductModel();
        $this->recieveOrderModel = new RecieveOrderProductModel();
        $this->convertUnitModel  = new ConvertUnitModel();
        $this->userModel         = new UserModel();
    }

    public function index()
    {
        $data['title']   = "SiBabad - Tambah Data Stock Produk";
        $data['product'] = $this->directDetailModel->joinStock();
        $data['stock']   = $this->stockModel->daftar_stock();
        // $data['hampir_expired'] = $this->stockModel->hampir_expired();
        // $data['hampir_habis'] = $this->stockModel->hampir_habis();
        $data['convert'] = $this->convertUnitModel->findAll();

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/stock-product/index-stock', $data);
    }

    public function tambah()
    {
        $data['title']        = "SiBabad - Tambah Data Stock Produk";
        $data['product']      = $this->directDetailModel->joinStock();
        $data['units_level2'] = $this->unitModel->where('level', 2)->findAll();
        $data['units_level3'] = $this->unitModel->where('level', 3)->findAll();

        return view('admin/body/stock-product/tambah-stock', $data);
    }

    public function saveData()
    {
        // Mengambil data dari request
        $id_do_products = $this->request->getVar('id_do_products');
        $p_name         = $this->request->getVar('p_name');
        $p_unit_type    = $this->request->getVar('p_unit_type');
        $s_barcode      = $this->request->getVar('s_barcode');
        $s_price        = $this->request->getVar('s_price');
        $s_stock        = $this->request->getVar('s_stock');
        $s_qty_grosir   = $this->request->getVar('s_qty_grosir');
        $s_price_grosir = $this->request->getVar('s_price_grosir');
        $s_qty_khusus   = $this->request->getVar('s_qty_khusus');
        $s_price_khusus = $this->request->getVar('s_price_khusus');
        $s_date_expired = $this->request->getVar('s_date_expired');
        $level_1        = $this->request->getVar('level_1');
        $level_2        = $this->request->getVar('level_2');
        $level_3        = $this->request->getVar('level_3');
        $userId         = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();

        $validationRules = [
            's_barcode' => [
                'rules'  => 'required|alpha_numeric_punct|is_unique[stock_product.s_barcode,id_s_product,{id_s_product}]',
                'errors' => [
                    'required'  => 'Barcode tidak boleh kosong.',
                    'is_unique' => 'Nilai Barcode tidak boleh sama.'
                ],
            ],
            'id_do_products' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Produk tidak boleh kosong.',
                ],
            ],
        ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $convert = 
                [
                    's_barcode'  => $s_barcode,
                    'level_1'    => $level_1,
                    'level_2'    => ($level_2 === "") ? 1 : $level_2,
                    'level_3'    => ($level_3 === "") ? 1 : $level_3,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            $this->convertUnitModel->insert($convert);

            // $idProducts = [];
            // for ($i = 0; $i < count($p_unit_type); $i++) {
            //     if (!empty($p_unit_type[$i])) {

            //     $existingProduct = $this->productModel->cariProduk($p_name, $p_unit_type[$i]);

            //     if ($existingProduct) {
            //         $idProduct = $existingProduct['id_product'];
            //     } else {
            //         $doSave = [
            //             'p_name'      => $p_name,
            //             'p_unit_type' => $p_unit_type[$i],
            //             'id_user'     => $userId,
            //             'created_at'  => date('Y-m-d H:i:s')
            //         ];

            //         $this->productModel->insert($doSave);
            //         $idProduct = $this->productModel->getInsertID();
            //     }

            //     }
            //     $idProducts[] = $idProduct;
            
            // }

            // $stock = [];

            // for ($i = 0; $i < count($p_unit_type); $i++) {
            //     if (!empty($p_unit_type[$i])) 
            //     {
            //         if (!empty($s_price_grosir[$i])) {
            //             $price_grosir[$i] = $s_price_grosir[$i];
            //         } else {
            //             $price_grosir[$i] = $s_price[$i];
            //         }
            //         if (!empty($s_price_khusus[$i])) {
            //             $price_khusus[$i] = $s_price_khusus[$i];
            //         } else {
            //             $price_khusus[$i] = $s_price[$i];
            //         }

            //         $stock[] = [
            //             's_barcode'      => $s_barcode,
            //             'id_product'     => $idProducts[$i],
            //             's_price'        => $s_price[$i],
            //             's_stock'        => $s_stock[$i],
            //             's_qty_grosir'   => $s_qty_grosir[$i],
            //             's_price_grosir' => $price_grosir[$i],
            //             's_qty_khusus'   => $s_qty_khusus[$i],
            //             's_price_khusus' => $price_khusus[$i],
            //             's_date_expired' => empty($s_date_expired) ? '0000-00-00' : $s_date_expired,
            //             'created_at'     => date('Y-m-d H:i:s'),
            //             'updated_at'     => date('Y-m-d H:i:s')
            //         ];
            //     }
            // }
            // $this->stockModel->insertBatch($stock);
            // $this->recieveOrderModel->where('id_do_products', $id_do_products)->set('ro_status_input', 1)->update();
            // return redirect()->back()->withInput()->with('success', 'Data Stok Produk berhasil disimpan.');

            dd($convert);
        }
    }


    public function bukaBox($id)
    {
        $data['title'] = "SiBabad - Buka box Data Produk";
        $data['prod']  = $this->stockModel->stockDetail($id);
        $data['units'] = $this->unitModel->opsiUnit();

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/stock-product/bukabox-stock', $data);
    }

    public function tambahPcs()
    {
        $id_s_product    = $this->request->getVar('id_s_product');
        $p_name          = $this->request->getVar('p_name');
        $p_unit_type     = $this->request->getVar('p_unit_type');
        $s_barcode       = $this->request->getVar('s_barcode');
        $s_price         = $this->request->getVar('s_price');
        $s_stock         = $this->request->getVar('s_stock');
        $s_qty_grosir    = $this->request->getVar('s_qty_grosir');
        $s_price_grosir  = $this->request->getVar('s_price_grosir');
        $s_qty_khusus    = $this->request->getVar('s_qty_khusus');
        $s_price_khusus  = $this->request->getVar('s_price_khusus');
        $s_date_expired  = $this->request->getVar('s_date_expired');
        $jumlah_box_buka = $this->request->getVar('jumlah_box_buka');

        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $validation = \Config\Services::validation();

        $validationRules = 
            [
                's_barcode' => [
                    'rules'  => 'required|alpha_numeric_punct',
                    'errors' => [
                        'required' => 'Barcode tidak boleh kosong.',

                    ],
                ],
                's_price' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Harga jual produk tidak boleh kosong.'
                    ],
                ],
                's_stock' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Jumlah stok produk tidak boleh kosong.'
                    ],
                ],
                'p_unit_type' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Satuan produk tidak boleh kosong.'
                    ],
                ],
                's_qty_grosir' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Jumlah grosir tidak boleh kosong. Jika kosong isi dengan nilai 0'
                    ],
                ],
                's_price_grosir' => [
                    'rules'  => 'required|less_than[s_price]',
                    'errors' => [
                        'required'  => 'Harga grosir tidak boleh kosong. Jika kosong berikan nilai harga jual',
                        'less_than' => 'Harga Grosir harus lebih kecil atau sama dengan harga jual.'
                    ],
                ],
                's_qty_khusus' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Jumlah qty khusus tidak boleh kosong. Jika kosong isi dengan nilai 0',

                    ],
                ],
                's_price_khusus' => [
                    'rules'  => 'required|less_than[s_price_grosir]',
                    'errors' => [
                        'required'  => 'Harga khusus tidak boleh kosong. Jika kosong berikan nilai harga jual',
                        'less_than' => 'Harga Khusus harus lebih kecil atau sama dengan Harga grosir.'
                    ],
                ],
            ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $existingProduct = $this->productModel->cariProduk($p_name, $p_unit_type);
            if ($existingProduct) {
                $idProduct = $existingProduct['id_product'];
            } else {
                $doSave = 
                    [
                        'p_name'      => $p_name,
                        'p_unit_type' => $p_unit_type,
                        'id_user'     => $userId,
                        'created_at'  => date('Y:m:d H:i:s')
                    ];

                $this->productModel->insert($doSave);
                $idProduct = $this->productModel->getInsertID();
            }

            $cariStokUnit = $this->stockModel->cariStokUnit($idProduct, $s_barcode);
            if ($cariStokUnit) {
                $this->stockModel->where('id_s_product', $id_s_product)->set('s_stock', 's_stock - ' . $jumlah_box_buka, false)->update();
                $this->stockModel->where('id_s_product', $cariStokUnit['id_s_product'])->set('s_stock', 's_stock + ' . $s_stock, false)->update();
                return redirect()->to('sibabad/stock-product/index')->withInput()->with('success', 'Data Stok Produk berhasil diupdate.');
            } else {
                $dataSave = [
                    'id_user'        => $userId,
                    'id_product'     => $idProduct,
                    's_barcode'      => $s_barcode,
                    's_price'        => $s_price,
                    's_qty_grosir'   => $s_qty_grosir,
                    's_price_grosir' => $s_price_grosir,
                    's_qty_khusus'   => $s_qty_khusus,
                    's_price_khusus' => $s_price_khusus,
                    's_stock'        => $s_stock,
                    's_date_expired' => $s_date_expired,

                    'created_at' => date('Y:m:d H:i:s'),
                    'updated_at' => date('Y:m:d H:i:s')
                ];

                $this->stockModel->insert($dataSave);
                $this->stockModel->where('id_s_product', $id_s_product)->set('s_stock', 's_stock - ' . $jumlah_box_buka, false)->update();
                return redirect()->to('sibabad/stock-product/index')->withInput()->with('success', 'Data Stok Produk berhasil disimpan.');
            }





        }
    }

    public function editProduct($id)
    {
        $data['title'] = "SiBabad - Edit data stok produk";
        $data['prod']  = $this->stockModel->stockDetail($id);

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/stock-product/edit-stock', $data);
    }

    public function editData($id)
    {
        $existingData   = $this->stockModel->find($id);
        $s_barcode      = $this->request->getVar('s_barcode');
        $s_date_expired = $this->request->getVar('s_date_expired');
        $s_price        = $this->request->getVar('s_price');
        $s_qty_grosir   = $this->request->getVar('s_qty_grosir');
        $s_price_grosir = $this->request->getVar('s_price_grosir');
        $s_qty_khusus   = $this->request->getVar('s_qty_khusus');
        $s_price_khusus = $this->request->getVar('s_price_khusus');
        $userId         = session('id_user');
        date_default_timezone_set('Asia/Jakarta');
        $validation = \Config\Services::validation();

        $validationRules = [
            's_barcode' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Barcode tidak boleh kosong.',
                ],
            ],
        ];

        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {

            if ($existingData) {
                $dataUpdate = [
                    'id_user'        => $userId,
                    's_barcode'      => $s_barcode,
                    's_date_expired' => $s_date_expired,
                    's_price'        => $s_price,
                    's_qty_grosir'   => $s_qty_grosir,
                    's_price_grosir' => $s_price_grosir,
                    's_qty_khusus'   => $s_qty_khusus,
                    's_price_khusus' => $s_price_khusus,
                    'updated_at'     => date('Y:m:d H:i:s')
                ];


                $this->stockModel->update($existingData['id_s_product'], $dataUpdate);
                $this->convertUnitModel->update($s_barcode, ['s_barcode' => $s_barcode]);
                session()->setFlashdata('update', 'Data berhasil diperbarui');
                return redirect()->to('sibabad/stock-product/index');
            }
        }
    }

    public function deleteStock($id)
    {
        $stockData = $this->stockModel->find($id);

        if ($stockData) {
            $this->stockModel->delete($id);
            // $this->convertUnitModel->where('s_barcode', $stockData['s_barcode'])->delete();
            $response['success'] = true;
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not found.';
        }

        return $this->response->setJSON($response);
    }

    public function getProductDetail($id)
    {

        $id_product = $this->directDetailModel->select(['id_product'])->where('id_do_products', $id)->first();
        $data2      = $this->directDetailModel->getprice($id_product['id_product']);
        $data       = $this->directDetailModel->getProduct($id);

        if ($data && $data2) {
            // jika data ditemukan, kirim data dalam format JSON
            $response = [
                's_stock'     => $data['s_stock'],
                'p_unit_type' => $data['p_unit_type'],
                'p_name'      => $data['p_name'],
                'dop_price'   => $data2['dop_price'],
                'id_product'  => $data['id_product']
            ];
            return $this->response->setJSON($response);
        } else {
            // jika data tidak ditemukan, kirim kode HTTP 404 Not Found
            return $this->response->setStatusCode(404);
        }
    }

    public function getHargaJual($id)
    {

        $data = $this->directDetailModel->getprice($id);

        if ($data) {
            // jika data ditemukan, kirim data dalam format JSON
            $response = [
                'dop_price' => $data['dop_price']
            ];
            return $this->response->setJSON($response);
        } else {
            // jika data tidak ditemukan, kirim kode HTTP 404 Not Found
            return $this->response->setStatusCode(404);
        }
    }
}