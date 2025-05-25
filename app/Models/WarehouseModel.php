<?php

namespace App\Models;

use CodeIgniter\Model;

class WarehouseModel extends Model
{
    protected $table = "warehouse";
    protected $primaryKey = "id_warehouse";
    protected $allowedFields = ['id_user', 'w_name', 'w_address', 'w_pic', 'w_pic_contact', 'created_at', 'updated_at'];
}
