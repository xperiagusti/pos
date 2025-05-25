<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;

use App\Libraries\Keranjang;
use App\Models\CustomerModel;
use App\Models\SaleModel;
use App\Models\TransactionModel;
use App\Models\StockProductModel;
use App\Models\ConvertUnitModel;
use App\Models\KaryawanModel;
use App\Models\KasModel;


class SaleController extends BaseController
{
    protected $customerModel;
    protected $saleModel;
    protected $transaction;
    protected $convertUnitModel;
    protected $karyawanModel;
    protected $kasModel;

    public function __construct()
    {
        $this->customerModel    = new CustomerModel();
        $this->saleModel        = new SaleModel();
        $this->transaction      = new TransactionModel();
        $this->stockModel       = new StockProductModel();
        $this->transactionModel = new TransactionModel();
        $this->convertUnitModel = new ConvertUnitModel();
        $this->karyawanModel    = new KaryawanModel();
        $this->kasModel         = new KasModel();

        helper('form');
    }
    public function index()
    {
              $id_user       = session('id_user');
        $date['waktu_start'] = $this->request->getVar('waktu_start');
        $date['waktu_end']   = $this->request->getVar('waktu_end');
              $data          = [
            'title'            => 'SiBabad - Kasir',
            'pelanggan'        => $this->customerModel->detailPelanggan(),
            'customer'         => $this->customerModel->findAll(),
            'kode_kas_masuk'   => $this->kasModel->kode_kas_masuk(),
            'kode_kas_keluar'  => $this->kasModel->kode_kas_keluar(),
            'kas_masuk'        => $this->kasModel->listKasMasukgdToday(),
            'kas_keluar'       => $this->kasModel->listKasKeluargdToday(),
            'stock'            => $this->stockModel->daftar_stock(),
            'popup'            => $this->karyawanModel->getPopupByUserId($id_user),
            'prof'             => $this->karyawanModel->getKaryawanWithShiftByUserId($id_user),
            'aaa'              => $this->karyawanModel->kas($id_user),
            'cari'             => $this->karyawanModel->getKaryawanByUserId($id_user),
            'transaksi'        => $this->saleModel->transaksiPenjualan($date),
            'transaksi2'       => $this->karyawanModel->getTransaksi($id_user),
            'rincianPenjualan' => $this->saleModel->rincianPenjualanHarianKasir($id_user),
            'rincianKas'       => $this->kasModel->rincianKasHarianKasir($id_user)
        ];
        return view('kasir/body/sale/index-sale', $data);
    }

    public function detailTransaksi($id)
    {
        $data = [
            'title'     => 'SiBabad - Transaksi Penjualan',
            'transaksi' => $this->transactionModel->detailTransaksi($id),
        ];
        return view('kasir/body/sale/sale-detail', $data);
    }


    //Menampung Data Kasir 
    public function keranjang()
    {
        if ($this->request->isAJAX()) {
            $respon = [
                'invoice'    => $this->saleModel->invoice(),
                'keranjang'  => Keranjang::keranjang(),
                'sub_total'  => Keranjang::sub_total(),
                'total_item' => Keranjang::total_item()
            ];

            return $this->response->setJSON($respon);
        }
    }

    public function barcode()
    {
        $keyword = $this->request->getGet('term', FILTER_SANITIZE_SPECIAL_CHARS);
        $data    = $this->stockModel->barcodeModel($keyword);
        $barcode = [];
        foreach ($data as $item) {
            array_push($barcode, [
                'label' => "{$item->barcode} - {$item->nama_item} - {$item->satuan} ",
                'value' => $item->id_s_product,
            ]);
        }

        return $this->response->setJSON($barcode);
    }

    public function detail()
    {
        $barcode = $this->request->getGet('barcode', FILTER_SANITIZE_SPECIAL_CHARS);
        $data    = $this->stockModel->detailItem($barcode);
        if (!empty($data)) {
            return $this->response->setJSON($data);
        }
    }

    public function cekStok()
    {
        $barcode = $this->request->getGet('barcode');
        $iditem  = $this->request->getGet('iditem');
        $respon  = $this->stockModel->cekStokProduk($barcode, $iditem);

        return $this->response->setJSON($respon);
    }

    public function cekHarga()
    {
        $item_id = $this->request->getGet('item_id');
        $jumlah  = $this->request->getGet('jumlah');
        $harga   = $this->request->getGet('harga');
        $item    = $this->stockModel->cekHargaProduk($item_id);
        $respon  = [];

        if ($jumlah >= $item['qty_khusus']) {
            $respon['harga_item'] = $item['harga_khusus'];
        } else if ($jumlah >= $item['qty_grosir'] && $jumlah < $item['qty_khusus']) {
            $respon['harga_item'] = $item['harga_grosir'];
        } else {
            $respon['harga_item'] = $item['harga_normal'];
        }

        return $this->response->setJSON($respon);
    }

