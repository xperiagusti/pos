<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyTransactionModel extends Model
{
    protected $table = "daily_transaction";
    protected $primaryKey = "id_daily_transaction";
    protected $allowedFields = ['id_user', 'd_trx_date', 'd_trx_detail', 'd_trx_type', 'd_trx_category', 'd_balance', 'created_at', 'updated_at'];
}
