<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\TransactionModel;
use App\Models\StockProductModel;

class SaleModel extends Model
{
    protected $table = 'sale';
    protected $primaryKey = 'id_sale';

    protected $allowedFields = [
        'invoice',
        'id_customer',
        'harga_produk',
        'nama_produk',
        'satuan',
        'qty_retur',
        'total_price',
        'discount',
        'final_price',
        'tunai',
        'return',
        'notes',
        'tipe',
        'jenis',
        'jumlah',
        'date',
        'id_user',
        'ip_address'
    ];
    protected $useTimestamps = true;

    public function transaksiHarian($filter = null)
    {
        $union = $this->db->table('sale')->select('id_sale as id, invoice as kode, final_price as nilai, tipe, sale.created_at, username as kasir')->join('user', 'user.id_user = sale.id_user');
        $builder = $this->db->table('kas')->select('id_kas as id, kode, kas_total as nilai, tipe, kas.created_at, username as kasir')->join('user', 'user.id_user = kas.id_user', 'left')->union($union);

        $query = $this->db->newQuery()->fromSubquery($builder, 'q')->orderBy('created_at', 'DESC');

        if (empty($filter)) {
            $query->where("DATE(created_at)", date('Y-m-d'));
        } elseif ($filter == '1') {
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $query->where("DATE(created_at)", $yesterday);
        } elseif ($filter == '2') {
            // Tambahkan kondisi untuk "Last 7 Days"
            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
            $query->where("DATE(created_at) >=", $sevenDaysAgo);
        } elseif ($filter == '3') {
            // Tambahkan kondisi untuk "Last 30 Days"
            $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
            $query->where("DATE(created_at) >=", $thirtyDaysAgo);
        } elseif ($filter == '4') {
            // Tambahkan kondisi untuk "This Months"
            $firstDayOfMonth = date('Y-m-01');
            $query->where("DATE(created_at) >=", $firstDayOfMonth);
        } elseif ($filter == '5') {
            // Tambahkan kondisi untuk "Last Months"
            $firstDayOfLastMonth = date('Y-m-01', strtotime('first day of last month'));
            $lastDayOfLastMonth = date('Y-m-t', strtotime('last day of last month'));
            $query->where("DATE(created_at) >=", $firstDayOfLastMonth);
            $query->where("DATE(created_at) <=", $lastDayOfLastMonth);
        } elseif ($filter == '6') {
            // Tidak perlu tambahan kondisi untuk "All"
        }

        return $query->get()->getResultArray();
    }

