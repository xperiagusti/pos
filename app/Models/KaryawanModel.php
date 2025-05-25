<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class KaryawanModel extends Model
{
    protected $table = "karyawan";
    protected $primaryKey = "id_karyawan";
    protected $allowedFields = ['nama', 'noktp', 'alamat', 'nohp', 'jam_selesai', 'foto', 'id_user', 'created_at', 'updated_at', 'kondisi'];

    public function getKaryawanByUserId($user_id)
    {
        return $this->where('id_user', $user_id)->first();
    }

    public function getKaryawanShift($id_user)
    {
        return $this->join('shift', 'karyawan.jam_selesai = shift.jam_selesai')
            ->where('karyawan.id_user', $id_user)
            ->select('karyawan.jam_selesai, shift.nama')
            ->first();
    }

    public function getKaryawanWithShiftByUserId($id_user)
    {
        return $this->join('shift', 'karyawan.jam_selesai = shift.jam_selesai', 'left')
            ->join('user', 'karyawan.id_user = user.id_user', 'left')
            ->join('sale', 'karyawan.id_user = sale.id_user', 'left')
            ->where('karyawan.id_user', $id_user)
            ->where('DATE(sale.updated_at)', 'CURDATE()', false) // Filter berdasarkan hari ini
            ->select('karyawan.*, shift.nama AS nama_shift')
            ->select('karyawan.*, shift.jam_mulai AS mulai_shift')
            ->select('karyawan.*, shift.jam_selesai AS selesai_shift')
            ->select('karyawan.*, user.role as posisi')
            ->select('karyawan.*, user.username as ini')
            ->select('
            (SUM(CASE WHEN sale.tipe = "Penjualan" THEN final_price ELSE 0 END) - SUM(CASE WHEN sale.tipe = "Retur" THEN final_price ELSE 0 END)) AS penjualan,
            SUM(CASE WHEN sale.jenis = "Non-Tunai" AND sale.tipe ="Penjualan" THEN final_price ELSE 0 END) AS bayar_nontunai,
            SUM(CASE WHEN sale.jenis = "Tunai" AND sale.tipe ="Penjualan" THEN final_price ELSE 0 END) AS bayar_tunai,
            SUM(CASE WHEN sale.tipe = "Retur" THEN final_price ELSE 0 END) AS retur')
            ->first();
    }

    public function kas($id_user)
    {
        return $this->join('kas', 'karyawan.id_user = kas.id_user', 'left')
            ->where('karyawan.id_user', $id_user)
            ->where('DATE(kas.updated_at)', 'CURDATE()', false)
            ->select('SUM(CASE WHEN kas.tipe = "Kas-Keluar" THEN kas.kas_total ELSE 0 END) AS total_kas_keluar')
            ->select('SUM(CASE WHEN kas.tipe = "Kas-Masuk" THEN kas.kas_total ELSE 0 END) AS total_kas_masuk')
            ->first();
    }

    public function getPopupByUserId($id_user)
    {
        return $this->join('shift', 'karyawan.jam_selesai = shift.jam_selesai', 'left')
            ->join('user', 'karyawan.id_user = user.id_user', 'left')
            ->join('sale', 'karyawan.id_user = sale.id_user', 'left')
            ->where('karyawan.id_user', $id_user)
            ->select('karyawan.*, shift.nama AS nama_shift')
            ->select('karyawan.*, shift.jam_mulai AS mulai_shift')
            ->select('karyawan.*, shift.jam_selesai AS selesai_shift')
            ->select('karyawan.*, user.role as posisi')
            ->select('karyawan.*, user.username as ini')
            ->first();
    }

    public function getTransaksi($id_user)
    {
        $saleQuery = $this->db->table('sale')
            ->join('karyawan', 'karyawan.id_user = sale.id_user')
            ->join('shift', 'karyawan.jam_selesai = shift.jam_selesai', 'left')
            ->join('user', 'karyawan.id_user = user.id_user', 'left')
            ->join('shift as s', 'karyawan.jam_selesai = s.jam_selesai', 'left')
            ->where('karyawan.id_user', $id_user)
            ->where('DATE(sale.created_at)', 'CURDATE()', false)
            ->select('sale.invoice AS kode, sale.final_price AS total_harga, sale.date AS tanggal, sale.tipe AS jenis, karyawan.nama AS nama, sale.jenis AS q');

        $kasQuery = $this->db->table('kas')
            ->join('karyawan', 'karyawan.id_user = kas.id_user', 'left')
            ->where('kas.id_user', $id_user)
            ->where('DATE(kas.created_at)', 'CURDATE()', false)
            ->select('kas.kode AS kode, kas.kas_total as total_harga, kas.date AS tanggal, kas.tipe AS jenis, karyawan.nama AS nama, NULL AS q');

        $result_sale = $saleQuery->get()->getResultArray();
        $result_kas = $kasQuery->get()->getResultArray();

        $merged_result = array_merge($result_sale, $result_kas);

        return $merged_result;
    }

    public function updateKondisi($id, $kondisi)
    {
        $data = [
            'kondisi' => $kondisi
        ];

        $this->where('id_karyawan', $id)->update($data);
    }

}