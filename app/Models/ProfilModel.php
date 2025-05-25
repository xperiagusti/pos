<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table = "profil";
    protected $primaryKey = "id_profil"; 

    protected $allowedFields = ['nama_perusahaan', 'alamat', 'kecamatan', 'provinsi', 'kode_pos', 'negara','email','id_user','updated_at'];

    public function getProfileById($id_profil)
    {
        return $this->where('id_profil', $id_profil)->first();
    }

}
