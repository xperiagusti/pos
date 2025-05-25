<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\TransactionModel;
use App\Models\StockProductModel;

class RefundModel extends Model
{
    protected $table = 'refund';
    protected $primaryKey = 'id_refund';

    protected $allowedFields = [
        'harga',
        'nama_produk',
        'satuan',
        'qty',
        'satuan_refund',
        'qty_refund',
        'total_refund',
        'invoice',
        'id_customer',
        'total_price',
        'discount',
        'final_price',
        'notes',
        'id_user',
        'ip_address'
    ];

    protected $useTimestamps = true;

    public function transaksiPenjualan($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end = $date['waktu_end'];
        $this->select('refund.*, customer.customer_name, user.username');
        $this->join('customer', 'customer.id_customer = refund.id_customer');
        $this->join('user', 'user.id_user = refund.id_user');
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

        $this->select('id_refund', false);
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

        $this->select('(SUM(CASE WHEN tipe = "Penjualan" THEN final_price ELSE 0 END) - SUM(CASE WHEN tipe = "Retur" THEN final_price ELSE 0 END)) AS total_income', false);
        if (!empty($waktu_start)) {
            $this->where('date >=', $waktu_start);
        }
        if (!empty($waktu_end)) {
            $this->where('date <=', $waktu_end);
        }
        return $this->get()->getRowArray();
    }

    public function total_refund_retur($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end = $date['waktu_end'];

        $this->select('SUM(CASE WHEN tipe = "Penjualan" THEN final_price ELSE 0 END) AS penjualan, 
        SUM(CASE WHEN tipe = "Retur" THEN final_price ELSE 0 END) AS retur,SUM(CASE WHEN jenis = "Non-Tunai" AND tipe ="Penjualan" THEN final_price ELSE 0 END) AS penjualan_non_tunai,
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
        $this->join('transaction', 'transaction.id_refund = refund.id_refund');
        $this->join('stock_product', 'stock_product.id_s_product = transaction.id_s_product');
        $this->join('product', 'product.id_product = stock_product.id_product');
        $this->where('refund.date >=', $sebulan_lalu);
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

    public function simpanRefund(array $data)
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        $this->save($data); // Simpan data ke tabel refund

        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return ['status' => false];
        } else {
            return ['status' => $db->transCommit()];
        }
    }

    public function laporanPenjualan($tahun)
    {
        return $this->builder('tb_bulan_tahun')->select('bulan')->selectCount('jumlah_item', 'total')->join('tb_transaksi', 'date_format(created_at, "%m-%Y") = bln_thn', 'left')->where('tahun', $tahun)->groupBy('bln_thn')->get()->getResult();
    }
}