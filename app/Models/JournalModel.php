<?php

namespace App\Models;

use CodeIgniter\Model;

class JournalModel extends Model
{
    protected $table = "journal";
    protected $primaryKey = "id_journal";
    protected $allowedFields = ['journal_name', 'journal_date'];
}
