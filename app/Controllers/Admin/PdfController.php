<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SaleModel;
use App\Models\DirectOrderProductModel;
use App\Models\KasModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends BaseController
{
    public function __construct()
    {
        $this->db        = \Config\Database::connect();
        $this->saleModel = new SaleModel();
        $this->kasModel  = new KasModel();
        $this->dopModel  = new DirectOrderProductModel();
    }

    public function dompdf($id_do)
    {
        // Load the dompdf library
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $builder = $this->db->table('direct_order_products as dop');
        $builder->select('s.s_name,s.s_pic, s.s_address, s.s_subdistrict
        , s.s_district, s.s_city,  p.p_name, dop.dop_qty,dop.dop_price, dop.dop_total, do.do_code,
        s.s_zip_code, s.s_province, s.s_nation, s.s_city, p.p_unit_type, 
        so.nama_sosmed, so.url, so.icon, b.biodata, b.footer, 
        pr.nama_perusahaan, pr.alamat, pr.kecamatan, pr.provinsi, pr.kode_pos, 
        pr.negara, pr.email, do.do_date, u.nama_lengkap, ka.logo, s.s_pabx');
        $builder->join('direct_order as do', 'dop.id_do = do.id_do');
        $builder->join('supplier as s', 'dop.id_supplier = s.id_supplier');
        $builder->join('product as p', 'dop.id_product = p.id_product');
        $builder->join('profil as pr', 'dop.id_user = pr.id_user');
        $builder->join('sosial as so', 'dop.id_user = so.id_user');
        $builder->join('keahlian as ka', 'dop.id_user = ka.id_user');
        $builder->join('biodata as b', 'dop.id_user = b.id_user');
        $builder->join('user as u', 'dop.id_user = u.id_user');
        $builder->where('do.id_do', $id_do);
              $query       = $builder->get();
        $data['supplier']  = $query->getResultArray();
              $seluruhdata = $query->getResultArray();
        $data['supplier1'] = $seluruhdata[0];

        // Hitung total dop di Controller
        $totalDop = 0;
        foreach ($data['supplier'] as $row) {
            $dopTotal = $row['dop_total'];

            // Hapus karakter pemisah ribuan (koma)
            $dopTotal = str_replace(',', '', $dopTotal);

            // Tambahkan ke totalDop
            $totalDop += $dopTotal;
        }

        // Kirim totalDop ke View
        $data['totalDop'] = $totalDop;

              $ppn     = $totalDop * 0.11;              // Hitung PPN 11%
        $data['ppn']   = $ppn;                          // Kirimkan ke view
              $total   = $totalDop + $ppn;
        $data['total'] = $total;
              $isi     = view('admin/pdf/isi', $data);

        $dompdf->loadHtml($isi);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        return $this->response->setHeader('Content-Type', 'application/pdf')->setHeader('Content-Disposition', 'inline; filename="nama_file.pdf"')->setBody($output);
    }

    public function transaksipdf()
    {
        // Load the dompdf library
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $filter             = $this->request->getGet('filter');
        $data['filter']           = $filter;
        $data['transaksi']        = $this->saleModel->transaksiHarian($filter);
        $data['rincianPenjualan'] = $this->saleModel->rincianPenjualanHarian($filter);
        $data['rincianKas']       = $this->kasModel->rincianKasHarian($filter);
              $isi                = view('admin/pdf/transaksipdf', $data);
        $dompdf->loadHtml($isi);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        return $this->response->setHeader('Content-Type', 'application/pdf')->setHeader('Content-Disposition', 'inline; filename="rekap_transaksi.pdf"')->setBody($output);
    }


    public function transaksirekappdf()
    {
        // Load the dompdf library
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $date['waktu_start'] = $this->request->getGet('date_from');
        $date['waktu_end']   = $this->request->getGet('date_to');
        $date['tipe']   = $this->request->getGet('tipe');
        $data['date']           = $date;
        $data['transaksi']        = $this->saleModel->rekapTransaksi($date);
        $data['total_pembelian']        = $this->dopModel->total_pembelian($date);
        $data['total_income']     = $this->saleModel->total_income($date);
        $data['total_sale_retur'] = $this->saleModel->total_sale_retur($date);
        $data['total_kas']       = $this->kasModel->total_kas($date);

              $isi                = view('admin/pdf/transaksirekap', $data);
        $dompdf->loadHtml($isi);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        return $this->response->setHeader('Content-Type', 'application/pdf')->setHeader('Content-Disposition', 'inline; filename="rekap_transaksi.pdf"')->setBody($output);
    }


    public function cetakBarcode($barcode)
    {
        $data['barcode'] = $barcode;
        return view('admin/pdf/cetakBarcode', $data);
    }
}