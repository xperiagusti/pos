<?php

namespace App\Models;

use CodeIgniter\Model;

class CourierModel extends Model
{
    protected $table = "courier";
    protected $primaryKey = "id_courier";
    protected $allowedFields = ['id_user', 'c_name', 'created_at', 'updated_at'];
}
