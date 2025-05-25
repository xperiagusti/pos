<?php

namespace App\Models;

use CodeIgniter\Model;

class OnlineStatusModel extends Model
{
    protected $table = "online_status";
    protected $primaryKey = "id_online";
    protected $allowedFields = ['id_user', 'status', 'logged_in', 'logged_out'];
}
