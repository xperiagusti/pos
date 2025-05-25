<?php

namespace App\Models;

use CodeIgniter\Model;

class RecieveOrderProductModel extends Model
{
    protected $table = "recieve_order_product";
    protected $primaryKey = "id_ro_products";
    protected $allowedFields = ['id_do', 'id_do_products', 'id_product', 'ro_product_keep', 'ro_product_return', 'ro_status_input', 'id_user', 'created_at', 'updated_at'];


    public function EditRO($id)
    {
        return $this->join('direct_order', 'direct_order.id_do = recieve_order_product.id_do')
            ->join('direct_order_products', 'direct_order_products.id_do_products = recieve_order_product.id_do_products')
            ->join('product', 'product.id_product = recieve_order_product.id_product')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->join('chart_of_account', 'chart_of_account.id_coa = direct_order_products.id_coa')
            ->where('direct_order.id_do', $id)
            ->get()
            ->getResult();
    }

    public function DetailRO($id)
    {
        return $this->join('direct_order', 'direct_order.id_do = recieve_order_product.id_do')
            ->join('direct_order_products', 'direct_order_products.id_do_products = recieve_order_product.id_do_products')
            ->join('product', 'product.id_product = recieve_order_product.id_product')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->join('chart_of_account', 'chart_of_account.id_coa = direct_order_products.id_coa')
            ->where('supplier.id_supplier', $id)
            ->select('product.p_name, product.p_unit_type, direct_order_products.dop_qty, direct_order_products.id_do, direct_order.do_date, direct_order.do_code')
            ->get()
            ->getResultArray();
    }

    // public function joinSupplier()
    // {
    //     return $this
    //         ->join('direct_order', 'direct_order_products.) // Sesuaikan kolom yang Anda inginkan
    //         ->join('direct_order_products', 'direct_order_products.id_do = direct_order.id_do')
    //         ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
    //         ->where('direct_order.do_status', '1')
    //         ->orderby('direct_order_products.id_do', 'desc')
    //         ->get()
    //         ->getResultArray();
    // }

}