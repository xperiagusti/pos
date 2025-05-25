<?php

namespace App\Models;

use CodeIgniter\Model;

class JournalTypeInModel extends Model
{
    protected $table = "journal_type_income";
    protected $primaryKey = "id_jt_income";
    protected $allowedFields = ['id_user', 'jt_name', 'created_at', 'updated_at'];
}
