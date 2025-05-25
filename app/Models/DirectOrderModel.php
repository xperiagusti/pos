<?php

namespace App\Models;

use CodeIgniter\Model;

class DirectOrderModel extends Model
{
    protected $table = "direct_order";
    protected $primaryKey = "id_do";
    protected $allowedFields = ['do_date', 'do_code', 'do_shipment', 'do_courier', 'do_status'];

    public function joinSupplier()
    {
        return $this->distinct('s_name')
            ->select('supplier.s_name, supplier.id_supplier')
            ->join('direct_order_products', 'direct_order_products.id_do = direct_order.id_do')
            ->join('supplier', 'supplier.id_supplier = direct_order_products.id_supplier')
            ->where('direct_order.do_status', '1')
            ->orderby('supplier.s_name', 'asc')
            ->get()
            ->getResultArray();
    }
}