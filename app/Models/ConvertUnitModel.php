<?php

namespace App\Models;

use CodeIgniter\Model;

class ConvertUnitModel extends Model
{
    protected $table = "convert_unit";
    protected $primaryKey = "id_c_unit";
    protected $allowedFields = ['s_barcode','level_1','level_2','level_3', 'created_at'];

    public function cekLevel($barcode) {
        return $this->select('level_1, level_2, level_3')
        ->where('s_barcode', $barcode)->get()
        ->getRowArray();
    }

}



