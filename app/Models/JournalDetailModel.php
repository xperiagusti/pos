<?php

namespace App\Models;

use CodeIgniter\Model;

class JournalDetailModel extends Model
{
    protected $table = "journal_detail";
    protected $primaryKey = "id_journal_detail";
    protected $allowedFields = ['id_journal', 'jd_account', 'jd_debit', 'jd_credit', 'created_at', 'updated_at'];

    public function getJournalDetailsWithJournal()
    {
        // Membangun query untuk melakukan join antara journal_detail dan journal
        $query = $this->select('journal_detail.*, journal.journal_date, journal.journal_name')
            ->join('journal', 'journal.id_journal = journal_detail.id_journal')
            ->findAll();

        return $query;
    }

    public function getJoinJournalToEdit()
    {
        $results = $this->select('journal_detail.*, journal.journal_date, journal.journal_name')
            ->join('journal', 'journal.id_journal = journal_detail.id_journal')
            ->first();

        return $results;
    }

    public function searchByTerm($searchTerm)
    {
        return $this->select('journal_detail.*, journal.journal_date, journal.journal_name')
            ->join('journal', 'journal.id_journal = journal_detail.id_journal')
            ->like('journal_name', $searchTerm)
            ->orLike('jd_account', $searchTerm)
            ->orLike('jd_debit', $searchTerm)
            ->orLike('jd_credit', $searchTerm)
            ->findAll();
    }
}
