<?php

namespace App\Models;

use CodeIgniter\Model;

class SosialModel extends Model
{
    protected $table = "sosial";
    protected $primaryKey = "id_sosial"; 
    protected $allowedFields = ['nama_sosmed', 'url', 'icon','id_user','update_at'];

    public function getSosialById($id_sosial)
    {
        return $this->where('id_sosial', $id_sosial)->first();
    }

}
