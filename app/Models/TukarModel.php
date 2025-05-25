<?php

namespace App\Models;

use CodeIgniter\Model;

class TukarModel extends Model
{
    protected $table = 'tukar';
    protected $primaryKey = 'id_tukar'; 

    protected $allowedFields = [
        'barcode',
        'invoice',
        'id_customer',
        'level_1',
        'level_2',
        'level_3',
        'harga_produk',
        'nama_produk',
        'satuan',
        'qty_retur',
        'total_price',
        'discount',
        'final_price',
        'tunai',
        'return',
        'notes',
        'tipe',
        'jenis',
        'jumlah',
        'date',
        'id_user',
        'created_at',
        'updated_at',
        'satuan_refund',
        'jumlah_uang_refund',
        'ip_address'
    ];
}