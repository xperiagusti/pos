<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = "product";
    protected $primaryKey = "id_product";
    protected $allowedFields = ['id_user', 'p_code', 'p_name', 'p_unit_type', 'p_price', 'created_at', 'updated_at'];

    public function getProductsAndSuppliers()
    {
        return $this->select('product.id_product, product.id_user, product.p_code, 
        product.p_name, product.p_unit_type, product.p_price, 
        GROUP_CONCAT(supplier.s_name) as id_supplier, supplier.s_name')
            ->join('direct_order_products', 'product.id_product = direct_order_products.id_product', 'left')
            ->join('supplier', 'direct_order_products.id_supplier = supplier.id_supplier', 'left')
            ->groupBy('product.id_product, product.p_name')
            ->findAll();
    }

    public function barcodeModel($keyword)
    {
        return $this->builder($this->table)->select('p_code, p_name')
            ->like('p_code', $keyword)
            ->orLike('p_name', $keyword)
            ->get()->getResult();
    }

    public function cariProduk($nama, $satuan)
    {
        return $this->builder($this->table)->select('id_product')
            ->where('p_name', $nama)
            ->where('p_unit_type', $satuan)
            ->get()->getRowArray();
    }

    public function detailItem($id = null)
    {
        $builder = $this->builder($this->table)->select('product.id_product AS iditem, p_code, nama_item AS item, harga, 
        harga_beliecer, harga_ecer, harga_karton, stok, stok_ecer, expired, 
        gambar, id_pemasok, nama_unit AS unit, nama_kategori AS kategori, nama_pemasok AS pemasok')

            ->join('tb_unit', 'tb_unit.id = id_unit')
            ->join('tb_kategori', 'tb_kategori.id = id_kategori')
            ->join('tb_pemasok', 'tb_pemasok.id = id_pemasok');
        if (empty($id)) {
            return $builder->get()->getResult(); // tampilkan semua data
        } else {
            // tampilkan data sesuai id/barcode
            return $builder->where('product.id', $id)->orWhere('barcode', $id)->get(1)->getRow();
        }
    }

    public function insertAndGetId($data)
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

}