<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id_transaction';

    protected $allowedFields = [
        'id_sale',
        'id_s_product',
        'item_price',
        'item_amount',
        'item_discount',
        'item_notes',
        'subtotal',
        'ip_address'
    ];

    protected $useTimestamps = true;

    public function detailTransaksi($id = null)
    {
        if ($id) {
            return $this->builder($this->table)
                ->select('item_price AS harga, item_amount AS jumlah, sale.jumlah as total_item, item_discount as diskon_item, item_notes as notes_item, subtotal, sale.invoice, sale.total_price as total_harga, sale.discount as diskon, sale.final_price as total_akhir, sale.tunai, sale.return as kembalian, 
            sale.notes as catatan, sale.created_at AS tanggal, product.p_name AS item, product.p_unit_type as satuan,product.p_code, customer.customer_name AS pelanggan,customer.address, sale.jenis, sale.tipe,user.username AS kasir, sale.ip_address, product.p_unit_type AS namaproduk')
                ->join('sale', 'sale.id_sale = transaction.id_sale')
                ->join('stock_product', 'stock_product.id_s_product = transaction.id_s_product')
                ->join('product', 'product.id_product = stock_product.id_product')
                ->join('customer', 'customer.id_customer = sale.id_customer')
                ->join('user', 'user.id_user = sale.id_user')
                ->where('sale.id_sale', $id, true)
                ->get()->getResultArray();
        }
    }

    public function detailTransaksiRefund($id = null)
    {
        if ($id) {
            return $this->builder($this->table)
                ->select('item_price AS harga, item_amount AS jumlah, sale.jumlah as total_item, item_discount as diskon_item, subtotal, sale.invoice, sale.total_price as total_harga, sale.discount as diskon, sale.final_price as total_akhir, sale.tunai, sale.return as kembalian, 
                        sale.notes as catatan, sale.created_at AS tanggal, product.p_name AS item, product.p_code,product.p_unit_type as satuan, customer.address,customer.customer_name AS pelanggan, sale.jenis, sale.tipe,user.username AS kasir, sale.ip_address, product.p_unit_type AS namaproduk')
                ->join('sale', 'sale.id_sale = transaction.id_sale')
                ->join('stock_product', 'stock_product.id_s_product = transaction.id_s_product')
                ->join('product', 'product.id_product = stock_product.id_product')
                ->join('customer', 'customer.id_customer = sale.id_customer')
                ->join('user', 'user.id_user = sale.id_user')
                ->where('sale.invoice', $id, true)
                ->where('sale.tipe', 'Retur-refund', true)
                ->get()->getResultArray();
        }
    }

    public function detailTransaksiTukar($id = null)
    {
        if ($id) {
            return $this->builder($this->table)
                ->select('item_price AS harga, item_amount AS jumlah, sale.jumlah as total_item, item_discount as diskon_item, subtotal, sale.invoice, sale.total_price as total_harga, sale.discount as diskon, sale.final_price as total_akhir, sale.tunai, sale.return as kembalian, 
                        sale.notes as catatan, sale.created_at AS tanggal, product.p_name AS item, product.p_unit_type as satuan,product.p_code, customer.customer_name AS pelanggan, customer.address, sale.jenis, sale.tipe,user.username AS kasir, sale.ip_address, product.p_unit_type AS namaproduk')
                ->join('sale', 'sale.id_sale = transaction.id_sale')
                ->join('stock_product', 'stock_product.id_s_product = transaction.id_s_product')
                ->join('product', 'product.id_product = stock_product.id_product')
                ->join('customer', 'customer.id_customer = sale.id_customer')
                ->join('user', 'user.id_user = sale.id_user')
                ->where('sale.invoice', $id, true)
                ->where('sale.tipe', 'Retur-tukar', true)
                ->get()->getResultArray();
        }
    }

    public function detailTransaksiJual($id = null)
    {
        if ($id) {
            return $this->builder($this->table)
                ->select('item_price AS harga, item_amount AS jumlah, sale.jumlah as total_item, item_discount as diskon_item, subtotal, sale.invoice, sale.total_price as total_harga, sale.discount as diskon, sale.final_price as total_akhir, sale.tunai, sale.return as kembalian, 
                        sale.notes as catatan, sale.created_at AS tanggal, product.p_name AS item, product.p_unit_type as satuan, customer.customer_name AS pelanggan, sale.jenis, sale.tipe,user.username AS kasir, sale.ip_address, product.p_unit_type AS namaproduk')
                ->join('sale', 'sale.id_sale = transaction.id_sale')
                ->join('stock_product', 'stock_product.id_s_product = transaction.id_s_product')
                ->join('product', 'product.id_product = stock_product.id_product')
                ->join('customer', 'customer.id_customer = sale.id_customer')
                ->join('user', 'user.id_user = sale.id_user')
                ->where('sale.invoice', $id, true)
                ->where('sale.tipe', 'Penjualan', true)
                ->get()->getResultArray();
        }
    }

    public function detailTransaks2($searchTerm = null)
    {
        $builder = $this->builder($this->table)
            ->select('
           
            sale.jumlah as total_item,
            sale.id_customer, 
            subtotal, 
            sale.invoice, 
            sale.total_price as total_harga, 
            sale.discount as diskon, 
            sale.final_price as total_akhir, 
            sale.tunai, 
            sale.return as kembalian,
            sale.notes as catatan, 
            sale.created_at AS tanggal, 
            item_price AS harga, 
            item_amount AS jumlah,
            item_discount as diskon_item,  
            product.p_name AS item,
            product.p_unit_type as satuan, 
            customer.customer_name AS pelanggan, 
            sale.jenis, 
            sale.tipe,
            user.username AS kasir, 
            sale.ip_address, 
            product.p_unit_type AS namaproduk,
            stock_product.s_barcode,
            stock_product.id_s_product,  
            convert_unit.level_1, 
            convert_unit.level_2, 
            convert_unit.level_3,
            unit_type.level,
        ')
            ->join('sale', 'sale.id_sale = transaction.id_sale')
            ->join('stock_product', 'stock_product.id_s_product = transaction.id_s_product')
            ->join('convert_unit', 'convert_unit.s_barcode = stock_product.s_barcode')
            ->join('product', 'product.id_product = stock_product.id_product')
            ->join('unit_type', 'unit_type.u_name = product.p_unit_type')
            ->join('customer', 'customer.id_customer = sale.id_customer')
            ->join('user', 'user.id_user = sale.id_user');

        if ($searchTerm) {
            $builder->where('sale.invoice', $searchTerm);
        }
        $builder->where('sale.tipe', 'Penjualan');
        return $builder->get()->getResultArray();
    }

    public function getProductUnitTypes()
    {
        return $this->db->table('product')->select('p_unit_type')->distinct()->get()->getResultArray();
    }

}