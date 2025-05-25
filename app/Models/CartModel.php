<?php

namespace App\Models;

use App\Models\ProductModel;
use CodeIgniter\Model;

class CartModel extends Model {
    protected $table         = 'tb_keranjang';
    protected $primaryKey    = 'id_keranjang';
    protected $allowedFields = ['id_keranjang', 'id_item', 'harga_produk', 'qty', 'diskon_item', 'total', 'id_user', 'stok_produk', 'ip_address'];

    protected $afterInsert = ['updateStok'];

    protected $db;
    protected $builder;

    public function __construct() {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table($this->table);
    }


    public function cekStokProduk($barcode) {
        return $this->builder('product')->select('stok')->where('p_code', $barcode)->get()->getRow();
    }

   
}