    public function cekLevel()
    {
        $barcode = $this->request->getGet('barcode');
        $jumlah  = $this->request->getGet('jumlah');
        $level   = $this->request->getGet('level');
        $item    = $this->convertUnitModel->cekLevel($barcode);
        $respon  = [];

        if ($level == '3') {
            $respon['box_minus']  = $jumlah / $item['level_3'];
            $respon['slop_minus'] = $jumlah / $item['level_2'];
            $respon['pcs_minus']  = $jumlah;
        } else if ($level == '1') {
            $respon['box_minus']  = $jumlah;
            $respon['pcs_minus']  = $jumlah * $item['level_3'];
            $respon['slop_minus'] = $jumlah * $item['level_2'];
        } else {
            $respon['box_minus']  = $jumlah / $item['level_2'];
            $respon['pcs_minus']  = $jumlah * ($item['level_3'] / $item['level_2']);
            $respon['slop_minus'] = $jumlah;
        }

        return $this->response->setJSON($respon);
    }

    public function tambahKeranjang()
    {
        if ($this->request->getMethod() == 'post') {
            $id   = $this->request->getPost('iditem', FILTER_SANITIZE_NUMBER_INT);
            $item = [
                'id'           => $id,
                'barcode'      => $this->request->getPost('barcode', FILTER_SANITIZE_STRING),
                'nama'         => $this->request->getPost('nama', FILTER_SANITIZE_STRING),
                'satuan'       => $this->request->getPost('satuan', FILTER_SANITIZE_STRING),
                'level'        => $this->request->getPost('level', FILTER_SANITIZE_STRING),
                'harga'        => $this->request->getPost('harga', FILTER_SANITIZE_NUMBER_INT),
                'harga_khusus' => $this->request->getPost('harga_khusus', FILTER_SANITIZE_NUMBER_INT),
                'harga_grosir' => $this->request->getPost('harga_grosir', FILTER_SANITIZE_NUMBER_INT),
                'harga_normal' => $this->request->getPost('harga_normal', FILTER_SANITIZE_NUMBER_INT),
                'qty_khusus'   => $this->request->getPost('qty_khusus', FILTER_SANITIZE_NUMBER_INT),
                'qty_grosir'   => $this->request->getPost('qty_grosir', FILTER_SANITIZE_NUMBER_INT),
                'jumlah'       => $this->request->getPost('jumlah', FILTER_SANITIZE_NUMBER_INT),
                'stok'         => $this->request->getPost('stok', FILTER_SANITIZE_NUMBER_INT),
                'box_minus'    => $this->request->getPost('box_minus'),
                'pcs_minus'    => $this->request->getPost('pcs_minus'),
                'slop_minus'   => $this->request->getPost('slop_minus'),
                'level_1'      => $this->request->getPost('level_1'),
                'level_2'      => $this->request->getPost('level_2'),
                'level_3'      => $this->request->getPost('level_3')
            ];
            $hasil = Keranjang::tambah($id, $item);  // masukan item ke keranjang
            if ($hasil == 'error') {
                $respon = [
                    'status' => false,
                    'pesan'  => 'Item yang ditambahkan melebihi stok',
                ];
            } else {
                $respon = [
                    'status' => true,
                    'pesan'  => 'Item berhasil ditambahkan ke keranjang.',
                ];
            }

            return $this->response->setJSON($respon);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $iditem = $this->request->getPost('iditem', FILTER_SANITIZE_NUMBER_INT);
            if (empty($iditem)) {
                // hapus session keranjang
                session()->remove('keranjang');
                $respon = [
                    'status' => true,
                    'pesan'  => 'Transaksi berhasil dibatalkan.',
                ];
            } else {
                $hapus = Keranjang::hapus($iditem);
                if ($hapus) {
                    $respon = [
                        'status' => true,
                        'pesan'  => 'Item berhasil dihapus dari keranjang.',
                    ];
                } else {
                    $respon = [
                        'status' => false,
                        'pesan'  => 'Gagal menghapus item dari keranjang',
                    ];
                }
            }

            return $this->response->setJSON($respon);
        }
    }

    public function ubahItem()
    {
        if ($this->request->getMethod() == 'post') {
            $id   = $this->request->getPost('item_id', FILTER_SANITIZE_NUMBER_INT);
            $item = [
                'harga'      => $this->request->getPost('item_harga', FILTER_SANITIZE_NUMBER_INT),
                'jumlah'     => $this->request->getPost('item_jumlah', FILTER_SANITIZE_NUMBER_INT),
                'diskon'     => $this->request->getPost('item_diskon', FILTER_SANITIZE_NUMBER_INT),
                'notes'     => $this->request->getPost('item_notes'),
                'total'      => $this->request->getPost('harga_setelah_diskon', FILTER_SANITIZE_NUMBER_INT),
                'box_minus'  => $this->request->getPost('item_box_minus'),
                'pcs_minus'  => $this->request->getPost('item_pcs_minus'),
                'slop_minus' => $this->request->getPost('item_slop_minus')
            ];
            Keranjang:: ubah($id, $item);  // masukan item ke keranjang
            $respon = [
                'pesan' => 'Item berhasil diubah.',
            ];

            return $this->response->setJSON($respon);
        }
    }

