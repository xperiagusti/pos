<?php

namespace App\Models;

use CodeIgniter\Model;

class BiodataModel extends Model
{
    protected $table = "biodata";
    protected $primaryKey = "id_biodata"; 

    protected $allowedFields = ['biodata', 'footer','id_user','update_at'];

    public function getBiodataById($id_biodata)
    {
        return $this->where('id_biodata', $id_biodata)->first();
    }

}
