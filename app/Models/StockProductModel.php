<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\ProductModel;

class StockProductModel extends Model
{
    protected $table = "stock_product";
    protected $primaryKey = "id_s_product";
    protected $allowedFields = ['id_product', 'id_dop', 's_barcode','s_stock','s_price','s_qty_grosir', 's_price_grosir', 's_qty_khusus', 's_price_khusus', 's_date_expired','id_user', 'created_at', 'updated_at'];


    public function cari_ids_product($barcode,$name,$satuan)
    {

        $productModel = new ProductModel();
        $product = $productModel->select('id_product')
                    ->join('unit_type', 'product.p_unit_type = unit_type.u_name')
                    ->where('product.p_name', $name)
                    ->where('unit_type.level', $satuan)
                    ->first();

        if ($product) 
        {
            return $this->select('id_s_product')
                    ->where('id_product', $product['id_product'])
                    ->where('s_barcode', $barcode)
                    ->first();
        }     
    }

    public function minusStock($name, $level, $minus, $barcode)
    {
        $productModel = new ProductModel();
    
        $namaProduk = $name;
        $levelProduk = $level;
        $product = $productModel->select('id_product')
                    ->join('unit_type', 'product.p_unit_type = unit_type.u_name')
                    ->where('product.p_name', $namaProduk)
                    ->where('unit_type.level', $levelProduk)
                    ->first();
                           
        if ($product) {
            $this->where('id_product', $product['id_product'])
                 ->where('s_barcode', $barcode)
                 ->set('s_stock', 's_stock-'.$minus, false)
                 ->update();
        } else {
            // Tidak ada produk yang cocok dengan kriteria yang diberikan.
            // Anda bisa mengembalikan status khusus atau pesan kesalahan di sini tanpa memulai transaksi.
            // Misalnya:
            return ['status' => 'Produk tidak ditemukan'];
        }
    }
    

    public function addStock($name,$level,$add,$barcode)
    {
        $productModel = new ProductModel();
        $namaProduk = $name;
        $levelProduk = $level;
        $product = $productModel->select('id_product')
                    ->join('unit_type', 'product.p_unit_type = unit_type.u_name')
                    ->where('product.p_name', $namaProduk)
                    ->where('unit_type.level', $levelProduk)
                    ->first();
                               
        if ($product) {
            $this->where('id_product', $product['id_product'])
                 ->where('s_barcode', $barcode)
                       ->set('s_stock', 's_stock+'.$add, false)
                       ->update();
        }
    }


    public function rekapProduk()
    {
        $this->select('stock_product.id_s_product,product.p_name, product.p_unit_type, stock_product.s_barcode, stock_product.s_stock, stock_product.s_date_expired');
        $this->join('product', 'product.id_product = stock_product.id_product');
        $this->where('stock_product.s_date_expired !=', '0000-00-00');
        $this->orderBy('stock_product.s_date_expired DESC');
        return $this->get()->getResultArray();
    }

    
    public function daftar_stock()
    {
        return $this->join('product', 'product.id_product = stock_product.id_product')->orderby('id_s_product','desc')
            ->get()->getResultArray();
    }

    public function stockDetail($id)
    {
        return $this->join('product', 'product.id_product = stock_product.id_product')
            ->where('stock_product.id_s_product', $id)
            ->get()->getrowArray();
    }

    public function barcodeModel($keyword)
    {
        return $this->builder($this->table)->select('stock_product.id_product, s_barcode as barcode, p_name as nama_item, p_unit_type as satuan, id_s_product')
        ->join('product','product.id_product = stock_product.id_product')
        ->like('stock_product.s_barcode', $keyword)
        ->orLike('product.p_name', $keyword)
        ->get()->getResult();
    }

    public function detailItem($id = null)
    {

        $builder = $this->builder($this->table)->select('stock_product.id_s_product AS iditem, stock_product.s_barcode as barcode, product.p_name AS item, convert_unit.level_1, convert_unit.level_2,convert_unit.level_3,
        , stock_product.s_price as harga, stock_product.s_stock as stok, product.p_unit_type as satuan, unit_type.level, stock_product.s_price_grosir as harga_grosir, stock_product.s_price_khusus as harga_khusus, stock_product.s_qty_grosir as qty_grosir, stock_product.s_qty_khusus as qty_khusus ')
            ->join('product', 'product.id_product = stock_product.id_product')
            ->join('convert_unit', 'convert_unit.s_barcode = stock_product.s_barcode')
            ->join('unit_type', 'unit_type.u_name = product.p_unit_type');
        if (empty($id)) {
            return $builder->get()->getResult(); 
        } else {
            return $builder->where('stock_product.id_s_product', $id)->orWhere('stock_product.s_barcode', $id)->get(1)->getRow();
        }
    }

    public function cekStokProduk($barcode,$iditem) {
        return $this->select('s_stock as stok')->where('s_barcode', $barcode)->where('id_s_product', $iditem)->get()->getRow();
    }

    public function cekHargaProduk($item_id) {
        return $this->select('stock_product.s_price as harga_normal, stock_product.s_price_grosir as harga_grosir, stock_product.s_price_khusus as harga_khusus, stock_product.s_qty_grosir as qty_grosir, stock_product.s_qty_khusus as qty_khusus')
        ->where('id_s_product', $item_id)->get()
        ->getRowArray();
    }

    public function cariStokUnit($id, $barcode)
    {
        return $this->builder($this->table)->select('id_s_product')
        ->where('id_product', $id)
        ->where('s_barcode', $barcode)
        ->get()->getRowArray();
    }

    public function item_habis()
    {
        return $this->builder($this->table)
            ->select('s_barcode')
            ->where('s_stock =', 0)
            ->get();
    }

    public function item_hampir_habis()
    {
        $sql = "SELECT id_s_product FROM stock_product
        WHERE (s_stock >= 1 AND s_stock <= 50)";
        return $this->db->query($sql)->getResult();
    }

    public function item_hampir_expired()
    {
        $sql = "SELECT * FROM stock_product
        WHERE s_date_expired > CURDATE() AND s_date_expired <= DATE_ADD(CURDATE(), INTERVAL 1 MONTH);; ";

        return $this->db->query($sql)->getResult();
    }

    public function item_expired()
    {
        $sql = "SELECT * FROM `stock_product` WHERE s_date_expired <= CURDATE() AND s_date_expired != '0000-00-00';";

        return $this->db->query($sql)->getResult();
    }

}