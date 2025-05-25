<?php

namespace App\Models;

use CodeIgniter\Model;

class KeahlianModel extends Model
{
    protected $table = "keahlian";
    protected $primaryKey = "id_keahlian"; 

    protected $allowedFields = ['keahlian', 'logo', 'persentase', 'id_user','updated_at'];

    public function getKeahlianById($id_keahlian)
    {
        return $this->where('id_keahlian', $id_keahlian)->first();
    }

}
