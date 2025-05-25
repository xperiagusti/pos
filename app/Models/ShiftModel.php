<?php

namespace App\Models;

use CodeIgniter\Model;

class ShiftModel extends Model
{
    protected $table = "shift";
    protected $primaryKey = "id_shift";
    protected $allowedFields = ['nama', 'id_user', 'jam_mulai', 'jam_selesai', 'created_at', 'updated_at'];
}
