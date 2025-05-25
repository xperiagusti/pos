<?php

namespace App\Models;

use CodeIgniter\Model;

class DirectOrderProductModel extends Model
{
    protected $table = "direct_order_products";
    protected $primaryKey = "id_do_products";
    protected $allowedFields = ['id_do', 'id_user', 'id_supplier', 'id_product', 'id_coa', 'dop_price', 'dop_qty', 'dop_total', 'dop_status', 'created_at', 'updated_at'];

    public function totalPO()
    {
        return $this->select('SUM(dop_total) AS total_po')
            ->get()->getRowArray();
    }

    public function total_pembelian($date = null)
    {
        $waktu_start = $date['waktu_start'];
        $waktu_end = $date['waktu_end'];

        $this->select('SUM(dop_total) AS total_po')
            ->join('direct_order', 'direct_order.id_do = direct_order_products.id_do' );
        if (!empty($waktu_start)) {
            $this->where('do_date >=', $waktu_start);
        }
        if (!empty($waktu_end)) {
            $this->where('do_date <=', $waktu_end);
        }
        return $this->get()->getRowArray();
    }


    public function joinDO()
    {
        return $this->distinct('id_do_products')
            ->select('direct_order.*, supplier.*') // Sesuaikan kolom yang Anda inginkan
            ->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
            ->join('product', 'product.id_product = direct_order_products.id_product')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->join('chart_of_account', 'chart_of_account.id_coa = direct_order_products.id_coa')
            ->orderby('direct_order.do_Date','desc')
            ->get()->getResultObject();
    }

    public function joinDO1()
    {
        return $this->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
            ->join('product', 'product.id_product = direct_order_products.id_product')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->join('chart_of_account', 'chart_of_account.id_coa = direct_order_products.id_coa')
            ->orderby('direct_order.do_Date','desc')
            ->get()->getResultObject();
    }

   

    public function joinDOToEdit($id)
    {
        return $this->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
            ->join('product', 'product.id_product = direct_order_products.id_product')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->join('chart_of_account', 'chart_of_account.id_coa = direct_order_products.id_coa')
            ->where('direct_order.id_do', $id)
            ->get()
            ->getResult();
    }

    public function joinDOByDate($dateFrom, $dateTo)
    {

        return $this->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
            ->join('product', 'product.id_product = direct_order_products.id_product')
            ->where('direct_order.do_date', $dateFrom)
            ->where('direct_order.do_date', $dateTo)
            ->get()
            ->getResultObject();
    }


    /// Untuk Peneriman Produk
    public function joinDOforRO()
    {
            return $this->distinct('id_do_products')
            ->select('direct_order.*, supplier.*') // Sesuaikan kolom yang Anda inginkan
            ->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
            ->join('product', 'product.id_product = direct_order_products.id_product')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->join('chart_of_account', 'chart_of_account.id_coa = direct_order_products.id_coa')
            ->where('direct_order.do_status', '0')
            ->orderby('direct_order.do_Date','desc')
            ->get()->getResultObject();
    }

    public function joinROToAdd($id)
    {
        return $this->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
            ->join('product', 'product.id_product = direct_order_products.id_product')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->join('chart_of_account', 'chart_of_account.id_coa = direct_order_products.id_coa')
            ->where('direct_order.id_do', $id)
            ->get()
            ->getResult();
    }


    //Untuk menampilkan stok produk
    public function joinStock()
    {
        return $this->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
            ->join('recieve_order_product', 'recieve_order_product.id_do_products = direct_order_products.id_do_products')
            ->join('product', 'product.id_product = direct_order_products.id_product')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->join('chart_of_account', 'chart_of_account.id_coa = direct_order_products.id_coa')
            ->where('recieve_order_product.ro_status_input', 0)
            ->orderby('recieve_order_product.created_at', 'desc')
            ->get()
            ->getResultArray();
    }

    // public function getProduct($id)
    // {
    // return $this->select('recieve_order_product.ro_product_keep as s_stock, direct_order_products.id_product,
    //         (SUM(direct_order_products.dop_price) / COUNT(direct_order_products.id_product)) as dop_price')
    //     ->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
    //     ->join('recieve_order_product', 'recieve_order_product.id_do_products = direct_order_products.id_do_products')
    //     ->join('product', 'product.id_product = direct_order_products.id_product')
    //     ->where('direct_order_products.id_do_products', $id)
    //     ->get()
    //     ->getRowArray();
    // }
    
    public function getProduct($id)
    {
    return $this->select('recieve_order_product.ro_product_keep as s_stock, direct_order_products.id_product, p_unit_type,p_name')
        ->join('direct_order', 'direct_order.id_do = direct_order_products.id_do')
        ->join('recieve_order_product', 'recieve_order_product.id_do_products = direct_order_products.id_do_products')
        ->join('product', 'product.id_product = direct_order_products.id_product')
        ->where('direct_order_products.id_do_products', $id)
        ->get()
        ->getRowArray();
    }

    public function getprice($id)
    {
    return $this->select('(SUM(dop_price) / COUNT(id_product)) as dop_price')
        ->where('direct_order_products.id_product', $id)
        ->get()
        ->getRowArray();
    }
}
