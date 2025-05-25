<?php

namespace App\Models;

use CodeIgniter\Model;

class KasModel extends Model
{
    protected $table         = 'kas';
    protected $primaryKey    = 'id_kas';
    protected $allowedFields = ['kode', 'kas_name', 'kas_total', 'tipe', 'id_user', 'date', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;

    public function kode_kas_masuk()
    {
        // ambil invoice terakhir sesuai date hari ini
        $builder = $this->builder($this->table)->selectMax('kode')->where('date', date('Y-m-d'))->where('tipe', 'Kas-Masuk')->get(1)->getRow();
        // buat format invoice baru
        if (empty($builder->kode)) {
            $no = '0001';
        } else {
            $data  = substr($builder->kode, -4);  // ambil 4 angka ke belakang
            $angka = ((int) $data) + 1;
            $no    = sprintf("%'.04d", $angka);
        }
        return "KAS_MASUK" . date('ymd') . $no;
    }

    public function kode_kas_keluar()
    {
        // ambil invoice terakhir sesuai date hari ini
        $builder = $this->builder($this->table)->selectMax('kode')->where('date', date('Y-m-d'))->where('tipe', 'Kas-Keluar')->get(1)->getRow();
        // buat format invoice baru
        if (empty($builder->kode)) {
            $no = '0001';
        } else {
            $data  = substr($builder->kode, -4);  // ambil 4 angka ke belakang
            $angka = ((int) $data) + 1;
            $no    = sprintf("%'.04d", $angka);
        }
        return "KAS_KELUAR" . date('ymd') . $no;
    }


    public function listKasMasuk()
    {
        return $this->where('tipe', 'Kas-Masuk')->orderby('id_kas', 'desc')->get()->getResultArray();
    }

    public function listKasMasukgdToday()
    {
        return $this->where('tipe', 'Kas-Masuk')
            ->where('DATE(created_at)', 'CURDATE()', false)
            ->orderBy('id_kas', 'desc')
            ->get()
            ->getResultArray();
    }



    public function listKasKeluar()
    {
        return $this->where('tipe', 'Kas-Keluar')->orderby('id_kas', 'desc')->get()->getResultArray();
    }

    public function listKasKeluargdToday()
    {
        return $this->where('tipe', 'Kas-Keluar')
            ->where('DATE(created_at)', 'CURDATE()', false) // Menggunakan CURDATE() untuk mendapatkan tanggal saat ini
            ->orderBy('id_kas', 'desc')
            ->get()
            ->getResultArray();
    }


    public function rincianKasHarian($filter = null)
    {
        $this->select('SUM(CASE WHEN tipe = "Kas-Masuk" THEN kas_total ELSE 0 END) AS kas_masuk, 
        SUM(CASE WHEN tipe = "Kas-Keluar" THEN kas_total ELSE 0 END) AS kas_keluar');

        if (empty($filter)) {
            $this->where("DATE(created_at)", date('Y-m-d'));
        } elseif ($filter == '1') {
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $this->where("DATE(created_at)", $yesterday);
        } elseif ($filter == '2') {
            // Tambahkan kondisi untuk "Last 7 Days"
            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
            $this->where("DATE(created_at) >=", $sevenDaysAgo);
        } elseif ($filter == '3') {
            // Tambahkan kondisi untuk "Last 30 Days"
            $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
            $this->where("DATE(created_at) >=", $thirtyDaysAgo);
        } elseif ($filter == '4') {
            // Tambahkan kondisi untuk "This Months"
            $firstDayOfMonth = date('Y-m-01');
            $lastDayOfMonth  = date('Y-m-t');
            $this->where("DATE(created_at) >=", $firstDayOfMonth);
            $this->where("DATE(created_at) <=", $lastDayOfMonth);
        } elseif ($filter == '5') {
            // Tambahkan kondisi untuk "Last Months"
            $firstDayOfLastMonth = date('Y-m-01', strtotime('first day of last month'));
            $lastDayOfLastMonth  = date('Y-m-t', strtotime('last day of last month'));
            $this->where("DATE(created_at) >=", $firstDayOfLastMonth);
            $this->where("DATE(created_at) <=", $lastDayOfLastMonth);
        } elseif ($filter == '6') {
            // Tidak perlu tambahan kondisi untuk "All"
        }
        return $this->get()->getRowArray();
    }


    public function rincianKasHarianKasir($id_user)
    {
        $this->select('SUM(CASE WHEN tipe = "Kas-Masuk" THEN kas_total ELSE 0 END) AS kas_masuk, 
        SUM(CASE WHEN tipe = "Kas-Keluar" THEN kas_total ELSE 0 END) AS kas_keluar');

        $this->where("DATE(created_at)", date('Y-m-d'));
        $this->where('kas.id_user', $id_user);

        return $this->get()->getRowArray();
    }

    public function total_kas($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end   = $date['waktu_end'];

        $this->select('SUM(CASE WHEN tipe = "Kas-masuk" THEN kas_total ELSE 0 END) AS kas_masuk, 
        SUM(CASE WHEN tipe = "Kas-keluar" THEN kas_total ELSE 0 END) AS kas_keluar');
        if (!empty($waktu_start)) {
            $this->where('date >=', $waktu_start);
        }
        if (!empty($waktu_end)) {
            $this->where('date <=', $waktu_end);
        }
        return $this->get()->getRowArray();
    }


}