<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitTypeModel extends Model
{
    protected $table = "unit_type";
    protected $primaryKey = "id_unit_type";
    protected $allowedFields = ['id_user', 'u_name', 'level', 'created_at', 'updated_at'];


    public function opsiUnit()
    {
        return $this->select('u_name')
            ->where('u_name !=', 'box')
            ->get()
            ->getResultArray();
    }
}