<?php

namespace App\Models;

use CodeIgniter\Model;

class COAModel extends Model
{
    protected $table = "chart_of_account";
    protected $primaryKey = "id_coa";
    protected $allowedFields = ['coa_name', 'coa_code'];
}