    public function rincianPenjualanHarian($filter = null)
    {
        $this->select('SUM(CASE WHEN tipe = "Penjualan" THEN final_price ELSE 0 END) AS penjualan, 
        SUM(CASE WHEN tipe = "Retur-refund" THEN final_price ELSE 0 END) AS retur,
        SUM(CASE WHEN jenis = "Non-Tunai" AND tipe = "Penjualan" THEN final_price ELSE 0 END) AS penjualan_non_tunai,
        SUM(CASE WHEN jenis = "Tunai" AND tipe = "Penjualan" THEN final_price ELSE 0 END) AS penjualan_tunai');

        if (empty($filter)) {
            $this->where("DATE(created_at)", date('Y-m-d'));
        } elseif ($filter == '1') {
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $this->where("DATE(created_at)", $yesterday);
        } elseif ($filter == '2') {
            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
            $this->where("DATE(created_at) >=", $sevenDaysAgo);
        } elseif ($filter == '3') {
            $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
            $this->where("DATE(created_at) >=", $thirtyDaysAgo);
        } elseif ($filter == '4') {
            $firstDayOfMonth = date('Y-m-01');
            $lastDayOfMonth = date('Y-m-t');
            $this->where("DATE(created_at) >=", $firstDayOfMonth);
            $this->where("DATE(created_at) <=", $lastDayOfMonth);
        } elseif ($filter == '5') {
            $firstDayOfLastMonth = date('Y-m-01', strtotime('first day of last month'));
            $lastDayOfLastMonth = date('Y-m-t', strtotime('last day of last month'));
            $this->where("DATE(created_at) >=", $firstDayOfLastMonth);
            $this->where("DATE(created_at) <=", $lastDayOfLastMonth);
        } elseif ($filter == '6') {
            // Tidak perlu tambahan kondisi untuk "All"
        }

        return $this->get()->getRowArray();
    }

    public function rincianPenjualanHarianKasir($id_user)
    {
        $this->select('SUM(CASE WHEN tipe = "Penjualan" THEN final_price ELSE 0 END) AS penjualan, 
        SUM(CASE WHEN tipe = "Retur-refund" THEN final_price ELSE 0 END) AS retur,
        SUM(CASE WHEN jenis = "Non-Tunai" AND tipe = "Penjualan" THEN final_price ELSE 0 END) AS penjualan_non_tunai,
        SUM(CASE WHEN jenis = "Tunai" AND tipe = "Penjualan" THEN final_price ELSE 0 END) AS penjualan_tunai');

        $this->where("DATE(created_at)", date('Y-m-d'));
        $this->where('sale.id_user', $id_user);

        return $this->get()->getRowArray();
    }

    public function rekapTransaksi($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end = $date['waktu_end'];
        $tipe = $date['tipe'];

        $unionSale = $this->db->table('sale')
        ->select('id_sale as id, invoice as kode, final_price as nilai, tipe, jenis, date, sale.created_at, username as kasir')
            ->join('user', 'user.id_user = sale.id_user');

        $unionKas = $this->db->table('kas')
            ->select('id_kas as id, kode, kas_total as nilai, tipe, jenis, date, kas.created_at, username as kasir')
            ->join('user', 'user.id_user = kas.id_user', 'left');

        $builder = $this->db->table('direct_order')
            ->select('direct_order.id_do as id, do_code as kode , SUM(dop_total) as nilai, "Pembelian" as tipe, "Tunai" as jenis, do_date as date, direct_order_products.created_at, username as kasir')
            ->join('direct_order_products', 'direct_order_products.id_do = direct_order.id_do')
            ->join('user', 'user.id_user = direct_order_products.id_user')
            ->groupBy('direct_order.id_do')
            ->union($unionSale)
            ->union($unionKas);

            $query = $this->db->newQuery()->fromSubquery($builder, 'q')->orderBy('created_at', 'DESC');



        if (!empty($tipe)) {
                $query->where('tipe =', $tipe);
        }
        if (!empty($waktu_start)) {
            $query->where('date >=', $waktu_start);
        }
        if (!empty($waktu_end)) {
            $query->where('date <=', $waktu_end);
        }
        return $query->get()->getResultArray();
    }


    public function transaksiPenjualan($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end = $date['waktu_end'];
        $this->select('sale.*, customer.customer_name, user.username');
        $this->join('customer', 'customer.id_customer = sale.id_customer');
        $this->join('user', 'user.id_user = sale.id_user');
        if (!empty($waktu_start)) {
            $this->where('date >=', $waktu_start);
        }
        if (!empty($waktu_end)) {
            $this->where('date <=', $waktu_end);
        }
        return $this->orderBy('id_Sale', 'desc')->get()->getResultArray();
    }

    public function total_transaction($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end = $date['waktu_end'];

        $this->select('id_sale', false);
        if (!empty($waktu_start)) {
            $this->where('date >=', $waktu_start);
        }
        if (!empty($waktu_end)) {
            $this->where('date <=', $waktu_end);
        }
        return $this->get()->getResultArray();
    }

    public function total_income($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end = $date['waktu_end'];

        $this->select('(SUM(CASE WHEN tipe = "Penjualan" THEN final_price ELSE 0 END) - SUM(CASE WHEN tipe = "Retur-refund" THEN final_price ELSE 0 END)) AS total_income', false);
        if (!empty($waktu_start)) {
            $this->where('date >=', $waktu_start);
        }
        if (!empty($waktu_end)) {
            $this->where('date <=', $waktu_end);
        }
        return $this->get()->getRowArray();
    }

    public function total_sale_retur($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end = $date['waktu_end'];

        $this->select('SUM(CASE WHEN tipe = "Penjualan" THEN final_price ELSE 0 END) AS penjualan, 
        SUM(CASE WHEN tipe = "Retur-refund" THEN final_price ELSE 0 END) AS retur,SUM(CASE WHEN jenis = "Non-Tunai" AND tipe ="Penjualan" THEN final_price ELSE 0 END) AS penjualan_non_tunai,
        SUM(CASE WHEN jenis = "Tunai" AND tipe ="Penjualan" THEN final_price ELSE 0 END) AS penjualan_tunai');
        if (!empty($waktu_start)) {
            $this->where('date >=', $waktu_start);
        }
        if (!empty($waktu_end)) {
            $this->where('date <=', $waktu_end);
        }
        return $this->get()->getRowArray();
    }

    public function penjualanHarian()
    {
        $today = date('Y-m-d'); // Mendapatkan tanggal hari ini
        $this->select('SUM(final_price) as total_penjualan');
        $this->where('tipe', 'Penjualan');
        $this->where('date', $today); // Menggunakan tanggal hari ini
        return $this->get()->getRowArray();
    }

    public function penjualanMingguan()
    {
        $seminggu_lalu = date('Y-m-d', strtotime('-1 week'));
        $this->select('SUM(final_price) as total_penjualan');
        $this->where('tipe', 'Penjualan');
        $this->where('date >=', $seminggu_lalu);
        return $this->get()->getRowArray();
    }

    public function penjualanBulanan()
    {
        $sebulan_lalu = date('Y-m-d', strtotime('-1 month'));
        $this->select('SUM(final_price) as total_penjualan');
        $this->where('tipe', 'Penjualan');
        $this->where('date >=', $sebulan_lalu);
        return $this->get()->getRowArray();
    }

    public function produkTerlaris()
    {
        $sebulan_lalu = date('Y-m-d', strtotime('-1 month'));

        $this->select('product.p_name, product.p_unit_type, stock_product.s_price, SUM(transaction.item_amount) as jumlah_item_terjual');
        $this->join('transaction', 'transaction.id_sale = sale.id_sale');
        $this->join('stock_product', 'stock_product.id_s_product = transaction.id_s_product');
        $this->join('product', 'product.id_product = stock_product.id_product');
        $this->where('sale.date >=', $sebulan_lalu);
        $this->groupBy('transaction.id_s_product');
        $this->orderBy('jumlah_item_terjual', 'desc');
        $this->limit(10); // Ambil 10 produk terlaris  
        return $this->get()->getResultArray();
    }

    public function rekapProduk()
    {
        $this->select('product.p_name, product.p_unit_type, stock_product.s_barcode, stock_product.s_stock, stock_product.s_date_expired.');
        $this->join('product', 'product.id_product = stock_product.id_product');
        $this->orderBy('stock_product.s_date_expired', 'desc');
        return $this->get()->getResultArray();
    }

    public function invoice()
    {
        // ambil invoice terakhir sesuai date hari ini
        $builder = $this->builder($this->table)->selectMax('invoice')->where('date', date('Y-m-d'))->where('tipe', 'Penjualan')->get(1)->getRow();
        // buat format invoice baru
        if (empty($builder->invoice)) {
            $no = '0001';
        } else {
            $data = substr($builder->invoice, -4); // ambil 4 angka ke belakang
            $angka = ((int) $data) + 1;
            $no = sprintf("%'.04d", $angka);
        }
        return "INV" . date('ymd') . $no;
    }

    public function simpanPenjualan(array $post, $tipe)
    {
        $item = new StockProductModel();
        $transaksi = new TransactionModel();

        $db = \Config\Database::connect();
        $db->transBegin();
        $this->save($post); // simpan transaksi ke tabel penjualan
        $id_penjualan = $this->insertID; // mengambil id penjualan
        $keranjang = session('keranjang'); // menampung session keranjang
        $data = [];
        foreach ($keranjang as $val) {
            $itemTransaksi = [
                'id_sale' => $id_penjualan,
                'id_s_product' => $val['id'],
                'item_price' => $val['harga'],
                'item_amount' => $val['jumlah'],
                'item_discount' => $val['diskon'],
                'item_notes' => $val['notes'],
                'subtotal' => $val['total'],
                'ip_address' => $post['ip_address'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
            array_push($data, $itemTransaksi); // masukan item transaksi ke variabel $data
            // update stok item sesuai idnya
            if ($tipe == 'Penjualan') {
                if ($val['box_minus'] !== 'Infinity') {
                    $item->minusStock($val['nama'], 1, $val['box_minus'], $val['barcode']);
                }
                if ($val['slop_minus'] !== 'Infinity') {
                    $item->minusStock($val['nama'], 2, $val['slop_minus'], $val['barcode']);
                }
                if ($val['pcs_minus'] !== 'Infinity') {
                    $item->minusStock($val['nama'], 3, $val['pcs_minus'], $val['barcode']);
                }
            } else {
                if ($val['box_minus'] !== 'Infinity') {
                    $item->addStock($val['nama'], 1, $val['box_minus'], $val['barcode']);
                }
                if ($val['slop_minus'] !== 'Infinity') {
                    $item->addStock($val['nama'], 2, $val['slop_minus'], $val['barcode']);
                }
                if ($val['pcs_minus'] !== 'Infinity') {
                    $item->addStock($val['nama'], 3, $val['pcs_minus'], $val['barcode']);
                }
            }

            // $item->set('s_stock', 's_stock-'.$val['jumlah'], false);
            // $item->where('id_s_product', $val['id']);
            // $item->update();
        }
        $transaksi->insertBatch($data); // tambahkan ke tabel transaksi

        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return ['status' => false];
        } else {
            // kosongkang keranjang
            unset($_SESSION['keranjang']);
            return ['status' => $db->transCommit(), 'id' => $id_penjualan];
        }
    }

    public function laporanPenjualan($tahun)
    {
        return $this->builder('tb_bulan_tahun')->select('bulan')->selectCount('jumlah_item', 'total')->join('tb_transaksi', 'date_format(created_at, "%m-%Y") = bln_thn', 'left')->where('tahun', $tahun)->groupBy('bln_thn')->get()->getResult();
    }
}