    public function hapusTransaksi()
    {
        if ($this->request->isAJAX()) {
            $iditem = $this->request->getPost('iditem', FILTER_SANITIZE_NUMBER_INT);
            if (empty($iditem)) {
                // hapus session keranjang
                session()->remove('keranjang');
                $respon = [
                    'status' => true,
                    'pesan'  => 'Transaksi berhasil dibatalkan.',
                ];
            } else {
                $hapus = Keranjang::hapus($iditem);
                if ($hapus) {
                    $respon = [
                        'status' => true,
                        'pesan'  => 'Item berhasil dihapus dari keranjang.',
                    ];
                } else {
                    $respon = [
                        'status' => false,
                        'pesan'  => 'Gagal menghapus item dari keranjang',
                    ];
                }
            }

            return $this->response->setJSON($respon);
        }
    }

    public function bayarTransaksi()
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($this->request->getMethod() == 'post') {
            // tambahkan record ke tabel penjualan
            $tunai     = $this->request->getPost('tunai', FILTER_SANITIZE_NUMBER_INT);
            $kembalian = $this->request->getPost('kembalian', FILTER_SANITIZE_NUMBER_INT);
            $data      = [
                'invoice'     => $this->request->getPost('invoice'),
                'id_customer' => $this->request->getPost('id_pelanggan', FILTER_SANITIZE_NUMBER_INT),
                'total_price' => $this->request->getPost('subtotal', FILTER_SANITIZE_NUMBER_INT),
                'discount'    => $this->request->getPost('diskon', FILTER_SANITIZE_NUMBER_INT),
                'final_price' => $this->request->getPost('total_akhir', FILTER_SANITIZE_NUMBER_INT),
                'tunai'       => str_replace('.', '', $tunai),
                'return'      => str_replace('.', '', $kembalian),
                'notes'       => $this->request->getPost('catatan', FILTER_SANITIZE_STRING),
                'tipe'        => $this->request->getPost('tipe', FILTER_SANITIZE_STRING),
                'jenis'       => $this->request->getPost('jenis', FILTER_SANITIZE_STRING),
                'jumlah'      => $this->request->getPost('total_item', FILTER_SANITIZE_NUMBER_INT),
                'date'        => $this->request->getPost('tanggal', FILTER_SANITIZE_STRING),
                'id_user'     => session('id_user'),
                'ip_address'  => $this->request->getIPAddress(),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ];

            $result = $this->saleModel->simpanPenjualan($data, $data['tipe']);
            if ($result['status']) {
                $respon = [
                    'status'      => $result['status'],
                    'pesan'       => 'Transaksi berhasil.',
                    'idpenjualan' => $result['id'],
                ];
            } else {
                $respon = [
                    'status' => $result['status'],
                    'pesan'  => 'Transaksi gagal',
                ];
            }

            return $this->response->setJSON($respon);
        }
    }

    public function cetakTransaksi($id)
    {
        $transaksi = $this->transactionModel->detailTransaksi($id);
        // jika id penjualan tidak ditemukan redirect ke halaman invoice dan tampilkan error
        if (empty($transaksi)) {
            return redirect()->to('/penjualan/invoice')->with('pesan', 'Invoice tidak ditemukan');
        }
        return view('kasir/body/sale/cetak-termal', ['transaksi' => $transaksi]);
    }

    public function akhiriShift()
    {
        $karyawanData = $this->karyawanModel->getKaryawanByUserId(session('id_user'));
        // var_dump(session('id_user'));

        $kondisi = $this->request->getVar('kondisi');
        date_default_timezone_set('Asia/Jakarta');

        $dataUpdate = [
            'kondisi'    => $kondisi,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->karyawanModel->update($karyawanData['id_karyawan'], $dataUpdate);

        return redirect()->to(base_url('sibabad2'));
    }

    public function mulaiShift()
    {
        $karyawanData = $this->karyawanModel->getKaryawanByUserId(session('id_user'));

        $kondisi = $this->request->getVar('kondisi');
        date_default_timezone_set('Asia/Jakarta');

        $dataUpdate = [
            'kondisi'    => $kondisi,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->karyawanModel->update($karyawanData['id_karyawan'], $dataUpdate);

        return redirect()->to(base_url('sibabad2'));
    }


}